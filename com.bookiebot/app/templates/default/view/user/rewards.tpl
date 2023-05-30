{{$Data.modules.header}}

{{$label_class = 'control-label col-md-3'}}
{{$input_class = 'col-md-9'}}
{{$form_class = '_col-md-5 _col-md-offset-3'}}

<body>

<div class="wrapper">
    {{$Data.modules.topmenu}}

    {{$Data.modules.bettingmenu}}




    <div class="container">

        <div class="row">

            <div class="col-md-12">

                {{$Data.modules.accountmenu}}

                <div class="panel panel-default panel-profile">

                    <div class="container-fluid" style="padding-bottom:25px">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{$base_href}}">
                                    <img src="{{$THEME}}/images/reweards_banner.jpg" class="img-responsive" title="Rewards"/>
                                </a>

                            </div>

                            <!-- col -->
                        </div>
                        <!-- row -->
                    </div>
                    <!-- container -->

                </div>
                <!-- panel -->

            </div>
            <!-- col -->
        </div>
        <!-- row -->

    </div>
    <!-- container -->



    {{$Data.modules.footer}}



