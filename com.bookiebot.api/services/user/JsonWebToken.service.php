<?php



if(!defined('APP')) {
    die();
}

//Use \Firebase\JWT\JWT;
use Firebase\JWT\JWT;

class JsonWebToken extends Service {


    private $SECRET_KEY = "ASFJO#*RT!^&QWFGDd_i2u3424";


    /**
     * @param array $JWTArray
     * @return string
     */
    public function encrypt($JWTArray) {
            return JWT::encode($JWTArray,$this->SECRET_KEY);
    }

    /**
     * @param $JWTToken
     * @return object
     */
    public function decrypt($JWTToken) {

        try {
            $decrypted = (array) JWT::decode($JWTToken, $this->SECRET_KEY,array('HS256'));
            return $decrypted;
        } catch(Exception $e) {
            return false;
        }


    }

}
