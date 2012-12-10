<?php
/*
 * 关注浮动层
 */

?>
<style>
        /*弹窗*/
    #popt {
        background: #111;
        position: absolute;
        z-index: 65534;
        filter: alpha(opacity=65);
        opacity: 0.65;
        float:left;
        display:none;
    }
    #poptDiv {
        background:url(http://www.lady8844.com/club/qz/meirong/images2/cffx/bg.jpg)  no-repeat scroll 0 0;
        height: 300px;
        line-height: 20px;
        position: absolute;
        width: 450px;
        z-index: 65535;
        display:none;
    }
    .gb{
        position:absolute;
        width:13px;
        height:13px;
        top:10px;
        right:10px;
        cursor:pointer;
    }
    .wel{
        float:left;
        text-align:center;
        padding:15px;
        padding-bottom:0;
        width:300px;
        height:120px;
        margin-top:30px;
    }
    .wel h3{
        font-family:"微软雅黑";
        line-height:24px;
        font-size:24px;
        margin-bottom:15px;
        color:#333;
    }
    .wel p{
        font-family:"微软雅黑";
        line-height:26px;
        text-indent:2em;
        text-align:left;
        padding-left:20px;
        color:#b28e00;
        font-size:14px;
    }
        /*more*/
    .moret{background:url(http://www.lady8844.com/club/qz/meirong/images2/cffx/more_03.gif) no-repeat 50% ; text-align:center; line-height:34px; font-size:14px; width:158px; margin:0 auto; margin-top:30px; font-weight:bold;}
    .moret a:link{ color:#ef6062; text-decoration:none;}
    .moret a:visited{ color:#ef6062; text-decoration:none;}
    .moret a:hover{ color: #666; text-decoration:underline;}
    .moret a:active{ color:#ef6062; text-decoration: none;}
</style>
<!--弹窗JS-->
<script type="text/javascript">

    var isfirst=1;
    function showWindow()
    {
        fusion2.iface.updateClientRect
                (
                        function(rec)
                        {
                            if(rec.top>600 && isfirst==1)
                            {
                                document.getElementById('popt').style.width = document.body.scrollWidth + "px";
                                document.getElementById('popt').style.height = document.body.scrollHeight + "px";


                                setTimeout(function (){jQuery('#popt').fadeIn('slow');},0);

                                setTimeout(function (){jQuery('#poptDiv').fadeIn('slow');},0);

                                setTimeout(function (){jQuery('#popt').fadeOut('slow');},11000);

                                setTimeout(function (){jQuery('#poptDiv').fadeOut('slow');},11000);
                                isfirst=0;
                            }
                            else
                            {
                                return false;
                            }
                        }
                );
    }
    jQuery(function(){
        if(!_isFans){
            showWindow();
        }
    });
</script>


<!--弹窗部分-->
<div id="popt" style=" top: 0px; left: 0px; margin:0 auto;filter:alpha(opacity=70);opacity:0.7; z-index:1500;"></div>
<div id="poptDiv" style="height:215px; width:350px; left:205px; top:970px; z-index:35000; position:absolute;">
    <p class="gb" onclick="document.getElementById('popt').style.display='none';document.getElementById('poptDiv').style.display='none';"></p>
    <div class="wel">
        <h3><span style="color:#fcce0e;">关注我们</span>的<span style="color:#82c9ff; font-family:Arial;">QQ</span>空间</h3>
        <p>&gt;&gt;更多精彩内容</p>
        <p>&gt;&gt;名品试用等你免费拿</p>
    </div>
    <div style="width:284px; margin:0 auto; height:auto; overflow:hidden;">
        <div style="float:left;width:126px;font-size:14px; text-indent:80px; overflow:hidden;"><a href="javascript:void(0)" onclick="javascript:document.getElementById('popt').style.display='none';document.getElementById('poptDiv').style.display='none'">关闭</a></div>
        <div style="float:left; width:130px; overflow:hidden;"><iframe scrolling="no" frameborder="0" src="http://open.qzone.qq.com/like?url=http%3A%2F%2Fuser.qzone.qq.com%2F2202411745&amp;type=button_num&amp;width=105&amp;height=24" allowtransparency="true" border="0"></iframe></div>
    </div>
</div>

<!--弹窗部分结束-->



