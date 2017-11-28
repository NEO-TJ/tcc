<input type='hidden' id='strDateStart' value="<?php echo($strDateStart); ?>"></input>
<input type='hidden' id='strDateEnd' value="<?php echo($strDateEnd); ?>"></input>
<input type='hidden' id='provinceCode' value="<?php echo($provinceCode); ?>"></input>
<div class="container">
    <div class="row">

        <!-- ************************************************ Div Detail Report -->
        <div class="col-xs-12 col-md-12 col-lg-12 panel-group" id="collapseDetailReportParent">
        <!-- ************************************** Panel Detail Report -->
            <div class="panel panel-primary">
            <!-- ************************* Panel Detail Report - Heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#collapseDetailReportParent" href="#collapseDetailReport">
                            <div id="panelHeaderCaption">
                                รายงานกิจกรรมการเก็บขยะรายจังหวัด
                            </div>
                        </a>
                    </h4>
                </div>
            <!-- ************************* End Panel Detail Report - Heading -->
                <div class="panel-collapse collapse in" id="collapseDetailReport">
            <!-- ************************* Panel Detail Report - Body -->
                    <div class="panel-body">
                        <div class="row">
                        <!-- Body Content -->
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <div class="row">
                                <!-- Marine Debris Column Chart Sub Section -->
                                <div class="col-xs-4 col-md-4 col-lg-4 text-left margin-input">
                                        <div id="marineDebrisDetailColumnChart"></div>
                                    </div>
                                <!-- End Marine Debris Column Chart Sub Section -->

                                <!-- Marine Debris 3Pie Chart Sub Section -->
                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left margin-input">
                                        <div id="marineDebrisDetailPieChart"></div>
                                    </div>
                                <!-- End Marine Debris 3Pie Chart Sub Section -->

                                <!-- Marine Debris Column Chart Sub Section -->
                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left margin-input">
                                        <div id="marineDebrisDetailColumnChart"></div>
                                    </div>
                                <!-- End Marine Debris Column Chart Sub Section -->

                                <!-- Marine Debris Table Sub Section -->
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <table class="table table-bordered table-components table-condensed table-hover table-striped table-responsive" 
                                            id="marineDebrisDetailTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center header-border-report"><h4><strong></strong></h4></th>
                                                    <th class="text-center header-border-report"><h4><strong>ชื่อโครงการ</strong></h4></th>
                                                    <th class="text-center header-border-report" width="100"><h4><strong>อาสาสมัคร</strong></h4></th>
                                                    <th class="text-center header-border-report" width="50"><h4><strong>อันดับ</strong></h4></th>
                                                    <th class="text-center header-border-report"><h4><strong>ประเภทขยะ</strong></h4></th>
                                                    <th class="text-center header-border-report"><h4><strong>จำนวน (ชิ้น)</strong></h4></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- End Marine Debris Table Sub Section -->
                                </div>
                            </div>
                        <!-- End Body Content -->
                        </div>
                    </div>
                </div>
            <!-- ************************* End Panel Detail Report - Body -->
            </div>
        <!-- ************************************** Panel Detail Report -->
        </div>
        <!-- ************************************************ End Div Detail Report -->

    </div>
</div>
