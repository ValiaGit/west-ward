<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 10/23/13
 * Time: 4:15 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined("APP")) {
    die("No Access");
}

class Rewards_Model extends Model {


    public function getStats() {
        $stats_service = $this->loadApiService("user.stats");
        return $stats_service->getUserStats();
    }


}

