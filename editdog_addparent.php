
<?php include("header.php"); ?>


<?php


// Get all values from form for edit_dog.
// Clean data and determine whether a male or female is passed.
	
	$child_id  =  $_POST[record_id];				// this is the child
	
	$parent_type = $_POST[parent_type];
	
	
	if ($parent_type == "sire") {
		$parent_id  =  $_POST[sire_id];					// id
														// tattoo unknown
		$parent_name =  ucwords($_POST[sire]); 			// name
		$parent_breed = ucwords($_POST[sire_breed]); 	// breed
		$parent_color =  ucwords($_POST[sire_color]); 	// color
														// birthdate unknown
		$parent_sex = "M";								// sex

	} elseif ($parent_type == "dam") {
		$parent_id  =  $_POST[dam_id];					// id
														// tattoo unknown
		$parent_name =  ucwords($_POST[dam]); 			// name
		$parent_breed = ucwords($_POST[dam_breed]); 	// breed
		$parent_color =  ucwords($_POST[dam_color]); 	// color
														// birthdate unknown
		$parent_sex = "F";								// sex

	} else { echo "ERROR!"; }


	$parent_breeder = "1";							// breeder


	




// If the sire id (sire_id) is passed from the form, then we assume that the sire record already exists. 
// Take the sire's record id (sire_id) and update the child's record.
// Then update the littermate record by finding the sire and birthdate matchm and appending the child id (child_id) to the array.


if ($parent_id != ""){

	if ($parent_type =="sire") {
		mysql_query ("UPDATE  doginfo SET sire_id = '$parent_id' WHERE record_id = '$child_id'  ");
		echo "update sire. dog $child_id was updated by adding $parent_id to the sire_id field"; 

	} elseif ($parent_type == "dam") {
		mysql_query ("UPDATE  doginfo SET dam_id = '$parent_id' WHERE record_id = '$child_id'  ");
		echo "update dam. dog $child_id was updated by adding $parent_id to the dam_id field"; 		
	}





} else { 

echo "the parent id was blank. no existing parent was added. let's add a new parent<br/>"; 

	if ($parent_name != "" && $parent_id == ""){
	
		echo "there is a new parent name<br/>"; 

// add new dog
			$query = "INSERT INTO doginfo VALUES ('', '$parent_tattoo', '$parent_name', '$parent_sex', '$parent_breed', '$parent_color', '', '', '', '$parent_breeder', '', '')";
			$result = mysql_query($query);
			echo "ID of last inserted record is: " . mysql_insert_id() ."<br/>";
			$parent_id = mysql_insert_id(); // last record
			
			if ($parent_type =="sire") {
				mysql_query ("UPDATE  doginfo SET sire_id = '$parent_id' WHERE record_id = '$child_id'  ");
				echo "update sire. dog $child_id was updated by adding $parent_id to the sire_id field"; 
		
			} elseif ($parent_type == "dam") {
				mysql_query ("UPDATE  doginfo SET dam_id = '$parent_id' WHERE record_id = '$child_id'  ");
				echo "update dam. dog $child_id was updated by adding $parent_id to the dam_id field"; 		
			}

	
	}



}







// if the sire doesnt already exist, take new data from form
// creates the dog entry for sire
// gets the id - how???



// updates sire id on child's entry



// updates littermatch
// if new, then creates a litter record of 1 littermate + 1 sire
// what if 








	


?>
