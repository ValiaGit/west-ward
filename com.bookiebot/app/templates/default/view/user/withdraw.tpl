{{$Data.modules.header}}
<body>

<div class="wrapper">

{{$Data.modules.topmenu}}

{{$Data.modules.bettingmenu}}

<div class="container">

    <div class="row">

        <div class="col-md-12">

            {{$Data.modules.accountmenu}}
            {{$Data.modules.accountsubmenu}}


            <div class="panel panel-default panel-profile no-space">
                <div class="container-fluid no-space">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-custom table-custom-border">
                                <tbody id="providers_data">

                                </tbody>
                            </table>
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

<script>
    MoneyProviders.renderList(2);
</script>
