<?php
$this->load->view('layout/layoutTop');
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
    .selectButton{

    }
</style>
<!-- Main content -->


<?php

function userReportFunction($users) {
    ?>
    <table id="tableData" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width:50px;">Image</th>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($users)) {

                $count = 1;
                foreach ($users as $key => $value) {
                    ?>
                    <tr>
                        <td>

                            <div class="user-block">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets_main/userimages/<?php echo $value->image; ?>" alt="User Image">
                                <span class="username"><a href="#"><?php echo $value->first_name; ?> <?php echo $value->last_name; ?></a></span>
                                <span class="description"><?php echo $value->email; ?> </span>

                            </div>

                        </td>
                        <td>
                            <button class="btn btn-primary pull-right selectButton">Select</button>
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


<section class="content" ng-controller="creditDebitController">
    <div class="">
        <div class="row">

            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Users Reports</h3>
                    </div>
                    <div class="box-body">

                        <table id="tableData" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:50px;">Users</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="user in usersdata">
                                    <td>
                                        <div class="user-block">
                                            <img class="img-circle" ng-if="user.image" src="<?php echo base_url(); ?>assets_main/userimages/{{user.image}}" alt="User Image">

                                            <img class="img-circle" ng-if="!user.image" src="<?php echo base_url() . "assets_main/" . default_image; ?>" alt="User Image">


                                            <span class="username">
                                                <a href="#">
                                                    {{user.first_name}} {{user.last_name}}
                                                </a>
                                            </span>
                                            <span class="description">
                                                {{user.email}}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary pull-right selectButton" ng-click="selectUser(user)">Select</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Credit Allotment</h3>
                    </div>
                    <div class="box-body">
                        <div ng-if="userobj.email">
                            <div class="box box-widget widget-user-2" >
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-yellow">
                                    <div class="widget-user-image" ng-if="userobj.image">
                                        <img class="img-circle" src="<?php echo base_url(); ?>assets_main/userimages/{{userobj.image}}" alt="User Avatar">
                                    </div>
                                    <div class="widget-user-image" ng-if="!userobj.image">
                                        <img class="img-circle" src="<?php echo base_url() . "assets_main/" . default_image; ?>" alt="User Avatar">
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <h3 class="widget-user-username">{{userobj.first_name}} {{userobj.last_name}}</h3>
                                    <h5 class="widget-user-desc">{{userobj.user_type}}</h5>
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li><a href="#">Available Credits <span class="pull-right badge bg-blue">{{userobj.credits-userobj.debits}}</span></a></li>
                                        <li><a href="#">Alloted Credits <span class="pull-right badge bg-blue">{{userobj.credits}}</span></a></li>
                                        <li><a href="#">Used Credits <span class="pull-right badge bg-aqua">{{userobj.debits}}</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <form action="#" method="post" >
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea class="form-control"  placeholder="Remark" name="remark"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">Enter Credits</label>
                                        <div class="col-sm-7">
                                            <input type="number" min="0" class="form-control price_tag_text" id='credit' name="credit"  aria-describedby="emailHelp" placeholder="" value=""> 
                                            <input type="hidden" class="form-control price_tag_text" name="user_id"  aria-describedby="emailHelp" placeholder="" value="{{userobj.id}}"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary " name="allot_credit">Allot Credit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h3 ng-if="!userobj.email">Please Select User</h3> 

                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
</section>
<!-- end col-6 -->
</div>


<?php
$this->load->view('layout/layoutFooter');
?> 




<script>
    HASALE.controller('creditDebitController', function ($scope, $http, $filter, $timeout) {

        var url = "<?php echo base_url(); ?>index.php/UserManager/users_api";
        $http.get(url).then(function (rdata) {
            $scope.usersdata = rdata.data.list;
            
            $scope.preuser = window.location.hash.replace("#", "");
            console.log($scope.preuser);
            if( $scope.usersdata[$scope.preuser]){
                var selecteduser = $scope.usersdata[$scope.preuser];
                $scope.selectUser(selecteduser);
            }
            
            $(function () {
                $('#tableData').DataTable({
                    'paging': true,
                    'lengthChange': false,
//      'searching'   : false,
//      'ordering'    : true,
                    'info': false,
//      'autoWidth'   : false
                })
            })
        });

        $scope.userobj = {};

        $scope.selectUser = function (userobj) {
            $scope.userobj = angular.copy(userobj);
        }
        
        





    })




</script>