<div id="leftmenu">
    <div class="menu1"><a href="index.php">角色管理</a></div>
    <?php
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'admingroup_list') echo ' class="active"';
            echo ' href="admingroup.php">管理员组</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'admin_list') echo ' class="active"';
            echo ' href="index.php">管理员</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'adminlog_list') echo ' class="active"';
            echo ' href="adminlog_list.php">管理员日志</a></div><div class="menuline"></div>';
        }

        //用户和分销商角色
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'user_list') echo ' class="active"';
            echo ' href="user_list.php">用户管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'partner_list') echo ' class="active"';
            echo ' href="partner_list.php">加盟商管理</a></div><div class="menuline"></div>';
        }


    
  ?>
</div>