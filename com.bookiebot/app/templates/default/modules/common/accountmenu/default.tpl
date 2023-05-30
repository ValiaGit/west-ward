<ul class="nav nav-tabs profile-tabs">
    {{foreach $Data.user_menu_list as $curpage}}
        <li{{if Fn::isActive($curpage.url)}} class="active"{{/if}} >
            <a href="{{$curpage.url}}">
                <i class="glyphicon glyphicon-{{$curpage.icon}}"></i> {{$curpage.title}}
            </a>
        </li>
    {{/foreach}}
</ul>