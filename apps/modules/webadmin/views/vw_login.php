<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyBlog</title>
<!--	<link rel="shortcut icon" href="<?php echo ASSETS_URL;?>images/favicon.png" type="image/x-icon" /> -->

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>font-awesome/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL;?>AdminLTE/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" style="background:#6a9cff;">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0)"><b>MyBlog</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div id="msgERROR" align="center"></div>
        <form action="#" method="post" id="formLogin">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" name="username" id="username" data-rule-required="true" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" data-rule-required="true" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row" align="center">
			  <div class=" col-md-offset-4 col-md-4 col-md-offset-4">
				<button type="submit" id="submit" class="btn btn-primary btn-block btn-flat"><i class=""></i> Sign In</button>
			  </div>	
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ASSETS_URL;?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo ASSETS_URL;?>plugins/jQueryUI/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo ASSETS_URL;?>plugins/form/jquery.validate.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo ASSETS_URL;?>bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
		var formLogin;
		$(function(){
			formLogin = $("#formLogin").validate({
				  submitHandler: function(form,e) {
					    e.preventDefault();
		    			$('#submit').prop('disabled', true);
						$("#submit i").attr('class','fa fa-cog fa-spin fa-1x fa-fw'); 
						
						var dopost = $("#formLogin").serializeArray(); 
						dopost.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash(); ?>'});
					    $.ajax({
						  type: "POST",
						  url: '<?php echo site_url('webadmin/ProsesLogin');?>',
						  data: dopost,
						  dataType: 'json'
						})
					    .done(function(f){
							console.log(f);
								if(f.msg == 'sukses')
								{
									window.location.reload();
								}
								else
								{
									$("#msgERROR").html("<p class='text-red'>"+f.msg+"</p>");
									$( ".login-box-body" ).effect( "shake",{direction: 'down'} );
									$('#submit').prop('disabled', false);
									$("#submit i").attr('class',''); 
								}
							})
						.fail(function(){
							alert('Terjadi Kesalahan. Silahkan coba kembali !!!');
							$('#submit').prop('disabled', false);
							$("#submit i").attr('class',''); 
							});
						/*
					    $.post('<?php echo site_url('launcher/ProsesLogin1');?>',{username:$("#username").val(),password:$("#password").val()})
					    .done(function(f){
							console.log(f);
								if(f.msg == 'sukses')
								{
									window.reload();
								}
								else
								{
									$("#msgERROR").html("<p class='text-red'>"+f.msg+"</p>");
									$( ".login-box-body" ).effect( "shake",{direction: 'down'} );
								}
							},'json')
						.fail(function(){
							alert('Terjadi Kesalahan. Silahkan coba kembali !!!');
							});*/
					  }
				});
			/*$("#formLogin").submit(function(event){
					event.preventDefault();
					alert('proses');
				});
			*/	
		});
    </script>
  </body>
</html>
