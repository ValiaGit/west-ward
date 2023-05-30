var express = require('express');
var connection = require('../connection');
var router = express.Router();
var moment = require('moment');

var Hashids = require("hashids");
var hashID = new Hashids("salt saaxalwlo sufraze!",6,"abcdefghijklmnpqrstuvwxyz123456789");

var jwt = require('jsonwebtoken');
var secret = 'Xaladeci saaxalwlo sufraze';


router.post('/easy_stats', function(req, res, next) {

    try {
      var decoded = jwt.verify(req.headers.jwt, secret);
      var user_id = decoded.user_id*1;

      if ( !user_id  ){
          return res.send({code: 20, msg: 'Missing user'});
      }

    } catch(err) {
      return res.send({code: 20, msg: 'Unauthenticated'});
    }

    if ( req.body.lvl && req.body.lvl > 0 ) {
        var lvl_qry = ' AND (from_lvl = '+req.body.lvl+') ';
    } else {
        var lvl_qry = '';
    }


    var dates = {
        'today' : moment().format('YYYY-MM-DD 00:00:01'),
        'month' : moment().format('YYYY-MM-01 00:00:01')
    }

    var qry = ` SELECT COALESCE(sum(amount/100), 0) AS d, null AS m, null AS t FROM affiliate.profit_logs where (users_user_id = `+user_id+`) AND (created_at > '`+dates.today+`') `+lvl_qry+`
                UNION
                SELECT null AS d, COALESCE(sum(amount/100), 0) AS m, null AS t FROM affiliate.profit_logs where (users_user_id = `+user_id+`) AND (created_at > '`+dates.month+`') `+lvl_qry+`
                UNION
                SELECT null AS d, null AS m, COALESCE(sum(amount/100), 0) AS t FROM affiliate.profit_logs where (users_user_id = `+user_id+`) `+lvl_qry;


    connection.query(qry, function(err, rows){
        if ( err ) {
            res.send({code: err.errno, msg: err.code});
        } else {
            var stats = {
                d : rows[0].d,
                m : rows[1].m,
                t : rows[2].t,
            }
            res.send({code: 10, stats: stats});
        }
    });
});

router.post('/get_chart', function(req, res, next) {

    try {
      var decoded = jwt.verify(req.headers.jwt, secret);
    } catch(err) {
      return res.send({code: 20, msg: 'Unauthenticated'});
    }
    var user_id = decoded.user_id;

    if ( !user_id || !req.body.from_date || !req.body.to_date ) {
        code = 20;
        msg = 'Parameter is missing';
        res.send({code: code, msg: msg});
        return false;
    }

    var and_lvl  = '';
    var tit_lvl  = ' From Whole Family';
    var and_user = '';
    if ( req.body.level > 0 && req.body.level <= 5 ) {
        and_lvl = "(pl.from_lvl = "+req.body.level+" ) AND ";
        tit_lvl = " From Level "+req.body.level;
    }

    if ( req.body.user_id ) {
        target_id = hashID.decode(req.body.user_id);
        if ( target_id > 0 ) {
            and_user = " ( (pl.supplier_id_1 = "+target_id+" ) OR (pl.supplier_id_2 = "+target_id+" ) OR (pl.supplier_id_3 = "+target_id+" ) OR (pl.supplier_id_4 = "+target_id+" ) OR (pl.supplier_id_5 = "+target_id+" ) ) AND ";
            tit_lvl = " From user "+req.body.user_id;
        }
    }

    var qry = "SELECT products_id, sum(pl.amount / 100) AS amount, DATE(pl.created_at) AS dat FROM affiliate.profit_logs pl WHERE "+and_lvl+and_user+" (pl.users_user_id = "+user_id+") AND (created_at between '"+req.body.from_date+" 00:00:01' AND '"+req.body.to_date+" 23:59:59') GROUP BY dat, products_id";

console.log(qry);
    connection.query(qry, function(err, rows){
        if ( err ) {
            res.send({code: err.errno, msg: err.code, full_err: err});
        } else {
            code = 10;

            var stats = {
                1 : {
                    name  : 'Betting Exchange',
                    values: []
                },
                2 : {
                    name  : 'Slots',
                    values: []
                },
                3 : {
                    name  : 'Live Casino',
                    values: []
                },
                4 : {
                    name  : 'Sports Book',
                    values: []
                },
                5 : {
                    name  : 'Skill Games',
                    values: []
                },
                6 : {
                    name  : 'Child Affiliation Subscription',
                    values: []
                }
            };

            for (var i=0; i<rows.length; i++){
                console.log(stats);
                stats[ rows[i].products_id ].values.push( [moment(rows[i].dat).valueOf(), rows[i].amount]  );
            }

            console.log(stats);
            var exportStats = [];

            for (var i=1; i<=6; i++){
                if ( stats[i].values.length > 0 ) {
                    exportStats.push({
                        name : stats[i].name,
                        data : stats[i].values
                    });
                }
            }



            res.send({code: 10, graph: exportStats, tit_lvl: tit_lvl});
        }
    });
});


router.post('/get_children', function(req, res, next) {

    try {
      var decoded = jwt.verify(req.headers.jwt, secret);
      var user_id = decoded.user_id*1;
      //var user_id = 48;

      if ( !user_id ) {
          return res.send({code: 20, msg: 'User is missing'});
      }

    } catch(err) {
      return res.send({code: 20, msg: 'Unauthenticated'});
    }

    var level = 1;
    if ( req.body.level > 1 && req.body.level <= 5 ) {
        level = req.body.level;
    }

    var page = 1;
    if ( req.body.page > 1 ) {
        page = req.body.page;
    }

    var qry ={
        1 : `SELECT
            	u.user_id,
            	u.affiliate_type,
                u.email,
                u.country,
                ( SELECT sum(amount/100) FROM affiliate.profit_logs WHERE (supplier_id_1 = u.user_id) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59')  ) AS profit
            FROM
            	affiliate.users u
            WHERE
                u.user_id > 0 AND
            	u.parent_id = `+user_id+` ORDER BY profit DESC`,
        2 : `SELECT
            	u1.user_id,
            	u1.affiliate_type,
                u1.email,
                u1.country,
                ( SELECT sum(amount/100) FROM affiliate.profit_logs WHERE (supplier_id_2 = u1.user_id) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59') ) AS profit
            FROM
            	affiliate.users u
            LEFT JOIN
            	affiliate.users u1
                ON u1.parent_id = u.user_id
            WHERE
                u1.user_id > 0 AND
            	u.parent_id = `+user_id+` ORDER BY profit DESC`,
        3 : `SELECT
            	u2.user_id,
            	u2.affiliate_type,
                u2.email,
                u2.country,
                ( SELECT sum(amount/100) FROM affiliate.profit_logs WHERE (supplier_id_3 = u2.user_id) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59') ) AS profit
            FROM
            	affiliate.users u
            LEFT JOIN
            	affiliate.users u1
                ON u1.parent_id = u.user_id
            LEFT JOIN
            	affiliate.users u2
                ON u2.parent_id = u1.user_id
            WHERE
                u2.user_id > 0 AND
            	u.parent_id = `+user_id+` ORDER BY profit DESC`,
        4 : `SELECT
            	u3.user_id,
            	u3.affiliate_type,
                u3.email,
                u3.country,
                ( SELECT sum(amount/100) FROM affiliate.profit_logs WHERE (supplier_id_4 = u3.user_id) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59') ) AS profit
            FROM
            	affiliate.users u
            LEFT JOIN
            	affiliate.users u1
            	ON u1.parent_id = u.user_id
            LEFT JOIN
            	affiliate.users u2
            	ON u2.parent_id = u1.user_id
            LEFT JOIN
            	affiliate.users u3
            	ON u3.parent_id = u2.user_id
            WHERE
                u3.user_id > 0 AND
            	u.parent_id = `+user_id+` ORDER BY profit DESC`,
        5 : `SELECT
            	u4.user_id,
            	u4.affiliate_type,
                u4.email,
                u4.country,
                ( SELECT sum(amount/100) FROM affiliate.profit_logs WHERE (supplier_id_5 = u4.user_id) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59') ) AS profit
            FROM
            	affiliate.users u
            LEFT JOIN
            	affiliate.users u1
            	ON u1.parent_id = u.user_id
            LEFT JOIN
            	affiliate.users u2
            	ON u2.parent_id = u1.user_id
            LEFT JOIN
            	affiliate.users u3
            	ON u3.parent_id = u2.user_id
			LEFT JOIN
            	affiliate.users u4
            	ON u4.parent_id = u3.user_id
            WHERE
                u4.user_id > 0 AND
            	u.parent_id = `+user_id+` ORDER BY profit DESC`,
    };

    connection.query(qry[level], function(err, rows){
        if ( err ) {
            res.send({code: err.errno, msg: err.code});
        } else {

            var total_count = rows.length;
            var per_page = 10;
            var total_pages = Math.ceil(total_count/per_page);

            var page_start = (page-1)*per_page;
            var page_end = page_start+per_page;

            if ( page_end > ( total_count -1 ) ) {
                page_end = total_count;
            }

            var childs = [];

            for (var i=page_start; i<page_end; i++){
                rows[i].user_id = hashID.encode(rows[i].user_id);
                childs.push(rows[i]);
            }

            return res.send({
                code   : 10,
                level  : level,
                total_pages: total_pages,
                current_page: page,
                childs :  childs,
            });
        }
    });
});


router.post('/search_user', function(req, res, next) {
    try {
      var decoded = jwt.verify(req.headers.jwt, secret);
      var user_id = decoded.user_id*1;

      if ( !user_id ) {
          return res.send({code: 20, msg: 'User is missing'});
      }

    } catch(err) {
      return res.send({code: 20, msg: 'Unauthenticated'});
    }

    var target_user = hashID.decode(req.body.user_id);
    if ( target_user > 0 ) {


        var getParentsQry = `   SELECT T2.user_id, T1.lvl
                                FROM (
                                   SELECT
                                       @r AS _id,
                                       (SELECT @r := parent_id FROM affiliate.users WHERE user_id = _id) AS parent_id,
                                       @l := @l + 1 AS lvl
                                   FROM
                                       (SELECT @r := `+target_user+`, @l := -1) vars,
                                       affiliate.users h
                                   WHERE @r <> 0) T1
                                JOIN affiliate.users T2
                                ON T1._id = T2.user_id
                                WHERE T1.lvl < 6
                                ORDER BY T1.lvl`;

        connection.query(getParentsQry, function(err, rows){
            var level = false;
            for (var i=0; i<rows.length; i++){
                if ( user_id == rows[i].user_id ) {

                    level = rows[i].lvl;

                    var qry = `SELECT
                        	u.user_id,
                            u.email,
                            u.country,
                            ( SELECT sum(amount) FROM affiliate.profit_logs WHERE (users_user_id =`+user_id+` ) AND (supplier_id_`+level+` = `+target_user+`) AND (created_at between '`+req.body.from_date+` 00:00:01' AND '`+req.body.to_date+` 23:59:59')  ) AS profit
                        FROM
                        	affiliate.users u
                        WHERE
                            u.user_id=`+target_user;

                    console.log('level found: '+level);
                    break;
                }
            }

            if ( level ) {
                connection.query(qry, function(err, rows){


                    if ( rows.length < 1 ) {
                        return res.send({code: 20, msg: 'Can not find user'});
                    }

                    rows[0].user_id = hashID.encode(rows[0].user_id);

                    return res.send({
                        code: 10,
                        level: level,
                        user: rows[0]
                    })
                });
            } else {
                return res.send({code: 20, msg: 'Can not find user'});
            }



        });
    } else {
        return res.send({code : 20, msg: 'Invalid User Id'});
    }



});




module.exports = router;
