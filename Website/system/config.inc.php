<?php
$config = [
/* ### DATABASE CONFIGURATION ### */
    "database_host" => "193.30.120.33",
    "database_port" => "3306",
    "database_user" => "root",
    "database_password" => "",
    "database_table" => "panel_in17",
/* ### SITE CONFIGURATION ### */
    "site_name" => "STATISTIKA",
    "site_url" => "http://s-web.it.gla/in17/boeltes/statistika",
    "site_logo" => "",
    "api_url"   => "/system/api/sql.php"
];


/* Connect using Windows Authentication. */  
try  
{
    $connectionString="sqlsrv:Server=s-mssql2017,1433;Database=IN17;";
    $db = new PDO($connectionString,"IN17W", "IN17DB");
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}  
catch(Exception $e)  
{   
    die( print_r( $e->getMessage() ) );   
}  
//$db = mysqli_connect($config["database_host"], $config["database_user"], $config["database_password"], $config["database_table"]);
/*
$db = new PDO("sqlsrv:Server=$mssql_server ; Database=$mssql_database", $mssql_user, $mssql_password);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
*/

$monateLang = [
    1   => "Januar",
    2   => "Februar",
    3   => "März",
    4   => "April",
    5   => "Mai",
    6   => "Juni",
    7   => "Juli",
    8   => "August",
    9   => "September",
    10  => "Oktober",
    11  => "November",
    12  => "Dezember"
];
?>