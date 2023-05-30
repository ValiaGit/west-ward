var MoneyProviders = {

    /**
     *
     * @param type 1 - Deposit; 2 -  Withdraw
     */
    renderList:function(type) {

        var tbody_item = $('#providers_data');

		Util.addLoader(tbody_item);

        API.call("cashier.paymentproviders","getList",{type:type},function(response){

			Util.removeLoader(tbody_item);

			if(response['code'] == 10) {
				var data = response['data'];
				data.forEach(function(provider){

					var onSBMT = '';
					// Deposit
					if ( type == 1 ){
						if ( provider.has_accounts == 1 ) {
							onSBMT = "Deposit.initTransactionWithAccounts(this);return false;";
						} else {
							onSBMT = "Deposit.initTransaction(this);return false;";
						};
						var FORMHtml = '<form method="POST" onsubmit="'+onSBMT+'"><input type="hidden" name="provider_interface" value="'+provider.interface+'" /><input type="hidden" name="provider_name"value="'+provider.class_name+'"/><input type="hidden" name="provider_id" value="'+provider.id+'"/><input type="hidden" name="commission"value="'+provider.commission+'"/><input type="text" name="amount"placeholder="'+lang_arr.enter_amount+'"class="form-control input-deposit input-default"/><button class="btn btn-sm btn-dark-blue btn-space">'+lang_arr.deposit+'</button></form>'

						// Withdraw
					} else {
						if ( provider.has_accounts == 1 ) {
							onSBMT = "Withdraw.initTransactionWithAccounts(this);return false;";
						} else {
							onSBMT = "Withdraw.initTransaction(this);return false;";
						};
						var FORMHtml = '<form method="POST" onsubmit="'+onSBMT+'"><input type="hidden" name="provider_interface" value="'+provider.interface+'" /><input type="hidden" name="provider_name" value="'+provider.class_name+'" /><input type="hidden" name="provider_id" value="'+provider.id+'" /><input type="text" name="amount" class="form-control input-deposit input-default" /><button class="btn btn-sm btn-dark-blue btn-space">'+lang_arr.withdraw+'</button></form>'
					}


					var TRHtml = '<tr><td class="white text-center" style="width:15%"><img src="'+base_href+'/_media/images/money_providers/'+provider.id+'.png" alt=""/></td><td><span class="small-grey"><span class="small-grey">'+lang_arr.min_amount+'</span></span><span class="large">'+provider.min_amount+' '+Currencies.list[provider.user_core_currency_id].icon+'</span></td><td><span class="small-grey">'+lang_arr.max_amount+'</span><span class="large">'+provider.max_amount+' '+Currencies.list[provider.user_core_currency_id].icon+'</span></td><td><span class="small-grey">'+lang_arr.commission+'</span><span class="large">'+provider.commission+'%</span></td><td class="text-center"><a class="icon-info-large" href="#"onclick="Util.Popup.open({title:\''+provider.title+'\',content:\''+lang_arr.money_providers_instructions[provider.id]+'\'})"></a></td><td class="text-center" valign="middle">'+FORMHtml+'</td></tr>';

					$('tbody#providers_data').append(TRHtml);
					console.log(provider);
				})
			}
			else {
				tbody_item.html("<p style='padding:15px;'>"+lang_arr['no_payment_options_for_currency']+"</p>");
			}



        },function() {
        	Util.removeLoader(tbody_item);
		});



    }


};
