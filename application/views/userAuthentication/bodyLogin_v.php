<div class="row">
	<div class="col-xs-4 col-md-4 col-lg-4">
	</div>
	<div class="col-xs-4 col-md-4 col-lg-4">
		<center>
			<h1>Thailand Coastal Cleanup</h1>
		</center>
	</div>
	<div class="col-xs-4 col-md-4 col-lg-4">
	</div>

	<div class="col-xs-12 col-md-12 col-lg-12">
		<?php 
			if ($this->session->flashdata ( 'msg' )) { 
				alert("Can't login please try again.");
				/*
				echo ('<div class="alert alert-info alert-dismissible" role="alert">'
						. '<button type="button" class="close" data-dismiss="alert">x</button>'
						. $this->session->flashdata('msg')
					. '</div>');
*/
			} // end if msg
		?>
	</div>

	<div class="col-xs-4 col-md-5 col-lg-5">
	</div>
	<div class="col-xs-4 col-md-2 col-lg-2">
		<div class="panel panel-warning">
			<div class="panel-heading" align="center">Log in</div>
				<div class="panel-body">
					<?php echo form_open ( 'userAuthentication/validate' ); ?>
						<div class="form-group">
							<label for="text">User ID</label> 
							<input type="text" id="username" name="userId">
						</div>					
						<!-- /.form-group -->
						
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" autocomplete="off">
						</div>
						<!-- /.form-group -->
						
						<div class="form-group">
							<input type="submit" class="btn btn-warning" value="Log in">
						</div>
						<!-- /.form-group -->
						
					<?php echo form_close(); ?>
				</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div>
	<div class="col-xs-4 col-md-5 col-lg-5">
	</div>
</div><!-- /.row -->