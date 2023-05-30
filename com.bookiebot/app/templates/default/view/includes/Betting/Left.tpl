
<div class="col-md-3 left-sidebar">
    <div class="sidebar-content" data-step="1" data-intro="After registration is finished you can find your desired Sport and Team to bet on here!">


        <div class="list-group list-custom list-blue">
            <h2>{{$lang_arr.featured}}</h2>
            <div id="FavCategories"></div>

            <h2>{{$lang_arr.favotires}}</h2>
            <div id="UserCategories">

            </div>
        </div>

        <select class="form-control input-sm" onchange="App.getStore('categories').init($(this).val())" id="time_filter">
            <option value="-1">{{$lang_arr.all_matches}}</option>
            <option value="60">{{$lang_arr.next_15_min}}</option>
            <option value="60">next 30 Minutes</option>
            <option value="60">next 1 Hour</option>
            <option value="120">next 2 Hours</option>
            <option value="180">next 3 Hours</option>
            <option value="720">next 12 Hours</option>
            <option value="1440">next 24 Hours</option>
        </select>

        <div class="list-group list-custom list-dark">
            <h2>{{$lang_arr.sports}}</h2>
            <!--<select>
                <option value="1">1 miNute</option>
            </select>-->
            <div id="categoriesTree" ></div>
        </div>


    </div>
    <!-- sidebar-content -->
</div>
