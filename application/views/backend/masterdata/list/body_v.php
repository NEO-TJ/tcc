<!-- Header and button AddNew -->
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="page-header users-header">
				<div class="col-xs-10 col-md-10 col-lg-10">
					<h1><label class="pull-left"><?php echo($dataTypeCaption); ?></label></h1>
				</div>
				<div class="col-xs-2 col-md-2 col-lg-2">
					<?php echo form_open(base_url("masterdata/addNew/".$dataType), array("id" => "formAddNew")); ?>
						<h1>
							<button type="submit" id="dataType" 
							name="dataType" value=<?php echo($dataType); ?>
							class="btn btn-warning pull-right startFocus
							<?php echo(($dataType == '10') ? ' hide' : ''); ?>">
								Add a new
							</button>
						</h1>
					<?php echo form_close(); ?><!-- Close formAddNew -->
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Table list view -->
<?php echo form_open(base_url("masterdata/edit/".$dataType), array("id" => "formChoose")); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<input type='hidden' id='dataType' name='dataType' value=<?php echo($dataType); ?> />
			<div style="overflow-x:auto; overflow-y:auto;">
			<table id="view"
			class="table table-bordered table-components table-condensed table-hover table-striped table-responsive">
			<!-- Table -->			
				<thead class="table-header">
				<!-- Row table header -->
					<tr>
						<th class="text-center" width="40">No.</th>
						<?php 
							if(count($dsView) > 0) {
								$i=0;
								foreach($dsView[0] as $col => $value) {
									if($i++ > 0) {
										echo ('<th class="text-center">'. $col .'</th>');
									}
								}
							}
						?>
						<th class="text-center" width="40">#</th>
					</tr>
				</thead>
				
				<tbody>
				<!-- Row table body -->
					<?php 
						$i = 1;
						foreach($dsView as $row) {
							echo ('<tr>');
								echo('<td class="text-center">' . $i++ . '</td>');
								$j=0;
								foreach($row as $value) {
									if($j++ > 0) {
										echo('<td class="text-left">' . $value . '</td>');
									}
								}
								echo('<td class="text-center">
										<button type="submit" class="btn btn-success'.(($dataType == '10') ? ' hide' : '').'"
											id="rowID" name="rowID" value='.$row['id'].'>
											edit
										</button>
									</td>');
							echo ('</tr>');
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo form_close(); ?><!-- Close formChoose -->


<div id="footer">
	<hr>
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-xs-10 col-md-10 col-lg-10">
				</div>
				<div class="col-xs-2 col-md-2 col-lg-2">
					<a href="#">Back to top</a>
				</div>
			</div>
		</div>
	</div>
</div>