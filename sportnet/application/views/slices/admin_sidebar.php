<div class="span3" id="sidebar">
    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
        <li class="">
            <a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard custom_icons"></i>&nbsp;Dashboard</a>
        </li>
        <li class="dropdown-submenu dropdown-menu-right">
            <a href="javascript:void(0)"><i class="fa fa-tag custom_icons"></i>&nbsp;Category</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('category/viewall'); ?>">View All</a></li>
                <li><a href="<?php echo site_url('category/add'); ?>">Add New</a></li>
            </ul>
        </li>

        <li class="dropdown-submenu dropdown-menu-right">
            <a href="javascript:void(0)"><i class="fa fa-bolt custom_icons"></i>&nbsp;Feeds</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('feeds'); ?>">View All Feeds</a></li>
                <li><a href="<?php echo site_url('feeds/add'); ?>">Add Feed</a></li>
                <li><a href="<?php echo site_url('feeds/addFavicon'); ?>">Update Feed</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu dropdown-menu-right">
            <a href="javascript:void(0)"><i class="fa fa-warning custom_icons"></i>&nbsp;Pages</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('admin/getPages'); ?>">View All Pages</a></li>
                <li><a href="<?php echo site_url('admin/addPage'); ?>">Add New Page</a></li>
            </ul>
        </li>

        <li class="<?php echo 'ads'; ?>"> 
            <a href="<?php echo site_url('settings'); ?>" ><i class="fa fa-users custom_icons"></i>&nbsp;Adds Management</a>
        </li> 

        <li class="<?php echo 'footer_settings'; ?>"> 
            <a href="<?php echo site_url('admin/footer_settings'); ?>" ><i class="fa fa-volume-up custom_icons"></i>&nbsp;Footer</a>
        </li>

    </ul>        
</div>