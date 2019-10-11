<div class="navbar navbar-default" id="navbar-second">
	<ul class="nav navbar-nav no-border visible-xs-block">
		<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
	</ul>
<div class="navbar-collapse collapse" id="navbar-second-toggle">
	<ul class="nav navbar-nav">
		<li><a href="../panel"><i class="icon-display4 position-left"></i> Dashboard</a></li>
		<?php
			$menu = $DB_con->prepare("SELECT * FROM menu ORDER BY menu_id ASC");
			$menu->execute();
			while ($dataMenu=$menu->fetch(PDO::FETCH_ASSOC)){
			$menu_id = $dataMenu['menu_id'];
			$submenu = $DB_con->prepare("SELECT * FROM submenu WHERE menu_id=:menu_id ORDER BY submenu_id ASC");
			$submenu->execute(array(":menu_id"=>$menu_id));
			if($submenu->rowCount() == 0)
			{ ?>
			<li><a href="<?php echo $dataMenu['menu_link']?>"><i class="fa <?php echo $dataMenu['menu_icon']?> position-left"></i> <?php echo $dataMenu['menu']?> </a></li>
			<?php }else{?>
			<li class="dropdown mega-menu mega-menu-wide">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa <?php echo $dataMenu['menu_icon']?> position-left"></i> <?php echo $dataMenu['menu']?> <span class="caret"></span></a>
				<div class="dropdown-menu dropdown-content">
					<div class="dropdown-content-body">
					<div class="row">
					<?php $y=$submenu->rowCount();
					if ($y>=4){
					$submenu = $DB_con->prepare("SELECT * FROM submenu WHERE menu_id=:menu_id ORDER BY submenu_id ASC");
					$submenu->execute(array(":menu_id"=>$menu_id));
					?>
					<div class="col-md-3">
						<span class="menu-heading underlined"><?php echo $dataMenu['menu'] ?></span>
						<ul class="menu-list">
						<?php while($dataSubmenu = $submenu->fetch(PDO::FETCH_ASSOC)){
						$submenu_id = $dataSubmenu['submenu_id'];
						$result = $DB_con->prepare("SELECT * FROM childmenu WHERE submenu_id=:submenu_id ORDER BY childmenu_id ASC");
						$result->execute(array(":submenu_id"=>$submenu_id));
						if($result->rowCount() == 0){?>
						<li>
							<a href="<?php echo $dataSubmenu['submenu_link']?>"><i class="fa <?php echo $dataSubmenu['submenu_icon']?>"></i> <?php echo $dataSubmenu['submenu']?> </a>
						</li><?php }else{?>
						<li>
							<a href="#"><i class="fa <?php echo $dataSubmenu['submenu_icon']?>"></i> <?php echo $dataSubmenu['submenu']?></a>
							<ul>
								<?php while($rowchild = $result->fetch(PDO::FETCH_ASSOC)){?>
								<li><a href="<?php echo $rowchild['childmenu_link']?>"><?php echo $rowchild['childmenu']?></a>
								</li><?php }?>
							</ul>
						</li>
						<?php }}?>
						</ul>
					</div>
					<?php }?>
					</div>
					</div>
				</div>
			</li>
			<?php }}?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog3"></i>
						<span class="visible-xs-inline-block position-right">Share</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
						<li><a href="setting-menu"><i class="icon-statistics"></i> Menu Setting</a></li>
						<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>