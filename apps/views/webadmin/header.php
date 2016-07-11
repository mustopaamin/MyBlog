<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $app_title;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="MyBlog"/>
	<meta name="keywords" content="Blog" />
	<meta name="author" content="mustopaamin@ymail.com" />	
		
	<link rel="shortcut icon" href="<?php echo ASSETS_URL;?>images/act.png" type="image/x-icon" />
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/bootstrap-dialog/bootstrap-dialog.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>font-awesome/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>ionicons/css/ionicons.min.css">
    <!-- JQueryUI -->
	<link href="<?= ASSETS_URL;?>plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>AdminLTE/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>AdminLTE/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Source Javascript -->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ASSETS_URL;?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?= ASSETS_URL;?>plugins/jQueryUI/jquery-ui-1.10.4.custom.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo ASSETS_URL;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo ASSETS_URL;?>plugins/bootstrap-dialog/bootstrap-dialog.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo ASSETS_URL;?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo ASSETS_URL;?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ASSETS_URL;?>AdminLTE/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo ASSETS_URL;?>AdminLTE/js/demo.js"></script>
    <script>
	    var infoDialog = new BootstrapDialog({
			onshown: function(dialogRef) {
					setTimeout(function(){
		               dialogRef.close();
		          }, 1500);                          
		    },		
		});
    </script>
        
  </head>
  <body class="hold-transition skin-blue sidebar-mini fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>ACT</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>ACT</b> Consulting</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-user-secret fa-2x img-circle"></i>
                  <span class="hidden-xs"><?php echo $this->session->userdata('sUsername');?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
					<i class="fa fa-user-secret fa-5x img-circle"></i>
                    <p>
                      <?php echo $this->session->userdata('sUsername');?>
                    </p>
                  </li>

                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?= site_url('md_login/fnLogout');?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
      <!-- =============================================== -->      
