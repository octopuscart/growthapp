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
</style>

<!-- begin #content -->
<div id="content" class="content"  ng-controller="bibleDataController">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Talugu Bible</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Talugu Bible <small></small></h1>
    <!-- end page-header -->

    <div id="gallery" class="gallery row">
        <div class="col-md-4">
            <div class="panel  panel-inverse">
                <div class="list-group">
                        <li class="list-group-item " style="
    background: #f00;
    color: white">Books</li>
                    <?php
                    foreach ($booklist as $lkey => $lvalue) {
                        ?>
                        <a href="<?php echo site_url("Songs/bible/" . $lvalue->id . "/0") ?>" class="list-group-item <?php echo $lvalue->id == $book_id ? 'active' : ''; ?>">
                            <?php echo $lvalue->book_name; ?>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="col-md-1 ">
            <div class="panel  panel-inverse">
                <div class="list-group">
                    <li class="list-group-item " style="padding: 10px 5px;
    background: #f00;
    color: white">Chapters</li>
                    <?php
                    foreach ($bookchepter as $ikey => $ivalue) {
                        ?>
                        <a href="<?php echo site_url("Songs/bible/" . $book_id . "/" . $ivalue->id) ?>" class="list-group-item <?php echo $ivalue->id == $chapter_id ? 'active' : ''; ?>">
                            <?php 
      
                            echo $ivalue->chapter_no; ?>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="col-md-12 panel  panel-inverse">
                <h3><?php echo $book_name;?><br/> <small>Chapter No.:<?php echo $chapter_name;?></small></h3>
                <p>Click to verse and edit.</p>
                <div class="list-group">

                    <li href="#" class="list-group-item " ng-click="detailSong(song)" ng-repeat="song in resultData.songsList" style="cursor: pointer">
                       {{song.verse_no}}: {{song.verse}}
                    </li>


                </div>
            </div>
        </div>




    </div>

    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><?php echo $book_name;?> (<?php echo $chapter_name;?>:{{selected.verse_no}})</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset>

                           
                            <div class="form-group">

                                <textarea class="form-control" name="description"  placeholder="Type Description Here" rows="10" value="{{selected.verse}}"></textarea>
                            </div>

                          
                            <br/>
                            <input type="hidden" name="table_id" value="{{selected.id}}">
                            <button type="submit" name="update_data" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-save"></i> Save Now</button>
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
    var gblurl = "<?php echo site_url("MobileApi/bibleVerses/" . $chapter_id) ?>";
    var deleteurl = "";
</script>

<script src="<?php echo base_url(); ?>assets/angular/requestData.js"></script>
