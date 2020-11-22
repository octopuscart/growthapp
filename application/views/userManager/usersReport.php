<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<style>
    .product_text {
        float: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width:350px
    }
    .product_title {
        font-weight: 700;
    }
    .price_tag{
        float: left;
        width: 100%;
        border: 1px solid #222d3233;
        margin: 2px;
        padding: 0px 2px;
    }
    .price_tag_final{
        width: 100%;
    }

    .exportdata{
        margin: 15px 0px 0px 0px;
    }
</style>
<!-- Main content -->


<?php

function userReportFunction($users) {
    ?>
    <table id="tableDataOrder" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 20px;">S.N.</th>
                <th style="width:50px;">Image</th>
                <th style="width: 75px;">Name</th>
                <th style="width: 100px;">Email </th>
                <th style="width: 100px;">Contact No.</th>
                <th style="width: 100px;">Gender </th>
                <th style="width: 100px;">Birth Date </th>
                <th style="width: 100px;">Profession </th>
                <th style="width: 100px;">Country </th>
                <th style="width: 100px;">Reg. Date/Time</th>
                <th style="width: 75px;">Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($users)) {

                $count = 1;
                foreach ($users as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>

                        <td>


                            <img src = '<?php echo base_url(); ?>assets/profile_image/<?php echo $value->image; ?>' alt = "" class = "media-object rounded-corner" style = "    width: 30px;background: url(<?php echo base_url(); ?>assets/emoji/user.png);    height: 30px;background-size: cover;" />



                        </td>

                        <td>
                            <span class="">
                                <b><span class="seller_tag"><?php echo $value->first_name; ?> <?php echo $value->last_name; ?></span></b>
                            </span>
                        </td>

                        <td>
                            <span class="">
                                <span class="seller_tag">
                                    <?php echo $value->email; ?>
                                </span>

                            </span>
                        </td>
                        <td>
                            <span class="">

                                <?php echo $value->contact_no; ?>
                            </span>
                        </td>
                        <td>
                            <span class="">

                                <?php echo $value->gender; ?>
                            </span>
                        </td>
                        <td>
                            <span class="">

                                <?php echo $value->birth_date; ?>
                            </span>
                        </td>
                        <td>
                            <span class="">

                                <?php echo $value->profession; ?>
                            </span>
                        </td>
                        <td>
                            <span class="">

                                <?php echo $value->country; ?>
                            </span>
                        </td>


                        <td>
                            <span class="">
                                <?php echo $value->registration_datetime; ?>
                            </span>
                        </td>

                        <td>
                            <a href="<?php echo site_url('userManager/user_details/' . $value->id); ?>" class="btn btn-danger"><i class="fa fa-eye "></i> View</a>
                        </td>
                    </tr>
                    <?php
                    $count++;
                }
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>


<section class="content">
    <div class="">

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Users Reports
                    <span class="pull-right label label-success">
                        <a class="btn btn-success btn-xs" href="<?php echo site_url('userManager/user_profile_record_xls/all'); ?>"  targer="_blank">
                            <i class="fa fa-file-excel-o"></i>  Export Data
                        </a>
                    </span>
                </h3>
                <div class="panel-tools">

                </div>

            </div>
            <div class="box-body">



                <!-- Tab panes -->
                <div class="tab-content">


                    <div class="" style="padding:20px">
                        <?php userReportFunction($users_all); ?>
                    </div>
                    <div style="clear: both"></div>
                </div>



            </div>
        </div>
    </div>
</section>
<!-- end col-6 -->
</div>


<?php
$this->load->view('layout/footer');
?> 
<script>
    $(function () {

        $('#tableDataOrder').DataTable({
            language: {
                "search": "Apply filter _INPUT_ to table"
            }
        })
    })

</script>