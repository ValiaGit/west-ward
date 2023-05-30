var express = require('express');
var connection = require('../connection');
var router = express.Router();
var moment = require('moment');
var request = require("request");

var Hashids = require("hashids");
var hashID = new Hashids("salt saaxalwlo sufraze!",6,"abcdefghijkmnpqrstuvwxyz23456789");

var jwt = require('jsonwebtoken');

/* GET home page. */
router.get('/', function(req, res, next) {

    if(req.query.token) {

        var languagePack = {
            'my_affiliate_id':'My Affiliation Id',
            'today':'Today',
            'month':'Month',
            'total':'Total',
            'all':'All',
            'level':'Level',
            'user_id':'User Id',
            'user_email':'User Email',
            'country':'Country',
            'profit':'Profit',
            'profit_diagrams':'Profit Diagram',
            'search':'Search',
            'select':'Select',
            'from':'From',
            'to':'To',
            'affiliate_type':'Affiliate Type',
            'governing_partner':'Governing Partner',
            'instructor':'Instructor',
            'top_affiliate':'Top Affiliate',
            'filter_by_level':'Filter by level'
        };

        var cur_lang = 'en';
        if(req.query.lang) {
            cur_lang = req.query.lang;
            if(req.query.lang == 'ja') {
                languagePack = {
                    'my_affiliate_id':'アフィリエイト番号',
                    'today':'本日',
                    'month':'月',
                    'total':'総計',
                    'all':'全て',
                    'level':'レベル',
                    'user_id':'ユーザー番号',
                    'user_email':'ユーザーEメール',
                    'country':'国名',
                    'profit':' 利益',
                    'profit_diagrams':'利益ダイアグラム',
                    'search':'検索する',
                    'select':'選択する',
                    'from':'より',
                    'to':'まで',
                    'affiliate_type':'Affiliate Type',
                    'governing_partner':'Governing Partner',
                    'instructor':'Instructor',
                    'top_affiliate':'Top Affiliate',
                    'filter_by_level':'Filter by level'
                };
            }
        }


        request.post('https://integrations.bookiebot.com/api/affiliates/auth', {form:{token:req.query.token}},function(err,httpResponse,body) {

                if(err) {
                    res.send(err);
                    return false;
                }

                body = JSON.parse(body);
                console.log(body);

                if ( body.code > 0 && body.data.userId) {

                    var data = {
                        title : 'Affiliates Dashboard',
                        today :  moment().format('YYYY-MM-DD'),
                        monthbefore : moment().subtract(1, "months").format('YYYY-MM-DD'),
                        user_id : hashID.encode(body.data.userId),
                        languagePack : languagePack,
                        cur_lang:cur_lang,
                        token : jwt.sign({
                          user_id: body.data.userId
                        }, 'Xaladeci saaxalwlo sufraze', { expiresIn: '1h' }),
                    };

                    // IF KYOH
                    if ( body.data.userId == 38 ) {
                        data.user_id = 'apple1';
                    }
                    // IF KOMISIA
                    if ( body.data.userId == 48 ) {
                        //data.user_id = 'msxali';
                    }

                    res.render('dashboard', { data: data });

                } else {
                    res.send('<img src="/img/promo_1.png" />');
                }

        });
    }
    else {
        res.send('<img src="/img/promo_1.png" />');
    }

});


module.exports = router;
