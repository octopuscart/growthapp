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
                                <br/>
                                <i class="fa fa-<?php echo strtolower($value->gender); ?>"></i>  <?php echo $value->gender; ?>
                                <br/>(<?php echo $value->profession ? $value->profession : '----'; ?>)
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
                                <?php echo $value->registration_datetime; ?>
                            </span>
                        </td>

                        <td>
                            <a href="<?php echo '../userManager/user_details/' . $value->id; ?>" class="btn btn-danger"><i class="fa fa-eye "></i> View</a>
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

        <div class="panel panel-inverse" data-sortable-id="index-10">
            <div class="panel-heading">
                <h4 class="panel-title">Managers Report</h4>
            </div>
            <div class="panel-body">



                <!-- Tab panes -->
                <div class="tab-content">


                    <div class="" style="padding:20px">
                        <?php userReportFunction($users_manager); ?>
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