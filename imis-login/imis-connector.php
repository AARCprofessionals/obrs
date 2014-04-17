<?php 

$sn = 'sqlserver.aarc.org:1433';

// Connect to MSSQL
$link = mssql_connect($sn, 'sa', 'aaRc11');

if (!$link) 
	{
    die('Something went wrong while connecting to MSSQL');
	}
else
	{
		echo "...waiting for input";
	}
	
if (!mssql_select_db('iMIS', $link)) {
  	die('Unable to select database!');
	}
?>
<br>


    
    


