<?php
/**
 * User: Yirius
 * Date: 17/4/29
 * Time: 16:12
 */

namespace icesui;


use think\Request;
use think\View;

class IcesBuilder
{
    protected $assets_path = "";
    protected $view_path = "";
    /**
     * @var \think\Request Request实例
     */
    protected $request;
    /**
     * @var \think\View 视图类实例
     */
    protected $view;

    /**
     * @var array 资源类型
     */
    protected $mimeType = [
        'xml'  => 'application/xml,text/xml,application/x-xml',
        'json' => 'application/json,text/x-json,application/jsonrequest,text/json',
        'js'   => 'text/javascript,application/javascript,application/x-javascript',
        'css'  => 'text/css',
        'rss'  => 'application/rss+xml',
        'yaml' => 'application/x-yaml,text/yaml',
        'atom' => 'application/atom+xml',
        'pdf'  => 'application/pdf',
        'text' => 'text/plain',
        'png'  => 'image/png',
        'jpg'  => 'image/jpg,image/jpeg,image/pjpeg',
        'gif'  => 'image/gif',
        'csv'  => 'text/csv',
        'html' => 'text/html,application/xhtml+xml,*/*',
    ];

    protected $showConfig = [
        'title' => "IcesUi后台框架",
        'headconfig' => '',
        'footconfig' => '',
        'scripts' => [],
        'styles' => [],
        'viewReplace' => true,
        'adminUrl' => '/admin.html',
        'adminTitle' => 'Icesui',
        'logoutUrl' => './logout.html',
        'personUrl' => './person.html',
        'welcomeTitle' => '仪表盘',
        'welcomeUrl' => './welcome.html',
        'uploadPath' => ROOT_PATH . 'public' . DS . 'uploads',
        'uploadShowUrl' => '/Uploads/',
        'uploadUidName' => 'userinfo.id',
        'uploadSize' => '200000',
        'uploadFileExt' => 'jpg,jpeg,png,gif,bmp,xls,doc,xlsx,docx,ppt,pptx',
        'uploadDb' => 'uploads',
        'tableConfig' => [
            "height" => 600,//设置表格高度
            "search" => true,
            "searchPlaceHolder" => "搜索",
            "pagination" => true,
            "pageSize" => "10",
            "showRefresh" => true,
            "showColumns" => true,
            "showExport" => true,
            "idField" => "id",
            "undefinedText" => "暂无信息",
            "initSort" => "id",
            "initSortOrder" => "desc",
            "selectedShowBtns" => ["#tableDeleteBtn"],
            "PreBtnText" => "上一页",
            "NextBtnText" => "下一页",
            "clickToSelect" => true,
            "singleSelect" => false,
            "getRowsUrl" => "/manage/index/_ajaxTable.html",
            "postData" => [],
            "tableColumns" => "",
            "tableDeleteUrl" => "",
            "tableAddUrl" => "",
            "tableAddTitle" => "",
            "tableCellClick" => "",
        ],
        'formConfig' => [

        ]
    ];

    /**
     * IcesBuilder constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        if (is_null($request)) {
            $request = Request::instance();
        }
        $this->request = $request;
        $this->assets_path = __DIR__ . DS . 'assets' . DS;
        $this->view_path = __DIR__ . DS . 'view' . DS;
        $config = [
            'view_path' => $this->view_path
        ];

        //整合两个配置项
        $icesuiConfig = config("icesui");
        $this->showConfig = array_merge($this->showConfig, $icesuiConfig);

        $this->view =  new View($config);

        $this->_init();
    }

    public function _init(){}

    /**
     * 显示模板
     * @param $name
     * @return mixed
     */
    protected function show($name, $vars = [], $replace = [], $config = [])
    {
        $resource = [
            "__ASSETS__" => $this->showConfig['viewReplace']===true?"/icesui/assets":$this->showConfig['viewReplace']
        ];
        $replace = array_merge($replace, $resource);
        $this->view->assign("showConfig", $this->showConfig);
        return $this->view->fetch($name, $vars, $replace, $config);
    }

    /**
     * curd的assign操作
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/4/29 16:50
     * @return $this
     */
    public function assign($name, $title){
        $this->view->assign($name, $title);
        return $this;
    }

    /**
     * @title setShowConfig设置界面参数
     * @description setShowConfig用来设置界面参数, 可以自动判断是数组还是非数组, 进行合并和赋值
     * @remark setShowConfig可以设置界面参数
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/1 20:33
     * @url /setShowConfig
     * @param $value
     * @param string $name
     * @return $this
     */
    public function setShowConfig($value, $name = "title")
    {
        if(!empty($this->showConfig[$name]) && is_array($this->showConfig[$name])){
            if(is_array($value))
                $this->showConfig[$name] = array_merge($this->showConfig[$name], $value);
            else
                $this->showConfig[$name][] = $value;
        }else{
            $this->showConfig[$name] = $value;
        }
        return $this;
    }

    /**
     * 显示后台主页
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/4/29 16:51
     * @return mixed
     * @param $topLists
     * @param $sideLists
     * @param $userTitle
     */
    public function getAdmin($topLists, $sideLists, $userTitle = "超级管理员 Yirius"){
        $this->assign("adminTopLists", $topLists)
        ->assign("adminUserTitle", $userTitle)
        ->assign("adminSlideLists", $sideLists)
        ->setShowConfig([
            "js/admin.js"
        ], "scripts");
        return $this->show("index");
    }

    public function getErrorPage(){
        return $this->show("index");
    }

    /**
     * 解析资源
     * @return $this
     */
    public function assets()
    {
        $path = str_replace("icesui/assets/", "", $this->request->pathinfo());
        $ext = $this->request->ext();
        if($ext)
        {
            $type= "text/html";
            $content = file_get_contents($this->assets_path.$path);
            if(array_key_exists($ext, $this->mimeType))
            {
                $type = $this->mimeType[$ext];
            }
            return response($content, 200, ['Content-Length' => strlen($content)])->contentType($type);
        }
    }
}

