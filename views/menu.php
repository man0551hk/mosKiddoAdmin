<aside id="sidebar-left" class="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title"></div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<?php
					UI::CreateMenu("", "Dashboard", "", [], 'fa-home');
					$products = [
						array("product/", "Product", "", [], 'fa-space-shuttle'),
						array("category/", "Category", "", [], ' fa-behance-square'),
					];
					UI::CreateMenu("product/", "Product", "", $products, 'fa-space-shuttle');
					UI::CreateMenu("orders/", "Orders", "", [], 'fa-shopping-cart');
					?>
				</ul>
			</nav>
		</div>
	</div>
</aside>