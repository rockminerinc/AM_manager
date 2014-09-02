
    <div id="sidebar">
		<div class="well sidebar-nav">
			<ul class="nav nav-list ">
				<li <?php echo $this->router->fetch_method()=='index' ? ' class="active"' : '' ?> ><a href = "?c=home&m=index" >Home</a></li>
				<li <?php echo $this->router->fetch_method()=='groups' ? ' class="active"' : ''?> ><a href = "?c=home&m=groups" >Groups</a></li>
				<li <?php echo $this->router->fetch_method()=='setip' ? ' class="active"' : ''?> ><a href = "?c=home&m=setip"  >Set IP</a></li> 
				<li <?php echo $this->router->fetch_method()=='setdns' ? ' class="active"' : ''?> ><a href = "?c=home&m=setdns"  >Set DNS</a></li> 

				<li  <?php echo $this->router->fetch_method()=='reboot' ? ' class="active"' : ''?> ><a href = "?c=home&m=reboot"  >Reboot</a></li> 
			</ul>
 
		</div><!--/.well -->	
	
	</div>
