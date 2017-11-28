<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

<nav class="navbar navbar-default navbar-inverse navbar-top" role="navigation">
<!-- Brand and toggle get grouped for better mobile display -->
	<div class="container-fluid">

		<?php if( ($level==1) || ($level==2) || ($level==3)){ ?>
	<!-- Backend Zone -->
		<!-- Navbar header -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
				data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Thailand Coastal Cleanup</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url(); ?>index">Thailand Coastal Cleanup::</a>
			</div>
		<!-- End Navbar header -->

		<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<ul class="nav navbar-nav">
				<!-- ICC Card -->
					<li><h4>||</h4></li>
					<li <?php if($this->uri->segment(1) == 'iccCard') { echo 'class="active"'; } ?>>
						<a href="<?php echo base_url(); ?>iccCard" title="แบบฟอร์ม ICC Card">ICC Card</a>
					</li>


				<!-- CMS -->
					<li><h4>||</h4></li>
					<li class="dropdown
						<?php 
							if( ($level == "1") || ($level == "2") ) {
								if($this->uri->segment(1) == 'cms') {
									echo ' active dropdown';
								}
							} else { echo ' hide';}
						?>
					">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							News
							<span class="caret"></span>
						</a>
					<!-- Dropdown Menu -->
						<ul class="dropdown-menu" role="menu">
						<!-- Cleanup Type -->
							<li <?php if(($this->uri->segment(1) == 'cms') && ($this->uri->segment(3) == 1)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>cms/view" title="จัดการบทความข่าวสาร">ข่าว</a>
							</li>
							<li class="divider"></li>
						<!-- Distance Unit -->
							<li <?php if(($this->uri->segment(1) == 'cms') && ($this->uri->segment(3) == 1.1)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>cms/view" title="จัดการหมวดหมู่ข่าวสาร">หมวดหมู่</a>
							</li>
							</ul>
					<!-- End Dropdown Menu -->
					</li>

				<!-- Photo Gallery --><!--
					<li><h4>||</h4></li>
					<li <?php if(($this->uri->segment(1) == 'eventImage')
					&& ($this->uri->segment(2) != 'galleryAdmin')) { echo 'class="active"'; } ?>>
						<a href="<?php echo base_url(); ?>eventImage/gallery/-1" title="ภาพกิจกรรมการเก็บขยะ">Gallery</a>
					</li>-->

				<!-- Photo Gallery Admin -->
					<li><h4>||</h4></li>
					<li <?php if(($this->uri->segment(1) == 'eventImage') 
					&& ($this->uri->segment(2) == 'galleryAdmin')) { echo 'class="active"'; } ?>>
						<a href="<?php echo base_url(); ?>eventImage/galleryAdmin/-1<?php //echo $dataInput['FK_ICC_Card'] ?>" 
						title="บริหารจัดการภาพกิจกรรม การเก็บขยะ">Gallery Admin</a>
					</li>

				<!-- Master Data -->
					<li><h4>||</h4></li>
					<li class="dropdown
						<?php 
							if($level == "1") {
								if($this->uri->segment(1) == 'masterdata') {
									echo ' active dropdown';
								}
							} else { echo ' hide';}
						?>
					">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Master data<span class="caret"></span></a>
					<!-- Dropdown Menu -->
						<ul class="dropdown-menu" role="menu">
						<!-- Cleanup Type -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 1)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/1">Cleanup Type</a>
							</li>
							<li class="divider"></li>
						<!-- Distance Unit -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 2)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/2">Distance Unit</a>
							</li>
						<!-- Weight Unit -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) ==3)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/3">Weight Unit</a>
							</li>
							<li class="divider"></li>
						<!-- Animal Status -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 4)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/4">Animal Status</a>
							</li>
							<li class="divider"></li>
						<!-- Garbage -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 5)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/5">Garbage</a>
							</li>
						<!-- Garbage Type -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 6)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/6">Garbage Type</a>
							</li>
							<li class="divider"></li>
						<!-- Media Type -->
							<!--
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 7)) { echo 'class="active"'; } ?>>
								<a href="<?php echo base_url(); ?>masterdata/view/7">Media Type</a>
							</li>
							<li class="divider"></li>
							-->
						<!-- User -->
							<li <?php if(($this->uri->segment(1) == 'masterdata') && ($this->uri->segment(3) == 0)) { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>masterdata/view/0">User</a>
							</li>
						</ul>
					<!-- End Dropdown Menu -->
					</li>


				<!-- Logout -->
					<li><h4>||</h4></li>
					<li>
						<a href="<?php echo base_url(); ?>logout">Logout</a>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		<!-- End Collect the nav links, forms, and other content for toggling -->
	<!-- End Backend Zone -->
		<?php } else { ?>
	<!-- Frontend Zone -->
			<?php echo form_open ( 'userAuthentication/validate', array("id" => "formLogin") ); ?>
				<div class="container member-status">
					<div class="row">
						<div class="col-xs-12 col-md-12 col-lg-12">
							<label class="member-status">ชื่อผู้ใช้</label>
							<input class="member-status-input" size="20" type="text" id="username" name="userId">
							
							<label class="member-status">รหัสผ่าน</label>
							<input class="member-status-input" size="20" type="password"
							id="password" name="password" autocomplete="off">
							
							<a href="#" class="member-status" 
							onclick="document.getElementById('formLogin').submit();">
								เข้าสู่ระบบ
							</a>
							<label class="member-status-slash">/</label>

							<a href="#" class="member-status">ลืมรหัสผ่าน</a>
							<label class="member-status-slash">/</label>

							<a href="<?php echo base_url(); ?>userAuthentication/register" 
							class="member-status">สมัครสมาชิก</a>

							<?php 
							if ($this->session->flashdata ( 'msg' )) { 
								echo (
									'<div class="alert alert-info alert-dismissible" role="alert">'
										. '<button type="button" class="close" data-dismiss="alert">x</button>'
										. $this->session->flashdata('msg')
									. '</div>'
								);
							} // end if msg
							?>

						</div>
					</div>
				</div>
			<?php echo form_close(); ?>
	<!-- End Frontend Zone -->
		<?php }; ?>

	</div><!-- /.container-fluid -->
<!-- End Brand and toggle get grouped for better mobile display -->
</nav>

		</div>
	</div>
</div>