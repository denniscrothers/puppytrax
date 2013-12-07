<?php
header("Cache-Control: no-cache, must-revalidate");
 // Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");






// Make a MySQL Connection
require_once('db_login.php'); 



$query = "SELECT * FROM doginfo";
$label = "Suggested matches:";


	 
$result = mysql_query($query) or die(mysql_error());

// loops through the entire array until there are no results
while($row = mysql_fetch_array($result)){

	$a[] = $row['dog_name']; // assigns value to $a array
	$b[] = $row['record_id']; // assigns value to $b array
	$c[] = $row['color']; // assigns value to $b array
	$d[] = $row['dog_tattoo']; 
	$e[] = $row['birthdate'];
	$f[] = $row['breed'];

}



// end





// this is what builds the list

//get the q parameter from URL
$q=$_GET["q"];
//lookup all hints from array if length of q>0
if (strlen($q) > 1) {
	$hint="";
	for($i=0; $i<count($a); $i++) {
	
		
			if (strtolower($q)==strtolower($a[$i])) { 						// complete = yes
				if ($hint==""){
					
					$hint="<li class='label'>".$label."</li><li>".
					
					"<span class='name'>".$a[$i]."</span>".
					"<span class='birthdate'>b. ".$e[$i]."</span>".
					"<span class='color'>".$c[$i]."</span>".
					
					"</li>";
					
					
				} else {
					$hint=$hint."<li>".
					
					"<span class='name'>".$a[$i]."</span>".
					"<span class='birthdate'>b. ".$e[$i]."</span>".
					"<span class='color'>".$c[$i]."</span>".
					
					"</li>";
				}
			}				
			
			

	
	
	} // end for

}

// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint == "" && strlen($q) > 1 ) {
	$response="No matches";
} else {
	$response=$hint;
}

//output the response
echo $response;
?>