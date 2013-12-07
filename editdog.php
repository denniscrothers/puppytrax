
<?php include("header.php"); ?>





<?php




// get the id from form
// assign all existing values to current_dog

$myDog = new Dog($_POST[record_id]); 

$current_record_id = $myDog->id ; 

$current_dog_name = $myDog->name ; 
$current_dog_tattoo = $myDog->tattoo ; 
$current_birthdate = $myDog->birthdate ; 
$current_sex = $myDog->sex ; 
$current_breed = $myDog->breed ; 
$current_color = $myDog->color ; 

$current_breeder = $myDog->breeder ; 









// get all values from form for edit_dog
// clean data

$edit_dog_name = ucwords($_POST[edit_dog_name]); // capitalizes name
$edit_dog_tattoo = strtoupper($_POST[edit_dog_tattoo]); // tattoo to uppercase
$edit_birthdate = $_POST[edit_birthYYYY]."-". $_POST[edit_birthMM]."-". $_POST[edit_birthDD]; // concats birthdate

$edit_sex = ucwords($_POST[edit_sex]); 
$edit_breed = ucwords($_POST[edit_breed]); 
$edit_color = ucwords($_POST[edit_color]); 

$edit_breeder = ($_POST[edit_breeder]);




// now compare
// if there is no match, then write new value


if ( $edit_dog_name != $current_dog_name ) { 
	mysql_query ("UPDATE  doginfo SET dog_name = '$edit_dog_name' WHERE record_id = '$current_record_id'  ");	
	echo "name has been changed<br/>";
} else {
	echo "name has NOT been changed<br/>";
};


if ( $edit_dog_tattoo != $current_dog_tattoo ) { 
	mysql_query ("UPDATE  doginfo SET dog_tattoo = '$edit_dog_tattoo' WHERE record_id = '$current_record_id'  ");	
	echo "tattoo has been changed<br/>";
} else {
	echo "tattoo has NOT been changed<br/>";
};


if ( $edit_sex != $current_sex ) { 
	mysql_query ("UPDATE  doginfo SET sex = '$edit_sex' WHERE record_id = '$current_record_id'  ");	
	echo "sex has been changed<br/>";
} else {
	echo "sex has NOT been changed<br/>";
};


if ( $edit_breed != $current_breed ) { 
	mysql_query ("UPDATE  doginfo SET breed = '$edit_breed' WHERE record_id = '$current_record_id'  ");	
	echo "breed has been changed<br/>";
} else {
	echo "breed has NOT been changed<br/>";
};


if ( $edit_color != $current_color ) { 
	mysql_query ("UPDATE  doginfo SET color = '$edit_color' WHERE record_id = '$current_record_id'  ");	
	echo "color has been changed<br/>";
} else {
	echo "color has NOT been changed<br/>";
};




if ( $edit_birthdate != $current_birthdate ) { 
	mysql_query ("UPDATE  doginfo SET birthdate = '$edit_birthdate' WHERE record_id = '$current_record_id'  ");	
	echo "birthdate has been changed<br/>";
} else {
	echo "birthdate has NOT been changed<br/>";
};


	


?>
