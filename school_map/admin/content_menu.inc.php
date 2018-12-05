<div id="leftmenu">
    <div class="menu1"><a href="news_list.php">内容管理</a></div>
    <?php
        //商品表，分类表和购物车表
        $sessionAuth = explode('|', $ADMINAUTH);
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'news_list') echo ' class="active"';
            echo ' href="news_list.php">新闻管理</a></div><div class="menuline"></div>';
        }
        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'notice_list') echo ' class="active"';
            echo ' href="notice_list.php">公告管理</a></div><div class="menuline"></div>';
        }

        if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'suggest_list') echo ' class="active"';
            echo ' href="suggest_list.php">留言建议</a></div><div class="menuline"></div>';
        }

        /*if(in_array('7001', $sessionAuth)){
            echo '<div class="menu2"><a';
            if($FLAG_LEFTMENU == 'banner_edit') echo ' class="active"';
            echo ' href="banner_edit.php">首页顶部图片</a></div><div class="menuline"></div>';
        }*/
    
  ?>
</div>