<?php
/*
Template Name: Start Here
*/
?>
<?php get_header(); ?>

<div class="column eightcol">
<table>
   <tr>
      <td width="90%">
<h1>START HERE</h1>
	<p>You must be registered and logged in to view this course.  Click the <strong>"Login"</strong> button to enter the course.</p>
	<p>If you have not registered, click the <strong>"Register"</strong> button below to get started.</p>
	<form action="https://www.aarc.org/profile/login.aspx?Page=http://ethics.aarc.org/aarctest/" method="post">
		<input type="submit" value="Register">
	</form>
      </td>
      <td vertical-align="top" width="40%" bgcolor="#f1f1f1"> </td>
   </tr>
</table>
	
 

</div>

<aside class="sidebar column fourcol last">
<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>
