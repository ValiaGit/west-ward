<?php
$db_curacao = new MysqliDb('10.30.60.10', 'shako', 'shako-321', 'curacao');
$last_backup_time = $db_curacao->getOne("backup_time","increment,backup_time");
$backup_time = $last_backup_time['backup_time'];
$last_backup_was_done = strtotime($backup_time);
$time_now = time();
$one_day = 60*60*24;
if($last_backup_was_done+$one_day >= $time_now) {
    echo "No Backup time yet";
    exit;
}

$updated = $db_curacao->update('backup_time',array(
   'increment'=>$db_curacao->inc(1)
));




$dir = "/var/backup-sql/";
$filename = "backup_". date("Y-m-d-H:i:s").".sql.gz";
$db_host = "10.30.60.10";
$db_username = "shako";
$db_password = "shako-321";
$db_database = "bookiebo_stock";
$db_tables = "core_providers_transactions";
$cmd = "mysqldump -h {$db_host} -u {$db_username} --password={$db_password} {$db_database} {$db_tables} | gzip > {$dir}{$filename}";
exec($cmd);

//Copy File To Cuaracao
exec("curl -T {$dir}{$filename} -v -k --ftp-ssl -u westwardgaming:299f90685f5b850c53c86ee313b62913 ftp://settlement.cloudxcel.com");