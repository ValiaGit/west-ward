<ul class="nav nav-tabs children-tabs">
    {{foreach $Data.user_menu_list as $curpage}}
    {{if $curpage.id eq 15 || $curpage.id eq 5 || $curpage.id eq 4 || $curpage.id eq 16 || $curpage.id eq 17}}

    <li {{if $Data.method eq "deposit" or $Data.method eq "balance_management"}} class="active" {{/if}}>
        <a href="{{$base_href}}/{{$cur_lang}}/user/deposit">
            {{$lang_arr.deposit}}
        </a>
    </li>


    <li {{if $Data.method eq "withdraw"}} class="active" {{/if}}>
        <a href="{{$base_href}}/{{$cur_lang}}/user/withdraw">
            {{$lang_arr.withdraw}}
        </a>
    </li>

    <li {{if $Data.method eq "transfer_history"}} class="active" {{/if}}>
        <a href="{{$base_href}}/{{$cur_lang}}/user/transfer_history">
            {{$lang_arr.transfer_history}}
        </a>
    </li>


    <li {{if $Data.method eq "transfer_history_games"}} class="active" {{/if}}>
        <a href="{{$base_href}}/{{$cur_lang}}/user/transfer_history_games">
            {{$lang_arr.transfer_history_games}}
        </a>
    </li>

    <li {{if $Data.method eq "card_details"}} class="active" {{/if}}>
        <a href="{{$base_href}}/{{$cur_lang}}/user/card_details">
            {{$lang_arr.card_details}}
        </a>
    </li>
    {{/if}}
    {{/foreach}}
</ul>