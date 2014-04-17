<?php 

function (user_id) {
get_header();
include('aarc_db.php');

//$user_id = $_POST['Username']; 		/* Get login from iMIS DB */
//$password = $_POST['Password']; 	/* Get password from form */

// Protect against sql injection
$login = mssql_real_escape_string(stripslashes($login));
$passward = mssql_real_escape_string(stripslashes($password));


/*$sql = "SELECT * from Name
		WHERE
		id = '$login' and
		password = '$password'";
*/
//Did member purchase a course and is registration current?
$purchase = mssql_query('SELECT Orders.ST_ID, Orders.ORDER_NUMBER, 	Orders.FULL_NAME, Orders.ORDER_DATE
									,SUM(DATEDIFF(d, DATEADD(d, -1, Orders.Order_date), GETDATE())) as num_days
									FROM Orders, Order_Meet
									WHERE Orders.ORDER_NUMBER = Order_Meet.ORDER_NUMBER
									AND Order_Meet.MEETING IN ("14ETHICALL", "14ETHICSN", "14ETHICSR")
									AND Orders.ST_ID = $user_id
									AND Orders.STATUS NOT IN ("C","CT")
									Group by Orders.ST_ID, Orders.ORDER_NUMBER, Orders.FULL_NAME, Orders.ORDER_DATE
									ORDER BY Orders.ORDER_DATE DESC');

//Create a variable for the course event ID founc in iMIS
$course = mssql_query('SELECT Orders_Meet.MEETING FROM Orders, Order_Meet');


//Create a variable which assigns the event ID to the proper course
if ($course == 'ETHICALL') {
		$coursenum = 2126;
	}else
	{
		$coursenum = 2128;
	}
endif;


// Create WP User and register for course 
//$user_id=wp_create_user( $login, $password,); 
//ThemexCourse::subscribeUser(2126, $user_id, true);
//echo 'Your id is now registered thanks---> '.$login;
?>