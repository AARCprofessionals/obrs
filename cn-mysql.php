<?php 


$link_mysql = mysql_connect('localhost:3306', 'wordpress', 'wordpress');
//$link_mysql = mysql_connect('localhost:3306', 'aarctest', 'aarctest');


if (!$link_mysql) 
	{
    die('Something went wrong while connecting to MSSQL');
	}
else
	{
		echo "...waiting for input";
	}
	
if (!mysql_select_db('wordpress', $link_mysql)) {
  	die('Unable to select database!');
	}
?>

