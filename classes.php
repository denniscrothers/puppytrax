
<?php


/*******
 NOTES
********


$myDog = new Dog($id)

$myDog->id
$myDog->name
$myDog->tattoo
$myDog->sex
$myDog->breed
$myDog->color
$myDog->birthdate
$myDog->sire_id
$myDog->dam_id
$myDog->status
$myDog->list_littermates() // returns an unordered list of littermates, excluding self
$myDog->brief_detail() // returns an unordered list of all stats


	$myBreeder = new Breeder_Dog($id)

	$myBreeder->litter_total // the total number of litters by this breeder	
	$myBreeder->litterStrings // an associative array - key=birthdate, value=string array of littermate IDs // not for end user
		$myBreeder->litterStrings[dob] // returns a comma-dilineated list of littermats from the DOB
	$myBreeder->list_litter($dob) // returns an unordered list of each littermate from a SINGLE litter; parameter: $dob
	$myBreeder->whelpDate[n] // an array of whelp dates; n is index
	$myBreeder->list_whelpDates()   // returns an unordered list of whelp dates



*******/





$db_host='127.0.0.1';
$db_database='dennisro_guidedogs';
$db_username='dennisro_dennisc';
$db_password='Lizbeth4L96';


// Connect
$connection = mysql_connect($db_host, $db_username, $db_password);
if (!$connection){
	die ("dammit could not connect to the database <br/>". mysql_error());
}


// Select a database
$db_select=mysql_select_db($db_database);
if (!$db_select){
	die ("dammit could not select  the database <br/>". mysql_error());
}






class Dog {

	var $newquery;
	var $newresult;
	var $row;
	var $id;
	
		
function Dog($id){

		$newquery = "SELECT * FROM doginfo WHERE record_id = $id";
		$newresult = mysql_query($newquery);
		if ($newresult){
			while ($row=mysql_fetch_array($newresult)) {
				$this->id = $row['record_id'];
				$this->name = $row['dog_name'];
				$this->tattoo = $row['dog_tattoo'];
				$this->sire_id = $row['sire_id'];
				$this->dam_id = $row['dam_id'];
				$this->sex = $row['sex'];
				$this->breed = $row['breed'];
				$this->color = $row['color'];
				$this->birthdate = $row['birthdate'];
				$this->breeder = $row['breeder'];

				$this->name_link = "<a href='ancestry.php?id=".$this->id."'>".$this->name."</a>";
				
			}
		}

			
		//$this->sire_name

		if ($this->sire_id != 0){
				$newquery = "SELECT * FROM doginfo WHERE record_id = $this->sire_id";
				$newresult = mysql_query($newquery);
				if ($newresult){
					while ($row=mysql_fetch_array($newresult)) {
						$this->sire_name = $row['dog_name'];
					}
				}
		} else { 
				$this->sire_name = "unknown";
		}



		$cssClass = "";
		if ($this->breeder == '1') { 
			$cssClass="breeder";
		}
		$cssClass = $cssClass." ".$this->sex." ".$this->color." ".$this->breed;
		$this->css = $cssClass;

	
	

if ($this->sire_id) {
	$key = $this->sire_id."-s";
	$dog_relatives[$key] = $this->sire_id;
} 
if ($this->dam_id) {
	$key = $this->dam_id."-s";
	$dog_relatives[$key] = $this->dam_id;
} 


if ($this->sire_id) {
		$dog2_sire_obj = new Dog($this->sire_id); 
		$dog2_s_sire = $dog2_sire_obj->sire_id;
		$dog2_s_dam = $dog2_sire_obj->dam_id;
		if ($dog2_s_sire) { 							// 
			$dog2_s_sire_obj = new Dog($dog2_s_sire); 
			$key = $dog2_sire_obj->id."-s"; 				// create key by appending dog id with -s
			$dog_relatives[$key] = $dog2_s_sire_obj->id; 		// add value of new dog's id
		} 
		if ($dog2_s_dam) {	 							//
			$dog2_s_dam_obj = new Dog($dog2_s_dam); 
			$key = $dog2_sire_obj->id."-d"; 				// create key by appending dog id with -d
			$dog_relatives[$key] = $dog2_s_dam_obj->id; 		// add value of new dog's id
		} 
}









$this->relatives_array = $dog_relatives;
	
	

	
	} // end construct

	
	


			function list_littermates(){						
				$newquery = "SELECT * FROM litters WHERE dam_id = $this->dam_id AND birthdate = '$this->birthdate'";
				$newresult = mysql_query($newquery);
				if ($newresult){ 
					while ($row=mysql_fetch_array($newresult)) {			
						$littermates = $row['litter_array']; // gets string array of littermates
					}
					$littermates = explode(',' , $littermates); 		// explode the string into  array
					echo "<ul class='litter_list'>";
					for ($i = 0; $i < count($littermates); $i++){
						$value = $littermates[$i];
						if($value != $this->id){
							$newDog = new Dog($value);
							$newName = $newDog->name;
							$newBirthdate = $newDog->birthdate;
							$newSex = $newDog->sex;
							$newBreed = $newDog->breed;
							$newColor = $newDog->color;
								echo "<ul class='littermate'>";
									echo "<li class='id'><a href='ancestry.php?id=".$value."'>".$value."</a></li>";
									echo "<li class='name'><a href='ancestry.php?id=".$value."'>".$newName."</a></li>";
									echo "<li class='sex'>".$newSex."</span>";
									echo "<li class='breed'>".$newBreed."</li>";
									echo "<li class='color'>".$newColor."</li>";
									echo "<li class='birthdate'>".$newBirthdate."</li>";
								echo"</ul>";
						}
	
					}
					echo "</ul>";
				} // end if
			}// end list_littermates()
			
			
			
			function brief_detail(){
				echo "<ul>";
					echo "<li class='id'><a href='ancestry.php?id=".$this->id."'>".$this->id."</a></li>";
					if($this->name != null){echo "<li class='name'><a href='ancestry.php?id=".$this->id."'>".$this->name."</a></li>";}
					if($this->sex != null){echo "<li class='sex'>".$this->sex."</span>";}
					if($this->breed != null){echo "<li class='breed'>".$this->breed."</li>";}
					if($this->color != null){echo "<li class='color'>".$this->color."</li>";}
					if($this->birthdate != null){echo "<li class='birthdate'>".$this->birthdate."</li>";}
					if($this->breeder == '1'){echo "<li class='breeder'>Breeder</li>";}

				echo"</ul>";
					
			} // end brief_detail
			


			
			
function ancestors(){

		
		// start multidimensional array, key is 0
		$self = "0-x-".$this->id;									// only instance of main array, testdogs
		$relatives =  array (array ($self));						// starts array w/ self
		$merge_no_ids = array($this->id);							// starts array w/ self
		$currentkey = 0; 											// reset $currentkey
		$stop = 0; 													// reset $stop
		
		
		// begin master loop
		do {
				$count = count($relatives[$currentkey]); 			// count how many dogs in the array (use array #0 for test)
				$end_marker = $count ;		
				$added_dog = 0; 									// resets counter for new array
				
				for ($i=0; $i<=$end_marker; $i++){ 					// create a loop for each dog
					$getrelative = $relatives[$currentkey][$i]; 	// get dog#i and name it j
					$pos = stripos($getrelative,"-") + 3;		
					$getrelative = substr($getrelative,$pos);
	
					$dog = new Dog($getrelative); 					// create new dog
				
					if($dog->sire_id){ 								// get sire				
						$value = $dog->id."-s-".$dog->sire_id;		// appends child and relation, instead of using key
						$temp_array[$added_dog] = $value; 			// add dog to temporary array
						$added_dog++; 								// increment
						$merge_no_ids[$dog->id."-s"] =  $dog->sire_id;	
					}
					if($dog->dam_id){ 								// repeat for dam
						$value = $dog->id."-d-".$dog->dam_id;					
						$temp_array[$added_dog] = $value;
						$added_dog++; 
						$merge_no_ids[$dog->id."-d"] =  $dog->dam_id;
					}
				}
				
				
				if ($added_dog > 0) { 
					array_push($relatives, $temp_array); 			// appends a new array to the end of $relatives
					unset($temp_array);  							// clear variable
					$added_dog = 0; 
				} else {$stop = 999;}
				$currentkey++; 										// increment //1
				$newcount = count($relatives[$a][$currentkey]); 	// 2
		} while ($stop != 999)	;
	
		// merges generations into one array
		$merge_ids = array();
		for($i=0; $i<=($currentkey-1); $i++){	
			$this->merge_ids =  array_merge($merge_ids, $relatives[$i]);
		}


}	// ancestors
			
			
		
			










} // end Dog class




class Breeder_Dog extends Dog {
	//constructor
	function Breeder_Dog($id){
		parent::Dog($id);

		// litter_string  // does not account for multiple litters!
		// these are strings, not arrays - therefore the output could be an array of strings
		
		if ($this->sex=='M'){$newquery = "SELECT * FROM litters WHERE sire_id = $this->id ORDER BY birthdate";}
		else {$newquery = "SELECT * FROM litters WHERE dam_id = $this->id ORDER BY birthdate";}
		
		$newresult = mysql_query($newquery);
		$i=0; // keeps count of how many matching rows
		$litterStrings = array(); // constructs array
		
		if ($newresult){ // if there's a match, do this....
			while ($row=mysql_fetch_array($newresult)) {			
				$litterStrings [$row['birthdate']] = $row['litter_array']; // adds a key DOB, and value of string array
				$i++;
			}
		$this->litter_total = $i; // this is how many litters the breeder had	
		$this->litterStrings = $litterStrings; // this is an array of arrays


	
		
		} // end if
		

		
	} // end construct
	
	
	
			// this displays an unordered list of all the whelp dates from $this breeder
			function list_whelpDates(){
				$whelpDates = array_keys ($this->litterStrings);
				for ($i = 0; $i < count($whelpDates); $i++){
					$this->whelpDate[$i] = $whelpDates[$i];
					echo "<li>".$this->whelpDate[$i]."</li>";
				}
			}



function list_allLitters(){
				$whelpDates = array_keys ($this->litterStrings);
				for ($i = 0; $i < count($whelpDates); $i++){
					$this->whelpDate[$i] = $whelpDates[$i];
					echo "<ul class='litter'>";
					echo "<li class='whelpDate'><a>".$this->whelpDate[$i]."</a>";			
					$existinglitter =  $this->litterStrings[$this->whelpDate[$i]]; 		// get the existing string(array) of littermates
					$litters = explode(',' , $existinglitter); 		// explode the string into  array
					
					for ($x = 0; $x < count($litters); $x++){
						$value = $litters[$x];
						$newDog = new Dog($value);
						$newDog->brief_detail();
					}
					
					
					echo "</li>"; 
					echo "</ul>"; 
					
					
				}

}




			// this lists each dog in a litter, & displays brief
			function list_litter($dob='0'){
					
				if ($dob==0){
				// this is to display all arrays
				
				
				
				} else {		
						
					$existinglitter =  $this->litterStrings[$dob]; 		// get the existing string(array) of littermates
					$litters = explode(',' , $existinglitter); 		// explode the string into  array
					//$count = count($litters)
					echo "<ul class='litter_list'>";
					for ($i = 0; $i < count($litters); $i++){
						$value = $litters[$i];
						$newDog = new Dog($value);
						$newName = $newDog->name;
						$newBirthdate = $newDog->birthdate;
						$newSex = $newDog->sex;
						$newBreed = $newDog->breed;
						$newColor = $newDog->color;
							echo "<ul class='littermate'>";
							echo "<li class='id'>".$value."</li>";
							echo "<li class='name'>".$newName."</li>";
							echo "<li class='sex'>".$newSex."</span>";
							echo "<li class='breed'>".$newBreed."</li>";
							echo "<li class='color'>".$newColor."</li>";
							echo "<li class='birthdate'>".$newBirthdate."</li>";
							echo"</ul>";
					}
					echo "</ul>";
				}
			}// end list litter



   
} // end Breeder subclass






?>

























	
	