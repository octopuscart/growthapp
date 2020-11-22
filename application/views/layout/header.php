<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title><?php echo SITE_NAME ?> | Admin Panel</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <?php
        $styleSheetArray = array(
            "Jquery" => "assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css",
            "Bootstrap3" => "assets/plugins/bootstrap/css/bootstrap.min.css",
            "FontAwesome" => "assets/plugins/font-awesome/css/font-awesome.min.css",
            "Animate" => "assets/css/animate.min.css",
            "Style" => "assets/css/style.min.css",
            "StyleResponsive" => "assets/css/style-responsive.min.css",
            "Default" => "assets/css/theme/default.css",
            "CustomeStyle" => "assets/css/customstyle.css",
            "IonicIcon" => "assets/plugins/ionicons/css/ionicons.min.css",
            "Gitter" => "assets/plugins/gritter/css/jquery.gritter.css",
            "DataTable" => "assets/plugins/DataTables/css/data-table.css",
            "Sweet Alert" => "assets/sweetalert2/sweetalert2.min.css",
        );
        foreach ($styleSheetArray as $title => $stylesheet) {
            ?>
                                                                <!-- ================== <?php echo $title ?> ================== -->
            <link href="<?php echo base_url(); ?><?php echo $stylesheet; ?>" rel="stylesheet" />
            <?php
        }
        ?>



        <!-- end page container -->	
        <!-- ================== BEGIN BASE JS ================== -->
 
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
        <!--[if lt IE 9]>
                <script src="assets/crossbrowserjs/html5shiv.js"></script>
                <script src="assets/crossbrowserjs/respond.min.js"></script>
                <script src="assets/crossbrowserjs/excanvas.min.js"></script>
        <![endif]-->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->

        <script src="<?php echo base_url(); ?>assets/sweetalert2/sweetalert2.min.js"></script>
        <!--angular js-->
        <script src="<?php echo base_url(); ?>assets/angular/angular.min.js"></script>

        <!--custom style-->
        <style>
<?php echo HEADERCSS; ?>
        </style>
        <!--custom style-->


    </head>
    <body class="" ng-app="Admin">

        <script>
            var Admin = angular.module('Admin', []).config(function ($interpolateProvider, $httpProvider) {
            //$interpolateProvider.startSymbol('{$');
            //$interpolateProvider.endSymbol('$}');
            $httpProvider.defaults.headers.common = {};
            $httpProvider.defaults.headers.post = {};
            });
            var rootBaseUrl = '<?php echo site_url("/"); ?>';
            var rootAssetUrl = '<?php echo base_url(); ?>';
            var contextgbl = new AudioContext();
            var globlelogo = "<?php echo base_url(); ?>assets/img/notification.jpg";
             var globleicon = "<?php echo base_url(); ?>assets/img/mobileicon1.png";
        </script>


        <audio id="alertSound">
            <source src="<?php echo base_url(); ?>assets/sound/sendemail.mp3" type="audio/mpeg">
        </audio>



        <!-- begin #page-loader -->
        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
        <!-- end #page-loader -->
        <!-- begin #page-container -->
        <div id="page-container" class="page-sidebar-fixed page-header-fixed" ng-controller="rootController">
            <div class="modal fade" id="modal-notification">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Unseen Orders</h4>
                        </div>
                        <div class="modal-body">
                            <div class="list-group">
                                <a href="<?php echo site_url("order/orderdetails/"); ?>{{order.id}}" class="list-group-item" ng-repeat="order in orderGlobleCheck.unseendata">
                                    <h4 class="list-group-item-heading"><i class="fa fa-user"></i>{{order.first_name}} {{order.last_name}}</h4>
                                    <p class="list-group-item-text"><i class="fa fa-clock-o"></i> {{order.select_date}} {{order.select_time}}</p>
                                    <p class="list-group-item-text"><b>Source:<b/><span>{{order.order_source}}</span>, <b>Guest(s):<b/><span>{{order.people}}</span></p>
                                                </a> 


                                                <a href="<?php echo site_url("Order/orderInbox"); ?>" class="list-group-item" ng-if="orderGlobleCheck.unseenemail.length">
                                                    <h4 class="list-group-item-heading"><i class="fa fa-envelope"></i> Unseen Mails: <span class="badge">{{orderGlobleCheck.unseenemail.length}}</span></h4>
                                                </a> 

                                                </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                </div>
                                                </div>
                                                </div>
                                                </div>