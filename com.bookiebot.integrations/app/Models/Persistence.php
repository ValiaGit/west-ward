<?php

namespace App\Models;

use App\Integrations\Helpers\GISLogger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persistence extends Model
{
    //
    public $timestamps = false;

    protected $table = 'persistence';

    private $logger;


    public function __construct(GISLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function persist($key,$value,$update_on_duplicate = false) {

        $key = md5($key);

        //If Passed Arra Convert As JSON String
        if(gettype($value) != 'string') {
            $value = json_encode($value);
        }

        //This should be zipped
        $value = gzcompress($value,9);


        try {

            $save = DB::table("persistence")->insert(
                [
                    "_key"=>DB::raw('unhex(\''.$key.'\')'),
                    "_value"=>$value
                ]
            );

            if($save) {
                return true;
            }

            else {
                return false;
            }

        } catch(\Exception $e) {
            return false;
        }

    }


    /**
     * @param $key
     * @param bool $minimum_update_date - If this is passed query will select on records after specified time
     * @return bool|mixed
     */
    public function check($key,$is_key_md5 = false) {

        try {

            if(!$is_key_md5) {
                $key = md5($key);
            }


            //Query DB To get Record
            $record = DB::table('persistence')->where(
                '_key',DB::raw('unhex(\''.$key.'\')')
            )->first();


            //Zip Value Before Saving
            $value = gzuncompress($record->_value);

            try {
                $value_json = json_decode($value,true);
                if($value_json) {
                    $value = $value_json;
                }

            }catch(\Exception $json_parse_exception) {
                return false;
            }

            return $value;

        }catch(\Exception $e) {
            $this->logger->error("Exception happened during token removal",['key'=>$key,'msg'=>$e->getMessage()]);
            return false;
        }


    }


    /**
     * @param array $key
     * @param array $value
     * @param bool $is_key_md5
     * @return bool|mixed
     */
    public function edit($key,$value,$is_key_md5 = false) {


        if(!$is_key_md5) {
            $key = md5($key);
        }

        if(gettype($value) != 'string') {
            $value = json_encode($value);
        }


        //Query DB To get Record
        $record = DB::table('persistence')->where(
            '_key',DB::raw('unhex(\''.$key.'\')')
        );

        if(!$record) {
            $this->logger->error("There was not key found in persistence to make update on");
        }


        try {

            $updated = $record->update(['_value'=>gzcompress($value,9)]);

            return true;

        }catch(\Exception $e) {
            $this->logger->error("Exception happened during token removal",['key'=>$key,'msg'=>$e->getMessage()]);
            return false;
        }


    }



    /**
     * Removes Record By Key
     * @param $key
     * @return mixed
     */
    public function remove($key,$is_key_md5 = false) {

        if(!$is_key_md5) {
            $key = md5($key);
        }

        try {

            //Query DB To get Record
            $record = DB::table('persistence')->where(
                '_key',DB::raw('unhex(\''.$key.'\')')
            );

            if(!$record) {
                return false;
            }

            //Query DB To get Record
            $delete = $record->delete();

            if($delete) {
                return true;
            }

            return false;

        }catch(\Exception $e) {
            $this->logger->error("Exception happened during token removal",['key'=>$key,'msg'=>$e->getTrace()]);
            return false;
        }




    }



}
