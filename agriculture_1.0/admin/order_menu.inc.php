<div id="leftmenu">
    <div class="menu1"><a href="address_list.php">地址订单管理</a></div>
    <?php
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'address_list') echo ' class="active"';
            echo ' href="address_list.php">地址管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'order_list') echo ' class="active"';
            echo ' href="order_list.php">订单管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'order_detail_list') echo ' class="active"';
            echo ' href="order_detail_list.php">订单详情</a></div><div class="menuline"></div>';
        }

        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'submit_list') echo ' class="active"';
            echo ' href="submit_list.php">工单管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'record_list') echo ' class="active"';
            echo ' href="record_list.php">统计管理</a></div><div class="menuline"></div>';
        }


    
  ?>
</div>