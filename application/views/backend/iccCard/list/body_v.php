<!-- Header and button AddNew -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="page-header users-header">
                <div class="col-xs-10 col-md-10 col-lg-10">
                    <h1><label class="pull-left"><?php echo($dataTypeName); ?></label></h1>
                </div>
                <div class="col-xs-2 col-md-2 col-lg-2">
                    <?php echo form_open(base_url("iccCard/addNew"), array("id" => "formAddNew")); ?>
                        <h1>
                            <button type="submit" id="addNew" class="btn btn-warning pull-right startFocus">
                                Add a new
                            </button>
                        </h1>
                    <?php echo form_close(); ?><!-- Close formAddNew -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<?php echo form_open(base_url("iccCard"), array("id" => "formSearch")); ?>
<div class="panel">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12 overflow-xy">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                    <!-- Daterange Section -->
                        <div class="col-xs-7 col-md-7 col-lg-7 text-left">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">ช่วงเวลา : </button>
                                </span>
                                <div id="daterange" class="form-control">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                    <!-- Province Section -->
                        <div class="col-xs-5 col-md-5 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">จังหวัด : </button>
                                </span>
                                <select class="form-control" id="provinceCode">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php
                                    foreach($dsProvince as $row) {
                                        echo '<option value='.$row['ProvinceCode'].'>'.$row['ProvinceName'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Department Section -->
                        <div class="col-xs-7 col-md-7 col-lg-7">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">ชื่อหน่วยงาน : </button>
                                </span>
                                <select class="form-control" id="orgId">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php
                                    foreach($dsOrg as $row) {
                                        echo '<option value='.$row['id'].'>'.$row['department'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Amphur Section -->
                        <div class="col-xs-5 col-md-5 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">อำเภอ : </button>
                                </span>
                                <select class="form-control" id="amphurCode">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php
                                    foreach($dsAmphur as $row) {
                                        echo '<option value='.$row['AmphurCode'].'>'.$row['AmphurName'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Garbage Type Section -->
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">ประเภทขยะ : </button>
                                </span>
                                <select class="form-control" id="garbageTypeId">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php
                                    foreach($dsGarbageType as $row) {
                                        echo '<option value='.$row['id'].'>'.$row['Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Icc Card Status Section -->
                        <div class="col-xs-3 col-md-3 col-lg-3">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">สถานะโครงการ : </button>
                                </span>
                                <select class="form-control" id="iccCardStatusCode">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php 
                                    $cn = count($rIccCardStatus) + 1;
                                    for($i=1; $i < $cn; $i++) {
                                        echo '<option value=' . $i . '>' . $rIccCardStatus[$i] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Project Name Section -->
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary disabled" type="button">ชื่อโครงการ : </button>
                                </span>
                                <select class="form-control" id="projectName">
                                    <option value="0" selected>เลือกทั้งหมด...</option>
                                    <?php
                                    foreach($dsProjectName as $row) {
                                        echo '<option value="'.$row['Project_Name'].'">'.$row['Project_Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <!-- Button Section -->
                        <div class="col-xs-1 col-md-1 col-lg-1 pull-left">
                            <button type="button" class="btn btn-primary pull-right" id="search">Go</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?><!-- Close form search -->


<hr>
<?php echo form_open(base_url("iccCard/edit"), array("id" => "formChoose")); ?>
<div class="panel">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="overflow-xy">
            <!-- Tabel view display -->
                <table class="table table-bordered table-components table-condensed table-hover table-striped table-responsive"
                id="iccCard" style="width: 100%;">
                    <thead class="table-header">
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
                            <th class="text-center" width="40">Edit</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        <?php 
                            $i = 1;
                            foreach($dsView as $row) {
                                echo ('<tr>');
                                    echo('<td class="text-center">' . $i++ . '</td>');
                                    $lastColumn = count($row) - 1;
                                    $j = 0;
                                    foreach($row as $value) {
                                        if ($j == $lastColumn) {
                                            echo('<td class="text-center">');
                                                echo($rIccCardStatus[$value]);
                                                if( (($level == 1) || ($level == 2)) && ($value == 1) ) {
                                                    echo('<div>'
                                                            . '<button id="approveIccCard"'
                                                            . ' type="button" class="btn btn-info">'
                                                                . 'อนุมัติ'
                                                            . '</button>'
                                                        . '</div>'
                                                    );
                                                }
                                            echo('</td>');
                                        } else if ($j > 0) {
                                            echo('<td class="text-left">' . $value . '</td>');
                                        }
                                        $j++;
                                    }
                                    echo('<td class="text-center">
                                            <button type="submit" class="btn btn-success"
                                            id="editIccCard" name="iccCardId" value='.$row['id'].'>
                                                Edit
                                            </button>
                                        </td>');
                                echo ('</tr>');
                            }
                        ?>
                    </tbody>
                </table>
            <!-- End Tabel view display -->
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?><!-- Close form choose -->



<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10 col-lg-10"></div>

            <div class="col-xs-2 col-md-2 col-lg-2">
                <a href="#">Back to top</a>
            </div>
        </div>
    </div>
</div>
<!--
    <div id="footer">
        <hr>
        <div class="inner">
        </div>
    </div>
-->