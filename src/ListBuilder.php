<?php
/**
 * User: Yirius
 * Date: 17/5/1
 * Time: 16:20
 */

namespace icesui;


use think\Exception;

class ListBuilder extends FormBuilder
{
    protected $listArray = [];
    protected $listBtnsArray = [];

    function __construct($pkField = 'id')
    {
        $this->listArray[] = [
            'field' => "checkbox".$pkField,
            'title' => "",
            'checkbox' => true
        ];
        parent::__construct();
    }

    public function setCellEditAble($url, $type = "text", $source = [], $value = '', $title = "", $validate = ''){
        $editableinfo = [];
        if(!in_array($type, ['text', 'select', 'date', 'datetime', 'email'])){
            throw Exception("请输入text|select|date|datetime|email这几种类型");
        }
        $editableinfo['type'] = $type;
        $editableinfo['url'] = $url;
        if(!empty($title)) $editableinfo['title'] = $title;
        if(!empty($value)) $editableinfo['value'] = $value;
        if(!empty($validate)) $editableinfo['validate'] = $validate;
        if($type == "select") $editableinfo['source'] = $source;
        return $editableinfo;
    }

    public function setTableColumns($title, $field, $sortable = false, $formatter = '', $width = '', $align = 'center', $editable = false){
        if(is_array($editable)){
            if(empty($editable['type'])){
                throw Exception("请调用setCellEditAble来设置editable");
            }
        }
        $this->listArray[] = [
            "field" => $field,
            "title" => $title,
            "align" => $align,
            "width" => $width,
            "sortable" => $sortable==false?false:true,
            "order" => $sortable,
            "formatter" => $formatter,
            "editable" => $editable
        ];
        return $this;
    }

    public function setButtonLists($title, $id = '', $class = '', $attrs = ''){
        if(is_array($title)){
            foreach($title as $i => $v){
                if(is_array($v))
                    $this->setButtonLists($v[0], @$v[1], @$v[2], @$v[3]);
                else
                    $this->setButtonLists($v);
            }
        }else{
            if($title == "add"){
                $id = "tableAddBtn";
                $class = "btn btn-success";
                $attrs = "";
                $title = '<i class="icon icon-plus"></i> 新增';
            }else if($title == "delete"){
                $id = "tableDeleteBtn";
                $class = "btn btn-danger";
                $attrs = "disabled";
                $title = '<i class="icon icon-remove"></i> 删除';
            }
            $this->listBtnsArray[] = <<<HTML
        <button id="{$id}" class="{$class}" {$attrs}>
            {$title}
        </button>
HTML;
        }
        return $this;
    }

    /**
     * @title setTableAddPage用来给tablelist界面设置新增按钮的去向
     * @description setTableAddPage用来设置新增按钮的去向
     * @remark setTableAddPage可以设置新增按钮的去向
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/1 20:29
     * @url /setTableAddPage
     * @param $url
     * @param $title
     * @return $this
     */
    public function setTableAddPage($url, $title){
        $this->showConfig['tableConfig']['tableAddUrl'] = $url;
        $this->showConfig['tableConfig']['tableAddTitle'] = $title;
        return $this;
    }

    /**
     * @title setCellClickEvent设置每一列的点击事件
     * @description setCellClickEvent用来设置每一列的点击事件, (field, value, row, data)
     * @remark setCellClickEvent可以设置每一列的点击事件
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/1 20:45
     * @url /setCellClickEvent
     * @param $event
     * @return $this
     */
    public function setCellClickEvent($event){
        $this->showConfig['tableConfig']['tableCellClick'] = $event;
        return $this;
    }

    /**
     * @title setTableDeletePage用来给tablelist界面设置删除按钮的去向
     * @description setTableDeletePage用来给tablelist界面设置删除按钮的去向
     * @remark setTableDeletePage用来给tablelist界面设置删除按钮的去向
     * @author: Yirius <postmaster@yangyuance.com>
     * @createtime: 17/5/1 20:29
     * @url /setTableDeletePage
     * @param $url
     * @return $this
     */
    public function setTableDeletePage($url){
        $this->showConfig['tableConfig']['tableDeleteUrl'] = $url;
        return $this;
    }

    public function setTableRightBtns($title, $btnlists = [], $width = '', $align = 'center'){
        $tempBtns = "";
        foreach($btnlists as $i => $v){
            $tempBtns.=$v;
        }
        return $this->setTableColumns($title, "operate", false, <<<HTML
function(value, data){
    return "{$tempBtns}".replace(new RegExp(/{id}/g), data[tableConfig.idField]);
}
HTML
        , $width, $align, false);
    }

    public function setTableConfig($name, $value){
        $this->showConfig['tableConfig'][$name] = $value;
        return $this;
    }

    public function getTable($getRowsUrl = "", $height = '600'){
        $this->showConfig['tableConfig']['tableColumns'] = json_encode($this->listArray);
        $this->assign("tableTopBtns", $this->listBtnsArray);
        $this->assign("formRenderArray", $this->formArray);
        $this->showConfig['tableConfig']['getRowsUrl'] = $getRowsUrl;
        $this->showConfig['tableConfig']['height'] = $height;

        //设置table需要的样式和js
        $this
            ->setShowConfig([
                "lib/bstable/bootstrap-table.min.js",
                "lib/bstable/extensions/export/bootstrap-table-export.min.js",
                "lib/bstable/extensions/export/tableExport.js",
                "lib/bstable/locale/bootstrap-table-zh-CN.min.js",
                "lib/bstable/extensions/editable/bootstrap-table-editable.min.js",
                "lib/bstable/extensions/editable/bootstrap-editable.js",
                "js/iceslist.js",
                "js/icesform.js"
            ], "scripts")
            ->setShowConfig([
                "lib/bstable/bootstrap-table.min.css"
            ], "styles");

        return $this->show("index/table");
    }
}
