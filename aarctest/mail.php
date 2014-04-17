<?php
$to = "rhonda.clark@aarc.org";
$subject = "Test mail";
$message = "Hey! This is a simple plain text message.";
$from = "info@aarc.org";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>

<?php
username="root";$password="aaRC94@%";$database="aarcTest";
mysql_connect(localhost,$username,$password);

mysql_select_db ("aarcTest");

if (@mysql_query ($query) )
  { echo '<p> Connected to MySQL Server. </p>';
   }
 else
  { die ( ' <p> Database creation failed because ' . mysql_error ( ) . ' </p>' 
             ' <p> The query was: ' . $query . '</p>');

// Check connection
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT *from wp_users

?>

