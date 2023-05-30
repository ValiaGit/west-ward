
{{foreach $Data.list as $curpage}}
    <li {{if Fn::isActive($curpage.url)}} class="active"{{/if}}>
        <a href="{{$curpage.url}}" >
            <span class="glyphicon glyphicon-{{$curpage.icon}} social-nav-icon"></span> {{$curpage.title}}
        </a>
    </li>
{{/foreach}}
