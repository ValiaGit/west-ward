{{$Data.modules.header}}
<body class="page-static">


<div class="wrapper"
     style="background: url({{$THEME}}/backgrounds/sport.jpeg) no-repeat top center;min-width:1224px !important;">

    {{$Data.modules.topmenu}}


    {{$Data.modules.bettingmenu}}


    {{if $ip|in_array:$config.whitelist or true}}
    <style>
        #bcsportsbookcontainer { float: left;width: 100%;height: 700px;position: relative;overflow: hidden;}
        #bcsportsbookcontainer iframe {height: 800px;position: absolute;top: ­100px;width: 100%;left: 0;}
    </style>
    <div class="container page-container" style="width:100%!important;">
        <div class="row">

            <div class="col-md-12 page-content" style="padding:0 0 0 4px;">
                <div class="content">

                    <div class="row" style="padding-left:10px;">
                        <div id="bcsportsbookcontainer"></div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    {{else}}
    <div class="container page-container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-12 page-content">
                <div class="content">
                    <h1>COMING SOON</h1>
                    {{$ip}}
                </div>
            </div>
        </div>
    {{/if}} 

</div>

<script>
    document.domain = 'betplanet.win';
    var page = 'sport';
    (function () {
        window.bettingCB = function bettingCB(name, value) {
            if (name === "balance") {
                Session.init();
                console.log("balance:", value);
            }

            else if (name === "login") {
                console.log("login button clicked from ", value);
            }


            else if (name === "register") {
                console.log("register button clicked from ", value)
            }


            else if (name === "selectedGameOffset") {
                console.log("current displayed game has offset ­ x:",
                        value.left, "y: ", value.top);
            }

            else if (name === "windowSize") {
                $('#bcsportsbookcontainer, #bcsportsbookcontainer iframe').height(5500);
                console.log("iframe size:",
                        value.width + "x" + value.height);
            }

            else if (name === "bodyHeight") {
                $('#bcsportsbookcontainer, #bcsportsbookcontainer iframe').height(5500);
                console.log("iframe body height changed to:", value);
            }
        }
    })();


</script>

{{$Data.modules.footer}}


