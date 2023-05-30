{{$Data.modules.header}}
<body class="page-static">


<div class="wrapper">

{{$Data.modules.topmenu}}


{{$Data.modules.bettingmenu}}



<div class="container page-container">
	 <div class="row">

         <div class="col-md-2 page-sidebar">
             {{$Data.modules.sidebarmenu}}
         </div>
         <div class="col-md-10 page-content">
             <!--<ol class="breadcrumb">
                 <li class="b-label">You are here:</li>
                 <li><a href="#">Home</a></li>
                 <li><a href="#">Library</a></li>
                 <li class="active">Data</li>
             </ol>-->
            <div class="content">

                <h1>{{$Data.page.title}}</h1>
                {{if $Data.page.content}}
                    {{foreach $Data.page.content as $content_value}}
                        {{$content_value}}
                    {{/foreach}}
                {{/if}}

            </div>
         </div>
	</div>

</div>



{{$Data.modules.footer}}


