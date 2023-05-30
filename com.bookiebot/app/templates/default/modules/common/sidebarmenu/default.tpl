<ul class="nav nav-page">
    {{foreach $Data.sidebar_menu as $page}}
    <li {{if Fn::isActive($page.url)}} class="active"{{/if}}><a href="{{$page.url}}">{{$page.title}}</a></li>
    {{/foreach}}
</ul>