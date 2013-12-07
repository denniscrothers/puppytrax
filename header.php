<?php  ?>

<html>

<head>

	<?php
	// Includes 
	require_once('db_login.php'); 
	include("classes.php");   
	
	?>	
	
	
	<!-- Includes -->
	<link rel="stylesheet" type="text/css" href="css/dog.css" />
	
	<script type="text/javascript" src="http://use.typekit.com/exf4mmy.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<script type="text/javascript" src="js/gethint.js"></script> 
	<script type="text/javascript" src="js/form_validation.js"></script> 
	<script type="text/javascript" src="js/functions.js"></script> 
	
	
</head>




<body>


<!-- Header -->
<div id='header'>
	<div id='navContainer'>
		<div id='logo'>
			<img src='i/header_logo.png'>
		</div>
	
		<div id='nav'>
			<ul>
				<li>Home</li>
				<li><a href='addlitter_form.php'>Add a dog</a></li>
				<li><a href='relatives.php'>Find a relative</a></li>
				<li>Profile</li>
			</ul>
		</div>
		
		<div id='searchBox'>
			<form name="search" method="get" action="ancestry.php">
				<input type="text" name="find" id="find" size="16" maxlength="16"  value="Search for a Dog" onfocus="this.value='';" />
				<input type="submit" name="search" value="Search" />
			</form>	
		</div>
		
		
	</div>

<!-- test 2 - sign in script -->

<!--
<div>
	<form method="POST" action="signin2.php" >
		<input type="text" name="username" />
		<input type="password" name="password" />
		<input type="submit" value="Sign In" />
	</form>
</div>
-->


<!--
	<div id='login'>
		<?php include("login.php"); ?>
	</div>
-->


</div>
<!-- end Header -->