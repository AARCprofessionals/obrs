<?php
// Connect to MSSQL
$link = mssql_connect('sqlserver.aarc.org:1433', 'sa', 'aaRc11');

if (!$link) 
	{
    die('Something went wrong while connecting to MSSQL');
	}
	
if (!mssql_select_db('iMIS', $link)) {
  	die('Unable to select database!');
	}
?>

<!--
$cn = mssql_connect('sqlserver','sa','aaRc11') or
	die('Unable to connect.');
mssql_select_db('iMIS') or
	die(mssql_error($cn));
-->