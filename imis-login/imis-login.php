<?php
include('imis-connector.php');
session_start();
?>
<div>
	<form method="post" action="imis-validate.php">
	<br>
	<br>

	Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<input type="text" name="login" value="" /><br>

	Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="password" name="password" value="" /><br><br>
	
	<input type="submit" value="signin"><input type="reset">

</form>
</div>



    
    


