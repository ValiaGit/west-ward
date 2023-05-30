<?php


if(!defined('APP')) {
    die();
}


class Documents extends Service {


    /**
     * @param int $user_id
     * @return array
     *      identity_type; 1 - Passport
                           2 - Driving License
                           3 - Personal Card
     */
    public function getDocuments($users_id = 0) {

        $user_id = (int) $users_id;

        $db = $this->db;
        $clause = " AND core_documents.core_users_id = $user_id ";

        $qs = "
                SELECT
                  core_documents.id,
                  core_documents.identity_type,
                  core_documents.document_number,
                  core_documents.copy_file_path,
                  core_documents.IsVerified,
                  core_countries.short_name as country,
                  CONCAT(core_users.first_name,' ',core_users.last_name) as fullname,
                  core_users.id as user_id,
                  DATE_FORMAT(core_documents.date_modified, '%Y-%m-%dT%TZ') as date_modified
                FROM
                  core_documents,
                  core_countries,
                  core_users
                WHERE
                  core_documents.core_countries_id = core_countries.id
                  AND
                  core_users.id = core_documents.core_users_id
                  $clause
            ";


        $data = $db->rawQuery($qs);



           return array("code"=>10,"data"=>$data);
    }


    /**
     * @param int $document_id
     * @return array
     */
    public function verifyDocument($document_id = 0) {
        if(!$document_id) {
            return array("code"=>50);
        }

        $db = $this->db;

        $db->where("id",$document_id);
        $update = $db->update("core_documents",array(
            "isVerified"=>1
        ));


        if($update) {
            $this->saveLog("User document was  verified: Documentid:$document_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }


    /**
     * @param int $document_id
     * @return array
     */
    public function unVerifyDocument($document_id = 0) {
        if(!$document_id) {
            return array("code"=>50);
        }

        $db = $this->db;

        $db->where("id",$document_id);
        $update = $db->update("core_documents",array(
            "isVerified"=>0
        ));


        if($update) {
            $this->saveLog("User document was  un verified: Documentid:$document_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }



}