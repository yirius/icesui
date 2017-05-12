<?php
/**
 * User: Yirius
 * Date: 17/5/1
 * Time: 21:23
 */

namespace icesui;


use think\Exception;

class FormBuilder extends IcesBuilder
{
    //存放自动生成的form数据
    protected $formArray = [];

    //存放form的value
    protected $formValue = [];

    /**
     * @title _addCommon添加一个有常用参数的通用方法
     * @description _addCommon添加一个有常用参数的通用方法
     * @remark _addCommon添加一个有常用参数的通用方法
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:09
     * @url /_addCommon
     * @param $fetch
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     */
    protected function _addCommon($fetch, $title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        $this->formArray[] = [
            "type" => $fetch,
            'title' => $title,
            'name' => $name,
            'value' => empty($value)?(empty($this->formValue[$name])?'':$this->formValue[$name]):$value,
            'tips' => $tips,
            'extra_class' => $extra_class,
            'extra_attr' => $extra_attr
        ];
    }

    /**
     * @title addText添加一个带有动画效果的text
     * @description addText用来
     * @remark addText可以
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/4 15:34
     * @url /addText
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addText($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        $this->_addCommon("text", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }

    /**
     * @title addChosenIcon添加一个选择图标器
     * @description addText用来
     * @remark addText可以
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/9 21:06
     * @url /addText
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addChosenIcon($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        $this->setLinkFiles([
            "lib/chosen/chosen.min.js",
            "lib/chosenicons/zui.chosenicons.min.js",
        ])->setLinkFiles([
            "lib/chosen/chosen.min.css",
            "lib/chosenicons/zui.chosenicons.min.css",
        ], 'styles');
        $this->_addCommon("chosenicon", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }

    /**
     * @title addTextFormatter设置有格式的text
     * @description addTextFormatter设置有格式的text
     * @remark addTextFormatter设置有格式的text
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:21
     * @url /addTextFormatter
     * @param $title
     * @param $name
     * @param $pattern
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addTextFormatter($title, $name, $pattern, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        //引入formatter.js来格式化样式
        $this->setLinkFiles([
            "lib/formatter/jquery.formatter.min.js"
        ]);

        $this->_addCommon("textformatter", $title, $name, $value, $tips, $extra_class, $extra_attr." data-pattern='".$pattern."'");
        
        return $this;
    }

    /**
     * @title addPassword添加一个密码框
     * @description addPassword添加一个密码框
     * @remark addPassword添加一个密码框
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:22
     * @url /addPassword
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addPassword($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        $this->_addCommon("password", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    /**
     * @title addText1添加一个没有样式的text
     * @description addText1添加一个没有样式的text
     * @remark addText1添加一个没有样式的text
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:23
     * @url /addText1
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addText1($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        $this->_addCommon("text1", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    /**
     * @title addTextarea添加一个textarea
     * @description addTextarea添加一个textarea
     * @remark addTextarea添加一个textarea
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:23
     * @url /addTextarea
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addTextarea($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        $this->_addCommon("textarea", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    /**
     * @title addDate添加一个日期
     * @description addDate添加一个日期
     * @remark addDate添加一个日期
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:23
     * @url /addDate
     * @param $title
     * @param $name
     * @param string $value
     * @param string $tips
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     */
    public function addDate($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'readonly'){

        //设置一下需要的js和css
        $this->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.js",
        ])->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.css"
        ], 'styles');

        $this->_addCommon("date", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    //添加一个日期加时间
    public function addDatetime($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'readonly'){

        $this->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.js",
        ])->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.css"
        ], 'styles');

        $this->_addCommon("datetime", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    //添加一个时间
    public function addTime($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'readonly'){

        $this->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.js",
        ])->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.css"
        ], 'styles');

        $this->_addCommon("time", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }

    //添加一个日期的范围
    public function addDateRange($title, $name, $value = [], $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'readonly'){
        if(!empty($value)){
            if(empty($value[1])){
                throw Exception("日期区间值请按照['2017-4-16', '2017-04-24']");
            }
        }else{
            $value = ['',''];
        }

        $this->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.js",
        ])->setLinkFiles([
            "lib/datetimepicker/datetimepicker.min.css"
        ], 'styles');

        $this->_addCommon("daterange", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }

    //序列化图片文件成一个合适的json
    public function listUploadFiles($id, $name, $type, $size, $orgiSize, $lastModifiedDate){
        return [
            "id" => $id,
            "name" => $name,
            "type" => $type,
            "size" => $size,
            "orgiSize" => $orgiSize,
            "lastModifiedDate" => $lastModifiedDate
        ];
    }

    /**
     * @title addUpload添加一个上传文件窗口
     * @description addUpload添加一个上传文件窗口
     * @remark addUpload添加一个上传文件窗口
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:26
     * @url /addUpload
     * @param $title
     * @param $name
     * @param array $value 调用listUploadFiles
     * @param string $url 上传的网址
     * @param int $limitcount 上传个数
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     * @throws Exception
     */
    public function addUpload($title, $name, $value = [], $url = '/icesui/upload.html', $limitcount = 5, $extra_class = 'col-xs-12', $extra_attr = 'readonly'){
        if(!empty($value)){
            if(empty($value[0]['id'])){
                throw Exception("upload的值需要包含id|name|type|size|orgiSize|lastModifiedDate");
            }
        }else{
            if(!empty($this->formValue[$name])){
                $value = db("uploads")->field("id,title as name,mime as type,size,size as orgSize,createtime as lastModifiedDate")->where('id', 'in', $this->formValue[$name])->select();
            }
        }

        $this->setLinkFiles([
            "lib/uploader/zui.uploader.min.js"
        ])->setLinkFiles([
            "lib/uploader/zui.uploader.min.css"
        ], 'styles');

        $this->formArray[] = [
            "type" => "upload",
            'title' => $title,
            'name' => $name,
            'value' => json_encode($value),
            'tips' => $url,
            'extra_class' => $extra_class,
            'extra_attr' => $extra_attr,
            'limitcount' => $limitcount
        ];
        return $this;
    }

    //添加一个静态样式框
    public function addStatic($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'readonly'){
        $this->_addCommon("static", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }

    //添加一个ueditor
    public function addUeditor($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = 'style="width: 100%;height: 500px;"'){

        $this->setLinkFiles([
            "lib/ueditor/ueditor.config.js",
            "lib/ueditor/ueditor.all.js"
        ]);

        $this->_addCommon("ueditor", $title, $name, $value, $tips, $extra_class, $extra_attr);

        return $this;
    }

    //设置select的额外参数
    public function getSelectData($styleforBtn = "btn-select", $showsubtext = "false", $livesearch = "false", $textformat = "title"){
        return [
            'styleforBtn' => $styleforBtn,
            'showsubtext' => $showsubtext,
            'textformat' => $textformat,
            'livesearch' => $livesearch
        ];
    }

    /**
     * @title addSelect添加一个select样式
     * @description addSelect添加一个select样式
     * @remark addSelect添加一个select样式
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:29
     * @url /addSelect
     * @param $title
     * @param $name
     * @param array $options
     * @param string $value
     * @param string $tips
     * @param array $selectData 调用getSelectData
     * @param string $extra_class
     * @param string $extra_attr
     * @return $this
     * @throws Exception
     */
    public function addSelect($title, $name, $options = [], $value = '', $tips = '',  $selectData = [], $extra_class = 'col-xs-12', $extra_attr = ''){
        if(empty($selectData))
            $selectData = $this->getSelectData();
        else{
            if(empty($selectData['styleforBtn']) || empty($selectData['showsubtext']) || empty($selectData['textformat']) || empty($selectData['livesearch'])){
                throw Exception("请调用getSelectData来设置select的data属性, 否则请传入[]");
            }
        }
        //判断options里面有没有subtext
        if(empty($options[0]['subtext']))
            $selectData['showsubtext'] = "false";

        $this->setLinkFiles([
            "lib/bsselect/js/bootstrap-select.min.js"
        ])->setLinkFiles([
            "lib/bsselect/css/bootstrap-select.min.css",
        ], "styles");

        $this->formArray[] = [
            'type' => "select",
            'title' => $title,
            'name' => $name,
            'options' => $options,
            'value' => empty($value)?(empty($this->formValue[$name])?'':$this->formValue[$name]):$value,
            'tips' => $tips,
            'selectData' => $selectData,
            'extra_class' => $extra_class,
            'extra_attr' => $extra_attr
        ];
        return $this;
    }

    //连环调用select
    public function addLinkSelect($title, $name, $options, $url, $tiggerName, $httpField = '', $value = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        return $this->addSelect($title, $name, $options, $value, '', [], $extra_class, $extra_attr.' data-plugin="linkselect" data-url="'.$url.'" data-tiggername="'.$tiggerName.'" data-httpfield="'.$httpField.'" ');

    }

    protected function _addOptionsCommon($type, $title, $name, $options = [], $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        $this->formArray[] = [
            "type" => $type,
            'title' => $title,
            'name' => $name,
            'options' => $options,
            'value' => empty($value)?(empty($this->formValue[$name])?'':$this->formValue[$name]):$value,
            'tips' => $tips,
            'extra_class' => $extra_class,
            'extra_attr' => $extra_attr
        ];
        return $this;
    }
    //添加一个可排序组件
    public function addSortable($title, $name, $options = [], $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        $this->setLinkFiles([
            "lib/sortable/zui.sortable.min.js"
        ]);

        return $this->_addOptionsCommon("sortable", $title, $name, $options, $value, $tips, $extra_class, $extra_attr);
    }

    //添加一个单选框
    public function addRadio($title, $name, $options = [], $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){

        return $this->_addOptionsCommon("radio", $title, $name, $options, $value, $tips, $extra_class, $extra_attr);

    }

    public function addCheckBox($title, $name, $options = [], $value = [], $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        if(!empty($value)){
            if(!is_array($value))
                $value = [$value];
        }

        return $this->_addOptionsCommon("checkbox", $title, $name, $options, $value, $tips, $extra_class, $extra_attr);

    }

    public function addCheckBoxGroup($title, $name, $options = [], $value = [], $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        if(!empty($value)){
            if(!is_array($value))
                $value = [$value];
        }else{
            $value = ['-1'];
        }

        return $this->_addOptionsCommon("checkboxgroup", $title, $name, $options, $value, $tips, $extra_class, $extra_attr);

    }

    //添加一个开关
    public function addSwitch($title, $name, $value = '', $tips = '', $extra_class = 'col-xs-12', $extra_attr = ''){
        $this->_addCommon("switch", $title, $name, $value, $tips, $extra_class, $extra_attr);
        return $this;
    }


    /**
     * @title setLinkFiles设置添加css或者script
     * @description setLinkFiles用来
     * @remark setLinkFiles可以
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/6 10:12
     * @url /setLinkFiles
     * @param $name
     * @param string $type
     * @return $this
     */
    protected function setLinkFiles($name, $type = "scripts"){
        $this->setShowConfig($name, $type);
        return $this;
    }

    /**
     * @title setValue设置form各项的值
     * @description setValue设置form各项的值
     * @remark setValue设置form各项的值
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/9 19:32
     * @url /setValue
     * @param $value
     * @return $this
     */
    public function setValue($value){
        $this->formValue = $value;
        return $this;
    }

    public function getForm($postUrl = ""){
        //挂一下渲染环境
        $this->assign("formRenderArray", $this->formArray);
        //引入一下form的js
        $this->setLinkFiles(["js/icesform.js"]);
        //设置posturl
        $this->assign("formPostUrl", $postUrl);
        return $this->show("index/form");
    }
}
