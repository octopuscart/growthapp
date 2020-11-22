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
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

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
        <li class="active">Prayer Request</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Prayer Request<small></small></h1>
    <!-- end page-header -->

    <div id="gallery" class="gallery row">



        <div class="col-md-12">
            <div class="col-md-12">
                <div class="panel  panel-primary">


                    <div class="panel-body">
                        <table id="tableData2" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th style="width: 150px;">Name/Email/Contact No.</th>
                                    <th style="width: 100px;">Country/Status/City</th>
                                    <th style="width: 150px;">Prayer Type</th>
                                    <th style="width: 200px;">Message</th>
                                    <th style="width: 150px;">Date Time</th>
                                    <th style="width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 400"></tbody>
                        </table>



              

                    </div>
                </div>
            </div>
        </div>




    </div>



</div>
<!-- end #content -->
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>

<?php
$this->load->view('layout/footer');
?>
<script>

    var deleteurl = "";
    $(function () {


        $('#tableData2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo site_url("MobileApi/prayerApi") ?>",
                type: 'GET'
            },
            "columns": [
                {"data": "id"},
                {"data": "contact_information"},
                {"data": "location"},
                {"data": "prayer_needed"},
                {"data": "messages"},
                {"data": "opt_date"},
                {"data": "operation"},
            ]}
        );


       
    })
</script>


