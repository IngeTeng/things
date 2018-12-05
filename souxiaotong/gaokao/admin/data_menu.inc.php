<div id="leftmenu">
    <div class="menu1"><a href="index_list.php">数据管理
    </a></div>
    <?php
        //商品表，分类表和购物车表
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7004', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'index_list') echo ' class="active"';
            echo ' href="index.php">数据管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7005', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'pay_list') echo ' class="active"';
            echo ' href="pay_list.php">支付管理</a></div><div class="menuline"></div>';
        }

    
  ?>
</div>