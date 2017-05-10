<?php
/**
 * User: Yirius
 * Date: 17/5/3
 * Time: 14:55
 */

namespace icesui;


class Logic extends IcesBuilder
{
    protected $uploadDataBase;

    public function _init()
    {
        //指定是json
        config("default_return_type", "json");
        $this->uploadDataBase = db($this->showConfig['uploadDb']);
    }

    public function ueditor(){
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(__DIR__ . "/assets/lib/ueditor/php/config.json")), true);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = $this->upload();
                break;
            /* 列出图片 */
            case 'listimage':
                $result = $this->listFiles();
                break;
            /* 列出文件 */
            case 'listfile':
                $result = $this->listFiles(0);
                break;
            default:
                $result = ['state'=> '请求地址出错'];
                break;
        }
        return $result;
    }

    /**
     * @title upload上传文件
     * @description upload上传文件
     * @remark upload上传文件
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/3 15:13
     * @url /icesui/upload
     * @param string $fileFormName
     * @return array
     */
    public function upload($fileFormName = "upfile"){
        $file = $this->request->file($fileFormName);
        $info = $file
            ->validate(['size' => $this->showConfig['uploadSize'],'ext' => $this->showConfig['uploadFileExt']])
            ->move($this->showConfig['uploadPath']);
        if($info){
            $ext = $info->getExtension();
            if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])){
                $isthumb = 1;
            }else{
                $isthumb = 0;
            }
            $fileinfo = [
                "state" => "SUCCESS",
                "url" => $this->showConfig['uploadShowUrl'].$info->getSaveName(),
                "title" => $info->getfilename(),
                "original" => $info->getBasename(),
                "mime" => $info->getMime(),
                "type" => ".".$ext,
                "size" => $info->getSize(),
                'hash' => $info->hash("sha1"),
                'createtime' => date("Y-m-d H:i:s"),
                'isthumb' => $isthumb
            ];
            $uid = session($this->showConfig['uploadUidName']);
            if(!empty($uid)){
                $fileinfo['uid'] = $uid;
            }
            $this->uploadDataBase->insert($fileinfo);
            return $fileinfo;
        }else{
            // 上传失败获取错误信息
            return [
                "state" => $file->getError()
            ];
        }
    }

    /**
     * @title listFiles用来列出目录下所有的文件
     * @description listFiles用来列出目录下所有的文件
     * @remark listFiles用来列出目录下所有的文件
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/3 15:23
     * @url /icesui/listFiles
     * @param int $isthumb
     * @return array
     */
    public function listFiles($isthumb = 1){
        $start = input('param.start', 0);
        $size = input('param.size', 20);
        $page = ceil($start/$size) + 1;
        $uid = session($this->showConfig['uploadUidName']);
        if(!empty($uid)){
            $where = ['uid' => $uid, 'isthumb' => $isthumb];
        }else{
            $where = ['isthumb' => $isthumb];
        }
        $fileList = $this->uploadDataBase->where($where)->page($page, $size)->select();
        $total = $this->uploadDataBase->where($where)->count();
        $filePath = [];
        foreach($fileList as $i => $v){
            $filePath[] = [
                'url'=> $v['url'],
                'mtime'=> filemtime(ROOT_PATH . DS . "public" . $v['url'])
            ];
        }
        return [
            "state" => "SUCCESS",
            "list" => $filePath,
            "start" => $start,
            "total" => $total
        ];
    }
}
