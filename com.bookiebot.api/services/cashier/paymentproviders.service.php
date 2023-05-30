<?php


if(!defined('APP')) {
    die();
}

class Paymentproviders extends Service
{
    public function getList($type) {

        global $db;

        $type = (int)$type;

        $user = $this->checkUserAccess();
        if($user) {

            $user_currency = $user['currency_name'];

            $db->where('type',$type);
            $db->where('status',1);
            $providers_list = $db->get("money_providers",null);

            if( $providers_list && count($providers_list) ) {

                $return_data = [];

                foreach($providers_list as $provider_item) {

                    if ( preg_match('/\b' . $user_currency . '\b/', $provider_item['supported_currencies']) ) {

                        $provider_item['min_amount'] = json_decode ($provider_item['min_amount'], true)[$user_currency];
                        $provider_item['max_amount'] = json_decode ($provider_item['max_amount'], true)[$user_currency];

                        $provider_item['instructions'] = 'Static Peach, Apple and etc.';
                        $provider_item['user_core_currency_id'] = $user['core_currencies_id'];

                        $return_data[] = $provider_item;
                    }

                }


                if(!count($return_data)) {
                    return ['code'=>60];
                }


                return ['code'=>10,'data'=>$return_data];


            }
            else {
                return ['code'=>60];
            }



        }

        else {
            return [
                'code'=>20
            ];
        }

    }

}
