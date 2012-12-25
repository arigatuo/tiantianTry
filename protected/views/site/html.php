<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://www.lady8844.com/images/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        jQuery(function(){
            alert('sth');
            $("#cur_iframe").click(function(){
                alert('sth');
            });
        });
        var IframeOnClick = {
            resolution: 200,
            iframes: [],
            interval: null,
            Iframe: function() {
                this.element = arguments[0];
                this.cb = arguments[1];

                this.hasTracked = false;
            },
            track: function(element, cb) {
                this.iframes.push(new this.Iframe(element, cb));
                if (!this.interval) {
                    var _this = this;
                    this.interval = setInterval(function() { _this.checkClick(); }, this.resolution);
                }
            },

            checkClick: function() {
                if (document.activeElement) {
                    var activeElement = document.activeElement;
                    for (var i in this.iframes) {
                        if (activeElement === this.iframes[i].element) { // user is in this Iframe
                            if (this.iframes[i].hasTracked == false) {
                                this.iframes[i].cb.apply(window, []);

                                this.iframes[i].hasTracked = true;
                            }
                        } else {
                            this.iframes[i].hasTracked = false;
                        }
                    }
                }
            }
        };

        jQuery(function(){
            IframeOnClick.track(document.getElementById("cur_iframe"), function() { alert('a click'); });
        });
    </script>
</head>
<body>
    <!--<iframe src="<?php echo Yii::app()->createUrl("Site/html2");?>" id="cur_iframe" ></iframe>-->
    <iframe src="http://open.qzone.qq.com/like?url=http%3A%2F%2Fuser.qzone.qq.com%2F625617480&type=button_num&width=400&height=30&style=2" id="cur_iframe" ></iframe>
</body>
</html>