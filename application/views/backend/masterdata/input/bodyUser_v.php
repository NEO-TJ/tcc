<input type='hidden' id='dataType' name='dataType' value=<?php echo($dataType); ?>></input>
<input type='hidden' id='rowID' name='rowID' value=<?php echo($dsInput['masterId']); ?> />
<input type='hidden' id='employeeId' name='FK_ID_Employee' value=<?php echo($dsInput['FK_ID_Employee']); ?> />
<input type='hidden' id='baseUrl' value="<?php echo(base_url()); ?>"></input>

<!-- First Name -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">First Name : </button>
		</span>
		<input type="text" class="form-control input-require startFocus" autocomplete="off"
			placeholder="First Name..." id="firstName" name="First_Name" value="<?php echo($dsInput['First_Name']); ?>">
	</div>
</div>

<!-- Last Name -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Last Name : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Last Name..." id="lastName" name="Last_Name" value="<?php echo($dsInput['Last_Name']); ?>">
	</div>
</div>

<!-- User ID -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">User ID : </button>
		</span>
		<input type="text" class="form-control input-require" autocomplete="off"
			placeholder="UserID..." id="userID" name="UserId" value="<?php echo($dsInput['UserId']); ?>">
	</div>
</div>

<!-- Password -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Password : </button>
		</span>
		<input type="password" class="form-control input-require" autocomplete="off" 
			readonly onfocus="this.removeAttribute('readonly');"
			placeholder="Password..." id="password" name="Password" value="<?php echo($dsInput['Password']); ?>">
	</div>
</div>

<!-- Emial -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Email : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Email@..." id="email" name="Email" value="<?php echo($dsInput['Email']); ?>">
	</div>
</div>

<!-- Level -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Level : </button>
		</span>
		<select class="form-control" id="level" name="Level">
			<option value="1" <?php echo(($dsInput['Level'] == '1') ? ' selected' : ''); ?>>Admin</option>
			<option value="2" <?php echo(($dsInput['Level'] == '2') ? ' selected' : ''); ?>>Supervisor/Engineer</option>
			<option value="3" <?php echo(($dsInput['Level'] == '3') ? ' selected' : ''); ?>>Staff</option>
		</select>
	</div>
</div>

<!-- Active -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Active : </button>
		</span>
		<select class="form-control" id="active" name="Active">
			<option value="0"<?php echo(($dsInput['Active'] == 0) ? ' selected' : ''); ?>>Terminate</option>
			<option value="1"<?php echo(($dsInput['Active'] == 1) ? ' selected' : ''); ?>>Active</option>
		</select>
	</div>
</div>

<!-- Job Title -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Job Title : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Job Title..." id="jobTitle" name="Job_Title" value="<?php echo($dsInput['Job_Title']); ?>">
	</div>
</div>

<!-- Department -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Department : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Department..." id="department" name="Department" value="<?php echo($dsInput['Department']); ?>">
	</div>
</div>

<!-- Workshop -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Workshop : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Workshop..." id="workshop" name="Workshop" value="<?php echo($dsInput['Workshop']); ?>">
	</div>
</div>

<!-- Gender -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Gender : </button>
		</span>
		<select class="form-control" id="gender" name="Gender">
			<option value=1<?php echo(($dsInput['Gender'] == 1) ? ' selected' : ''); ?>>Male</option>
			<option value=2<?php echo(($dsInput['Gender'] == 2) ? ' selected' : ''); ?>>Female</option>
		</select>
	</div>
</div>

<!-- Age -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">Age : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="Age..." id="age" name="Age" value="<?php echo($dsInput['Age']); ?>">
	</div>
</div>

<!-- ID Card Number -->
<div class="col-xs-12 col-md-12 col-lg-12 margin-input">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-primary disabled" type="button">ID Card Number : </button>
		</span>
		<input type="text" class="form-control" autocomplete="off"
			placeholder="ID Card Number..." id="idCardNumber" name="ID_Card_Number" value="<?php echo($dsInput['ID_Card_Number']); ?>">
	</div>
</div>