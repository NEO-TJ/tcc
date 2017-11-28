<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12 page-header users-header">
			<div class="container">
				<div class="row">
					<div class="col-xs-10 col-md-10 col-lg-10">
						<h1>
							<label class="pull-left"><?php echo($dataTypeCaption); ?></label>
						</h1>
					</div>

					<div class="col-xs-2 col-md-2 col-lg-2">
						<h1>
							<button type="button" class="btn btn-danger btn-reset pull-right"
							onclick="location.href='<?php echo(base_url());?>masterdata/view/<?php echo($dataType);?>'">
								<<--- back   
							</button>
						</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo form_open(base_url("masterdata/save"), array("id" => "formInputData")); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading" style="text-align: center;">
					<h3 id="panel-caption"><?php echo($inputModeName);?></h3>
				</div>
