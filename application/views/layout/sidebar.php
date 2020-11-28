<?php
$userdata = $this->session->userdata('logged_in');
if ($userdata) {
    
} else {
    redirect("Authentication/index", "refresh");
}
$menu_control = array();




$seo_menu = array(
    "title" => "Bible Study",
    "icon" => "fa fa-calendar",
    "active" => "",
    "link"=>site_url("BibleStudy/listPage/99"),
    "sub_menu" => array(),
);
array_push($menu_control, $seo_menu);



foreach ($menu_control as $key => $value) {
    $submenu = $value['sub_menu'];
    if ($submenu) {
        foreach ($submenu as $ukey => $uvalue) {
            if ($uvalue == current_url()) {
                $menu_control[$key]['active'] = 'active';
                break;
            }
        }
    } else {
        if ($menu_control[$key]['link'] == current_url()) {
            $menu_control[$key]['active'] = 'active';
        }
    }
}
?>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar whitebackground">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src='<?php echo base_url(); ?>assets/profile_image/<?php echo $userdata['image'] ?>' alt="" class="media-object rounded-corner" style="    width: 35px;background: url(<?php echo base_url(); ?>assets/emoji/user.png);    height: 35px;background-size: cover;" /></a>
                </div>
                <div class="info textoverflow" >

                    <?php echo $userdata['first_name']; ?>
                    <small class="textoverflow" title="<?php echo $userdata['username']; ?>"><?php echo $userdata['username']; ?></small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>

            <?php
            foreach ($menu_control as $mkey => $mvalue) {
                if ($mvalue['sub_menu']) {
                    ?>

                    <li class="has-sub <?php echo $mvalue['active']; ?>">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>  
                            <i class="<?php echo $mvalue['icon']; ?>"></i> 
                            <span><?php echo $mvalue['title']; ?></span>
                        </a>
                        <ul class="sub-menu">
                            <?php
                            $submenu = $mvalue['sub_menu'];
                            foreach ($submenu as $key => $value) {
                                ?>
                                <li><a href="<?php echo $value; ?>"><?php echo $key; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="<?php echo $mvalue['active']; ?>">
              
                        <a href="<?php echo $mvalue['link']; ?>">
                            
                              <b class="fa fa-long-arrow-right pull-right" style="line-height: 22px;"></b>  
                            <i class="<?php echo $mvalue['icon']; ?>"></i> 
                            <span><?php echo $mvalue['title']; ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
            <li class="nav-header"> Admin V <?php echo PANELVERSION; ?></li>
   
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->