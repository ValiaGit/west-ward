<html>
<head>
    <title>REST TESTER</title>
    <!-- Place this asynchronous JavaScript just before your </body> tag -->


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="http://api.kakauridze.com/media/css/libs/codelight/dark.css">


    <script>
        var base_href = '{{$base_href}}';
        var api_url = '{{$api_url}}';
        var cur_lang = "en";
    </script>


    <script type="text/javascript" src="{{$THEME}}/js/libs/jquery.js"></script>
    <script type="text/javascript" src="{{$THEME}}/js/libs/md5.js"></script>
    <script src="{{$THEME}}/js/libs/jquery-ui.min.js"></script>
    <script src="{{$THEME}}/js/libs/jquery.cookie.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="http://bookiebot.com/lang_en.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{$THEME}}/js/Betstock/Util.js"></script>
    <script type="text/javascript" src="{{$THEME}}/js/classes/API.js"></script>
</head>
<body>



<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">REST TESTER</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">SERVICES <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>-->
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-5">


            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">CHOOSE SERVICE</div>
                <div class="panel-body">
                    <select class="form-control" id="services">
                    </select>
                </div>
            </div>

            <div class="panel panel-default" style="display:none" id="methods_panel">
                <!-- Default panel contents -->
                <div class="panel-heading">METHODS FOR CHOSEN SERVICE</div>
                <div class="panel-body">
                    <select class="form-control" id="methods">
                    </select>
                </div>
            </div>

            <div class="panel panel-default" style="display:none" id="params_panel">
                <!-- Default panel contents -->
                <div class="panel-heading">Params</div>
                <div class="panel-body">
                    <form id="paramsForm" method="POST"></form>
                    <br />
                    <input class="btn btn-default" value="Call Service" onclick="callService()"/>
                </div>

            </div>



        </div>
        <div class="col-md-7">
            <div class="panel panel-default"  id="canvas">
                <!-- Default panel contents -->
                <div class="panel-heading">REST API TESTER CANVAS</div>
                <div class="panel-body">
                    <pre id="canvas" style="min-height:200px"></pre>
                    <div id="comments"></div>
                    <!--<a href="Errors.txt" target="_blank">Code Descriptions</a>-->
                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{$THEME}}/js/libs/jquery.cookie.js"></script>
<script src="http://yandex.st/highlightjs/8.0/highlight.min.js"></script>
<script>

    var service_data = null;

    API.call("rest.services","getServices",{ },function(response) {
        service_data = response;

        response.sort(function(a,b) {
            if (a.service < b.service)
                return -1;
            if (a.service > b.service)
                return 1;
            return 0;
        });

        var selectHTML = "<option value=''>Choose service..</option>";
        for(var index in response) {
            var service = response[index];
            selectHTML+="<option value='"+service.service+"' data-index='"+index+"'>"+service.service+"</option>";
        }
        $('#services').html(selectHTML);
    });


    $('#services').change(function() {
        $('#params_panel').fadeOut();
        $('#params').val("");
        $('#methods_panel').fadeOut(100);
        $('#methods').html("");
        $('pre#canvas').html("");
        $('div#comments').html("");
        var val = $(this).find(":selected").attr('data-index');
        var service = service_data[val];


        var methods = service.methods;
        var methodsHTML = "<option value=''>Choose method..</option>";
        for(var index in methods) {
            var curMethod = methods[index];
            methodsHTML+='<option value="'+curMethod.name+'" data-index="'+index+'" data-service_index="'+val+'">'+curMethod.name+'</option>';
        }
        $('#methods').html(methodsHTML);
        $('#methods_panel').fadeIn(100);
    });


    $('#methods').change(function() {
        var option = $(this).find(":selected");

        var service_index = option.attr('data-service_index');
        var method_index = option.attr('data-index');

        var paramsHtml = "";
        var paramsInputs = "";
        var method = service_data[service_index].methods[method_index];
        var params = method.parameters;
        var comments = method.comments;
        $('#comments').html('').html("<pre>"+comments+"</pre>");

        console.log(params);

        for(var index in params) {
            var cur = params[index];
            paramsInputs+= '<div class="form-group">' +
                    '<label for="exampleInputPassword1">'+cur.name+'</label>' +
                    '<input type="text" name="'+cur.name+'" class="form-control" id="'+cur.name+'" placeholder="" value="">' +
                    '</div>';


        }


        paramsHtml = "{"+paramsHtml+"}";
        $('#params_panel').show();
        $('#paramsForm').html(paramsInputs);
    });

    function serialize(form) {
        var serialized = form.serializeArray();
        var retObj = {

        };

        for(var i in serialized) {
            var field = serialized[i];

            if(field.value!="") {
                retObj[field.name] = field.value;
            }

        }
        return retObj;
    }

    function callService() {
        var service = $('#services').val();
        var method = $('#methods').val();


        var params = serialize($('#paramsForm'));
        params.user_id = Util.Cookie.get("user_id");
        //params.user_id = Util.Cookie.get('user_id');
        $('#canvas').fadeOut(100);
        console.log(JSON.stringify(params));
        API.call(service,method,params,function(response) {



            if(method=="login") {
                if(response.code == 10) {
                    $.cookie("user_id",response.user.id);
                }

            }

            var string = JSON.stringify(response, null, "\t");
            $('pre#canvas').text(string);
            highlight();
            $('#canvas').fadeIn(100);
        },function() {
            $('#canvas').fadeIn(100);
        });

    }








    function highlight() {
        $('pre#canvas').each(function(i, e) {
            hljs.highlightBlock(e)
        });
    }
    highlight();
</script>
</html>

