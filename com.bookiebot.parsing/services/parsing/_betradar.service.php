<?php

if (!defined('APP')) {
    die();
}


/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class _Betradar extends Service
{

    
    private $parse_url = "https://www.betradar.com/betradar/getXmlFeed.php?bookmakerName=Betstock&key=758123ac78a8&xmlFeedName=Fixtures&deleteAfterTransfer=yes";
    private $queue_remove_url = "https://www.betradar.com/betradar/getXmlFeed.php?bookmakerName=Betstock&key=758123ac78a8&xmlFeedName=Fixtures&deleteFullQueue=yes";

    private $xml = null;
    private $xml_string = null;
    private $file_name = null;


    /**
     * Parse Data From File
     */
    public function openFile() {
        $file_path = $_GET['file_path'];



        //XML SERVICE
        $file = ROOT_DIR."".$file_path;

        if(!file_exists($file)) {
            echo "No File";
            return false;
        }



        $xml_string = file_get_contents($file);
        $xml = @simplexml_load_string($xml_string);
        echo $xml;
        $this->xml = $xml;
        $this->xml_string = $xml_string;
        $this->file_name = $file_path;
        $this->handle();

    }



    /**
     * Request Bet radar And Get Data
     */
    public function request() {


        $file_name = date("d-m-Y H:i:s");
        $xml_string = file_get_contents($this->parse_url);

        $no_data = strpos($xml_string,"Too frequent");

        if($xml_string && !$no_data) {
            try {
                //XML SERVICE
                if(is_dir(ROOT_DIR."/BetradarXML/")) {
                    $datafile = fopen(ROOT_DIR."/BetradarXML/".$file_name.".xml","a+");
                    if($datafile) {
                        echo "WroteDataNew=".(boolean) fwrite($datafile,"$xml_string");
                    }
                }
            }catch(Exception $e) {
                echo $e->getMessage();
            }


        } else {
            echo "Did not save";
            return false;
        }



        $xml = @simplexml_load_string($xml_string);


        $this->xml = $xml;
        $this->xml_string = $xml_string;

        $this->file_name = $file_name;
        $this->handle();
    }



    /**
     * Remove Bet radar Queue
     */
    public function removeQueue() {
        $xml_string = file_get_contents($this->queue_remove_url);
        echo $xml_string;
    }


    /**
     * Check Some XML Validations
     * @return bool
     */
    private function handle() {


        $xml = $this->xml;


        if(!count($xml->Sports)) {
            return false;
        }

        $countSports = count($xml->Sports->Sport);
        if(!$countSports) {
            return false;
        }

        $this->handelSports();
    }


    /**
     *
     */
    private function handelSports() {

        $db = $this->db;
        $xml = $this->xml;

        //Iterate Over Sports
        foreach($xml->Sports->Sport AS $sport) {

            $BetRadarSportID = (array)$sport['BetradarSportID'];
            $BetRadarSportID = $BetRadarSportID[0];

            $sport_title = $this->GetTitleAsJSON($sport->Texts,true);
            $code = strtolower($sport_title['BET']);
            $sport_title = json_encode($sport_title);


            $insert_data = array(
                "BetradarSportId"=>$BetRadarSportID,
                "title"=>$sport_title,
                "status"=>1,
                "code"=>$code,
            );

            $sport_id = $this->checkExistence("betting_sport","BetradarSportId",$BetRadarSportID,$insert_data);

            if($sport_id) {
                echo "Sport: $sport_title ($sport_id) <br/>";
                $Category = $sport->Category;
                $this->handleCategories($Category,$sport_id);
            }

            echo "<hr/><hr/>";

        }
    }


    /**
     * @param $Category
     * @param $sport_id
     */
    private function handleCategories($Category,$sport_id) {
        $this->sport_id = $sport_id;
        foreach($Category as $category) {


            $BetRadarCategoryID = (array)$category['BetradarCategoryID'];
            $BetRadarCategoryID = $BetRadarCategoryID[0];

            $IsoName = (array)$category['IsoName'];
            $IsoName = isset($IsoName[0]) ?$IsoName[0]:"";

            $category_title = $this->GetTitleAsJSON($category->Texts);


            $insert_data = array(
                "betting_sport_id"=>$sport_id,
                "BetradarCategoryId"=>$BetRadarCategoryID,
                "title"=>$category_title,
                "code"=>$IsoName
            );
            if(count($category->Outright)) {
                $insert_data['has_outright'] = 1;
            }

            $category_id = $this->checkExistence("betting_category","BetradarCategoryId",$BetRadarCategoryID,$insert_data);

            echo "Category: $category_title ($category_id) <br/>";

            //Handle Tournaments
            if(count($category->Tournament)) {
                $Tournaments = $category->Tournament;
                $this->handleTournaments($Tournaments,$category_id);
            }

            //Handle Outright
            if(count($category->Outright)) {
                $Outright = $category->Outright;
                $this->handleOutRights($Outright,$category_id,$sport_id);
            }


        }
    }


    /**
     * Handle Outright Tournament
     * @param $Outright
     * @param $category_id
     * @param $sport_id
     */
    private function handleOutRights($Outright,$category_id,$sport_id) {
        $db = $this->db;

        /**
         * Iterate Over All Outright Tournaments That Are Inside A Category
         */
        foreach($Outright as $outright) {
            $BetradarOutrightID = (array)$outright['BetradarOutrightID'];
            $BetradarOutrightID = $BetradarOutrightID[0];

            $Fixture = $outright->Fixture;

            $EventInfo = $Fixture->EventInfo;

            $EventName = $this->GetTitleAsJSON($EventInfo->EventName->Texts);
            $Off = $EventInfo->Off;
            $EventDate = (array)$EventInfo->EventDate;
            $EventDate = $EventDate[0];


            $EventEndDate = (array) $EventInfo->EventEndDate;
            $EventEndDate = $EventEndDate[0];

            $TournamentId = (array)$EventInfo->TournamentId;
            $TournamentId = $TournamentId[0];



            //Save Outright Tournament In Database
            $insert_data = array(
                "BetradarOutrightID"=>$BetradarOutrightID,
                "TournamentId"=>$TournamentId,
                "title"=>$EventName,
                "betting_category_id"=>$category_id,
                "betting_category_betting_sport_id"=>$sport_id,
                "EventDate"=>$EventDate,
                "status"=>1,
                "EventEndDate"=>$EventEndDate
            );


            $OutrightTournamentID = $this->checkExistence("betting_outright","BetradarOutrightID",$BetradarOutrightID,$insert_data);
            echo "Outright Tournament: $EventName ($OutrightTournamentID) <br/>";


            //After We Save Tournament
            //We Have To Save Competitors And Odds Data For That Competition
            $Competitors = $Fixture->Competitors;
            //Id On Every Competitor Is Also Outright Odd ID
            $this->handleOutrightOdds($Competitors,$OutrightTournamentID);




            //Handle Outright Results
            $OutrightResult = $outright->OutrightResult;
            if($OutrightResult) {
                $this->saveLog("Received Result. Outright:$OutrightTournamentID betradar_outright_id:$BetradarOutrightID",1);
                $savedBetResults = $this->handleOutrightBetResults($OutrightResult,$OutrightTournamentID);
            }
        }

    }


    /**
     * Save Competitors Data On Outright Tournament With Corresponding Odds
     * @param $Competitors
     * @param $OutrightTournamentID
     */
    private function handleOutrightOdds($Competitors,$OutrightTournamentID) {
        $db = $this->db;

        foreach($Competitors->Texts as $index=>$competitor) {

            //OutrightOdd
            $BetradarOutrightOddID = (array)$competitor->Text['ID'];
            $BetradarOutrightOddID = $BetradarOutrightOddID[0];

            //OutrightOddTitle
            $competitor_title = $this->GetTitleAsJSON($competitor->Text);


            //Save Betting Competitor
            $outright_competitor_id = $this->checkExistence("betting_outright_competitors","BetradarOutrightOddID",$BetradarOutrightOddID,array(
                "BetradarOutrightOddID"=>$BetradarOutrightOddID,
                "title"=>$competitor_title
            ));




            //Check If We Already Saved OutrightOdd With Selected Competition
            $db->where('betting_outright_id',$OutrightTournamentID);
            $db->where('BetradarOutrightOddID',$BetradarOutrightOddID);
            $exists = $db->getOne("betting_outright_odds","1");
            //If odd doesn't exists add new one
            if(!$exists) {
                $insert_data = array(
                    "betting_outright_id"=>$OutrightTournamentID,
                    "BetradarOutrightOddID"=>$BetradarOutrightOddID,
                    "betting_outright_competitors_id"=>$outright_competitor_id,
                    "status"=>1,
                    "title"=>$competitor_title
                );
                $inserted = $db->insert("betting_outright_odds",$insert_data);
            }
        }
    }



    /**
     * @param $OutrightEventResult
     * @param $OutrightTournamentID
     * @return boolean
     */
    private function handleOutrightBetResults($OutrightEventResult,$OutrightTournamentID) {
        $db = $this->db;

        try {
            $WinnerOutrightOddId = (array) $OutrightEventResult->Result['ID'];
            $WinnerOutrightOddId = (int)$WinnerOutrightOddId[0];

            $db->startTransaction();



            //Update Loser Odds
            $db->where ("BetradarOutrightOddID!= $WinnerOutrightOddId");
            $db->where ("betting_outright_id=$OutrightTournamentID");
            $updateAsLosers = $db->update("betting_outright_odds",array("status"=>2));


            //Update Winner Odds
            $db->where("BetradarOutrightOddID",$WinnerOutrightOddId);
            $db->where("betting_outright_id",$OutrightTournamentID);
            $updateWinner = $db->update("betting_outright_odds",array("status"=>3));



            //Insert Resulting Queue
            $inserted_queue_id = $db->insert("betting_resulting_queue",array("file_name"=>$this->file_name,"event_id"=>$OutrightTournamentID,"type"=>2));


            //Update Outright Event As Finished
            $db->where("id",$OutrightTournamentID);
            $update_as_finished = $db->update("betting_outright",array("status"=>2));



            if($updateAsLosers && $updateWinner && $update_as_finished && $inserted_queue_id) {
                $db->commit();
                return true;
            } else {
                $db->rollback();
                $this->saveLog("Cant save outright results: $OutrightTournamentID, ".$db->getLastError());
                return false;
            }



        }catch(Exception $e) {
            $this->saveLog("Error Happened When Tried To Save Result Fro Outright: $OutrightTournamentID");
            return false;
        }



    }

    /**
     * @param $Tournaments
     * @param $category_id
     */
    private function handleTournaments($Tournaments,$category_id) {
        $this->category_id = $category_id;
        foreach($Tournaments as $tournament) {

            $BetRadarTournamentID = (array)$tournament['BetradarTournamentID'];
            $BetRadarTournamentID = $BetRadarTournamentID[0];
            $tournament_title = $this->GetTitleAsJSON($tournament->Texts);

            $insert_data = array(
                "betting_category_id"=>$category_id,
                "BetradarTournamentId"=>$BetRadarTournamentID,
                "title"=>$tournament_title,
                "status"=>1
            );

            $tournament_id = $this->checkExistence("betting_tournament","BetradarTournamentId",$BetRadarTournamentID,$insert_data);

            echo "Tournament: $tournament_title ($tournament_id) <br/>";

            $Match = $tournament->Match;
            $this->handleMatches($Match,$tournament_id);
        }
    }


    /**
     * @param $Match
     * @param $tournament_id
     */
    private function handleMatches($Match,$tournament_id) {

        $db = $this->db;
        $this->tournament_id = $tournament_id;

        foreach($Match as $match) {

            $BetRadarMatchID = (array)$match['BetradarMatchID'];
            $BetRadarMatchID = $BetRadarMatchID[0];

            $Fixture = $match->Fixture;
            $BetFairIDs = (array) $match->BetfairIDs->EventID;
            $BetFairEventID = 0;


            if(count($BetFairIDs)) {
                $BetFairEventID = ($BetFairIDs[0]);
            }

            $StatusInfo = $Fixture->StatusInfo;
            $Off = $Fixture->StatusInfo->Off;

            $MatchDate = (array)$Fixture->DateInfo->MatchDate;

            $MatchDate = $MatchDate[0];



            $Round = $Fixture->RoundInfo->Round;

            $Competitors = $Fixture->Competitors->Texts;
            $competitor_ids = $this->handleMatchCompetitors($Competitors);
            $competitor1 = $competitor_ids[0];
            $competitor1 = $competitor1['id'];

            $competitor2 = $competitor_ids[1];
            $competitor2 = $competitor2['id'];



            $insert_data = array(
                "BetradarMatchId"=>$BetRadarMatchID,
                "BetFairEventId"=>$BetFairEventID,
                "betting_tournament_id"=>$tournament_id,
                "betting_competitors_id"=>$competitor1,
                "betting_competitors_id1"=>$competitor2,
                "betting_sport_id"=>$this->sport_id,
                "betting_category_id"=>$this->category_id,
                "starttime"=>$MatchDate,
                "type"=>1,
                "status"=>0
            );

            //Save Match
            $match_id = $this->checkExistence("betting_match","BetradarMatchId","$BetRadarMatchID",$insert_data);

            echo "Match: ($match_id) <br/>";

            $insert_data['match_id'] = $match_id;
            $MatchOdds = $match->MatchOdds;



            /**
             *
             */
            $BetResults = $match->BetResult;



            /**
             * Save Odds For Match
             */
            if(count($MatchOdds) && !count($BetResults)) {
//                echo "handleMatches = ";
//                var_export($match_id);

                $this->handleMatchOdds($MatchOdds,$match_id);
                $db->where('id',$match_id);
                $db->update("betting_match",array("status"=>1));
            }
            //Save Just Fixture
            else {
                $this->saveLog("Updated As Disabled No Odds match_id:$match_id, BetRadarMatchID:$BetRadarMatchID",1);

            }




            if(count($BetResults)) {
                $this->saveLog("Received Result. match_id:$match_id betradarmatch_id:$BetRadarMatchID",1);
                $insert_queue =  $db->insert("betting_resulting_queue",array(
                    "file_name"=>$this->file_name,
                    "event_id"=>$match_id,
                    "type"=>1
                ));

                $this->handleMatchBetResults($BetResults,$match_id);
            }


            /**
             *
             */
            $ResultScore = $match->Result->ScoreInfo;
            if(count($ResultScore)) {
                $this->saveLog("Received Match Score match_id:$match_id, BetRadarMatchID:$BetRadarMatchID",1);
                $this->HandleMatchScore($ResultScore,$match_id);
            }


        }
    }



    /**
     * @param $Competitors
     * @return array
     */
    private function handleMatchCompetitors($Competitors) {

        $competitor_ids = array();
        foreach($Competitors as $competitor) {
            $compText = $competitor->Text;


            $BetRadarCompetitorID = (array)$compText['ID'];
            $BetRadarCompetitorID = $BetRadarCompetitorID[0];

            $BetRadarCompetitorType = (array)$compText['Type'];
            $BetRadarCompetitorType = $BetRadarCompetitorType[0];


            $competitor_titles =  $this->GetTitleAsJSON($competitor->Text);

            $insert_data = array(
                "betting_sport_id"=>$this->sport_id,
                "BetradarCompetitorId"=>$BetRadarCompetitorID,
                "title"=>$competitor_titles
            );

            $competitor_id = $this->checkExistence("betting_competitors","BetRadarCompetitorID",$BetRadarCompetitorID,$insert_data);
            array_push($competitor_ids,array("id"=>$competitor_id,"type"=>$BetRadarCompetitorType));
        }


        return $competitor_ids;
    }


    /**
     * @param $MatchOdds
     * @param $match_id
     * @return bool
     */
    private function handleMatchOdds($MatchOdds,$match_id) {
        $db = $this->db;

        $sport_id = $this->sport_id;
        $category_id = $this->category_id;
        $tournament_id = $this->tournament_id;

        if(!count((array)$MatchOdds->Bet)) {
            return false;
        }


            //Iterate Over Bets
            foreach($MatchOdds->Bet as $Bet) {

                $OddsType = (array)$Bet['OddsType'];
                $OddsType = (int)$OddsType[0];

                //Check If OddType Exists In Database
                $insert_data = array(
                    "BetradarOddsTypeID"=>$OddsType,
                    "title"=>"title-$OddsType",
                    "status"=>1
                );
                $odd_type_id = $this->checkExistence("betting_oddtypes","BetradarOddsTypeID",$OddsType,$insert_data);


                //Check This Odd Type For Current Sport And Save As OddType For Current Sport
                $db->where("betting_oddtypes_id",$odd_type_id);
                $db->where("betting_sport_id",$sport_id);
                $type_in_sport = $db->getOne("betting_sport_has_betting_oddtypes","1");
                if(!$type_in_sport) {
                    $data_to_insert = array("betting_sport_id"=>$sport_id,"betting_oddtypes_id"=>$odd_type_id);
                    $db->insert("betting_sport_has_betting_oddtypes",$data_to_insert);
                }

                $Odds = $Bet->Odds;
                if(count((array)$Odds)) {
                    $this->saveOdds($Odds,$match_id,$odd_type_id);
                }
            }



    }



    /**
     * Save Odds If We don't have saved odd with selected typeid we save it in database.
     * And After we have already saved oddsid or new inserted odds id we save it as Concrete Match's odd.
     * @param $Odds
     * @param $match_id
     * @param $odd_type_id
     */
    private function saveOdds($Odds,$match_id,$odd_type_id) {

        $db = $this->db;

//        echo "$match_id<hr/>";


        $testOdds = (array)$Odds;



        //Iterate Over Odds Available For Current Match
        foreach($Odds as $index=>$odd) {


            $OutCome = (string) $odd['OutCome'];


            if($OutCome == "-1") {
                continue;
            }


            if(isset($odd['SpecialBetValue'])) {
                $SpecialBetValue = (array)$odd['SpecialBetValue'];
                $SpecialBetValue = $SpecialBetValue[0];
            }
            else {
                $SpecialBetValue = "";
            }


            try {
                $oddValue = (array)$odd;
                if(isset($oddValue[0])) {
                    $oddValue = $oddValue[0];
                } else {
                    $oddValue = "";
                }
            }catch(Exception $e) {
                echo $e->getMessage();
            }



            /**
             * Check if we already have this odd
             * and save it if we don't have
             */
            $odd_types_with_player_names = array(172,171);

            $match_odd_name = "";
            //$instance = $db->getSQLIInstance();
            if(in_array($odd_type_id,$odd_types_with_player_names)) {
                $match_odd_name = $OutCome;
                $qs = "
                                      SELECT
                                          odds.id
                                      FROM
                                          betting_odds odds
                                      WHERE
                                          betting_oddtypes_id = $odd_type_id
                                      LIMIT 1
                                    ";
            } else {
                $qs = "
                                      SELECT
                                          odds.id
                                      FROM
                                          betting_odds odds
                                      WHERE
                                          OutCome = '$OutCome'
                                          AND
                                          betting_oddtypes_id = $odd_type_id
                                      LIMIT 1
                                    ";
            }


            $odd_id_result = $db->rawQuery($qs);
            if(!($odd_id_result)) {
                $insert_data = array(
                    "betting_oddtypes_id"=>$odd_type_id,
                    "OutCome"=>$OutCome,
                    "title"=>$OutCome,
                    'status'=>1
                );
                $odd_id = $db->insert('betting_odds',$insert_data);
            } else {
                $odd_id =  $odd_id_result[0]['id'];

            }



            $db->where("betting_match_id",$match_id);
            $db->where("betting_odds_id",$odd_id);
            $db->where("SpecialBetValue",$SpecialBetValue);
            $checkOddExists = $db->getOne("betting_match_odds","id,oddValue");

            if(!$checkOddExists) {

                //Insert Odd As Match's Odd
                $match_odd_insert_data = array(
                    "betting_match_id"=>$match_id,
                    "betting_odds_id"=>$odd_id,
                    "SpecialBetValue"=>$SpecialBetValue,
                    "status"=>1,
                    "oddValue"=>$oddValue,
                    "match_odd_name"=>$match_odd_name
                );
                $match_odd_insert = $db->insert("betting_match_odds",$match_odd_insert_data);

            } else {

                //If BetRadar Changed Trending Odd Value
                if($checkOddExists['oddValue']!=$oddValue) {
                    $match_idd_id = $checkOddExists['id'];
                    $db->where("id",$match_idd_id);
                    $match_odd_update = $db->update("betting_match_odds",array("oddValue"=>$oddValue));
                }

            }
        }


    }



    /**
     * @param $BetResult
     * @param $match_id
     * @return array
     */
    private function handleMatchBetResults($BetResult,$match_id) {


        if(!count($BetResult)) {
            return false;
        }


        $db = $this->db;

        $update_data = Array (
            'status' => 2
        );
        $db->where('id',$match_id);
        $update_match = $db->update('betting_match', $update_data);

        if($update_match) {
            $this->saveLog("Updated As Finished-Result match_id:$match_id");
        }



        foreach($BetResult->W as $index=>$Won_Odd) {
            $OutCome = $Won_Odd['OutCome'];
            $OddsType = $Won_Odd['OddsType'];
            $SpecialBetValue = "";
            if(isset($Won_Odd['SpecialBetValue'])) {
                $SpecialBetValue = $Won_Odd['SpecialBetValue'];
            }


            $qs_select_match_odd_id = "
                                               SELECT
                                                    match_odds.id as match_odd_id
                                               FROM
                                                    betting_match_odds match_odds,
                                                    betting_oddtypes oddtypes,
                                                    betting_odds odds
                                               WHERE
                                                   oddtypes.BetradarOddsTypeID = '$OddsType'
                                                    AND
                                                   odds.OutCome = '$OutCome'
                                                    AND
                                                   match_odds.SpecialBetValue = '$SpecialBetValue'
                                                    AND
                                                   odds.betting_oddtypes_id = oddtypes.id
                                                    AND
                                                   odds.id = match_odds.betting_odds_id
                                                    AND
                                                   match_odds.betting_match_id = $match_id
                                               ";


            $match_odds = $db->rawQuery($qs_select_match_odd_id);


            if($match_odds) {

                foreach($match_odds as $match_odd) {
                    if(!isset($match_odd['match_odd_id'])) {
                        continue;
                    } else {
                        $match_odd_id = $match_odd['match_odd_id'];
                        $oddsGroup = $this->loadService("data/odds")->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);

                        $updated = $db->rawQuery("UPDATE betting_match_odds SET status = 3 WHERE id=$match_odd_id");
                        $db->rawQuery("UPDATE betting_match_odds SET status = 2 WHERE id IN($oddsGroup[loser_odd_ids])");
                    }

                }


            }


        }


    }



    /**
     * @param $ResultScore
     * @param $match_id
     */
    private function HandleMatchScore($ResultScore,$match_id) {

        $arr_to_save = array();
        if(count((array)$ResultScore)) {
            $db = $this->db;

            $update_data = Array (
                'status' => 2
            );
            $db->where('id',$match_id);
            $update_as_finished = $db->update('betting_match', $update_data);
            if($update_as_finished) {
                $this->saveLog("Updated As Finished-SCORE match_id:$match_id");
            }

            $scoreArr = (array)$ResultScore;
            $scores = $scoreArr['Score'];

            $counter = 0;
            foreach($ResultScore->Score as $index=>$sc) {
                $type = (array)$sc['Type'];
                $type = $type[0];
                $score = $scores[$counter];
                array_push($arr_to_save,array(
                    $type=>$score
                ));
                $counter++;
            }
            $score_data = json_encode($arr_to_save);
            $db->where("id",$match_id);
            $update = $db->update("betting_match",array(
               "score_data"=> $score_data
            ));

            if($update==false) {
                $this->saveAlert("Received Score But Couldn't save");
            }
        }

    }



    /**
     * @param $tableName
     * @param $paramName
     * @param $paramValue
     * @param $dataToInsert
     * @return array
     */
    private function checkExistence($tableName,$paramName,$paramValue,$dataToInsert) {
        $db = $this->db;

        $db->where($paramName,$paramValue);
        $existence = $db->getOne($tableName,"id");
        if($existence) {

            $db->where("id",$tableName);
            $db->update($tableName,$dataToInsert);

            return $existence['id'];
        }
        else {
            $insert = $db->insert($tableName,$dataToInsert);
            if($insert) {
                return $insert;
            } else {
                echo $db->getLastError();
                return false;
            }
        }
    }



    /**
     * Some Competitors Have TEXTS node which contains all names for this competitor in different languages
     * I save this name in database as json so i need to convert every name for Sport,Category,Tournament is JSON format
     * @param (string) $texts
     * @param $asArray
     * @return array
     */
    private function GetTitleAsJSON($texts,$asArray = false) {
        $title_arr = array();
        //Iterate And Save Competitors Title By Language
        foreach($texts->Text as $title) {
            $Language = (array) $title['Language'];
            $Language = $Language[0];
            $title_val = (array)$title->Value;
            $title_arr[$Language] = $title_val[0];
        }

        if($asArray) {
            return $title_arr;
        }
        return json_encode($title_arr);
    }





}