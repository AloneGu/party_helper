
<?php
/* 
 * Function ：Database connection configuration, use Variables defined in SAE 
 
             * SAE_MYSQL_USER: username
             * SAE_MYSQL_PASS：password 
             * SAE_MYSQL_HOST_M：main library domain name 
             * SAE_MYSQL_HOST_S：sud library domain name
             * SAE_MYSQL_PORT：port
             * SAE_MYSQL_DB: database's name
 
*/

$conn = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if(!$conn)
{
	die("mysql conn failed");
}
else{
	mysql_select_db("app_party1992", $conn);  
    mysql_query("set names 'utf8'",$conn);
}
?>


