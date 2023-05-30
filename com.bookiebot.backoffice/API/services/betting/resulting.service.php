<?php

if (!defined('APP')) {
    die();
}

class Resulting extends Service {

    public function addEventInResultingQueue($event_id, $type) {
        $db = $this->db;

        $event_id = (int)$event_id;

        $type = (int)$type;


        $insert_data = [
            "event_id"=>$event_id,
            "type"=>$type
        ];

        //Check If It's already insrted
        $db->where("event_id",$event_id);
        $db->where("type",$type);
        $exists = $db->getOne("betting_resulting_queue","id");

        if($exists) {
            return ["code"=>10,"msg"=>"Queue Exists"];
        }

        $inserted = $db->insert("betting_resulting_queue",$insert_data);
        if($inserted) {
            return ["code"=>10,"msg"=>"Inserted"];
        }
        else {
            return ["code"=>30,"msg"=>$db->getLastError()];
        }



    }
}