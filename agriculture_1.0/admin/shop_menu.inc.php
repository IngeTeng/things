<div id="leftmenu">
    <div class="menu1"><a href="product_list.php">商品管理</a></div>
    <?php
        //商品表，分类表和购物车表
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'product_list') echo ' class="active"';
            echo ' href="product_list.php">商品管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'category_list') echo ' class="active"';
            echo ' href="category_list.php">商品分类管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'cart_list') echo ' class="active"';
            echo ' href="cart_list.php">购物车管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'comment_list') echo ' class="active"';
            echo ' href="comment_list.php">商品评价管理</a></div><div class="menuline"></div>';
        }

    
  ?>
</div>