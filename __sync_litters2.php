<?php
// MUST READ:
// This is a one-time script, which can be edited. 
// The script inserts new data into the 'litters' table based on info in 'dogsinfo'
// 'litters' must be cleared first, before running this script


require_once('db_login.php'); 


$query1 = "SELECT * FROM doginfo WHERE birthdate !='' AND dam_id !='' AND sire_id !=''"; 					// select all rows that have valid and COMPLETE litter information
$result1 = mysql_query($query1) ;
while($row1 = mysql_fetch_array($result1)){
	
$birthdate = $row1['birthdate'];
$dog_id = $row1['record_id'];
$sire_id = $row1['sire_id'];
$dam_id = $row1['dam_id'];
		
		$query = "SELECT * FROM litters2 WHERE birthdate = '$birthdate' AND  dam_id='$dam_id' "; 			// look for matching birthdate AND dam // there may be 2 birthdates frm different dams
		$result = mysql_query($query);
		$anymatches=mysql_num_rows($result);																// quantify results
		if ($anymatches == 0){ 																				// if no match , then add a new litter record									
			$query = "INSERT INTO litters2 VALUES ('', '$birthdate', '$sire_id', '$dam_id')";
			$result = mysql_query($query);
			$litter_id = mysql_insert_id(); // last record
			echo "<li> last addition: $litter_id";
		
		
			// Test this:
			$query = "UPDATE doginfo SET litter = '$litter_id' WHERE record_id = '$dog_id' ";  
			$result = mysql_query($query);


		} elseif ( $anymatches == 1) {
		

			$query = "SELECT * FROM litters2 WHERE birthdate !='' AND dam_id !='' "; 
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$litter_id = $row['litter_id'];
			}
			$query = "UPDATE doginfo SET litter = '$litter_id' WHERE record_id = '$dog_id' ";  
			$result = mysql_query($query);
		
		}

}
	

// create litter records of incomplete litters (eg. dam_id unknown, sire_id unknown, or birthdate unknown

$query2 = "SELECT * FROM doginfo WHERE birthdate = '' AND (dam_id !='' OR sire_id !='') "; 					// select all rows that have valid and COMPLETE litter information
$result2 = mysql_query($query2) or die(mysql_error());
while($row2 = mysql_fetch_array($result2)){


			$name = $row2['dog_name'];
			$dog_id = $row2['record_id'];
			$sire_id = $row2['sire_id'];
			$dam_id = $row2['dam_id'];


			$query = "INSERT INTO litters VALUES ('', '$sire_id', '$dam_id', '', '$dog_id')";
			$result = mysql_query($query);

	echo "$name has incomplete  birth information <br/>";

}





?>