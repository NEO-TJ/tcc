<div class="breadcrumb-main">
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="breadcrumb">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>index">หน้าแรก</a></li>
						<?php if($breadcrumb !== NULL) {
							foreach($breadcrumb as $bcRow) {
								if($bcRow["link"] === NULL) {
									echo ('<li class="active">' . $bcRow["caption"] . '</li>');
								} else { 
									echo ('<li><a href="' . base_url() . $bcRow["link"] . '">' 
									. $bcRow["caption"] . '</a></li>');
								}
							}
						} ?>
					</ol>
				</div>
			</div>

		</div>
	</div>
</div>