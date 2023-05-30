{{$Data.modules.header}}
<script type="text/javascript">
    var whereami = "bookmakers";
</script>
<body class="page-home">

<div class="wrapper">

{{$Data.modules.topmenu}}


{{$Data.modules.bettingmenu}}



<div class="container main-container">
    <div class="row">

        {{include file='view/includes/Betting/Left.tpl'}}

        <div class="col-md-6" >
            {{include file='view/includes/Betting/NewsSlider.tpl'}}


            <div class="col-md-12 home-middle" id="MiddleContainer" data-step="2" data-intro="When you click tournaments on the left you will see matches list here">
                {{include file='view/includes/Betting/Center.tpl'}}
            </div>




        </div>

        {{include file='view/includes/Betting/Right.tpl'}}

    </div>
    <!-- row -->
</div>
<!-- container -->

    <!--Start of Zopim Live Chat Script-->
    <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
                d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
                $.src="//v2.zopim.com/?43NHNyM0vP1nk998CDUnWqkczhu2S2E4";z.t=+new Date;$.
                type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");

        var page = "main";
    </script>
    <!--End of Zopim Live Chat Script-->
{{$Data.modules.footer}}