<div class="container">
    <div class="row">

        <!-- ************************************************ Panel of Public Relations List -->
        <?php echo form_open(base_url("publicRelations/choose"), array("id" => "formPublicRelationsList")); ?>
        <div class="col-xs-12 col-md-12 col-lg-12 panel-group" id="collapsePublicRelationsListParent">
        <!-- ************************************** Panel Public Relations List -->
            <div class="panel">
                <div class="panel-collapse collapse in" id="collapsePublicRelationsList">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-lg-12">

                            <!-- Body Content -->
                                <div>

                                    <div class="wrap-topic-head">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="innerBg">
                                            <tr>
                                                <td align="center"  style="padding-top:10px;">
                                                    <span class="headTxt">
                                                        <font style="vertical-align: inherit;">
                                                            <font style="vertical-align: inherit;">
                                                                <!--News Release.-->
                                                            </font>
                                                        </font>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div id="two-col">
                                        <div class="col-left">
                                        <!-- Sidebar -->
                                            <div class="sidebar">
                                                <div class="h">
                                                    <h3><?php echo $dataTypeName ?></h3>
                                                </div>
                                                <ul>
                                                    <ul>
                                                    <!-- Article category list -->
                                                        <li <?php echo ( ($articleCategoryId==0) ? 'class="active"' : '' ) ?>>
                                                            <a title="ข่าวสารล่าสุด" href="<?php 
                                                            echo base_url("publicRelations/articleCategory/"
                                                            .$articleTypeId."/0") ?>">
                                                                <font style="vertical-align: inherit;">
                                                                    <font style="vertical-align: inherit;">
                                                                        <?php echo "ข่าวสารล่าสุด" ?>
                                                                    </font>
                                                                </font>
                                                            </a>
                                                        </li>

                                                        <?php foreach($dsArticleCategory as $rowArticleCategory) { ?>
                                                        <li <?php echo ( ($articleCategoryId==$rowArticleCategory["id"]) ? 'class="active"' : '' ) ?>>
                                                            <a title="<?php $rowArticleCategory["Title"] ?>" href="<?php 
                                                            echo base_url("publicRelations/articleCategory/"
                                                            . $rowArticleCategory["FK_Article_Type"] 
                                                            . "/" . $rowArticleCategory["id"]) ?>">
                                                                <font style="vertical-align: inherit;">
                                                                    <font style="vertical-align: inherit;">
                                                                        <?php echo $rowArticleCategory["Name"] ?>
                                                                    </font>
                                                                </font>
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                    <!-- End Article category list -->
                                                    </ul>
                                                </ul>
                                            </div>
                                        <!-- End Slidebar -->

                                        <!-- Main content -->
                                            <div class="mainContent">
                                            <!-- News -->
                                                <div id="news">
                                                <!-- News list -->
                                                    <div class="newsList">
                                                        <ul>
                                                        <!-- Article list -->
                                                            <?php foreach($dsArticle as $rowArticle) { ?>
                                                            <li>
                                                            <!-- Thumbnial div -->
                                                                <div class="tn">
                                                                    <a href="<?php echo base_url('publicRelations/fullContent/' 
                                                                    . $articleTypeId . '/' . $rowArticle['id']); ?>">
                                                                        <img width="80" 
                                                                        src="<?php echo base_url('assets/uploads/Media/Images/' 
                                                                        . $rowArticle['Thumbnail_Url']) ?>">
                                                                    </a>
                                                                </div>
                                                            <!-- End Thumbnial div -->
                                                            <!-- Full one content div -->
                                                                <div style="height:80px; margin-top:10px;">
                                                                <!-- Caption content -->
                                                                    <div class="h">
                                                                        <a style="color:#66CCFF" title="<?php echo $rowArticle["Title"] ?>" 
                                                                        href="<?php echo base_url('publicRelations/fullContent/' 
                                                                        . $articleTypeId . '/' . $rowArticle['id']); ?>">
                                                                            <?php echo $rowArticle["Caption"] ?>
                                                                        </a>
                                                                    </div>
                                                                <!-- End Caption content -->
                                                                <!-- Shot content -->
                                                                    <div>
                                                                        <?php echo $rowArticle['Header'] ?>
                                                                    </div>
                                                                <!-- End Shot content -->
                                                                <!-- Publish date of content -->
                                                                    <div class="date">
                                                                        <font style="vertical-align: inherit;">
                                                                            <font style="vertical-align: inherit;">
                                                                                <?php echo date("d-m-Y", strtotime($rowArticle['Publish_Date'])); ?>
                                                                            </font>
                                                                        </font>
                                                                    </div>
                                                                <!-- End Publish date of content -->
                                                                    <p><p><hr>
                                                                </div>
                                                            <!-- End Full one content div -->
                                                            </li>
                                                            <?php } ?>
                                                        <!-- End Article list -->
                                                        </ul>
                                                    </div>
                                                <!-- End News list -->
                                                </div>
                                            <!-- End News -->
                                            </div>
                                        <!-- End Main content -->
                                        </div>
                                    <div>

                                <div>
                            <!-- End Body Content -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ************************************** Panel Public Relations List -->
        </div>
        <?php echo form_close(); ?><!-- Close formPublicRelationsList -->

    </div>
</div>
