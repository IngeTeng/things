<div id="leftmenu">
    <div class="menu1"><a href="index.php">后台管理</a></div>
    <?php
        
     

            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'category_list') echo ' class="active"';
            echo ' href="category_list.php">商品分类</a></div><div class="menuline"></div>';


        //用户和分销商角色
      
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'product_list') echo ' class="active"';
            echo ' href="index.php">商品管理</a></div><div class="menuline"></div>';
    
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'order_detail_list') echo ' class="active"';
            echo ' href="order_detail_list.php">订单详情</a></div><div class="menuline"></div>';

            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'comment_list') echo ' class="active"';
            echo ' href="comment_list.php">商品评价</a></div><div class="menuline"></div>';
    


    
  ?>
</div>