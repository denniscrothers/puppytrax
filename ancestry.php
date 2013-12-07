
<?php include("header.php"); ?>
	
	
	
	
	

	
<?php	
// Get Dog ID
	
	
	// if the id is passed as parameter
	if ($_GET["id"]) {
		$page_id = $_GET["id"];
		$anymatches = 1;
		
	// if a search string is passed as parameter	
	} else  if ($_GET["search"] == "Search"){
	
		$searchterm = $_GET['find'];

		$find = $_GET['find'];
		
		echo "<div id='search results'>";
		
			if ($find == ""){
				echo "<p>You forgot to enter a search term";
			} else{
					
				// We preform a bit of filtering
				$find = ucfirst($find);
				$find = strip_tags($find);
				$find = trim ($find);
			
				
				//Now we search for our search term, in the field the user specified
				$query = "SELECT * FROM doginfo WHERE dog_name LIKE '%$find%'";
				$result = mysql_query($query);
				if (!$result){
					die ("dammit could not search  the database <br/>". mysql_error());
				}
			
				//This counts the number or results - and if there wasn't any it gives them a little message explaining that
				$anymatches=mysql_num_rows($result);
				
				
				// if there are no  exact matches
				if ($anymatches == 0){
					echo "Sorry, there are no exact matches for <span class='searchterm'>".$searchterm."</span><br/>";


					// if first 1 letters match 
					$substr = substr($find,0,1); 
					$query = "SELECT * FROM doginfo WHERE dog_name LIKE '$substr%'";
					$result = mysql_query($query);
					if (!$result){
						die ("dammit could not search  the database <br/>". mysql_error());
					}
					

					while($row = mysql_fetch_array($result)){


						$str = $row['dog_name'];
						//similar_text($find, $str, $percent);
						// metaphone($searchterm)
						$similar = similar_text($find, $str);
						$strlen_find = strlen($find);
						$strlen_match = strlen($str);
						$diff = $strlen_find - $similar;
						$diff_length = abs($strlen_find - $strlen_match);  // absolute value of difference in string length

						if ($diff <= 1 && $diff_length <= 1) {
							echo "Did you mean:<br/>";
							$myDog = new Dog($row['record_id']);
							echo "<div class='result ".$myDog->css."'>";
							$myDog->brief_detail();
							echo "</div>";		
							
						} else	if ($diff <= 2  && $diff_length <= 1) {
							echo "Did you mean:<br/>";
							$myDog = new Dog($row['record_id']);
							echo "<div class='result ".$myDog->css."'>";
							$myDog->brief_detail();
							echo "</div>";							
						}
						
						
					}

					
					


					
				
				// if there are multiple matches, display all of the results
				} else if ($anymatches > 1 && $anymatches < 15){
					echo "There are ".$anymatches." results";
					while($row = mysql_fetch_array($result)){
							$myDog = new Dog($row['record_id']);
							echo "<div class='result ".$myDog->css."'>";
							$myDog->brief_detail();
							echo "</div>";
					}


				// if there are more than 15 matches
				} else if ($anymatches >= 15){
					echo "Sorry, there are too many results for <span class='searchterm'>".$searchterm."</span>. Please refine your search.";


				// if there is one exact match
				} else if ($anymatches == 1){	
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
						$page_id = $row['record_id'];
					}
	
	
				}
				
			} 
			echo "</div>"; // end search results

	
	// otherwise chose Lizbeth
	} else {
		$page_id = "461";
	}




// once id is defined, create dogs

	$myDog = new Dog($page_id); 					// create dog
	
	$mySire = new Breeder_Dog($myDog->sire_id); 	// create sire
	$myDam = new Breeder_Dog($myDog->dam_id);		// create dam
	
	
	$myPSire = new Breeder_Dog($mySire->sire_id);
	$myPDam = new Breeder_Dog($mySire->dam_id);
	$myMSire = new Breeder_Dog($myDam->sire_id);
	$myMDam = new Breeder_Dog($myDam->dam_id);
			
		



// change title of doc

if ($anymatches == 1){ 
	?>
	<script type="text/javascript">
	document.title = "Ancestry of <?php echo $myDog->name; ?> - City Sights"; 
	</script>
	<?php
}

















// begin tree

if ($anymatches == 1){ // only display tree if there is a single match

echo "<div id='ancestry'>";


// self
echo "<div id='self' class='ancestor ".$myDog->css."' >";
	$myDog->brief_detail();
	
?>	
	
	
<div id="editLink">	
<a href="javascript:displayEdit();">click here to edit</a>
</div>	
	
	
	
	
	
	
	
	
<div id="editTemplate" style="display:none; ">
<form id="edit_dogform" name="edit_dogform" method="post" autocomplete="off" action="editdog.php"   > 

	
		<?php  
			$year = substr($myDog->birthdate,0,4);    
			$month = substr($myDog->birthdate,5,2);    
			$day = substr($myDog->birthdate,8,2);    

			if ($myDog->sex == "M"){ ?><script type="text/javascript"> var edit_sex_value = 1;</script> <?php }	
			else if ($myDog->sex == "F"){ ?><script type="text/javascript"> var edit_sex_value = 2;</script> <?php }	
			else { ?><script type="text/javascript"> var edit_sex_value = 0;</script> <?php }
		?>
	
		
		<label id="edit_dog_name" for="edit_dog_name">Name</label><input type="text" name="edit_dog_name"  value="<?php echo $myDog->name ?>" maxlength="30"/ ><br/>
		<label id="edit_dog_tattoo" for="edit_dog_tattoo">Tattoo</label><input type="text" name="edit_dog_tattoo"  value="<?php echo $myDog->tattoo ?>" maxlength="30"/ ><br/>
		
	
		<div id="edit_birthdate">
			<label id="edit_birthdate" for="edit_birthdate">Birthdate</label>
			<input id="birthMM" name="edit_birthMM" type="text"  value="<?php echo $month ?>" size="2" maxlength="2"   />
			<span class="error" id="birthMM_error"></span>
			
			<input id="birthDD" name="edit_birthDD" type="text"  value="<?php echo $day ?>" size="2" maxlength="2"   />
			<span class="error" id="birthDD_error"></span>
			
			<input id="birthYYYY" name="edit_birthYYYY" type="text"  value="<?php echo $year ?>" size="4" maxlength="4"   />
			<span class="error" id="birthYYYY_error"></span>
		</div>
	
				
		<select id="edit_sex" name="edit_sex">
			<option value="" selected="selected" >Sex</option>
			<option value="M">Male</option>
			<option value="F">Female</option>
		</select>
		
		<br/>
		
		<script type="text/javascript">
			var myselect = document.getElementById("edit_sex");
			var edit_sex_value = 2;
			//myselect.options[1].selected = true;			 
			myselect.selectedIndex = 2;
			//myselect.style.display = "none";			 
		</script>
	
	
		<label id="edit_sex" for="edit_sex">Sex</label><input type="text" name="edit_sex"  value="<?php echo $myDog->sex ?>" maxlength="30"/ ><br/>	
		<label id="edit_breed" for="edit_breed">Breed</label><input type="text" name="edit_breed"  value="<?php echo $myDog->breed ?>" maxlength="30"/ ><br/>
		<label id="edit_color for="edit_color">Color</label><input type="text" name="edit_color"  value="<?php echo $myDog->color ?>" maxlength="30"/ ><br/>				
		<input type="hidden" name="record_id"  value="<?php echo $myDog->id ?>" / >
				
	
		<!-- submit -->
		<div id="submit">
			<button type="button" value="cancel" onclick="javascript:removeDisplayEdit();">Cancel</button>
			<input type="submit" name="submit" value="Woof!"  />
		</div>
	
</form>
</div>



					
	
	<?php
	
	
	
echo "</div>";




// descendants
if ($myDog->breeder=="1"){
	echo "<div id='descendants'>";
	$myDog = new Breeder_Dog($myDog->id);
	$myDog->list_allLitters();	
	echo "</div>";

}



// sire 
if ($mySire->name){
	echo "<div id='sire_container'>";
	echo "<div id='sire' class='ancestor ".$mySire->css."' >";
		echo "<ul>";
		$mySire->brief_detail();
		echo "<li class='littertotal'>".$mySire->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
} else {
	echo "<div id='sire_container'>";
	echo "<div id='sire_form'>";

?>
			<div>
			<form id="edit_addsire" name="edit_addsire" method="post" autocomplete="off" action="editdog_addparent.php"   > 
				<label id="sire_label" for="sire">Sire</label>
				<input id="sire" name="sire" type="text"  value="Enter Sire Name" size="16" maxlength="30"  onkeyup="showHint(this.value, this.name, 'breeder', 'no')"  onfocus="this.value='';"/ >
				<input id="sire_id" name="sire_id" type="text"  value="" size="6" maxlength="6" tabindex=""/ >
				<span class="error" id="sire_error"></span></br>
				<ul id="sire_txtHint" class="txtHint"></ul>
		
					<select name="sire_breed" id="sire_breed"  onchange="selectColor(this.value);">
						<option value="" selected="selected">Breed</option>
						<option value="Labrador">Labrador Retriever</option>
						<option value="Golden Retriever">Golden Retriever</option>
						<option value="Labrador Cross">Labrador Cross</option>
						<option value="Standard Poodle">Standard Poodle</option>
						<option value="German Shepard">German Shepard</option>
					</select>
					
					<select id="sire_color" name="sire_color"  tabindex=""  onchange="change_bg(this.value, this.name);">
						<option value="" selected="selected">Color</option>
						<option value="Yellow">Yellow</option>
						<option value="Black">Black</option>
						<option value="Chocolate">Chocolate</option>
						<option value="Brindle">Brindle</option>
						<option value="Light">Light</option>
						<option value="Medium">Medium</option>
						<option value="Dark">Dark</option>
						<option value="White">White</option>
						<option value="Black and tan">Black and tan</option>
					</select>
					
					<input type="hidden" name="record_id"  value="<?php echo $myDog->id ?>" / >
					<input type="hidden" name="parent_type"  value="sire" / >

					
					<div id="submit">
						<input type="submit" name="submit" value="Add Sire"  />
					</div>
					
			</form>
			</div>
	
<?php


	echo "</div>";
	echo "</div>";
}


// dam
if ($myDam->name){
	echo "<div id='dam_container'>";
	echo "<div id='dam' class='ancestor ".$myDam->css."' >";
		echo "<ul>";
		$myDam->brief_detail();
		echo "<li class='littertotal'>".$myDam->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
} else {
	echo "<div id='dam_container'>";
	echo "<div id='dam_form'>";

?>
			<div>
			<form id="edit_add_dam" name="edit_add_dam" method="post" autocomplete="off" action="editdog_addparent.php"   > 
				<label id="dam_label" for="dam">Dam</label>
				<input id="dam" name="dam" type="text"  value="Enter Dam Name" size="16" maxlength="30"  onkeyup="showHint(this.value, this.name, 'breeder', 'no')"  onfocus="this.value='';"/ >
				<input id="dam_id" name="dam_id" type="text"  value="" size="6" maxlength="6" tabindex=""/ >
				<span class="error" id="sire_error"></span></br>
				<ul id="dam_txtHint" class="txtHint"></ul>
		
					<select name="dam_breed" id="dam_breed"  onchange="selectColor(this.value);">
						<option value="" selected="selected">Breed</option>
						<option value="Labrador">Labrador Retriever</option>
						<option value="Golden Retriever">Golden Retriever</option>
						<option value="Labrador Cross">Labrador Cross</option>
						<option value="Standard Poodle">Standard Poodle</option>
						<option value="German Shepard">German Shepard</option>
					</select>
					
					<select id="dam_color" name="dam_color"  tabindex=""  onchange="change_bg(this.value, this.name);">
						<option value="" selected="selected">Color</option>
						<option value="Yellow">Yellow</option>
						<option value="Black">Black</option>
						<option value="Chocolate">Chocolate</option>
						<option value="Brindle">Brindle</option>
						<option value="Light">Light</option>
						<option value="Medium">Medium</option>
						<option value="Dark">Dark</option>
						<option value="White">White</option>
						<option value="Black and tan">Black and tan</option>
					</select>
					
					<input type="hidden" name="record_id"  value="<?php echo $myDog->id ?>" / >
					<input type="hidden" name="parent_type"  value="dam" / >

					
					<div id="submit">
						<input type="submit" name="submit" value="Add Dam"  />
					</div>
					
			</form>
			</div>
	
<?php
	echo "</div>";


	echo "</div>";
}




// littermates
echo "<div id='littermates' >";
echo "<h4>".$myDog->name."'s Littermates</h4>";
	//echo $myDam->list_litter($myDog->birthdate); //passes birthdate param
	//echo "<br/>this is the littermates: <br/>";
$myDog->list_littermates();
echo "</div>";




// paternal sire
if ($myPSire->name){
	echo "<div id='psire_container'>";
	echo "<div id='psire' class='ancestor  ".$myPSire->css."' >";
		echo "<ul>";
		$myPSire->brief_detail();
		echo "<li class='littertotal'>".$myPSire->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
}


// paternal dam
if ($myPDam->name){
	echo "<div id='pdam_container'>";
	echo "<div id='pdam' class='ancestor  ".$myPDam->css."' >";
		echo "<ul>";
		$myPDam->brief_detail();
		echo "<li class='littertotal'>".$myPDam->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
}


// maternal sire
if ($myMSire->name){
	echo "<div id='msire_container'>";
	echo "<div id='msire' class='ancestor  ".$myMSire->css."' >";
		echo "<ul>";
		$myMSire->brief_detail();
		echo "<li class='littertotal'>".$myMSire->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
}

// maternal dam
if ($myMDam->name){
	echo "<div id='mdam_container'>";
	echo "<div id='mdam' class='ancestor  ".$myMDam->css."' >";
		echo "<ul>";
		$myMDam->brief_detail();
		echo "<li class='littertotal'>".$myMDam->litter_total."</li>";
		echo "</ul>";
	echo "</div>";
	echo "</div>";
}


echo "</div>";
} // end condition

// end tree






?>




</body>
</html>






















	
	