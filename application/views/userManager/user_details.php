<?php
$this->load->view('layout/layoutTop');
?>
<style>
    .product_image{
        height: 200px!important;
    }
    .product_image_back{
        background-size: contain!important;
        background-repeat: no-repeat!important;
        height: 200px!important;
        background-position-x: center!important;
        background-position-y: center!important;
    }
</style>
<style>
    .cartbutton{
        width: 100%;
        padding: 6px;
        color: #fff!important;
    }
    .noti-check1{
        background: #f5f5f5;
        padding: 25px 30px;

        font-weight: 600;
        margin-bottom: 30px;
    }

    .noti-check1 span{
        color: red;
        color: red;
        width: 111px;
        float: left;
        text-align: right;
        padding-right: 13px;
    }

    .noti-check1 h6{
        font-size: 15px;
        font-weight: 600;
    }

    .address_block{
        background: #fff;
        border: 3px solid #d30603;
        padding: 5px 10px;
        margin-bottom: 20px;

    }
    .checkcart {
        border-radius: 50%;
        position: absolute;
        top: -12px;
        left: 2px;
        font-size: 6px;
        padding: 4px;
        background: #fff;
        border: 2px solid green;
    }


    .default{
        border: 2px solid green;
    }

    .default{
        border: 2px solid green;
    }

    .checkcart i{
        color: green;
    }



    .cartdetail_small {
        float: left;
        width: 203px;
    }
    
    .subtext{
        margin-left: 10px;
        margin-left: 17px;
    color: black;
    font-weight: 400;
    }

</style>

<style>
    .order_box{
        padding: 10px;
        padding-bottom: 11px!important;
        height: 110px;
        border-bottom: 1px solid #c5c5c5;
    }
    .order_box li{
        line-height: 19px!important;
        padding: 7px!important;
        border: none!important;
    }

    .order_box li i{
        float: left!important;
        line-height: 19px!important;
        margin-right: 13px!important;
    }

    .blog-posts article {
        margin-bottom: 10px;
    }
</style>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php
                    if ($user_details->image) {
                        echo base_url() . 'assets_main/userimages/' . $user_details->image;
                    } else {
                        echo ( base_url() . "assets_main/dist/img/avatar5.png");
                    }
                    ?>" alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $user_details->first_name; ?> <?php echo $user_details->last_name; ?></h3>

                    <p class="text-muted text-center"><?php echo $user_details->user_type; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><i class="fa fa-phone"></i>  Contact no.</b> <br/><a class="subtext"><?php echo $user_details->contact_no; ?></a>
                        </li>
                        <li class="list-group-item">

                           <b> <i class="fa fa-<?php echo strtolower($user_details->gender); ?>"></i>   Gender</b> <br/><a class="subtext"><?php echo $user_details->gender; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-birthday-cake"></i>  Date Of Birth</b> <br/><a class="subtext"><?php echo $user_details->birth_date; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-suitcase"></i>  Profession</b> <br/><a class="subtext"><?php echo $user_details->profession; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-globe"></i>  Country</b><br/> <a class="subtext"><?php echo $user_details->country; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-calendar"></i> Registration Date</b> <br/><a  style="font-size: 12px"><?php echo $user_details->registration_datetime; ?></a>
                        </li>
                    </ul>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#activity" data-toggle="tab">Orders</a>
                    </li>
                    <li>
                        <a href="#settings" data-toggle="tab">Update Profile</a>
                    </li>
                    <li>
                        <a href="#timeline" data-toggle="tab">Address</a>
                    </li>
                    <!--                    <li>
                                            <a href="#creditstatement" data-toggle="tab">Credit Statement</a>
                                        </li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (count($orderslist)) {
                                    foreach ($orderslist as $key => $value) {
                                        ?>
                                        <div class="col-md-12  "> 
                                            <div class="pricing">
                                                <article class="order_box" style="padding: 10px">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h6 style="font-weight: bold;">
                                                                Order No. #<?php echo $value->order_no; ?>
                                                            </h6>
                                                            Total Amount: {{<?php echo $value->total_price; ?>|currency:" "}}
                                                            <br/>
                                                            Total Products: {{<?php echo $value->total_quantity; ?>}}
                                                        </div>

                                                        <div class="col-md-4">
                                                            <span >
                                                                <i class="fa fa-calendar"></i> <?php echo $value->order_date; ?>  <?php echo $value->order_time; ?>
                                                            </span><br/>
                                                            Status: <?php echo $value->status; ?>

                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="<?php echo site_url('order/orderdetails/' . $value->order_key); ?>" class="btn btn-default btn-small" style="margin: 0px;    float: right;">View Order <i  class="fa fa-arrow-right"></i> </a>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 10px;">
                                                        <div class="col-md-6 orderlist_stylemes">
                                                            <b>Items:</b>  <span style="font-weight: 500"><?php echo $value->items; ?></span>
                                                        </div>
                                                        <div class="col-md-6 orderlist_stylemes">
                                                            <b>Sizes:</b>  <span style="font-weight: 500"><?php echo $value->measurement_style; ?></span>
                                                        </div>
                                                    </div>

                                                </article>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h4><i class="fa fa-warning"></i> No order found</h4>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="timeline">
                        <div class="row">
                            <div class="col-md-12" style="margin-top:25px;">
                                <?php
                                if (count($user_address_details)) {
                                    ?>
                                    <?php
                                    foreach ($user_address_details as $key => $value) {
                                        ?>
                                        <div class="col-md-12">
                                            <?php if ($value['status'] == 'default') { ?> 
                                                <div class="checkcart <?php echo $value['status']; ?> ">
                                                    <i class="fa fa-check fa-2x"></i>
                                                </div>
                                            <?php } ?> 
                                            <div class=" address_block <?php echo $value['status']; ?> ">
                                                <p>
                                                    <?php echo $value['address1']; ?>,<br/>
                                                    <?php echo $value['address2']; ?>,<br/>
                                                    <?php echo $value['city']; ?>, <?php echo $value['state']; ?>, <?php echo $value['country']; ?>, <?php echo $value['zipcode']; ?>
                                                </p>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h4><i class="fa fa-warning"></i> No Shipping Address Found</h4>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>  
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <div class="row">

                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="col-md-12">


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >First Name</label>
                                            <input type="text" class="form-control" name="first_name"  placeholder="First Name" value="<?php echo $user_details->first_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Last Name</label>
                                            <input type="text" class="form-control"  name="last_name"  placeholder="Last Name" value="<?php echo $user_details->last_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <span class="form-control"  ><?php echo $user_details->email; ?></span> 
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control"  name="contact_no" placeholder="Contact No." value="<?php echo $user_details->contact_no; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                <option <?php echo $user_details->gender == 'Male' ? "selected" : ''; ?>>Male</option>
                                                <option <?php echo $user_details->gender == 'Female' ? "selected" : ''; ?>>Female</option>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                            <input type="text" class="form-control" id="datemask"  name="birth_date" placeholder="Birth Date" value="<?php echo $user_details->birth_date; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control" name="country">
                                                <option value="" >Select Country</option>
                                                <option value="Aruba" >Aruba</option>
                                                <option value="Afghanistan" >Afghanistan</option>
                                                <option value="Angola" >Angola</option>
                                                <option value="Anguilla" >Anguilla</option>
                                                <option value="Albania" >Albania</option>
                                                <option value="Andorra" >Andorra</option>
                                                <option value="Netherlands Antilles" >Netherlands Antilles</option>
                                                <option value="United Arab Emirates" >United Arab Emirates</option>
                                                <option value="Argentina" >Argentina</option>
                                                <option value="Armenia" >Armenia</option>
                                                <option value="American Samoa" >American Samoa</option>
                                                <option value="Antarctica" >Antarctica</option>
                                                <option value="French Southern territories" >French Southern territories</option>
                                                <option value="Antigua and Barbuda" >Antigua and Barbuda</option>
                                                <option value="Australia" >Australia</option>
                                                <option value="Austria" >Austria</option>
                                                <option value="Azerbaijan" >Azerbaijan</option>
                                                <option value="Burundi" >Burundi</option>
                                                <option value="Belgium" >Belgium</option>
                                                <option value="Benin" >Benin</option>
                                                <option value="Burkina Faso" >Burkina Faso</option>
                                                <option value="Bangladesh" >Bangladesh</option>
                                                <option value="Bulgaria" >Bulgaria</option>
                                                <option value="Bahrain" >Bahrain</option>
                                                <option value="Bahamas" >Bahamas</option>
                                                <option value="Bosnia and Herzegovina" >Bosnia and Herzegovina</option>
                                                <option value="Belarus" >Belarus</option>
                                                <option value="Belize" >Belize</option>
                                                <option value="Bermuda" >Bermuda</option>
                                                <option value="Bolivia" >Bolivia</option>
                                                <option value="Brazil" >Brazil</option>
                                                <option value="Barbados" >Barbados</option>
                                                <option value="Brunei" >Brunei</option>
                                                <option value="Bhutan" >Bhutan</option>
                                                <option value="Bouvet Island" >Bouvet Island</option>
                                                <option value="Botswana" >Botswana</option>
                                                <option value="Central African Republic" >Central African Republic</option>
                                                <option value="Canada" >Canada</option>
                                                <option value="Cocos (Keeling) Islands" >Cocos (Keeling) Islands</option>
                                                <option value="Switzerland" >Switzerland</option>
                                                <option value="Chile" >Chile</option>
                                                <option value="China" >China</option>
                                                <option value="Côte d’Ivoire" >Côte d’Ivoire</option>
                                                <option value="Cameroon" >Cameroon</option>
                                                <option value="Congo, The Democratic Republic" >Congo, The Democratic Republic</option>
                                                <option value="Congo" >Congo</option>
                                                <option value="Cook Islands" >Cook Islands</option>
                                                <option value="Colombia" >Colombia</option>
                                                <option value="Comoros" >Comoros</option>
                                                <option value="Cape Verde" >Cape Verde</option>
                                                <option value="Costa Rica" >Costa Rica</option>
                                                <option value="Cuba" >Cuba</option>
                                                <option value="Christmas Island" >Christmas Island</option>
                                                <option value="Cayman Islands" >Cayman Islands</option>
                                                <option value="Cyprus" >Cyprus</option>
                                                <option value="Czech Republic" >Czech Republic</option>
                                                <option value="Germany" >Germany</option>
                                                <option value="Djibouti" >Djibouti</option>
                                                <option value="Dominica" >Dominica</option>
                                                <option value="Denmark" >Denmark</option>
                                                <option value="Dominican Republic" >Dominican Republic</option>
                                                <option value="Algeria" >Algeria</option>
                                                <option value="Ecuador" >Ecuador</option>
                                                <option value="Egypt" >Egypt</option>
                                                <option value="Eritrea" >Eritrea</option>
                                                <option value="Western Sahara" >Western Sahara</option>
                                                <option value="Spain" >Spain</option>
                                                <option value="Estonia" >Estonia</option>
                                                <option value="Ethiopia" >Ethiopia</option>
                                                <option value="Finland" >Finland</option>
                                                <option value="Fiji Islands" >Fiji Islands</option>
                                                <option value="Falkland Islands" >Falkland Islands</option>
                                                <option value="France" >France</option>
                                                <option value="Faroe Islands" >Faroe Islands</option>
                                                <option value="Micronesia, Federated States o" >Micronesia, Federated States o</option>
                                                <option value="Gabon" >Gabon</option>
                                                <option value="United Kingdom" >United Kingdom</option>
                                                <option value="Georgia" >Georgia</option>
                                                <option value="Ghana" >Ghana</option>
                                                <option value="Gibraltar" >Gibraltar</option>
                                                <option value="Guinea" >Guinea</option>
                                                <option value="Guadeloupe" >Guadeloupe</option>
                                                <option value="Gambia" >Gambia</option>
                                                <option value="Guinea-Bissau" >Guinea-Bissau</option>
                                                <option value="Equatorial Guinea" >Equatorial Guinea</option>
                                                <option value="Greece" >Greece</option>
                                                <option value="Grenada" >Grenada</option>
                                                <option value="Greenland" >Greenland</option>
                                                <option value="Guatemala" >Guatemala</option>
                                                <option value="French Guiana" >French Guiana</option>
                                                <option value="Guam" >Guam</option>
                                                <option value="Guyana" >Guyana</option>
                                                <option value="Hong Kong" >Hong Kong</option>
                                                <option value="Heard Island and McDonald Isla" >Heard Island and McDonald Isla</option>
                                                <option value="Honduras" >Honduras</option>
                                                <option value="Croatia" >Croatia</option>
                                                <option value="Haiti" >Haiti</option>
                                                <option value="Hungary" >Hungary</option>
                                                <option value="Indonesia" >Indonesia</option>
                                                <option value="India" >India</option>
                                                <option value="British Indian Ocean Territory" >British Indian Ocean Territory</option>
                                                <option value="Ireland" >Ireland</option>
                                                <option value="Iran" >Iran</option>
                                                <option value="Iraq" >Iraq</option>
                                                <option value="Iceland" >Iceland</option>
                                                <option value="Israel" >Israel</option>
                                                <option value="Italy" >Italy</option>
                                                <option value="Jamaica" >Jamaica</option>
                                                <option value="Jordan" >Jordan</option>
                                                <option value="Japan" >Japan</option>
                                                <option value="Kazakstan" >Kazakstan</option>
                                                <option value="Kenya" >Kenya</option>
                                                <option value="Kyrgyzstan" >Kyrgyzstan</option>
                                                <option value="Cambodia" >Cambodia</option>
                                                <option value="Kiribati" >Kiribati</option>
                                                <option value="Saint Kitts and Nevis" >Saint Kitts and Nevis</option>
                                                <option value="South Korea" >South Korea</option>
                                                <option value="Kuwait" >Kuwait</option>
                                                <option value="Laos" >Laos</option>
                                                <option value="Lebanon" >Lebanon</option>
                                                <option value="Liberia" >Liberia</option>
                                                <option value="Libyan Arab Jamahiriya" >Libyan Arab Jamahiriya</option>
                                                <option value="Saint Lucia" >Saint Lucia</option>
                                                <option value="Liechtenstein" >Liechtenstein</option>
                                                <option value="Sri Lanka" >Sri Lanka</option>
                                                <option value="Lesotho" >Lesotho</option>
                                                <option value="Lithuania" >Lithuania</option>
                                                <option value="Luxembourg" >Luxembourg</option>
                                                <option value="Latvia" >Latvia</option>
                                                <option value="Macao" >Macao</option>
                                                <option value="Morocco" >Morocco</option>
                                                <option value="Monaco" >Monaco</option>
                                                <option value="Moldova" >Moldova</option>
                                                <option value="Madagascar" >Madagascar</option>
                                                <option value="Maldives" >Maldives</option>
                                                <option value="Mexico" >Mexico</option>
                                                <option value="Marshall Islands" >Marshall Islands</option>
                                                <option value="Macedonia" >Macedonia</option>
                                                <option value="Mali" >Mali</option>
                                                <option value="Malta" >Malta</option>
                                                <option value="Myanmar" >Myanmar</option>
                                                <option value="Mongolia" >Mongolia</option>
                                                <option value="Northern Mariana Islands" >Northern Mariana Islands</option>
                                                <option value="Mozambique" >Mozambique</option>
                                                <option value="Mauritania" >Mauritania</option>
                                                <option value="Montserrat" >Montserrat</option>
                                                <option value="Martinique" >Martinique</option>
                                                <option value="Mauritius" >Mauritius</option>
                                                <option value="Malawi" >Malawi</option>
                                                <option value="Malaysia" >Malaysia</option>
                                                <option value="Mayotte" >Mayotte</option>
                                                <option value="Namibia" >Namibia</option>
                                                <option value="New Caledonia" >New Caledonia</option>
                                                <option value="Niger" >Niger</option>
                                                <option value="Norfolk Island" >Norfolk Island</option>
                                                <option value="Nigeria" >Nigeria</option>
                                                <option value="Nicaragua" >Nicaragua</option>
                                                <option value="Niue" >Niue</option>
                                                <option value="Netherlands" >Netherlands</option>
                                                <option value="Norway" >Norway</option>
                                                <option value="Nepal" >Nepal</option>
                                                <option value="Nauru" >Nauru</option>
                                                <option value="New Zealand" >New Zealand</option>
                                                <option value="Oman" >Oman</option>
                                                <option value="Pakistan" >Pakistan</option>
                                                <option value="Panama" >Panama</option>
                                                <option value="Pitcairn" >Pitcairn</option>
                                                <option value="Peru" >Peru</option>
                                                <option value="Philippines" >Philippines</option>
                                                <option value="Palau" >Palau</option>
                                                <option value="Papua New Guinea" >Papua New Guinea</option>
                                                <option value="Poland" >Poland</option>
                                                <option value="Puerto Rico" >Puerto Rico</option>
                                                <option value="North Korea" >North Korea</option>
                                                <option value="Portugal" >Portugal</option>
                                                <option value="Paraguay" >Paraguay</option>
                                                <option value="Palestine" >Palestine</option>
                                                <option value="French Polynesia" >French Polynesia</option>
                                                <option value="Qatar" >Qatar</option>
                                                <option value="Réunion" >Réunion</option>
                                                <option value="Romania" >Romania</option>
                                                <option value="Russian Federation" >Russian Federation</option>
                                                <option value="Rwanda" >Rwanda</option>
                                                <option value="Saudi Arabia" >Saudi Arabia</option>
                                                <option value="Sudan" >Sudan</option>
                                                <option value="Senegal" >Senegal</option>
                                                <option value="Singapore" >Singapore</option>
                                                <option value="South Georgia and the South Sa" >South Georgia and the South Sa</option>
                                                <option value="Saint Helena" >Saint Helena</option>
                                                <option value="Svalbard and Jan Mayen" >Svalbard and Jan Mayen</option>
                                                <option value="Solomon Islands" >Solomon Islands</option>
                                                <option value="Sierra Leone" >Sierra Leone</option>
                                                <option value="El Salvador" >El Salvador</option>
                                                <option value="San Marino" >San Marino</option>
                                                <option value="Somalia" >Somalia</option>
                                                <option value="Saint Pierre and Miquelon" >Saint Pierre and Miquelon</option>
                                                <option value="Sao Tome and Principe" >Sao Tome and Principe</option>
                                                <option value="Suriname" >Suriname</option>
                                                <option value="Slovakia" >Slovakia</option>
                                                <option value="Slovenia" >Slovenia</option>
                                                <option value="Sweden" >Sweden</option>
                                                <option value="Swaziland" >Swaziland</option>
                                                <option value="Seychelles" >Seychelles</option>
                                                <option value="Syria" >Syria</option>
                                                <option value="Turks and Caicos Islands" >Turks and Caicos Islands</option>
                                                <option value="Chad" >Chad</option>
                                                <option value="Togo" >Togo</option>
                                                <option value="Thailand" >Thailand</option>
                                                <option value="Tajikistan" >Tajikistan</option>
                                                <option value="Tokelau" >Tokelau</option>
                                                <option value="Turkmenistan" >Turkmenistan</option>
                                                <option value="East Timor" >East Timor</option>
                                                <option value="Tonga" >Tonga</option>
                                                <option value="Trinidad and Tobago" >Trinidad and Tobago</option>
                                                <option value="Tunisia" >Tunisia</option>
                                                <option value="Turkey" >Turkey</option>
                                                <option value="Tuvalu" >Tuvalu</option>
                                                <option value="Taiwan" >Taiwan</option>
                                                <option value="Tanzania" >Tanzania</option>
                                                <option value="Uganda" >Uganda</option>
                                                <option value="Ukraine" >Ukraine</option>
                                                <option value="United States Minor Outlying I" >United States Minor Outlying I</option>
                                                <option value="Uruguay" >Uruguay</option>
                                                <option value="United States" >United States</option>
                                                <option value="Uzbekistan" >Uzbekistan</option>
                                                <option value="Holy See (Vatican City State)" >Holy See (Vatican City State)</option>
                                                <option value="Saint Vincent and the Grenadin" >Saint Vincent and the Grenadin</option>
                                                <option value="Venezuela" >Venezuela</option>
                                                <option value="Virgin Islands, British" >Virgin Islands, British</option>
                                                <option value="Virgin Islands, U.S." >Virgin Islands, U.S.</option>
                                                <option value="Vietnam" >Vietnam</option>
                                                <option value="Vanuatu" >Vanuatu</option>
                                                <option value="Wallis and Futuna" >Wallis and Futuna</option>
                                                <option value="Samoa" >Samoa</option>
                                                <option value="Yemen" >Yemen</option>
                                                <option value="Yugoslavia" >Yugoslavia</option>
                                                <option value="South Africa" >South Africa</option>
                                                <option value="Zambia" >Zambia</option>
                                                <option value="Zimbabwe" >Zimbabwe</option>
                                            </select>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profession</label>
                                            <select class="form-control" name="profession">
                                                <option value="" >Select Profession</option>
                                                <option value="Academic" >Academic</option>
                                                <option value="Medicine" >Medicine</option>
                                                <option value="Law" >Law</option>
                                                <option value="Banking" >Banking</option>
                                                <option value="IT" >IT</option>
                                                <option value="Entrepreneur" >Entrepreneur</option>
                                                <option value="Sales/Marketing" >Sales/Marketing</option>
                                                <option value="Other" >Other</option> 
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
                                        <button type="submit" name="delete_user" class="btn btn-danger subtext" value="<?php echo $user_details->id; ?>" >Delete User</button>
                                        <button type="submit" name="<?php echo $user_details->status == 'Blocked' ? 'unblock_user' : 'block_user'; ?>" class="btn btn-<?php echo $user_details->status == 'Blocked' ? 'success' : 'warning'; ?> subtext" value="<?php echo $user_details->id; ?>" style="margin-right: 10px"><?php echo $user_details->status == 'Blocked' ? 'Unblock User' : 'Block User'; ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                    <!-- /.tab-pane -->
                    <!--
                                        <div class="tab-pane" id="creditstatement">
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top:25px;">
                                                    <div class="" >
                                                        <h4>Available Credits : <small>Rs.</small> {{<?php echo $user_credits; ?> |currency:" "}}</h4>
                    
                                                        <h5 style="    margin-top: 51px;
                                                            font-size: 18px;
                                                            font-weight: 400">Credits Statement</h5>
                    
                    
                                                        <table class="table">
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Credit</th>
                                                                <th>Debit</th>
                                                                <th>Remark</th>
                                                            </tr>
                    <?php
                    foreach ($creditlist as $key => $value) {
                        ?>
                                                                                                            <tr>
                                                                                                                <td><?php echo $key + 1; ?></td>
                                                                                                                <td><?php echo $value->c_date; ?></td>
                                                                                                                <td><?php echo $value->c_time; ?></td>
                                                                                                                <td>{{<?php echo $value->credit ? $value->credit : 0; ?> |currency:" "}}</td>
                                                                                                                <td>{{<?php echo $value->debit ? $value->debit : 0; ?> |currency:" "}}</td>
                                                                                                                <td><?php echo $value->remark; ?></td>
                                                                
                                                                                                            </tr>
                        <?php
                    }
                    ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>-->
                    <!-- /.tab-pane -->


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->





<?php
$this->load->view('layout/layoutFooter');
?> 
<script>
    $(function () {
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('[name="country"]').val("<?php echo $user_details->country; ?>");
        $('[name="profession"]').val("<?php echo $user_details->profession; ?>");
    })
</script>
