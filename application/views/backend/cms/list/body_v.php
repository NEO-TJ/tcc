<!-- Header and button AddNew -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="page-header users-header">
                <div class="col-xs-10 col-md-10 col-lg-10">
                    <h1><label class="pull-left"><?php echo($dataTypeName); ?></label></h1>
                </div>
                <div class="col-xs-2 col-md-2 col-lg-2">
                    <?php echo form_open(base_url("cms/addNew"), array("id" => "formAddNew")); ?>
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


<hr>
<?php echo form_open(base_url("cms/edit"), array("id" => "formChoose")); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div style="overflow-x:auto; overflow-y:auto;">
                <!-- Tabel view display -->
                <table class="table table-bordered table-components table-condensed table-hover table-striped table-responsive"
                id="cms" style="width: 100%;">
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
                            <th class="text-center" width="40">#</th>
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
                                        if($j++ > 0) {
                                            echo('<td class="text-left">' . $value . '</td>');
                                        }
                                    }
                                    echo('<td class="text-center">
                                            <button type="submit" class="btn btn-success"
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