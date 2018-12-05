<div id="topmenu">
	<ul>
		<!-- <li><a href="index.php" <?php if($FLAG_TOPNAV=='index') echo ' class="active"';?> title="系统首页">系统首页</a></li> -->
		<li><a href="index.php" <?php if($FLAG_TOPNAV == 'role') echo ' class="active"';?> title="角色管理">角色管理</a></li>
		<li><a href="product_list.php" <?php if($FLAG_TOPNAV == 'shop') echo ' class="active"';?> title="商品管理">商品管理</a></li>
		<li><a href="address_list.php" <?php if($FLAG_TOPNAV == 'order') echo ' class="active"';?> title="地址订单管理">地址订单管理</a></li>

	</ul>
</div>