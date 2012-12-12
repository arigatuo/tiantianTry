var appTools = {
    //打开url
    openUrl : function(url){
        fusion2.nav.open({url:url});
    },

    //分享后打开url
    openUrlWithShare : function(xid, url){
        //tools.sendStory(xid, appTools.openUrl(url));
        tools.sendStory(url, appTools.openUrl, xid);
    },

    //分享
    shareToOthers: function(){
    },

    //最新留言
    getLatestMsg : function(){
        var msgContainer = jQuery("#msgContainer");
        jQuery.getJSON(baseUrl + "/main/Ajax/GetLatestMsg", function(data){
            var html = "";
            if(data.result_count > 0){
                var i = 0;
                for(i in data.msgs){
                    var addClass = (i == 0) ? "" : "nodisplay";
                    html += "<span class='clickMsg " + addClass + "' msgId='" + data.msgs[i]['autoid'] + "'>" + "<a class='br' href='javascript:' >" + data.msgs[i]['msg'] + "</a></span>";
                }
                html += "<span class='nodisplay'>暂无新消息</span>";
            }else{
                html = "<span>暂无新消息</span>";
            }

            msgContainer.html(html);
            jQuery(".clickMsg").click(appTools.showNextMsg);
        })
    },

    //显示下一条留言
    showNextMsg : function(){
        var obj = jQuery(this);
        obj.hide();
        obj.next("span").show();

        jQuery.getJSON( baseUrl + "/main/Ajax/MarkMsgReaded", {msgId:obj.attr("msgId")}, function(){appTools.updateMsgLeft()} );
    },

    //更新剩余未读消息的数量(伪)
    updateMsgLeft : function(){
        var curLeft = parseInt(jQuery('.msgLeft').eq(0).html()) - 1;
        jQuery('.msgLeft').html( curLeft > 0 ? curLeft : 0)
    },

    //购买
    shopping: function(productId){
        jQuery.getJSON(baseUrl + "/main/Ajax/BuyProduct", {productId:productId}, function(msg){
            var returnVal = parseInt(msg.result);
            if(returnVal > 0){
                location.reload();
            }else{
                if(returnVal === -1){
                    appTools.showFloat(2);
                }else if(returnVal === -3){
                    alert('您已经有这个道具了');
                }else{
                    alert("购买失败");
                }
            }
        });
    },

    //每日签到
    signDaily: function(){
        var obj = jQuery(this);
        jQuery.getJSON(baseUrl + "/main/Ajax/SignDaily",function(data){
            var returnVal = parseInt(data.result);
            if(returnVal > 0){
                location.reload();
            }else{
                if(returnVal == -1){
                    alert('您今天已经签到过了');
                }else{
                    alert('签到失败');
                }
            }
        });
    },


    //使用时光机
    useTimeMachine :  function(){
        jQuery.getJSON(
            baseUrl + "/main/Ajax/IsHaveTimeMachine",
            function(data){
                if(parseInt(data.result) > 0){
                    appTools.showFloat(1, function(){ location.href = baseUrl + '/main/Index/TryPageTimeMachine'; });
                }else{
                    alert("您还没有时光机， 请去用户中心购买");
                    if(location.href.indexOf("UserCenter") < 0 ){
                        location.href = baseUrl + "/main/Index/UserCenter/";
                    }
                }
            }
        );
    },

    //使用先到先得
    useGotFirst : function(){
        jQuery.getJSON(
            baseUrl + "/main/Ajax/IsHaveGotFirst",
            function(data){
                if(parseInt(data.result) > 0){
                    appTools.showFloat(4, function(){ location.reload();});
                }else{
                    alert("您还没有折扣到底卡， 请去用户中心购买");
                    if(location.href.indexOf("UserCenter") < 0 ){
                        location.href = baseUrl + "/main/Index/UserCenter/";
                    }
                }
            }
        );
    },

    //显示浮动层
    showFloat : function(floatId, closeFunc){
        var content = jQuery("#overlay"+floatId).html();
        jQuery.colorbox({html:content, overlayClose:false, opacity:0.6 , onClosed:closeFunc, top:"25px" 		});
        jQuery("#cboxClose").remove();
    },

    //第一次登录弹窗
    firstEnter : function(){
        jQuery(".init").show();
        jQuery.getJSON( baseUrl + "/main/Ajax/setFirstEnterFalse",  function(){});
    },

    //关闭init窗口
    closeFirstEnter : function(){
        jQuery(".init").hide();
    },

    userAddGoldInJs: function(usergold){
        jQuery(".user_gold").html(usergold);
    }
};


jQuery(function(){
    //jQuery.ajaxSetup({ cache: false });
    jQuery(".shoppingButton").click(function(){
        appTools.shopping(jQuery(this).attr("productId"));
    });

    jQuery(".signButton").click(appTools.signDaily);

    jQuery(".close").live("click", jQuery.colorbox.close);

    jQuery(".timeMachineButton").click(function(){
        var obj = jQuery(this);
        if(obj.hasClass("disable")){
        }else{
            appTools.useTimeMachine();
        }
    });

    jQuery(".gotFirstButton").click(function(){
        var obj = jQuery(this);
        if(obj.hasClass("disable")){
        }else{
            appTools.useGotFirst();
        }
    });
    //倒计时
    /*
    var dateTime = new Date();
    var difference = dateTime.getTime() - serverTime; //客户端与服务器时间偏移量

     setInterval(function(){
     $(".time").each(function(){
     var obj = $(this);
     var endTime = new Date(parseInt(obj.attr('timevalue')) * 1000);
     var nowTime = new Date();
     var nMS=endTime.getTime() - nowTime.getTime() + difference;
     var myD=Math.floor(nMS/(1000 * 60 * 60 * 24)); //天
     var myH=Math.floor(nMS/(1000*60*60)) % 24 + (myD * 24); //小时
     var myM=Math.floor(nMS/(1000*60)) % 60; //分钟
     var myS=Math.floor(nMS/1000) % 60; //秒
     //var myMS=Math.floor(nMS/100) % 10; //拆分秒
     if(myD>= 0){
     //var str = myD+"天"+myH+"小时"+myM+"分"+myS+"."+myMS+"秒";
     obj.find(".shi").eq(0).html(myH);
     obj.find(".fen").eq(0).html(myM);
     obj.find(".miao").eq(0).html(myS);
     }else{
     obj.find(".shi").eq(0).html(0);
     obj.find(".fen").eq(0).html(0);
     obj.find(".miao").eq(0).html(0);
     }
     });
     }, 200); //每个0.1秒执行一次
     */
});



