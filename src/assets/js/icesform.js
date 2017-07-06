/**
 * Created by yangyuance1 on 17/5/1.
 */
$(function(){
    $("input").on("blur", function(){
       if($(this).val() == ""){
           $(this).addClass("empty");
       }else{
           $(this).removeClass("empty");
       }
    });

    var datetimepickerConfig = {
        language:  "zh-CN",
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        format: "yyyy-mm-dd hh:ii:ss"
    };
    $("input[data-plugin='datetime']").each(function(n,v){
        $(v).datetimepicker(datetimepickerConfig);
    });
    datetimepickerConfig.format = "yyyy-mm-dd";
    datetimepickerConfig.minView = 2;
    $("input[data-plugin='date']").each(function(n,v){
        $(v).datetimepicker(datetimepickerConfig);
    });
    datetimepickerConfig.format = 'hh:ii';
    datetimepickerConfig.minView = 0;
    datetimepickerConfig.startView = 1;
    datetimepickerConfig.maxView = 1;
    $("input[data-plugin='time']").each(function(n,v){
        $(v).datetimepicker(datetimepickerConfig);
    });

    //绑定一下联动的select
    $("select[data-plugin='linkselect']").on("changed.bs.select", function(){
        var linkValue = $(this).val(), linkUrl = $(this).data("url"),
            linkTigger = $(this).data("tiggername"), linkHttpField = $(this).data("httpfield");
        if(!linkHttpField)
            linkHttpField = $(this).attr("name");
        if(linkUrl){
            $.post(linkUrl, {field: linkHttpField, value: linkValue}, function(data){
                if(data.code == 1){
                    var lists = data.data, optionsArr = [];
                    $.each(lists, function(n,v){
                        optionsArr.push("<option value='" + v.value + "'>" + v.text + "</option>");
                    });
                    var tiggerEle = $("#adminField"+linkTigger);
                    if(tiggerEle){
                        tiggerEle.empty().html(optionsArr.join("")).selectpicker('refresh');
                    }
                }else{
                    new $.zui.Messager(data.msg, {
                        close: false // 禁用关闭按钮
                    }).show();
                }
            });
        }
    });

    $('input[data-plugin="formatter"]').each(function(n,v){
        var pattern = $(v).data("pattern");
        $(v).formatter({
            'pattern': pattern,
            'persistent': true
        });
    });

    $('input[data-plugin="tags"]').each(function(n,v){
        $(v).tagsinput();
    });

    $('div[data-plugin="sortable"]').each(function(n,v){
        var initValue = [], inputForthis = $("#"+$(v).data("id"));
        $(v).find("div").each(function(key, value){
            initValue.push($(value).attr("value"));
        });
        inputForthis.val(initValue.join(","));
        $(v).sortable({
            finish: function(event){
                var items = event.list;
                var itemsValue = [];
                $.each(items, function(k, val){
                    itemsValue.push($(val).attr("value"));
                });
                inputForthis.val(itemsValue.join(","));
            }
        });
    });

    //绑定一下ueditor初始化
    $("script[data-plugin='ueditor']").each(function(n, v){
        var ue = UE.getEditor(v, {
            autoHeightEnabled: false,
            autoFloatEnabled: false
        });
    });

    //绑定一下uploader事件
    $('div[data-plugin="uploader"]').each(function(n,v){
        var staticFiles = uploaderFile[$(this).data("name")], filesArr = [];
        $.each(staticFiles, function(n,v){
            filesArr.push(v.id);
        });
        var thiInput = $("input[name="+$(this).data("name")+"]");
        thiInput.val(filesArr.join(","));
        var limitFilesCount = uploaderLimit[$(this).data("name")];
        $(v).uploader({
            max_retries: 0,
            chunk_size: 0,
            limitFilesCount: limitFilesCount,
            filters: {
                // 只允许上传图片或图标（.ico）
                mime_types: [
                    {title: '图片', extensions: 'jpg,gif,png'},
                    {title: '图标', extensions: 'ico'},
                    {title: '文档', extensions: 'doc,docx,xls,xlsx,ppt,pptx'}
                ],
                // 最大上传文件为 1MB
                max_file_size: '20mb',
                // 不允许上传重复文件
                prevent_duplicates: true
            },
            deleteActionOnDone: function(file, doRemoveFile){
                objUtil.arrRemove(file.id, filesArr);
                thiInput.val(filesArr.join(","));
                //直接删除, 从数据里也删除
                doRemoveFile();
            },
            deleteConfirm: true,
            staticFiles: staticFiles
        }).on('onFileUploaded', function(file, event, respone) {
            respone = JSON.parse(respone.response);
            filesArr.push(respone.id);
            thiInput.val(filesArr.join(","));
        });
    });

    /**
     * 对checkboxgroup操作一下全选和反选
     */
    $(".checkgroup").on("click", "input", function(){
        var inputs = $(this).parent().parent().parent().parent().find(".panel-collapse").find("input");
        if($(this).is(":checked")){
            inputs.prop("checked",true);
        }else{
            inputs.prop("checked",false);
        }
    })

    $('select[data-plugin="chosenicons"]').each(function(n,v){
        $(v).chosenIcons();
    });
});
