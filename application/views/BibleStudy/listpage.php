<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');

function truncate($str, $len) {
    $tail = max(0, $len - 10);
    $trunk = substr($str, 0, $tail);
    $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len - $tail))));
    return $trunk;
}
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->

<link href="<?php echo base_url(); ?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url(); ?>assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/lightbox/js/lightbox-2.6.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />


<style>
    .gallery .image img {
        width: 100%;
        height: auto;
        -webkit-border-radius: 3px 3px 0 0;
        -moz-border-radius: 3px 3px 0 0;
        border-radius: 3px 3px 0 0;
    }

    a.tag_style {
        padding: 2px 4px;
        background: black;
        color: white;
        border-radius: 6px;
        font-size: 10px;
    }

    .gallery .desc {
        margin-top: 12px;
    }

    .songlyrics{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .youtubelink{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- begin #content -->
<div id="content" class="content"  ng-controller="BibleStudyDataController">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Bible Study</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Bible Study:- <?php echo $char_text;?> <small></small></h1>
    <!-- end page-header -->

    <div id="gallery" class="gallery row">
       
        <div class="col-md-2 ">
            <div class="panel  panel-inverse">
                <div class="list-group">
                    <?php
                    foreach ($indexlist as $ikey => $ivalue) {
                        ?>
                        <a href="<?php echo site_url("BibleStudy/listPage/" . $ivalue->id) ?>" class="list-group-item <?php echo $ivalue->id == $char_id ? 'active' : ''; ?>">
                            <?php echo $ivalue->title; ?>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="col-md-12">
                <div class="panel  panel-inverse">
                 



                        <div class="list-group " >
                            <li class="list-group-item active" style="height: 50px;    font-size: 20px;">
                                Index List
                                <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addModal">Add New</button>
                            </li>
                               <li href="#" class="list-group-item  songitems">
                                <div class="row">
                                    <div class="songlyrics col-md-5">Title</div> 
                                
                                </div>
                            </li>
                        </div>
                        <div class="list-group ">
                         


                            <li href="#" class="list-group-item  songitems" ng-click="detailSong(bso)" ng-repeat="bso in resultData.bsList" style="cursor: pointer">
                                <div class="row">
                                    <div class="songlyrics col-md-5">{{$index+1}}: {{bso.title}}</div> 
                                </div>
                            </li>


                        </div>
                        
               
                </div>
            </div>
        </div>




    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add New Bible Study</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" name="title"  placeholder="Enter Title Here" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea class="form-control" name="body"  placeholder="Type Lyrics Here" rows="20" value=""></textarea>
                            </div>

                       

                            <button type="submit" name="addnew" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-save"></i> Add Now</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-sm btn-default" ><i class="fa fa-times"></i> Cancel</button>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">{{selected.title}}</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" name="title"  placeholder="Enter Title Here" value="{{selected.title}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea class="form-control" name="body"  placeholder="Type Description Here" rows="20" value="{{selected.body}}"></textarea>
                            </div>
                        



                            <br/>
                            <input type="hidden" name="table_id" value="{{selected.id}}">
                            <button type="submit" name="update_data" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-save"></i> Save Now</button>

                            <button type="submit" name="delete_data" class="btn btn-sm btn-danger m-r-5"><i class="fa fa-trash"></i> Delete Now</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-sm btn-default" ><i class="fa fa-times"></i> Cancel</button>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- end #content -->


<?php
$this->load->view('layout/footer');
?>
<script>
    var gbltablename = "";
    var gblurl = "<?php echo site_url("MobileApi/getBibleStudyDataByIndex/" . $char_text) ?>";
    var deleteurl = "";
</script>

<script src="<?php echo base_url(); ?>assets/angular/requestData.js"></script>
