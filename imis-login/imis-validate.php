<?php
include('imis-connector.php');


$login = $_POST['login']; 		/* Get login from iMIS DB */
$password = $_POST['password']; 	/* Get password from form */

/* Protect against sql injection
$login = mssql_real_escape_string(stripslashes($login));
$passward = mssql_real_escape_string(stripslashes($password));
*/
?>

<!-- Check if the user is not logged in -->
<?php
	//Validate user credentials
	$sql = "SELECT * FROM Name
		WHERE
	full_name = '$login'";

if (!mssql_select_db('iMIS', $link)) {
  die('Unable to select database!');
}

$result = mssql_query("SELECT Orders.ST_ID
        , Orders.ORDER_NUMBER
        , Orders.INVOICE_NUMBER
        , Orders.FULL_NAME
        , Orders.FULL_ADDRESS
        , Order_Meet.MEETING as MEETING
    FROM Orders, Order_Meet 
    WHERE Orders.ORDER_NUMBER = Order_Meet.ORDER_NUMBER
    AND Order_Meet.MEETING IN ('14ETHICSN','14ETHICSR','14ETHICSALL') 
    AND Orders.STATUS NOT IN ('C','CT')
    AND Orders.BALANCE <= 0 
    AND Orders.ST_ID = '#user_ID#'");

while ($row = mssql_fetch_array($result)) {
  var_dump($row);
}

mssql_free_result($result);

?>




<!-- 
// Create WP User and register for course 
$id=wp_create_user( $login, $password, $email ); 
ThemexCourse::subscribeUser($coursefield, $id, true);
-->
    
<!-- 
// SQL Query to iMIS DB

SELECT Orders.ST_ID
        , Orders.ORDER_NUMBER
        , Orders.INVOICE_NUMBER
        , Orders.FULL_NAME
        , Orders.FULL_ADDRESS
        , Order_Meet.MEETING as MEETING
    FROM Orders, Order_Meet 
    WHERE Orders.ORDER_NUMBER = Order_Meet.ORDER_NUMBER
    AND Order_Meet.MEETING IN ('14ETHICSN','14ETHICSR','14ETHICSALL') 
    AND Orders.STATUS NOT IN ('C','CT')
    AND Orders.BALANCE <= 0 
    AND Orders.ST_ID = '#user_ID#'
--> 

<!--
Login page = https://services.aarc.org/source/security/AARCLogon.cfm
-->

