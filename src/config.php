<?php
/**
 * User: Yirius
 * Date: 17/5/10
 * Time: 18:22
 */
return [
    'title' => "IcesUi后台框架",//后台的title
    'headconfig' => '', //头部的一些设置, 可以直接写<style></style>
    'footconfig' => '', //尾部的一些设置<script></script>
    'scripts' => [], //需要引入的script
    'styles' => [], //需要引入的styles
    'viewReplace' => true, //替换的assets网址, true是默认网址
    'adminUrl' => '/admin.html', //admin的主页
    'adminTitle' => 'Icesui', //admin界面左侧的标题
    'logoutUrl' => './logout.html', //退出登录界面
    'personUrl' => './person.html', //个人资料界面
    'welcomeTitle' => '仪表盘', //首页的标题
    'welcomeUrl' => './welcome.html', //首页的网址
    'uploadPath' => ROOT_PATH . 'public' . DS . 'uploads',//上传图片的网址
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
