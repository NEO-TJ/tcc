
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="panel-group">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">
						<h3>
							ภาพกิจกรรมโครงการ : 
							<?php echo isset($dsIccCard[0]["Project_Name"]) ? $dsIccCard[0]["Project_Name"] : "" ?>
						</h3>
					</div>
					<div class="panel-body">
					<!-- Upload Form -->
						<div class="form_data">
							<form method="post" action="<?php echo site_url('eventImage/uploadImage')?>" enctype="multipart/form-data">
								<input type="hidden" name="iccCardId" value="<?php echo $iccCardId ?>">
								<input type="file" multiple="multiple" name="imageFile[]">
								<input type="submit" value="Upload image" name="submit">
							</form>
						</div>
					<!-- End Upload Form -->

					<!--Uploaded Image -->
						<?php if(isset($dsImage)) { ?>
							<table width="50%" cellpadding="1" cellspacing="0">
								<?php foreach($dsImage as $image) { ?>
								<tr>
									<td>
										<img class="img" 
										src="<?=base_url().'uploads/Event_Images/'.$image['Image_URL'] ?>">
									</td>
									<td>
										<img class="img" 
										src="<?=base_url().'uploads/Event_Images/thumbs/'.$image['Image_URL'] ?>">
									</td>
								</tr>
								<?php }?>
							</table>
						<?php } ?>
					<!-- End Uploaded Image -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br><br><br>