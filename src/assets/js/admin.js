/**
 * 显示左侧菜单栏
 * @param menuTitle
 * @returns {boolean}
 */
function showSideMenu(menuTitle){
    //判断存在打开栏目, 不存在就是home
    menuTitle = menuTitle || "home";
    if(typeof adminSlideLists == "undefined")
        return true;
    //判断存在adminSlideLists
    if(!objUtil.isNull(adminSlideLists)){
        //判断存在adminSlideLists里的这个栏目
        if(!objUtil.isNull(adminSlideLists[menuTitle])){
            var adminTreeMenu = $("#sideTreeMenu");
            adminTreeMenu.empty();//把它内部存在的html都清空
            var thisMenu = adminSlideLists[menuTitle];
            for(var i in thisMenu){
                var li = $("<li></li>");
                //区分存在不存在子菜单
                if(!objUtil.isNull(thisMenu[i]['sub'])){
                    li.append('<a href="#"><i class="icon ' + thisMenu[i].icon + '"></i>' + thisMenu[i].text + '<span class="icon icon-caret-down pull-right"></span></a>');
                    var ul = $("<ul></ul>");
                    //如果存在子菜单就直接渲染出来
                    for(var j in thisMenu[i]['sub']){
                        ul.append('<li><a class="sideMenuA" href="' + thisMenu[i]['sub'][j].href + '"><i class="icon ' + thisMenu[i]['sub'][j].icon + '"></i>' + thisMenu[i]['sub'][j].text + '</a></li>');
                    }
                    li.append(ul);
                }else{
                    li.append('<a class="sideMenuA" href="' + thisMenu[i].href + '"><i class="icon ' + thisMenu[i].icon + '"></i>' + thisMenu[i].text + '</a>');
                }
                adminTreeMenu.append(li);
            }
            return true;
        }
    }
    new $.zui.Messager('对不起, 系统出现错误, 请联系管理员', {
        close: false // 禁用关闭按钮
    }).show();
}

var hasOpendFrame = {tabhomeboard: 1}, adminTabsOrignWidth = $(".admin-tabline").width();

/**
 * 打开指定窗口
 * @param href
 * @param title
 * @param search
 * @constructor
 */
function CreateFrame(href, title, search){
    //因为需要一个id, 把网址做去重处理,去/和.之后作为id判断
    var href2id = href.replace(new RegExp(/[/.]/g),'').toLowerCase();

    search = search || '';

    //先判断是否已经打开, 如果已经打开那么自动打开这个frame
    if(!objUtil.isNull(hasOpendFrame[href2id])){
        $("#" + href2id).find("iframe").attr("src", href + search);
        $("#tab" + href2id).click();
        return;
    }

    //生成tab的样式
    var tab = $("<li></li>");
    tab.append('<a href="#" id="tab' + href2id + '" data-target="#' + href2id + '" data-toggle="tab">' + title + ' <span class="icon icon-times"></span></a>');

    //生成content的样式
    var tabcontent = $('<div class="tab-pane fade" id="' + href2id + '"></div>');
    tabcontent.append('<iframe src="' + href + search + '"></iframe>');

    //加入赋值
    hasOpendFrame[href2id] = 1;
    $("#adminMainTabs").append(tab);
    $("#adminMainTabContents").append(tabcontent);

    _calcWidthToCLose();

    //打开新增模块
    $("#tab" + href2id).click();
}

/**
 * 关闭指定窗口
 * @param href
 */
function CloseFrame(href){
    //因为需要一个id, 把网址做去重处理,去/和.之后作为id判断
    var href2id = href.replace(new RegExp(/[/.]/g),'').toLowerCase();
    //先判断是否已经打开, 如果已经打开那么自动打开这个frame
    if(!objUtil.isNull(hasOpendFrame[href2id])){
        $("#tab" + href2id).remove();
        $("#" + href2id).remove();
        delete hasOpendFrame[href2id];
        $("#tabhomeboard").click();
    }else{
        new $.zui.Messager('对不起, 尚未打开该界面, 无法关闭', {
            close: false // 禁用关闭按钮
        }).show();
    }
    _calcWidthToCLose();
}

/**
 * 设置用来计算开启和关闭上方左右箭头的
 * @private
 */
function _calcWidthToCLose(){
    var adminMainTabs = $("#adminMainTabs");
    var totalWidth = 0;
    adminMainTabs.find("li").each(function(n,v){
        totalWidth+=$(v).width();
    });

    if(totalWidth > adminTabsOrignWidth){
        adminMainTabs.width(totalWidth);
        adminMainTabs.addClass("showTabScroll");
        $(".admin-arraw").css("display", "block");
    }else{
        adminMainTabs.removeClass("showTabScroll");
        $(".admin-arraw").css("display", "none");
    }
}

$(function(){
    //首先先显示一个slidebar
    showSideMenu();
    //绑定打开frame事件
    $("#sideTreeMenu").on("click", ".sideMenuA", function(e){
        e.preventDefault();
        CreateFrame($(this).attr('href'), $(this).text());
    });
    //绑定关闭frame事件
    $("#adminMainTabs").on("click", ".icon-times", function(){
        CloseFrame($(this).parent().data("target").replace("#", ""));
    });
    //左右键绑定事件
    $("#adminArrawLeft").click(function(){
        var adminMainTabs = $("#adminMainTabs");
        var offsetLeft = adminMainTabs.css("left").replace("px", "");
        if(adminMainTabs.width()+parseInt(offsetLeft) > adminTabsOrignWidth){
            adminMainTabs.css("left", 40);
        }else{
            adminMainTabs.css("left", parseInt(offsetLeft)+100);
        }
    });
    $("#adminArrawRight").click(function(){
        var adminMainTabs = $("#adminMainTabs");
        var offsetLeft = adminMainTabs.css("left").replace("px", "");
        if(adminMainTabs.width()+parseInt(offsetLeft) <= adminTabsOrignWidth){
            adminMainTabs.css("left", adminTabsOrignWidth - adminMainTabs.width() - 40);
        }else{
            adminMainTabs.css("left", parseInt(offsetLeft)-100);
        }
    });
    //顶部按钮切换
    $("#adminTopLists").on("click", "li", function(){
        $("#adminTopLists").find('li').removeClass("active");
        $(this).addClass("active");
        showSideMenu($(this).data("href"));
    })
});
