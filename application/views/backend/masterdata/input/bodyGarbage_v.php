<input type='hidden' id='dataType' name='dataType' value=<?php echo($dataType); ?>></input>
<input type='hidden' id='rowID' name='rowID' value=<?php echo($dsInput['id']); ?>></input>
<input type='hidden' id='baseUrl' value="<?php echo(base_url()); ?>"></input>

<!-- Garbage Type -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Garbage Type : </button>
		</span>
		<select class="form-control input-require startFocus" id="garbageTypeID" name="FK_Garbage_Type">
			<option value="0" selected>Please select Garbage Type</option>
			<?php 
				foreach($dsGarbageType as $row) {
					$selected = (($dsInput['FK_Garbage_Type'] == $row['id']) 
								? ' selected' : '');
					echo '<option value='.$row['id'].$selected.'>'.$row['Name'].'</option>';
				}
			?>
		</select>
	</div>
</div>

<!-- Garbage Name -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Name : </button>
		</span>
		<input type="text" class="form-control input-require" 
			autocomplete="off" placeholder="Garbage Name..."
			id="Name" name="Name" value="<?php echo($dsInput['Name']); ?>">
	</div>
</div>