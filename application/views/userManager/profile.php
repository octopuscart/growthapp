<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"  />

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />

<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li class="active">Profile Page</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header"><?php echo $userdata->first_name; ?> <?php echo $userdata->last_name; ?> <small><?php echo $userdata->email; ?> </small></h1>
    <!-- end page-header -->
    <!-- begin profile-container -->
    <div class="profile-container" style="background: #d2cbcb;">
        <!-- begin profile-section -->
        <div class="profile-section" style="background: #fff;">
            <!-- begin profile-left -->
            <div class="profile-left">
                <!-- begin profile-image -->
                <div class="profile-image" style="background: url(<?php echo base_url(); ?>assets/emoji/user.png); background-size: cover;">
                    <img src='<?php echo base_url(); ?>assets/profile_image/<?php echo $userdata->image; ?>' style="width: 100%;   height: auto;
                         " />
                    <i class="fa fa-user hide"></i>
                </div>
                <!-- end profile-image -->
                <div class="m-b-10">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="btn-group" role="group" aria-label="..." style="    width: 100%;">
                            <span class="btn btn-success col fileinput-button" style="width: 70%">
                                <i class="fa fa-plus"></i>
                                <span>Add files...</span>
                                <input type="file" name="picture" required="">
                            </span>
                            <button type="submit" name="submit" class="btn btn-warning" style="width: 30%"><i class="fa fa-upload"></i></button>

                        </div>
                    </form>



                </div>
                <!-- begin profile-highlight -->
                <div class="profile-highlight">
                    <h4><i class="fa fa-cog"></i> Settings</h4>
                    <div class="checkbox m-b-5 m-t-0" >
                        <label><input type="checkbox" id="edit_toggle" /> Edit Profile Information</label>
                    </div>

                    <div class="checkbox m-b-0">
                        <button class="btn btn-xs btn-link" data-toggle="modal" data-target="#changePassword"><i class="fa fa-lock"></i> Change Your Password</button>
                    </div>
                </div>
                <!-- end profile-highlight -->
            </div>
            <!-- end profile-left -->
            <!-- begin profile-right -->
            <div class="profile-right">
                <!-- begin profile-info -->
                <div class="profile-info">
                    <!-- begin table -->
                    <div class="table-responsive">

                        <table class="table table-profile">
                            <thead>
                                <tr>
                                    <th colspan="2">

                                        <div class="media">
                                            <a class="media-left" href="javascript:;">
                                                <img src='<?php echo base_url(); ?>assets/profile_image/<?php echo $userdata->image; ?>' alt="" class="media-object rounded-corner" style="    width: 45px;background: url(<?php echo base_url(); ?>assets/emoji/user.png);    height: 45px;background-size: cover;">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><?php echo $userdata->first_name; ?> <?php echo $userdata->last_name; ?></h4>
                                                <p>
                                                    <?php echo $userdata->email; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!--                                        <h4>
                                                                                    <i class="ion-android-person"></i>
                                        <?php echo $userdata->first_name; ?> <?php echo $userdata->last_name; ?>
                                                                                    <small>
                                        <?php echo $userdata->email; ?>
                                                                                    </small>
                                                                                </h4>-->
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <td class="field">First Name</td>
                                    <td>
                                        <span id="first_name" data-type="text" data-pk="<?php echo $userdata->id; ?>" data-name="first_name" data-value="<?php echo $userdata->first_name; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Enter First Name" class="m-l-5 editable editable-click" tabindex="-1" data-toggle="#edit_fname" > <?php echo $userdata->first_name; ?></span><button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>
                                <tr >
                                    <td class="field">Last Name</td>
                                    <td>
                                        <span id="last_name" data-type="text" data-pk="<?php echo $userdata->id; ?>" data-name="last_name" data-value="<?php echo $userdata->last_name; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Enter Last Name" class="m-l-5 editable editable-click" tabindex="-1" data-toggle="#edit_lname" > <?php echo $userdata->last_name; ?></span><button  class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>


                                <tr class="highlight">
                                    <td class="field">Contact No.</td>
                                    <td>
                                        <i class="fa fa-mobile fa-lg m-r-5"></i> 
                                        <span id="contact_no" data-type="text" data-pk="<?php echo $userdata->id; ?>" data-name="contact_no" data-value="<?php echo $userdata->contact_no; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Enter Contact No." class="m-l-5 editable editable-click" tabindex="-1" data-toggle="#edit_contact" > <?php echo $userdata->contact_no; ?></span><button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>


                                <tr >
                                    <td class="field">Gender</td>
                                    <td>
                                        <span id="gender" data-type="select" data-pk="<?php echo $userdata->id; ?>" data-name="gender" data-value="<?php echo $userdata->gender; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Select Gender" class="m-l-5 editable editable-click" tabindex="-1" > <?php echo $userdata->gender; ?></span><button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>
                                <tr >
                                    <td class="field">Birth Date</td>
                                    <td>
                                        <a href="#" id="dob" data-type="combodate"  data-name="birth_date" data-value="<?php echo $userdata->birth_date; ?>" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="<?php echo $userdata->id; ?>" data-title="Select Date of birth" class="editable editable-click" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>"><?php echo $userdata->birth_date; ?></a>                                        
                                        <button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>

                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>

                                <tr class="highlight">
                                    <td class="field">Profession</td>
                                    <td>
                                        <span id="profession" data-type="select" data-pk="<?php echo $userdata->id; ?>" data-name="profession" data-value="<?php echo $userdata->profession; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Select Profession" class="m-l-5 editable editable-click" tabindex="-1" > <?php echo $userdata->profession; ?></span><button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>

                                <tr class="highlight">
                                    <td class="field">Country</td>
                                    <td>
                                        <span id="country" data-type="select" data-pk="<?php echo $userdata->id; ?>" data-name="country" data-value="<?php echo $userdata->country; ?>" data-url="<?php echo site_url("LocalApi/updateUserClient"); ?>" data-original-title="Select Country" class="m-l-5 editable editable-click" tabindex="-1" > <?php echo $userdata->country; ?></span><button class="btn btn-xs btn-link edit_detail" ><i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <!-- end table -->
                </div>
                <!-- end profile-info -->
            </div>
            <!-- end profile-right -->
        </div>
        <!-- end profile-section -->

        <div class="" style="margin-top: 10px">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#usersOrders" data-toggle="tab">Orders List</a></li>
                <li class=""><a href="#userLog" data-toggle="tab">User Log</a>
            </ul>
            <div class="tab-content">
          

                <div class="tab-pane fade active in" id="usersOrders">
                    <h3 class="m-t-10"><i class="fa fa-list"></i> Orders List </h3>
                    <div class="row">
                        <?php
                        foreach ($orderslist as $key => $value) {
                            ?>
                            <div class="row  "> 
                                <div class="pricing">

                                    <article class="order_box" style="padding: 10px">
                                        <div class="col-md-12">
                                            <h6>
                                                Order No. #<?php echo $value->order_no; ?>
                                                <span style="float: right;margin: 0px">
                                                    <i class="fa fa-calendar"></i><?php echo $value->order_date; ?>  <?php echo $value->order_time; ?>
                                                </span>
                                            </h6>
                                        </div>
                                        <div class="col-md-4">
                                            Total Amount: {{<?php echo $value->total_price; ?>|currency:"<?php echo GLOBAL_CURRENCY; ?> "}}
                                            <br/>
                                            Total Products: {{<?php echo $value->total_quantity; ?>}}
                                        </div>
                                        <div class="col-md-4">
                                            Status: <?php echo $value->status; ?>

                                        </div>
                                        <div class="col-md-4">
                                            <a href="<?php echo site_url('order/orderdetails/' . $value->order_key); ?>" class="btn btn-inverse btn-small" style="margin: 0px;    float: right;">View Order</a>
                                        </div>
                                    </article>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

         

                <!--user log-->
                <div class="tab-pane fade" id="userLog">
                    <h3 class="m-t-10"><i class="fa fa-list-ol"></i> User Log </h3>
                    <div class="row">
                        <table id="tableDataOrder" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">S.N.</th>
                                    <th style="width:50px;">Activity Type</th>
                                    <th style="width: 75px;">Details</th>
                                    <th style="width: 100px;">Date Time </th>

                <!--                <th style="width: 75px;">Edit</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($systemlog)) {

                                    $count = 1;
                                    foreach ($systemlog as $key => $value) {
                                        ?>
                                        <tr>
                                            <td style="width: 20px;"><?php echo $count; ?></td>



                                            <td>
                                                <?php echo $value->log_type; ?>
                                            </td>

                                            <td>
                                                <?php echo $value->log_detail; ?>
                                            </td>
                                            <td>
                                                <?php echo $value->log_datetime; ?>
                                            </td>



                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end of user log-->                


            </div>

        </div>

    </div>



</div>


<!-- Modal -->
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Your Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Current Password</label>
                        <input type="" class="form-control"  required="" placeholder="Enter Your Current Password" value="<?php echo $userdata->password2; ?>" disabled="">
                        <input type="hidden" name="c_password" class="form-control"  required="" placeholder="Enter Your Current Password" value="<?php echo $userdata->password2; ?>" disabled="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Password</label>
                        <input type="password" class="form-control" name="n_password"  required=""  placeholder="Enter Your Current Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" class="form-control"name="r_password" required=""  placeholder="Enter Your Current Password">
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" name="changePassword" class="btn btn-primary">Save changes</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="clear:both"></div>
<?php
$this->load->view('layout/footer');
?>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


<script>
$(function () {
<?php
$checklogin = $this->session->flashdata('checklogin');
if ($checklogin['show']) {
    ?>
        $.gritter.add({
            title: '<?php echo $checklogin['title']; ?>',
            text: '<?php echo $checklogin['text']; ?>',
            image: '<?php echo base_url(); ?>assets/emoji/<?php echo $checklogin['icon']; ?>',
                        sticky: true,
                        time: '',
                        class_name: 'my-sticky-class'
                    });
    <?php
}
?>
            })
</script>

<script>
    $(function () {
        $('.edit_detail').hide();
        $("#edit_toggle").click(function () {
            $('.edit_detail').hide();
            if (this.checked) {
                $('.edit_detail').show();
            }
        })

        $('.edit_detail').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            $($(this).prev()).editable('toggle');
        });

        $('#gender').editable({
            source: {
                'Male': 'Male',
                'Female': 'Female'
            }
        });


        $('#profession').editable({
            source: {
                'Academic': 'Academic',
                'Medicine': 'Medicine',
                'Law': 'Law',
                'Banking': 'Banking',
                'IT': 'IT',
                'Entrepreneur': 'Entrepreneur',
                'Sales/Marketing': 'Sales/Marketing',
                'Other': 'Other',
            }
        });


        $('#country').editable({
            source: {
<?php
foreach ($country as $key => $value) {
    $cont = $value['country_name'];
    echo "'$cont':'$cont',";
}
?>

            }
        });




    })
</script>

<script>
    $(function () {

        $('#tableDataOrder').DataTable({
            language: {
                "search": "Apply filter _INPUT_ to table"
            }
        })
    })

</script>