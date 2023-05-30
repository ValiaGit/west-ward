<?php


if(!defined('APP')) {
    die();
}



class Currencies extends Service {


    private static $base_currency_id = 1;


    /**
     *
     */
    public function getList() {


        global $db;

        $return_data = [];


        $list = $db->rawQuery("select id,name,exchange_rate,iso_code,iso_name from core_currencies");

        //Iterate Over Currencies
        foreach($list as $currency_node) {
            $return_data[$currency_node['id']] = [
                "name"=>$currency_node['name'],
                "exchange_rate"=>$currency_node['exchange_rate'],
                "iso_code"=>$currency_node['iso_code'],
                "iso_name"=>$currency_node['iso_name']
            ];
        }

        return array(
            'code'=>10,
            "data"=>$return_data
        );

    }



    /**
     * @param $fromCurrency
     * @param $toCurrency
     * @param $amount
     * @return array|void
     */
    public function exchange($fromCurrency, $toCurrency, $amount) {

        global $db;

        ini_set('display_errors',1);

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $fromCurrency = (int)$fromCurrency;
            $toCurrency = (int)$toCurrency;

            //If From Is Base Return to's exchange rate
            if($fromCurrency == Currencies::$base_currency_id) {

                $exchange_rate = $db->rawQuery("SELECT exchange_rate from core_currencies WHERE id=$toCurrency LIMIT 1");


                if(count($exchange_rate)) {
                    return [
                        'code'=>10,
                        'amount'=>($exchange_rate[0]['exchange_rate']*$amount)
                    ];
                }

                else {
                    return array("code"=>60);
                }

            }


            //If to currency
            if($toCurrency == Currencies::$base_currency_id) {

                $exchange_rate = $db->rawQuery("SELECT exchange_rate from core_currencies WHERE id=$fromCurrency LIMIT 1");


                if(count($exchange_rate)) {
                    return [
                        'code'=>10,
                        'amount'=>($exchange_rate[0]['exchange_rate']*$amount)
                    ];
                }

                else {
                    return array("code"=>60);
                }

            }


            //From Currency to base and then from base to toCurrency
            $qs = "select from_currency.exchange_rate as  from_rate, to_currency.exchange_rate as to_rate  from core_currencies from_currency, core_currencies to_currency where from_currency.id=$fromCurrency AND to_currency.id=$toCurrency ";
            $exchange_rates = $db->rawQuery($qs);

            if(count($exchange_rates)) {

                $rates = $exchange_rates[0];




                return [
                    'code'=>10,
                    'amount'=>($amount/$rates['from_rate'])*$rates['to_rate'],
                    "rates"=>$rates
                ];



                return $exchange_rates;
            }
            else {
                return['code'=>60];
            }




        }
        else {
            return [
              'code'=>20
            ];
        }






    }


}