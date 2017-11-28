<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Koravit Lomwong">
        <title>Thailand Coastal Cleanup</title>
        <!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
        <?php
	// Css in head tag.
		// Css tmplate plugin.
			if($useCssTemplate) {
				$this->load->view('template/coreCss_v');
				//echo css_asset('plugin/menubar/menubar.css');
			}
		// End Css tmplate plugin.

		// Css customize.
			$this->load->view('template/customizeCss_v');
		// End Css customize.

		// Css extended.
			if(isset($extendedCss)) echo $extendedCss;
		// End Css extended.		
	// End Css in head tag.

	// Js in head tag.
		// Js template plugin.
		if( ($useJsTemplate) && ($useJsTemplateHeadTag) ) {
			$this->load->view('template/coreJs_v');
		}
		// End Js template plugin.
	// End Js in head tag.
 		?>
	</head>
	<body>
		<?php 
			if(($this->uri->segment(1) == 'index') || ($this->uri->segment(1) == '')) {
				$cssHome = "-home";
				$isHome = TRUE;
			} else {
				$cssHome = "";
				$isHome = FALSE;
			}
		?>

	<!-- Body -->
		<!-- Menubar section -->
		<?php $this->load->view('template/menubar_v'); ?>
		<!-- End Menubar section -->

		<div class="BGrepeatY">

		<!-- Breadcrumb section -->
		<?php $this->load->view('template/breadcrumb_v'); ?>
		<!-- End Breadcrumb section -->

		<!-- All Content and Footer section -->
			<div class="BGbottom<?php echo $cssHome ?>">

			<?php if($isHome) {?>
			<!-- Content-1-Home-bg section -->
				<?php $this->load->view('template/content1_v'); ?>
			<!-- End Content-1-Home-bg section -->


			<!-- Content-3-Home section -->
				<div class="content3-home">
				</div>
			<!-- End Content-3-Home section -->

			<?php } else {?>

			<!-- Content-1 section -->
				<div class="content1">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-md-12 col-lg-12">							
								<input type='hidden' id='baseUrl' value="<?php echo(base_url()); ?>" >
								<?php if($header) echo $header;?>
								<?php if($body) echo $body;?>
								<?php if($footer) echo $footer;?>
							</div>
						</div>
					</div>
				</div>
			<!-- End Content-1 section -->
			<?php } ?>

			</div>
		<!-- End All Content and Footer section -->
		</div>
	<!-- End Body -->
		<?php 
	// Js in body tag.
		// Js template plugin.
			if( ($useJsTemplate) && !($useJsTemplateHeadTag) ) {
				$this->load->view('template/coreJs_v');
			}
		// End Js template plugin.

		// Js customize.
			if(isset($extendedJs)) echo $extendedJs;
		// Js customize.
	// End Js in body tag.
		?>
	</body>
</html>