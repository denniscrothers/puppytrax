
<?php include("header.php"); ?>





<div id='main'>

<h1>Add a Dog or Litter</h1>


<form id="dogform" name="litterform" method="post" autocomplete="off" action="writelitter.php"   > 



	
	
	<!--
	// the following sire and dam fields will use ajax search suggestion
	// if a dam is found in the db, it will populate the field
	// to-do
	-->
	<div id="form_container_sire">
		<label id="sire_label" for="sire">Sire</label>
		<input id="sire" name="sire" type="text"  value="Enter Sire Name" size="16" maxlength="30" tabindex="" disabled="" onkeyup="showHint(this.value, this.name, 'breeder', 'no')"  onfocus="this.value='';"/ > <!--  onblur="showHint(this.value, this.name,'', 'yes')"   this is used to show other dogs -->
		<input id="sire_id" name="sire_id" type="hidden"  value="" size="6" maxlength="6" tabindex=""/ >
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
			

			
	</div>
	
	
	
	
	<div id="form_container_dam">	
		<label id="dam_label" for="dam">Dam</label>
		<input id="dam" name="dam" type="text"  value="Enter Dam Name" size="16" maxlength="30" tabindex="" disabled="" onkeyup="showHint(this.value, this.name, 'breeder', 'no')"   onfocus="this.value='';"/ > <!--  onblur="showHint(this.value, this.name,'', 'yes')"   this is used to show other dogs -->
		<input id="dam_id" name="dam_id" type="hidden"  value="" size="6" maxlength="6" tabindex=""  / >
		<span class="error" id="dam_error"></span>
		<ul id="dam_txtHint"  class="txtHint"></ul>
		
			<select name="dam_breed" id="dam_breed"  onchange="selectColor(this.value);">
				<option value="" selected="selected">Breed</option>
				<option value="Labrador">Labrador Retriever</option>
				<option value="Golden Retriever">Golden Retriever</option>
				<option value="Labrador Cross">Labrador Cross</option>
				<option value="Standard Poodle">Standard Poodle</option>
				<option value="German Shepard">German Shepard</option>
			</select>		
		
		
			<select id="dam_color" name="dam_color"  tabindex="" onchange="change_bg(this.value, this.name);">
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
	</div>




	<div id="form_container_birthdate">
		<h3>Birthdate</h3>
		<label id="birthMM" for="birthMM">MM</label>
		<input id="birthMM" name="birthMM" type="text"  value="MM" size="2" maxlength="2" onfocus="this.value='';"  />
		<span class="error" id="birthMM_error"></span>
		
		<label id="birthDD" for="birthDD">DD</label>
		<input id="birthDD" name="birthDD" type="text"  value="DD" size="2" maxlength="2" onfocus="this.value='';"  />
		<span class="error" id="birthDD_error"></span>
		
		<label id="birthYYYY" for="birthYYYY">YYYY</label>
		<input id="birthYYYY" name="birthYYYY" type="text"  value="YYYY" size="4" maxlength="4" onfocus="this.value='';"  />
		<span class="error" id="birthYYYY_error"></span>
	</div>



	
	<div id="breed">
		<select name="breed" id="breed"  tabindex=""  onchange="selectColor(this.value);">
			<option value="" selected="selected">Select a breed</option>
			<option value="Labrador">Labrador Retriever</option>
			<option value="Golden Retriever">Golden Retriever</option>
			<option value="Labrador Cross">Labrador Cross</option>
			<option value="Standard Poodle">Standard Poodle</option>
			<option value="German Shepard">German Shepard</option>
		</select>
		<span class="error" id="dog_breed_error"></span>
	</div>

	
	
	
	
<!-- First Littermate -->
<div id="littermate_container">

	<div id="1">
		<div class="newRow">
		
			<label for="dog_name" style="display:none;">Name 1 (required):</label>
			<input id="dog_name" name="dog_name[]" type="text"  value="Dog name" size="16" maxlength="30" tabindex=""  onfocus="this.value='';"   onkeyup="showHint2(this.value, this.parentNode.parentNode.id);"  / >
		
			
			<label for="dog_tattoo" style="display:none;">Tattoo:</label>
			<input id="dog_tattoo" name="dog_tattoo[]" type="text"  value="Tattoo" size="4" maxlength="4" tabindex=""   onfocus="this.value='';"  onkeyup="validateTattoo(this.value);" / >
			
		
			<!-- cannot get radio buttons to work with the script -->
			<select id="sex" name="sex[]"  tabindex="">
				<option value="" selected="selected" >Sex</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select>
					
			
			<select id="color" name="color[]"  tabindex="">
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
			
		
			<input type="checkbox" name="breeder[]" value="Breeder" />Breeder
	
			
			
			<ul id="name_txtHint"></ul>
	
			<span class="error" id="error"></span>
	
	
		</div>
		<div class="hints" id="hints1"></div>
		
	</div>
</div>
<!-- End First Littermate -->


	<!-- ad new -->
	<div id="addNew">	
		<a href="javascript:new_div()">Add New </a>
	</div>	
		

	<!-- submit -->
	<div id="submit">
		<input type="submit" name="submit" value="Woof!"  />
		<input type="reset" value="Reset"  >
	</div>
	
	
</form>






	
	


<!-- Template -->
<!-- this is used for all of the 'add new' copies. script uses this template to add new divs -->
<div id="newlinktpl" style="display:none;">
	<div class="newRow">
	
		<label for="dog_name" style="display:none;">Name (required):</label>
		
		<script type="text/javascript">
		//x=document.getElementById("dog_name");
		//parent = x.parentNode.parentNode.id;
		</script>
		
		<input id="dog_name" name="dog_name[]" type="text"  value="Dog name" size="16" maxlength="30" tabindex=""  onfocus="this.value='';" onkeyup="showHint2(this.value, this.parentNode.parentNode.id);"   / >
	
		
		<label for="dog_tattoo" style="display:none;">Tattoo:</label>
		<input id="dog_tattoo" name="dog_tattoo[]" type="text"  value="Tattoo" size="4" maxlength="4" tabindex=""   onfocus="this.value='';"  onkeyup="validateTattoo(this.value);" / >
		
	
		<!-- cannot get radio buttons to work with the script -->
		<select id="sex" name="sex[]"  tabindex="">
			<option value="" selected="selected">Sex</option>
			<option value="M">Male</option>
			<option value="F">Female</option>
		</select>
				
		
		<select id="color" name="color[]"  tabindex="">
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
		
	
		<input type="checkbox" name="breeder[]" value="Breeder" />Breeder

		
		
		<ul id="name_txtHint"></ul>

		<span class="error" id="error"></span>


		
			
	</div>
</div>
<!-- End Template -->















<script language="JavaScript" type="text/javascript" >



	
	// enable fields
	document.getElementById("dam").disabled=false;
	document.getElementById("sire").disabled=false;




</script>
	

</div>


</body>
</html>
