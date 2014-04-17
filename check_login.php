<?php
// Connect to MSSQL
include('cn.php');
include('./aarctest/wp-config.php');
	

//Start User Session
session_start();
$_SESSION['loggedInImis'] = "AARCCF";


//Collect user login and password
$userName = $_POST["userName"];
$userPassword = $_POST["userPassword"];// Need to hash it

echo $userPassword . "\n";
$hashedPassword = sha1($userPassword);
//$hashedPassword = hash ('MD5',$userPassword);
echo $hashedPassword;

//Is user an AARC Member? - WE DON'T NEED THIS SECTION
$ck_imis_cred = mssql_query("SELECT *
		FROM Name_Security
		WHERE id = '$userName'");

echo "<br>";
while ($row = mssql_fetch_array($ck_imis_cred)) {
  print_r ($row);
}


// Is Member logged into iMIS? Set 2 functions:
 
    function loginURL() { //1. send users not logged into iMIS to sign in page
    $loginURL = 'https://www.aarc.org/profile/login.aspx?Page=http://ethics.aarc.org/course';
     
 	return $loginURL;
	}
	

	function successURL() { //2. do this for iMIS logged in users - (needs debugging)
    	$successURL = 'http://ethics.aarc.org/imis-login/profile.php';
     
 	return $successURL;
	
/*	
	// A valid purchase was found - Create WP User ID and Log user into course
		//if user id does not exist in wpdb create user then auto log them in
		
		// 1. Create WP User and register for course 
			//$id=wp_create_user( $login, $password, $email ); 
			//ThemexCourse::subscribeUser(plan_id, user_id, true);
			//auto_login('user');
		
		//else check for iMIS pw update & auto_login() - added code to functions.php
		//update user password
		//auto_login('user');
		
	
	
	}
*/


//Variables for functions above
$loginRedirect = loginURL();
$enterCourse = successURL();

if(!isset($_COOKIE['AARCCF']) || ($_COOKIE['AARCF'] != 'true'))
    {
        header("Location:$loginRedirect"); exit;
    }else 
	
	{
		header("Location:$enterCourse"); exit;
	}	



// Check for a valid purchase
/*
	$purchase = mssql_query('SELECT Orders.ST_ID, Orders.ORDER_NUMBER, 	Orders.FULL_NAME, Orders.ORDER_DATE
		,SUM(DATEDIFF(d, DATEADD(d, -1, Orders.Order_date), GETDATE())) as num_days
		FROM Orders, Order_Meet
		WHERE Orders.ORDER_NUMBER = Order_Meet.ORDER_NUMBER
		AND Order_Meet.MEETING IN ("14ETHICALL", "14ETHICSN", "14ETHICSR")
		AND Orders.ST_ID = $login
		AND Orders.STATUS NOT IN ("C","CT")
		Group by Orders.ST_ID, Orders.ORDER_NUMBER, Orders.FULL_NAME, Orders.ORDER_DATE
		ORDER BY Orders.ORDER_DATE DESC');
*/
}
?>