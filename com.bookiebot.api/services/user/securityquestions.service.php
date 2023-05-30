<?php

if (!defined('APP')) {
    die();
}



class Securityquestions extends Service {


    /**
     * @return array
     */
    public function getList()
    {
        $db = $this->db;

        $data = $db->get("core_security_questions", null, "id,question");

        if(count($data)) {
            return array("code"=>10,"data"=>$data);
        }

        else {
            return array("code"=>60);
        }
    }

    /**
     * Get Security Question Value
     */
    public function getSecurityQuestionForCurrentUser() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $data = $db->rawQuery("
                                    SELECT
                                      core_security_questions.id as question_id,
                                      core_security_questions.question
                                    FROM
                                      core_security_questions,
                                      core_security_answers
                                    WHERE
                                      core_security_answers.core_users_id = $user_id
                                      AND
                                      core_security_questions.id = core_security_answers.core_security_questions_id
                                    ");
            if(count($data)) {
                return array("code"=>10,"data"=>$data[0]);
            } else {
                return array("code"=>60);
            }

        }
        else {
            return array("code"=>40);
        }
    }

    /**
     * @param bool $core_question_id
     * @param bool $answer_value
     * @return array
     */
    public function checkSecurityQuestion($user_id = false, $core_question_id = false, $answer_value = false)
    {

            global $config;
            $db = $this->db;
            $user_id = (int) $user_id;


            $db->where("answer_value",base64_encode(hash("sha512", $answer_value . $config['security_questions_sault'], True)));
            $db->where("core_users_id",$user_id);
            $db->where("core_security_questions_id",$core_question_id);

            $one = $db->getOne("core_security_answers","1");

            if($one) {
                return array("code"=>10);
            } else {
                return array("code"=>20);
            }


    }


    /**
     * @return array
     */
    public function changeSecurityQuestion($question_id = false,$answer_value = false,$user_password = false) {


        if(!$question_id || !$answer_value || !$user_password || empty($user_password) || empty($answer_value)) {
            return array("code"=>50);
        }


        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            global $config;
            $db = $this->db;


            //Check User Old Password Correctness
            $db->where("id",$db->escape($user_id));
            $user_password = sha1($db->escape($user_password).$config['password_sault']);
            $db->where("password",$db->escape($user_password));

            //Check Current User Provided Password Was Correct
            $check_password_for_current_user = $db->getOne("core_users","1");
            if($check_password_for_current_user) {

                //Save Changed Security Question
                $db->where("core_users_id",$user_id);
                $update_array = array(
                    "core_security_questions_id"=>$question_id,
                    "answer_value"=>base64_encode(hash("sha512", $answer_value . $config['security_questions_sault'], True))
                );
                $update_status = $db->update("core_security_answers",$update_array);

                var_export($update_status);

            }



            //Update Security QAnswer Value



        }

        else {
            return array("code"=>20);
        }
    }

}