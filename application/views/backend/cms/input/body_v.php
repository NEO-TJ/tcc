<?php echo form_open(base_url("cms/save"), array("id" => "formContentEditor")); ?>
<div class="container">
    <div class="row">

	<input type='hidden' id='rowID' name='rowID' value=<?php echo($dsInput['dsArticle'][0]['id']); ?> />
	
	<!-- ************************************************ Container of Content Editor -->
		<div class="col-xs-12 col-md-12 col-lg-12 panel-group" id="collapseContentEditorParent">
			<div class="panel panel-primary">
		<!-- ************************************** Panel Content Editor -->
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#collapseContentEditorParent" href="#collapseContentEditor">
							
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse in" id="collapseContentEditor">
					<div class="panel-body">
						<div class="row">
				<!-- Title -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input">
								<div><h4>Title : </h4></div>

								<input type="text" class="form-control input-require" autocomplete="off"
								placeholder="Title..." id="title" name="Title"
								value="<?php echo($dsInput['dsArticle'][0]['Title']); ?>">
							</div>
				<!-- Caption -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input">
								<div><h4>Caption : </h4></div>

								<div class="text-left margin-input">
									<input type="text" class="form-control input-require" autocomplete="off"
									placeholder="Caption..." id="caption" name="Caption"
									value="<?php echo($dsInput['dsArticle'][0]['Caption']); ?>">
								</div>
							</div>
				<!-- Header -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input">
								<div><h4>Header : </h4></div>

								<div class="text-left margin-input">
									<input type="text" class="form-control input-require" autocomplete="off"
									placeholder="Header..." id="header" name="Header"
									value="<?php echo($dsInput['dsArticle'][0]['Header']); ?>">
								</div>
							</div>
				<!-- Content -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input">
								<div><h4>Content : </h4></div>

								<div class="text-left margin-input">
									<textarea class="tinymce" id="content" style="width:100%; height:1000px;">
										<?php echo($dsInput['dsArticle'][0]['Content']); ?>
									</textarea>
								</div>
							</div>
				<!-- Mata Tag Title -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input"></div>
								<div><h4>Mata Tag Title : </h4></div>

								<div class="text-left margin-input">
								<input type="text" class="form-control input-require" autocomplete="off"
								placeholder="Mata Tag Title..." id="metaTagTitle" name="Mata_Tag_Title"
								value="<?php echo($dsInput['dsArticle'][0]['Mata_Tag_Title']); ?>">
							</div>
				<!-- Mata Tag Description -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input"></div>
								<div><h4>Mata Tag Description : </h4></div>

								<div class="text-left margin-input">
								<input type="text" class="form-control input-require" autocomplete="off"
								placeholder="Mata Tag Description..." id="metaTagDescription" name="Mata_Tag_Description"
								value="<?php echo($dsInput['dsArticle'][0]['Mata_Tag_Description']); ?>">
							</div>
				<!-- Mata Tag Keywords -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input"></div>
								<div><h4>Mata Tag Keywords : </h4></div>

								<div class="text-left margin-input">
								<input type="text" class="form-control input-require" autocomplete="off"
								placeholder="Mata Tag Keywords..." id="metaTagKeywords" name="Mata_Tag_Keywords"
								value="<?php echo($dsInput['dsArticle'][0]['Mata_Tag_Keywords']); ?>">
							</div>
				<!-- Thumbnail Url -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input"></div>
								<div><h4>Thumbnail Url : </h4></div>

								<div class="text-left margin-input">
									<textarea class="tinymce" id="thumbnailUrl" style="width:100px;">
										<?php echo($dsInput['dsArticle'][0]['Thumbnail_Url']); ?>
									</textarea>
								</div>
							</div>
				<!-- Publish Date -->
							<div class="col-xs-12 col-md-12 col-lg-12 text-left margin-input"></div>
								<div><h4>Publish Date : </h4></div>

								<div class="input-group date" id='dtsPublishDate'>
									<input data-date-format="DD-MMM-YYYY" type="text"
									class="small-input-group input-require" name="Publish_Date"
									value=<?php 
										echo( 
											( ($dsInput['dsArticle'][0]['Publish_Date'] == 0)
												? date("d-M-Y")
												: date("d-M-Y", strtotime($dsInput['dsArticle'][0]['Publish_Date']))));
											?>>
									</input>

									<span class="input-group-addon small-input-group">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
				<!-- End Publish Date -->

						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- ************************************** End Panel Content Editor -->

		<br/><br/>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<div class="col-xs-10 col-md-10 col-lg-10">
					</div>
					<div class="col-xs-2 col-md-2 col-lg-2 pull-right">
						<button type="submit" class="btn btn-primary pull-right" id="btnSave">Save</button>
					</div>
				</div>
			</div>
		</div>
		<hr>
	<!-- ************************************************ End Container of Content Editor -->
	</div>
</div>
<?php echo form_close(); ?><!-- Close formContentEditor -->
