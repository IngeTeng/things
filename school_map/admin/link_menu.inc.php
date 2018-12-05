<div id="leftmenu">
    <div class="menu1"><a href="node_list.php">路径管理</a></div>
    <?php
        //商品表，分类表和购物车表
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'node_list') echo ' class="active"';
            echo ' href="node_list.php">节点管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'link_list') echo ' class="active"';
            echo ' href="link_list.php">路径管理</a></div><div class="menuline"></div>';
        }
    
  ?>
</div>