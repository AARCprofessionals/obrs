<?php 

$sn = 'sqlserver.aarc.org:1433';

// Connect to MSSQL
$link = mssql_connect($sn, 'ethics', 'aarc94@%');

if (!$link) 
	{
    die('Something went wrong while connecting to MSSQL');
	}
else
	{
		echo "";
	}
	
if (!mssql_select_db('iMIS', $link)) {
  	die('Unable to select database!');
	}
?>
<br>
