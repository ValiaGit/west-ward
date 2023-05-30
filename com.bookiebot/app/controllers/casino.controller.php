<?php


if(!defined("APP")) {
    die("No Access!");
}



class Casino extends Controller {


    public function init() {
        $data = array();
        echo $this->render("casino/slots.tpl",$data);
    }


    public function sport() {
        $data = array();
        echo $this->render("casino/sport.tpl",$data);
    }

    public function slots() {
        $data = array();
        echo $this->render("casino/slots.tpl",$data);
    }

    public function live_casino() {
        $data = array();
        echo $this->render("casino/live_casino.tpl",$data);
    }

    public function skill_games() {
        $data = array();
        echo $this->render("casino/skill_games.tpl",$data);
    }

    public function game() {
        $id = $_GET['intParam'];

        $game = $this->loadModel("casino")->get_game($id);

        if ( $game['background'] == '' ) {
            $game['background'] = '#000';
        } else {
            $game['background'] = "url(".$game['background'].") top left no-repeat";
        }

        $data = array(
            "id"=>$id,
            "game"=>$game
        );

        echo $this->render("casino/game.tpl",$data);
    }
    public function game2() {
        $id = $_GET['intParam'];
        $data = array(
            "id"=>$id
        );
        echo $this->render("casino/game2.tpl",$data);
    }
    public function get_games() {

        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Accept, Accept-CH, Accept-Charset, Accept-Datetime, Accept-Encoding, Accept-Ext, Accept-Features, Accept-Language, Accept-Params, Accept-Ranges, Access-Control-Allow-Credentials, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Expose-Headers, Access-Control-Max-Age, Access-Control-Request-Headers, Access-Control-Request-Method, Age, Allow, Alternates, Authentication-Info, Authorization, C-Ext, C-Man, C-Opt, C-PEP, C-PEP-Info, CONNECT, Cache-Control, Compliance, Connection, Content-Base, Content-Disposition, Content-Encoding, Content-ID, Content-Language, Content-Length, Content-Location, Content-MD5, Content-Range, Content-Script-Type, Content-Security-Policy, Content-Style-Type, Content-Transfer-Encoding, Content-Type, Content-Version, Cookie, Cost, DAV, DELETE, DNT, DPR, Date, Default-Style, Delta-Base, Depth, Derived-From, Destination, Differential-ID, Digest, ETag, Expect, Expires, Ext, From, GET, GetProfile, HEAD, HTTP-date, Host, IM, If, If-Match, If-Modified-Since, If-None-Match, If-Range, If-Unmodified-Since, Keep-Alive, Label, Last-Event-ID, Last-Modified, Link, Location, Lock-Token, MIME-Version, Man, Max-Forwards, Media-Range, Message-ID, Meter, Negotiate, Non-Compliance, OPTION, OPTIONS, OWS, Opt, Optional, Ordering-Type, Origin, Overwrite, P3P, PEP, PICS-Label, POST, PUT, Pep-Info, Permanent, Position, Pragma, ProfileObject, Protocol, Protocol-Query, Protocol-Request, Proxy-Authenticate, Proxy-Authentication-Info, Proxy-Authorization, Proxy-Features, Proxy-Instruction, Public, RWS, Range, Referer, Refresh, Resolution-Hint, Resolver-Location, Retry-After, Safe, Sec-Websocket-Extensions, Sec-Websocket-Key, Sec-Websocket-Origin, Sec-Websocket-Protocol, Sec-Websocket-Version, Security-Scheme, Server, Set-Cookie, Set-Cookie2, SetProfile, SoapAction, Status, Status-URI, Strict-Transport-Security, SubOK, Subst, Surrogate-Capability, Surrogate-Control, TCN, TE, TRACE, Timeout, Title, Trailer, Transfer-Encoding, UA-Color, UA-Media, UA-Pixels, UA-Resolution, UA-Windowpixels, URI, Upgrade, User-Agent, Variant-Vary, Vary, Version, Via, Viewport-Width, WWW-Authenticate, Want-Digest, Warning, Width, X-Content-Duration, X-Content-Security-Policy, X-Content-Type-Options, X-CustomHeader, X-DNSPrefetch-Control, X-Forwarded-For, X-Forwarded-Port, X-Forwarded-Proto, X-Frame-Options, X-Modified, X-OTHER, X-PING, X-PINGOTHER, X-Powered-By, X-Requested-With`");

        $data = array(
            'cat'       => ( isset($_GET['cat'])  && $_GET['cat']  <> '' ) ? (int)$_GET['cat'] : false,
            'prov'      => ( isset($_GET['prov']) && $_GET['prov'] <> '' ) ? (int)$_GET['prov'] : false,
            'is_mobile' => ( isset($_GET['mobile']) ) ? 1 : 0,
            'lim'       => ( isset($_GET['lim']) ) ? (int)$_GET['lim'] : null
        );

        $games = $this->loadModel("casino")->get_list($data);

        header('Content-Type: application/json');
        echo json_encode($games);
        //var_export( $games );
    }

}
