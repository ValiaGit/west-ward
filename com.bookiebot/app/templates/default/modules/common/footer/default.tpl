<div class="push"></div>
</div>
<!-- wrapper -->

<div class="footer">
    <div class="footer-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <ul class="nav nav-pills">
                        {{foreach $Data.secondary_menu_list as $page}}
                        <li {{if Fn::isActive($page.url)}} class="active"{{/if}}><a
                                    href="{{$page.url}}">{{$page.title}}</a></li>
                        {{/foreach}}

                    </ul>
                    <br/>
                    <h3>{{$lang_arr.warning_gambling}}!</h3>
                </div>
                <!-- col -->
                <div class="col-md-7 text-right">
                    <div class="contact-phone">
                        {{$lang_arr.phone}}: <span class="phone-number">  <em>‎+1 844 202 6414</em></span>
                    </div>
                    <!-- contact phone -->
                    <div class="copyright">
                        <span style="margin-top:4px;display: block;">© Bookiebot. {{$lang_arr.all_rights_reserved}}. Westward-Entertainment Ltd is licensed and regulated by the Malta Gaming Authority<br/> License Number: MGA/CL3/1064/2014</span>
                        <span style="margin-top:4px;display: block;"><strong>{{$lang_arr.address}}</strong>: The Penthouse, Carolina Court, Giuseppe Cali Street, Ta’ Xbiex XBX1425. Malta</span>
                    </div>
                    <!-- copyright -->
                </div>
                <!-- col -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- footer-nav -->
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 clearfix">

                </div>
                <div class="col-md-12 clearfix">
                    <div class="pull-left">


                        <a href="https://www.authorisation.mga.org.mt/verification.aspx?lang=EN&company=11854e28-3a67-49c7-bd87-dcbef44e7c71&details=1" target="_blank">
                            <img class="care_image" src="{{$THEME}}/images/mga.png" style="width:78px !important; height:45px;" alt=""/>
                        </a>


                        <a href="https://validator.curacao-egaming.com/ee0c2830-4fb5-44a2-964a-70c06c3e5dae" target="_blank">
                            <img class="care_image" src="{{$THEME}}/images/ceg-logo.png"  alt=""/>
                        </a>

                        </div>
                    <div class="pull-right footer_icons_right">
                        <img class="care_image pull-right" src="{{$THEME}}/images/protect/18.png" alt=""/>

                        <a href="http://www.gamcare.org.uk/" target="_blank">
                            <img class="care_image pull-right" src="{{$THEME}}/images/protect/gamcare.png" alt=""/>
                        </a>
                        <a href="https://www.gamblingtherapy.org/" target="_blank">
                            <img class="care_image pull-right" src="{{$THEME}}/images/protect/gt.png" alt=""/>
                        </a>

<!--
                        <iframe src='https://www.authorisation.mga.org.mt/handlers/seal-of-authorisation.aspx?company=a00b7116-a894-4a1c-8d85-854e804632b6&lang=en&fullDetails=1&size=0' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:75px; height:43px;' allowTransparency='true'></iframe>
-->
                        <img class="img-responsive pull-right" src="{{$THEME}}/images/footer-logos.png" alt=""/>
                    </div>

                </div>
                <!-- col-md-12 -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->

    </div>
    <!-- footer-content -->
</div>
<!-- footer -->
<script src="https://goldfirestudios.com/proj/howlerjs/howler.min.js?v=1.1.28"></script>

<script>


   var sound = new Howl({
       urls: ['/sounds/blast.ogg'],
       sprite: {
           blast: [0, 2000],
           laser: [3000, 700],
           winner: [5000, 9000]
       }
   });


    var sumo_enter_sound = new Howl({
        urls: ['/sounds/open.ogg']
    });

    var cashier_sound = new Howl({
        urls: ['/sounds/cashier.ogg']
    });


    var sumo_click_sound = new Howl({
        urls: ['/sounds/sumo.ogg']
    });


</script>
<!-- Place this asynchronous JavaScript just before your </body> tag -->
<script src="{{$base_href}}/lang_{{$cur_lang}}.js?v={{$cache_version}}"></script>

<script src="{{$THEME}}/js/libs/jquery.js"></script>
<script src="{{$THEME}}/js/libs/jquery-ui.min.js"></script>
<script src="{{$THEME}}/js/libs/jquery.validate.min.js"></script>
<script src="{{$THEME}}/js/libs/additional-methods.min.js"></script>
<script src="{{$THEME}}/js/libs/jquery.cookie.js"></script>
<script src="{{$THEME}}/js/libs/bootstrap.min.js"></script>
<script src="{{$THEME}}/js/libs/idangerous.swiper.min.js"></script>
<script src="{{$THEME}}/js/libs/jquery.sticky.min.js"></script>


<script src="{{$THEME}}/js/libs/select2.min.js"></script>
<script src="{{$THEME}}/js/libs/collapsible.min.js"></script>
<script src="{{$THEME}}/js/libs/moment.js"></script>

<script src="{{$THEME}}/js/libs/md5.js"></script>
<script src="{{$THEME}}/js/libs/ux.js"></script>


<!--<script src="{{$THEME}}/intro/intro.min.js"></script>-->

<script src="{{$THEME}}/js/classes/Util.js?v={{$cache_version}}"></script>
<script src="{{$THEME}}/js/classes/API.js"></script>



<script src="{{$THEME}}/js/compiled/BetStock/bundle.min.js?v={{$cache_version}}"></script>
<script src="{{$THEME}}/js/load.js?v={{$cache_version}}"></script>


<script>

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-88318205-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
