var express = require('express');
var connection = require('../connection');
var moment = require('moment');
var sha256 = require('sha256');

var router = express.Router();
var code = 0;
var msg = 'Init Default Message';

var Hashids = require("hashids");
var hashID = new Hashids("salt saaxalwlo sufraze!",6,"abcdefghijklmnpqrstuvwxyz123456789");


router.use(function (req, res, next) {

    var salt = 'iXvniskarta saaxalwlo sufraze';
    var hash = req.body.hash;
    var body_string = '';
    var body = req.body;
    delete body.hash;


    for (var key in body) {
        body_string += body[key]
    }

    body_string += salt;
    console.log(body_string);

    var local_hash = sha256(body_string);

    if ( hash == local_hash ) {
        next()
    } else {

        var ip = req.ip;
        var path = req.originalUrl;
        var header = JSON.stringify(req.headers);
        var body = JSON.stringify(req.body);
        var now = moment().format('YYYY-MM-DD H:m:s');

        connection.query('INSERT INTO bad_logs (ip,path,header,body,created_at) VALUES ("'+ip+'","'+path+'","?","?","'+now+'")',[header,body], function(err, rows){
            res.send({code: 20, msg: 'IP not matched'+err});
        });
    }

});


/* POST new user */
router.post('/add_user', function(req, res, next) {
    var now = moment().format('YYYY-MM-DD H:m:s');

    connection.query('INSERT INTO users (user_id,parent_id,email,country,created_at) VALUES ('+req.body.user_id+','+req.body.parent_id+',"'+req.body.email+'","'+req.body.country+'","'+now+'")', function(err, rows){
        if ( err ) {
            code = err.errno;
            msg = err.code;
        } else {
            code = 10;
            msg = 'inserted new user';
        }
        res.send({code: code, msg: msg});
    });

});



router.post('/updateAffiliateType',function(req, res, next) {

    var user_id = req.body.user_id;

    //1 - Governor Partner\n2 - Instructor\n3 - Free
    var agreement_type = +req.body.agreement_type;

    //console.log(user_id,agreement_type,req.body);


    if(!user_id || !agreement_type) {
        res.send({code: -1, msg: "Wrong request"});
    }

    connection.query("UPDATE users SET affiliate_type='"+agreement_type+"' WHERE user_id='"+user_id+"'",function(err, rows) {
        if ( err ) {
            code = err.errno;
            msg = err.code;
        } else {
            code = 10;
            msg = 'updated agreement type for user';
        }
        res.send({code: code, msg: msg});
    });

});



/* POST new losing log */
router.post('/add_log', function(req, res, next) {
    var now = moment().format('YYYY-MM-DD H:m:s');


    if (
        !req.body.user_id ||
        !req.body.product_id ||
        !req.body.amount ||
        !req.body.transaction_id
    ) {
        code = 20;
        msg = 'Parameter is missing';
        res.send({code: code, msg: msg});
        return false;
    }

    try {
        connection.query('SELECT * FROM users WHERE user_id='+req.body.user_id,function(checkUserErr,CheckUser){
            try {
                if ( checkUserErr || CheckUser.length ==0 ) {
                    code = 20;
                    msg = 'User not found.';
                    res.send({code: code, msg: msg});
                    return false;
                }
                else {

                    try {
                        connection.query('INSERT INTO incoming_logs (users_user_id,products_id,transaction_id,amount,created_at) VALUES ('+req.body.user_id+','+req.body.product_id+','+req.body.transaction_id+','+req.body.amount+',"'+now+'")', function(err, incoming_log){
                            var code = 20;
                            if ( err ) {
                                code = err.errno;
                                msg = 'INSERTING INCOMING LOG: '+err;
                                res.send({code: code, msg: msg});
                                return false;
                            } else {
                                code = 10;
                                msg = 'inserted new log';

                                var getParentsQry = `   SELECT T2.user_id, T2.parent_id, T1.lvl
                                            FROM (
                                               SELECT
                                                   @r AS _id,
                                                   (SELECT @r := parent_id FROM affiliate.users WHERE user_id = _id) AS parent_id,
                                                   @l := @l + 1 AS lvl
                                               FROM
                                                   (SELECT @r := `+req.body.user_id+`, @l := -1) vars,
                                                   affiliate.users h
                                               WHERE @r <> 0) T1
                                            JOIN affiliate.users T2
                                            ON T1._id = T2.user_id
                                            WHERE T1.lvl < 6
                                            ORDER BY T1.lvl`;



                                connection.query(getParentsQry, function(parent_err, parent_rows){
                                    if ( parent_err ) {
                                        code = parent_err.errno;
                                        msg = 'CAN NOT SELECT PARENTS: '+parent_err.code;

                                        // rollback incoming_logs
                                        connection.query('DELETE FROM incoming_logs WHERE id='+incoming_log.insertId,function(rollbackErr,rollbackRes){
                                            res.send({code: code, msg: msg});
                                            return false;
                                        });

                                    }

                                    var parents = {};
                                    if(req.body.product_id == 6 || req.body.product_id == '6') {
                                        var rate = 0.12;
                                    }
                                    else {
                                        var rate = 0.25;
                                    }

                                    var profit_logs_qry = 'INSERT INTO profit_logs (amount,users_user_id,incoming_logs_id,from_lvl,created_at,products_id,supplier_id_1,supplier_id_2,supplier_id_3,supplier_id_4,supplier_id_5) VALUES ';
                                    var supplier_id = {};

                                    try {
                                        for (var i=1; i<parent_rows.length; i++){
                                            parents[i] = {
                                                user_id : parent_rows[i].user_id,
                                                amount  : req.body.amount * rate
                                            };

                                            for ( var j=1; j<=5; j++ ){
                                                if ( j <= parent_rows[i].lvl ) {
                                                    supplier_id[j] = parent_rows[i-j].user_id;
                                                } else {
                                                    supplier_id[j] = null;
                                                }
                                            }

                                            profit_logs_qry += ' ('+parents[i].amount+','+parents[i].user_id+','+incoming_log.insertId+','+parent_rows[i].lvl+",'"+now+"', "+req.body.product_id+','+supplier_id[1]+','+supplier_id[2]+','+supplier_id[3]+','+supplier_id[4]+','+supplier_id[5]+"),";

                                            rate = rate / 2;
                                        }


                                        if ( i > 1 && code == 10 ) {
                                            profit_logs_qry = profit_logs_qry.slice(0,-1);
                                            profit_logs_qry += ';';

                                            connection.query(profit_logs_qry, function(profitLogsErr, profitLogs){
                                                if ( profitLogsErr ) {
                                                    code = profitLogsErr.errno;
                                                    msg = 'INSERTING PROFIT LOGS: '+profitLogsErr.code;
                                                    parents = {};
                                                    // rollback incoming_logs
                                                    connection.query('DELETE FROM incoming_logs WHERE id='+incoming_log.insertId,function(rollbackErr,rollbackRes){
                                                    });

                                                    //return res.send(profit_logs_qry);
                                                } else {
                                                    code = 10;
                                                    msg = 'INSERTED PROFIT LOGS.';

                                                }
                                                res.send({code: code, msg: msg, profits: parents});
                                            })

                                        }
                                        else {
                                            code = 20;
                                            msg = 'No parents found for declare profit';
                                            // rollback incoming_logs
                                            connection.query('DELETE FROM incoming_logs WHERE id='+incoming_log.insertId,function(rollbackErr,rollbackRes){
                                                res.send({code: code, msg: msg});
                                            });
                                        }
                                    }catch(e) {
                                        res.send({code: 123, msg: e});
                                        return false;
                                    }

                                }); // connection: select parents
                            } // incoming log inserted
                        }); // connection: insert incoming log
                    }catch(e) {
                        res.send({code: 123, msg: e});
                        return false;
                    }

                } // check user_id

            }catch(e) {
                res.send({code: 123, msg: e});
                return false;
            }
            // check user_id

        }); // connect users for checking
        return false;
    }catch(e) {
        res.send({code: 123, msg: e});
        return false;
    }
    return false;



});

module.exports = router;
