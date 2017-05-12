#icesui-doc
##icesui for thinkphp5
###纯后台框架模板, 不包含任何成型逻辑
###升级维护接口不变
~~~
安装方法 composer require yirius/icesui
~~~
表单自动化生成项
需要引用的方法


自动化生成form表单
~~~

        use icesui\FormBuilder;
        use icesui\ListBuilder;
        public function useradd(){
            if(request()->isAjax()){
                    $post = input('post.');
                    if(empty($post['phone'])){
                        $this->error("手机号不能为空");
                    }
                    $count = $authuserModel->where('phone', $post['phone'])->count();
                    if($count != 0 && $id == 0){
                        $this->error("该手机号已经被人使用, 请勿重复注册");
                    }
                    if(strlen($post['password']) > 35){
                        unset($post['password']);
                    }else{
                        if(strlen($post['password']) < 6){
                            $this->error("密码不得小于6位");
                        }
                        $post['password'] = sha1($post['password']."Yirius");
                    }
                    $authuserModel->AutoSave($post, 这里是where条件);
                }
            $formBuilder = new FormBuilder();
                //这个是select等的选择内容, 必须是[text => '', value => '']的形式
                $options = [
                    ['text' => "路虎", 'value' => "LuHu", "subtext" => "LH","icon" => "icon-ok", "title" => "路虎揽胜"],
                    ['text' => "奔驰", 'value' => "BMW", "subtext" => "BMW", "icon" => "icon-user"]
                ];
                //请使用listUploadFiles来获取到指定的upload默认文件信息
                $uploadList = [$formBuilder->listUploadFiles("1", "测试.jpg", "image/jpg", "134000", "134000", "2017-04-16")];
                //select的一些附加属性
                $selectData = $formBuilder->getSelectData("btn-select", "true");
                return $formBuilder
                    ->addText("动画效果输入框", "input的name", "default的值", "测试tips", "col-xs-6", "readonly")
                    ->addText1("只有边框效果输入框", "input的name", "default的值", "测试tips", "col-xs-6")
                    ->addPassword("测试密码", "input的name", "default的值", "测试tips", "col-xs-6")
                    ->addSelect("单选框测试", "select的name", $options, "default的值", "请选择合适车型", $selectData, "col-xs-6")
                    ->addSelect("多选框测试", "select的name", $options, "default的值", "请选择合适车型", $selectData, "col-xs-6", "multiple")
                    ->addLinkSelect("联动select测试", "linkselect", $options, "点击之后默认去那个网址获取信息", "需要触发的那个select的name,如select1", '')//这个方法会发送两个字段, field和value字段到指定网址, 网址的function在下方
                    ->addSwitch("switch测试", "input的name", "如果希望是打开状态, 只要值不为空或0, 就都是打开状态", "请确认打开", "col-xs-6")
                    ->addTextarea("输入区域", "textarea的name", ""default的值, "测试tips", "col-xs-6")
                    ->addDate("测试日期", "input的name", "default的值", "测试tips", "col-xs-6")
                    ->addDatetime("测试日期时间", "input的name", "default的值", "测试tips", "col-xs-6")
                    ->addTime("测试时间", "input的name", "default的值", "测试tips", "col-xs-6")
                    ->addDateRange("测试时间区间", "timerange", [start的值, end的值], "测试时间区间", "col-xs-6")
                    ->addStatic("静态文本测试", "static", "静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试静态文本测试")//可以使<<<HTML HTML内容
                    ->addUpload("上传测试", "upload1", $uploadList)
                    ->addRadio("Radio测试", "radio", $options, "BMW", '', 'col-xs-6')
                    ->addCheckBox("CheckBox测试", "checkbox", $options, ['LuHu', "BMW"], '', 'col-xs-6')
                    ->addUeditor("Ueditor测试", "ueditor", "", "测试tips", "col-xs-6")
                    ->addTextFormatter("格式化输入框", "fomatter", "¥{{999}},{{999}},{{999}}.{{99}}", "", "测试tips", "col-xs-6")//这个请去看formatter官网
                    ->addSortable("Sortable测试", "sortable", $options, "BMW", '', 'col-xs-6')//拖动排序
                    ->getForm("/welcome");//form表单的提交网址, 可以为空, 就是提交到当前网址
        }
```
```


>接下来这个方法是对应LinkSelect方法的那个提交网址

```
public function _formList(){
        $post = input('post.');
        $this->success("生成成功", null, [
            ['text' => "路虎11", 'value' => "LuHu", "subtext" => "LH","icon" => "icon-ok", "title" => "路虎揽胜"],
            ['text' => "奔驰22", 'value' => "BMW", "subtext" => "BMW", "icon" => "icon-user"]
        ]);
    }
```


##然后是listBuilder的使用方式
~~~

    public function tablelists(){
        $icesBuilder = new ListBuilder();
        return $icesBuilder
            //上方是添加搜索项
            ->addText1("测试", "test",'','','col-xs-6')
            ->addText1("测试", "test1",'','','col-xs-6')
            ->addSelect("单选测试", "select", [
                ['text' => 1, 'value' => 1]
            ], '', '', [], 'col-xs-6')
            ->addDateRange("时间", 'times')
            //从这里开始是设置table内容
            ->setButtonLists(['add', 'delete'])//设置上方可点击按钮, 内置两个方法add和delete
            ->setTableColumns("ID", "id")
            ->setTableColumns("测试", "name")
            ->setTableColumns("价格", "price", false, '', '', 'center',
                $icesBuilder->setCellEditAble("/welcome.html", "select", [
                    ['value' => "2017-04-16", "text" => "1"],
                    ['value' => "2017-04-17", "text" => "2"]
                ], '', '请选择价格', <<<HTML
function(value){
    console.log(value);
    return '日期格式不正确';//return '';是校验成功
}
HTML
                )
            )
            //设置界面新增的网址
            ->setTableAddPage("/welcome", "新增")
            //设置删除按钮的提交网址
            ->setTableDeletePage("/welcome")
            //设置从那个界面获取提交内容
            ->getTable("/manage/index/_ajaxTable.html");
    }
    
    //因为表单使用的bootstrap-table, 所有icesui里面内置了一个Model, 可以直接Extend这个Model,然后又AutoTable和AutoSave等方法
    例如manage/model/config.php
    use icesui\Model;
    
    class Config extends Model
    {
    
    }
    
    这样就可以直接在方法这么写
    public function index(){
        if(request()->isAjax()){//判断是不是ajax
            $authuserModel = new AuthUser();
            if(request()->isDelete()){//判断是不是删除
                $authuserModel->AutoDelete([], [1]);//是的话调用自动删除, 第一项是制定删除那几行, 第二个是指定不删除的选项
                //比如->AutoDelete(input('post.ids'));也就是默认方法
                //AutoDelete($ids = [], $notDelete = [], $pkField = "id")
                //第一个是删除的行的标识, 第二个是不删除那些, 第三个是指定主键, 如果主键不是id需要自己指定
                //同时需要->setTableConfig("idField", "type")来设定提交的主键名称
            }
            return $authuserModel->AutoTable("a.id", "a.phone|a.name",[
                ["__AUTH_GROUP__ b", "a.group_id = b.id", "LEFT"]
            ], [], 'a.id, a.realname, a.phone, a.group_id, b.title as group_name');
            //AutoTable($sort = 'id', $search_fields = "", $with = [], $where = [], $field = '*', $where_extra = '', $order_force = "", $sort_for_table = [], $group_by_key = '')
            //这个方法是自动获取表格内容含义依次是AutoTable(排序的那个键, 在table默认输入框输入的内容的查询条件, 连表查询的表(如果这项不为空, 那么会自动把当前的model设置成a这个别名), 查询的where条件, 查询的字段, 其他的where条件(字符串或function), 强制排序的字段(写上这个之后table上的点击无效), 表单点击之后有with里面的字段的排序方式, groupby的字段)
        }
        $listBuilder = new ListBuilder();
        return $listBuilder
            ->setTableColumns("用户编号", "id")
            ->setTableColumns("真实姓名", "realname")
            ->setTableColumns("用户手机号", "phone")
            ->setTableColumns("用户角色", "group_name")
            ->setTableRightBtns("操作", [
                "<a data-href='manage/user/userAdd' data-search='?id={id}' data-title='资料修改' class='btn btn-primary createframe'><span class='icon icon-pencil'></span></a>"
            ])
            ->setButtonLists(['add', 'delete'])
            ->setTableAddPage("manage/user/userAdd", "用户新增")
            ->getTable("");//获取table的地址
    }
~~~
