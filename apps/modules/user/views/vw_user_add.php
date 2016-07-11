<!-- load css dan js -->
<script src="<?php echo ASSETS_URL;?>plugins/form/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo ASSETS_URL;?>plugins/select2/select2.min.js"></script>
<!-- end load css dan js -->

<section class="content-header">
	<h1>
		<?php echo $app_title;?>
		<small><?php echo $app_desc;?></small>
	</h1>
</section>

<section class="content">
	<div class="box box-info"> <!-- start .box -->
		<div class="box-header"> <!-- start .box-header -->
			<?php echo $form_header;?>
		</div> <!-- end .box-header -->
		
		<div class="box-body"> <!-- start .box-body -->
			<form name="frmUser" id="frmUser" method="post" class="form-horizontal">
				<input type="hidden" name="f_user_id" id="f_user_id" value="" >
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Email</label>
					<div class="col-md-6"><input type="text" name="f_user_email" id="f_user_email" class="form-control" placeholder="Email ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Password</label>
					<div class="col-md-6"><input type="password" name="f_user_password" id="f_user_password" class="form-control" placeholder="Password ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Name</label>
					<div class="col-md-6"><input type="text" name="f_user_name" id="f_user_name" class="form-control" placeholder="Name ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Role</label>
					<div class="col-md-6">
					<?php
						$dataTes = array(1=>'Satu',2=>'Dua',3=>'Tiga',4=>'Empat',);
						echo form_dropdown('f_user_role',$dataTes,2,'id="f_user_role" class="form-control select"');
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Active</label>
					<div class="col-md-6">
					<?php
						$dataTes = array(1=>'Satu',2=>'Dua',3=>'Tiga',4=>'Empat',);
						echo form_dropdown('f_user_active',$dataTes,2,'id="f_user_active" class="form-control select"');
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Create Date</label>
					<div class="col-md-6"><input type="text" name="f_user_create_on" id="f_user_create_on" class="form-control" placeholder="Create Date ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Create By</label>
					<div class="col-md-6"><input type="text" name="f_user_create_by" id="f_user_create_by" class="form-control" placeholder="Create By ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Update Date</label>
					<div class="col-md-6"><input type="text" name="f_user_update_on" id="f_user_update_on" class="form-control" placeholder="Update Date ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Update by</label>
					<div class="col-md-6"><input type="text" name="f_user_update_by" id="f_user_update_by" class="form-control" placeholder="Update by ..." value="" ></div>
				</div>	
				<div class="col-md-8" align="center" id="fnButton">
		<?php 	
			if($fAct == 'Add')	echo '<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />';

			if($fAct == 'Edit')	echo '<input type="submit" name="submit" value="Ubah" id="btnUpdate" class="btn btn-warning" />';
		?>
				&nbsp;&nbsp;&nbsp;
				<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>
				</div>
			</form>

		</div> <!-- end .box-body -->
		<div class="box-footer" align="right"> <!-- start box-footer -->
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div> <!-- end .box-footer-->
	</div> <!-- end .box -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	$('#frmUser').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$('#addUser').click(function()	{
		$('#tableUser_wrapper').hide();
		$('.box-header').hide();
		$('#frmUser').trigger("reset");
		$('#frmUser').show();
		$('#fnButton').html('<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />&nbsp;&nbsp;&nbsp;<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>');
	});

	var $f_user_role = $('#f_user_role'); 
    $f_user_role.select2();


	var $f_user_active = $('#f_user_active'); 
    $f_user_active.select2();

<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('user/fnUserDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_user_id').val(data.f_user_id);
			$('#f_user_email').val(data.f_user_email);
			$('#f_user_password').val(data.f_user_password);
			$('#f_user_name').val(data.f_user_name);
			$('#f_user_role').val(data.f_user_role);
			$('#f_user_active').val(data.f_user_active);
			$('#f_user_create_on').val(data.f_user_create_on);
			$('#f_user_create_by').val(data.f_user_create_by);
			$('#f_user_update_on').val(data.f_user_update_on);
			$('#f_user_update_by').val(data.f_user_update_by);
		}
	}, "json");

	var url = "<?php echo site_url('user/fnUserUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('user/fnUserSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmUser').submit(function(e){
		var oForm = $('#frmUser');
		var rec = $('#frmUser').serializeArray();
		rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = "<?php echo site_url('user');?>";
				}
				else
				{
					infoDialog.realize();
					infoDialog.setTitle('Info').setMessage('<center>Gagal !!</center>').setType(BootstrapDialog.TYPE_DANGER).open();
				}
			}, 'json');
		}
	});
});

function fnBack()
{
	window.location.href = "<?php echo site_url('user');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



