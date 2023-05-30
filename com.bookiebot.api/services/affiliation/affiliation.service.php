<?php

/**
 * Created by PhpStorm.
 * User: shako
 * Date: 2/2/17
 * Time: 10:19 AM
 */
class Affiliation extends Service
{

    /**
     * @return array
     */
    public function hasPayedMasterAffiliationFee() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

        }
        else {
            return array("code"=>20);
        }
    }




}