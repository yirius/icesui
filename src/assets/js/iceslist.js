/**
 * Created by yangyuance1 on 17/5/1.
 */
$(function(){
    if(typeof tableConfig == "undefined")
        return;
    var $table = $('#table');
    $table.bootstrapTable({
        height: tableConfig.height,
        toolbar: "#toolbar",
        search: objUtil.isTrue(tableConfig.search),
        formatSearch: function(){
            return tableConfig.searchPlaceHolder;
        },
        pagination: objUtil.isTrue(tableConfig.pagination),
        pageSize: tableConfig.pageSize,
        showRefresh: objUtil.isTrue(tableConfig.showRefresh),
        showColumns: objUtil.isTrue(tableConfig.showColumns),
        showExport: objUtil.isTrue(tableConfig.showExport),
        idField: tableConfig.idField,
        undefinedText: tableConfig.undefinedText,
        striped: true,
        sortName: tableConfig.initSort,
        sortOrder: tableConfig.initSortOrder,
        paginationPreText: tableConfig.PreBtnText,
        paginationNextText: tableConfig.NextBtnText,
        pageList: 	[10, 25, 50, 100, "ALL"],
        sidePagination:"server",
        clickToSelect: objUtil.isTrue(tableConfig.clickToSelect),
        singleSelect: objUtil.isTrue(tableConfig.singleSelect),
        columns: tableConfig.tableColumns,
        ajax: function(data){
            var postData = data.data;
            postData.extraData = tableConfig.postData;
            $.post(tableConfig.getRowsUrl, postData, function(info){
                $table.bootstrapTable("load", info);
                $table.bootstrapTable("hideLoading");
            });
        }
    });

    /**
     * 计算是否可以打开限定的按钮
     */
    function CanDrawSelectedBtn(){
        var SelectedItems = $table.bootstrapTable("getSelections");
        var SelectedItemArray = [];
        $.each(SelectedItems, function(n,v){
            SelectedItemArray.push(v[tableConfig.idField]);
        });
        if(SelectedItemArray.length == 0){
            for(var i in tableConfig.selectedShowBtns){
                $(tableConfig.selectedShowBtns[i]).attr("disabled", "disabled");
            }
        }else{
            for(var i in tableConfig.selectedShowBtns){
                $(tableConfig.selectedShowBtns[i]).removeAttr("disabled");
            }
        }
        return SelectedItemArray;
    }
    //绑定四个事件, 防止出现错误
    $table.on("check.bs.table", CanDrawSelectedBtn);
    $table.on("uncheck.bs.table", CanDrawSelectedBtn);
    $table.on("check-all.bs.table", CanDrawSelectedBtn);
    $table.on("uncheck-all.bs.table", CanDrawSelectedBtn);
    //设置一下cell的点击事件
    $table.on("click-cell.bs.table", function(field, value, row, td){
        if(tableConfig.tableCellClick)
            tableConfig.tableCellClick(field, value, row, td);
    });

    /**
     * 设置一下新增按钮的打开
     */
    $("#tableAddBtn").click(function(){
        var url = tableConfig.tableAddUrl;
        if(url == ""){
            new $.zui.Messager('提示：很抱歉, 未指定新增界面', {
                type: 'warning' // 定义颜色主题
            }).show();
            return;
        }
        parent.CreateFrame(url, tableConfig.tableAddTitle || "新增界面");
    });

    /**
     * 设置删除按钮的点击事件
     */
    $("#tableDeleteBtn").click(function(){
        var url = tableConfig.tableDeleteUrl;
        if(url == ""){
            new $.zui.Messager('提示：很抱歉, 未指定删除网址', {
                type: 'warning' // 定义颜色主题
            }).show();
            return;
        }
        //获取到选中的行
        var selectItems = CanDrawSelectedBtn();
        if(selectItems.length == 0){
            new $.zui.Messager('提示：很抱歉, 尚未选择删除列', {
                type: 'warning' // 定义颜色主题
            }).show();
            return;
        }
        //执行删除操作
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {ids: selectItems.join(",")},
            success: function(data){
                if(data.code == 1){
                    new $.zui.Messager(data.msg, {
                        type: 'success' // 定义颜色主题
                    }).show();
                    $table.bootstrapTable("refresh");
                }else{
                    new $.zui.Messager(data.msg, {
                        type: 'warning' // 定义颜色主题
                    }).show();
                }
            }
        });
    });

    $(document).on("click", ".createframe", function(){
        parent.CreateFrame($(this).data("href"), $(this).data("title"), $(this).data("search"));
    });

    $(document).on("click", ".closeframe", function(){
        parent.CloseFrame($(this).data("href"));
    });

    $(".form").on("submit", function(){
        var postDatasTemp = {};
        $.each($(this).serializeArray(), function(n,v){
            postDatasTemp[v.name] = v.value;
        });
        tableConfig.postData = postDatasTemp;
        $table.bootstrapTable("refresh");
        return false;
    });
});
