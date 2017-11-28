<!--<img border="0" alt="W3Schools" src="<?php echo ($News); ?>" width="100%" height="100%">-->
<div class="container">
    <div class="row">

        <!-- ************************************************ Panel of Public Relations Full -->
        <?php echo form_open(base_url("publicRelations/choose"), array("id" => "formPublicRelationsFull")); ?>



        <div class="col-xs-12 col-md-12 col-lg-12 panel-group" id="collapsePublicRelationsFullParent">
        <!-- ************************************** Panel Public Relations Full -->
            <div class="panel">
                <div class="panel-collapse collapse in" id="collapsePublicRelationsFull">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                            <!-- Header Page -->
                            <div class="wrap-topic-head">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="innerBg">
                                <tbody><tr>
                                    <td align="center" style="padding-top:10px;">
                                        <span class="headTxt"><?php $dataTypeName ?></span>
                                    </td>
                                </tr>
                                </tbody></table>
                            </div>
                            <!-- End Header Page -->
                            <!-- Body Content -->
                                <div id="newsDetail">
                                    
                                    <div class="pageContent">
                                        <div class="head-news">
                                            <h2><?php echo $article["Caption"] ?></h2>
                                            <div class="boxview">
                                                <ul>
                                                    <li><?php echo date("d-m-Y", strtotime($article['Publish_Date'])); ?></li>
                                                    <li class="last">View: 273</li>
                                                </ul>
                                            </div>
                                            <hr>
                                        </div>

                                        <?php echo $article["Content"] ?>
                                <!--
                                        <div class="head-news">
                                            <h2>ข่าวสารที่เกี่ยวข้อง</h2>
                                            <a class="btn-newsAbout"
                                            href="<?php 
                                            echo base_url("publicRelations/articleCategory/" . $articleTypeId
                                            . "/" . $article["id"]) ?>">
                                                ดูทั้งหมด
                                            </a>
                                        </div>
                                -->

                                    </div>

                                </div>
                            <!-- End Body Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ************************************** Panel Public Relations Full -->
        </div>
        <?php echo form_close(); ?><!-- Close formPublicRelationsFull -->

    </div>
</div>
