<?php
include_once('./aarctest/wp-includes/class-phpass.php' );

define('AUTH_KEY',         'JY|ySH8R.taG5s-jPo!fUZI~ruJex(t3L3A-me[|8+~* NA@XFG;iDtN n47c|M[');
define('SECURE_AUTH_KEY',  'S8$xOZUn-XV,PqhhVKeQuWyptY2|p^E#`.~OKd4HUw8Cee-% N;b>)5w~X{2^nQ!');
define('LOGGED_IN_KEY',    'sXg*C1r><R*&gTjHalUhBbg|_4tQ[ ~Tc|J c[)ls$VObf$FQKrO-CGH[.E0cD+Y');
define('NONCE_KEY',        ';@6+@_@1s?q4$Zy>qxJ018J-E+/2u.,rXe-KF.R<40#Xh*XPn}|YG`_9Eg~a6m%M');
define('AUTH_SALT',        '`gacnmv|Pi[;7{]9v(-+lVdRYA9]s.X`.K$Y4LuLTF+a7|k]49=Q|W;/:Ok+g?m7');
define('SECURE_AUTH_SALT', '2(v-5;4?N3x`[^oNm%rf_d*%Rppww>+.j*lUL_yQgH!~=_kKv{ORgQnu-EFQ0e|:');
define('LOGGED_IN_SALT',   'D7^X:tm67oWY-Nr$yhhCS,>k71`ykMtA:NTRBaBRJA{b &~#<f8[0?c:|?v$lPWs');
define('NONCE_SALT',       'o4[Nf8R+D<y`i]RKo/5.rcl.x%s`(ah|J!%N^T3.D#,Y.]x,A+_{/;8s#&q3DTDW');

// Connect to MSSQL
include('cn-mysql.php');
// Connect to MSSQL
include('cn.php');


//Collect user login and password
/*
$user_name = $_POST["userName"];
$wordpress_user = mysql_query ( "select ID from wp_users where user_login ='$user_name'");

while($row = mysql_fetch_array($wordpress_user) ){
        $user = $row[0];
		echo $user.'<br>';
		}
*/
$client->setCredentials($username,$pwd,'function');

$user= $_POST["userName"];
$user_name = htmlspecialchars($user,ENT_QUOTES);
$password = $_POST["userPassword"];
$hasher = new PasswordHash(8, TRUE);


// get user_name's hashed password from wordpress database
$queryx = "select * from wp_users where user_login='$user_name'";
$Resultx = mysql_query($queryx);

while($row = mysql_fetch_array($Resultx)){
     $passnya = $row['user_pass'];
	 echo $passnya . "<br>";
}

// compare plain password with hashed password
if ($hasher->CheckPassword( $password, $passnya )){
	echo "MATCHED";
	// This is where the Word press cookie needs to be set
	
		$username=$user;
		$password=$password;
		$url="http://olga.obrs.wordpress.aarc.org/aarctest/";
		$cookie="cookie.txt";

		$postdata = "log=". $username ."&pwd=". $password ."&wp-submit=Log%20In&redirect_to=". $url ."blog/wordpress/wp-admin/&testcookie=1";
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url . "blog/wordpress/wp-login.php");

		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 0);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt ($ch, CURLOPT_REFERER, $url . "blog/wordpress/wp-login.php");

		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt ($ch, CURLOPT_POST, 1);
		$result = curl_exec ($ch);
		curl_close($ch);
		echo $result;



		
} else { 
    echo "NO MATCHED";
	// Since no user was found in Word Press. Check against imis for valid user. 
	
	
	
	
}  

?>