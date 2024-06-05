	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">
				<div style="flex">
					<img src="<?php echo base_url();?>assets/images/pg_logo.png" class="img-circle" alt="" style="width: 30px;">
					<span style="font-weight: bold;">Telegraphic Transfer System</span>
					
				</div>

			</a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				
			</ul>

			
			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						
					<?php if($this->session->userdata('empName')){ ?>
                        <span>
                            <?php echo $this->session->userdata('empName')?>
                        </span>
					<?php } 
					else if($this->session->userdata('username')){?>
             			<span>
                            <?php echo $this->session->userdata('username')?>
                        </span>

					<?php }?>
					      
                        
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo base_url(). 'mainController/logout' ?>"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>

			<p class="navbar-text">
				<span class="label bg-success">Online</span>
			</p>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>

								<?php if($this->session->userdata('empName')){ ?>

									<li id="0"><a href="<?php echo base_url(). 'mainController/afterLogin' ?>"><i class="icon-home"></i><span>Dashboard</span></a></li>
								
								<?php } else if($this->session->userdata('username')){?>

									<li id="0"><a href="<?php echo base_url(). 'mainController/afterLoginSR' ?>"><i class="icon-home"></i><span>Dashboard</span></a></li>
								<?php }  ?>
								
                                <?php 

                                    $getModule = $this->mainModel->getModules();

                                    foreach($getModule as $getModules){
                                        
                                        $getMenus = $this->mainModel->getMenus($getModules['roles_desc']);
                                        
                                        foreach ($getMenus as $menus) {
                                            echo '
                                            <li id="'.$menus->id.'">
                                                    <a href="'.$menus->siteName.'" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="'.$menus->icon.'"></i><span>'.$menus->moduleName.'</span></a>
                                                <ul>';

                                                //get subMENUs based on modules
                                                $getsubMenus = $this->mainModel->getsubMenus($menus->firstLvl,$getModules['roles_desc']);

                                                foreach ($getsubMenus as $submenus) {
                                                    echo '<li id="li'.$submenus->id.'"><a href="'.base_url().$submenus->siteName.'" class="li'.$submenus->id.'">
                                                    <i class="'.$menus->icon.'"></i><span>'.$submenus->moduleName.'</span></a></li>';
                                                }
                                                    
                                            echo '</ul>
                                            </li>'; 
                                        }

                                    ?>

                                    <?php  }?>


                                <!-- <li></li>
								<li id="m1"><a href="<?php echo base_url();?>mainController/dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								<li id="m2"><a href="<?php echo base_url();?>mainController/createProduct"><i class="icon-plus-circle2"></i> <span>Create Product</span></a></li>
								<li id="m3"><a href="<?php echo base_url();?>mainController/viewProduct"><i class="icon-basket"></i> <span>View Product</span></a></li>
								<li id="m4"><a href="<?php echo base_url();?>mainController/viewDeleteProduct"><i class="icon-eraser2"></i> <span>View Deleted Product</span></a></li>
								 -->
								<!-- /main -->

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
		<div class="content-wrapper">

<script>

	idleLogout();

	var idle = 0;

	function idleLogout() {
	
    var t;
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer;      
    window.ontouchstart = resetTimer; 
    window.ontouchmove = resetTimer; 
    window.onclick = resetTimer; 
    window.onkeydown = resetTimer;   
    window.addEventListener('scroll', resetTimer, true); 

    function destroy() {
	
		if(idle == 0){

			idle = 1;
			
		$.ajax({
			url: '<?php echo base_url(). 'mainController/logout' ?>',
			type: 'POST',
			success: function(data){

				}
		});

				swal({
					title: "Session Alert.",
					text: "Your session has been expired, please login again.",
					type: "error",
					confirmButtonColor: "#EF5350",
					confirmButtonText: "Yes",
					closeOnConfirm: false,
					closeOnClickOutside: false
				},
				function(isConfirm){
					if (isConfirm)
					{

						window.location.href='<? echo base_url() ?>';  

					}
					
					else 
					{
			
					}
				});

				
				
	
		}
	
        
    }

    function resetTimer() {
        clearTimeout(t);
        //t = setTimeout(destroy, 1000);  // time is in milliseconds
		//15
		t = setTimeout(destroy, 900000);  // time is in milliseconds
    }

}
</script>
