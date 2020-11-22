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
<div id="content" class="content"  >
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">App Pages</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">App Pages <small></small></h1>
    <!-- end page-header -->

    <div id="gallery" class="gallery row">
        <div class="col-md-4">
            <div class="panel  panel-inverse">
                <div class="list-group">
                    <?php
                    foreach ($pagelist as $lkey => $lvalue) {
                        ?>
                        <a href="<?php echo site_url("CMS/applicationPages/" . $lvalue->id) ?>" class="list-group-item <?php echo $lvalue->id == $page_id ? 'active' : ''; ?>">
                            <?php echo $lvalue->title; ?>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>


        <div class="col-md-8">
            <div class="col-md-12">
                <div class="panel  panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"></h2><?php echo $pageobj->title; ?>
                    </div>

                    <div class="panel-body">

                     
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <fieldset>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control" name="sub_title"  placeholder="Enter Title Here" value="<?php echo $pageobj->sub_title; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Body</label>
                                    <textarea class="form-control" name="body"  placeholder="Type Lyrics Here" rows="10" value=""><?php echo $pageobj->body; ?></textarea>
                                </div>
                                
                                <div class="" style="margin-bottom: 20px;">

                                <div class="btn-group" role="group" aria-label="..." style="float:left;margin-right: 10px;">
                                    <span class="btn btn-success col fileinput-button" ">
                                        <i class="fa fa-plus"></i>
                                        <span>Add files...</span>
                                        <input type="file" name="file"  file-model="filemodel" accept="image/*">
                                    </span>
                                </div>


                                <span style="font-size: 10px;">  Attach File From Here (PDF, JPG, PNG Allowed)</span>

                                <h2 style="    font-size: 12px;">{{filemodel.name}}</h2>
                                <input type="hidden" name="file_real_name" value="{{filemodel.name}}"/>


                            

                                <button type="submit" name="update_data" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-save"></i> Update Now</button>
                            </fieldset>
                        </form>
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
                    <h4 class="modal-title">Add New Song</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" name="title"  placeholder="Enter Title Here" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Lyrics</label>
                                <textarea class="form-control" name="lyrics"  placeholder="Type Lyrics Here" rows="20" value=""></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Youtube Link</label>
                                <input type="text" class="form-control" name="youtube_link"  placeholder="Enter Link Here" value="">
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
                                <label for="exampleInputPassword1">Lyrics</label>
                                <textarea class="form-control" name="lyrics"  placeholder="Type Description Here" rows="20" value="{{selected.lyrics}}"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Youtube Link</label>
                                <label for="exampleInputEmail1"></label>
                                <input type="text" class="form-control" name="youtube_link"  placeholder="Enter Link Here" value="{{selected.youtube_link}}">
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
    var gblurl = "<?php echo site_url("MobileApi/songList/" . $index_id) ?>";
    var deleteurl = "";
</script>

<script src="<?php echo base_url(); ?>assets/angular/requestData.js"></script>
