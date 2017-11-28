<input type='hidden' id='dataType' name='dataType' value=<?php echo($dataType); ?>></input>
<input type='hidden' id='rowID' name='rowID' value=<?php echo($dsInput['id']); ?>></input>
<input type='hidden' id='baseUrl' value="<?php echo(base_url()); ?>"></input>

<!-- Garbage Type Order -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">ลำดับที่ : </button>
		</span>
		<input type="number" class="form-control input-require" 
		autocomplete="off" placeholder="ลำดับที่..."
		id="OrderType" name="Priority" value="<?php echo($dsInput['Priority']); ?>">
	</div>
</div>

<!-- Garbage Type Name -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">ชื่อประเภทขยะ : </button>
		</span>
		<input type="text" class="form-control input-require" 
		autocomplete="off" placeholder="Garbage Name..."
		id="Name" name="Name" value="<?php echo($dsInput['Name']); ?>">
	</div>
</div>