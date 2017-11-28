<input type='hidden' id='dataType' name='dataType' value=<?php echo($dataType); ?>></input>
<input type='hidden' id='rowID' name='rowID' value=<?php echo($dsInput['id']); ?>></input>
<input type='hidden' id='baseUrl' value="<?php echo(base_url()); ?>"></input>

<!-- Common Name -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Name : </button>
		</span>
		<input type="text" class="form-control input-require startFocus" autocomplete="off"
			placeholder=<?php echo(str_replace(' ', '_', $dataTypeCaption) . "_Name..."); ?> 
			id=<?php echo($dataType); ?> name="Name"
			value="<?php echo($dsInput['Name']); ?>">
	</div>
</div>