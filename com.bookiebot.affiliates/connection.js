var mysql = require('mysql');

var connection = mysql.createConnection({
  host     : 'westwardaffiliates.c8ayyksfivem.eu-central-1.rds.amazonaws.com',
  user     : 'WafUser1',
  password : 'Vaflebi198',
  database : 'affiliate'
});

module.exports = connection;
