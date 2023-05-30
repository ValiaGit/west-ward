{{$Data.modules.header}}
<style>
    body {
        /* padding-top: 0 !important; */
    }
    .navbar-sub-header,
    div.push,
    div.footer{
        display: none;
    }

    #gameplay_bg {
        background: {{$Data.game.background}};
        background-size: cover;
    }

    #game_wrapper {
        margin: 0 auto;
    }

</style>
<body class="page-static">

<div class="wrapper" id="gameplay_bg">

    {{$Data.modules.topmenu}}

    {{if $ip|in_array:$config.whitelist or true}}
            <div id="game_wrapper"></div>
    {{else}}
        <div class="container page-container" style="margin-top:50px;">
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="content">
                        <h1>COMING SOON</h1>
                        {{$ip}}
                    </div>
                </div>
            </div>
        </div>
    {{/if}}


    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            Casino.openBCGame({{$Data.id}},'{{$Data.game.ratio}}');
        });
    </script>

    {{$Data.modules.footer}}
