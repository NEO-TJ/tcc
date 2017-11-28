
<!-- Search -->
<?php echo form_open(base_url("eventImage"), array("id" => "formSearch")); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-11 col-md-11 col-lg-11">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-primary disabled" type="button">ชื่อโครงการ : </button>
								</span>
								<select class="form-control" id="iccCardId" name="iccCardId">
									<option value=-1 selected>กรุณาเลือกโครงการ</option>
									<?php
									foreach($dsFilter as $row) {
										$selected = ( ($dsIccCard[0]['id'] == $row['id']) ? ' selected' : '' );
										echo '<option '.$selected.' value='.$row['id'].'>'.$row['Project_Name'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-xs-1 col-md-1 col-lg-1 pull-left">
							<button type="submit" class="btn btn-primary pull-right" id="search">
								Go
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?><!-- Close form search -->


<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="panel-group">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">
						<h3>ภาพกิจกรรมโครงการ : <?php echo $dsIccCard[0]['Project_Name'] ?></h3>
					</div>
					<div class="panel-body">
						<?php echo $gallery['html']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br><br><br>