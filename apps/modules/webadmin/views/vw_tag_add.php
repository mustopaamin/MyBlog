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
			<form name="frmTag" id="frmTag" method="post" class="form-horizontal">
				<input type="hidden" name="f_tag_id" id="f_tag_id" value="" >
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Name</label>
					<div class="col-md-6"><input type="text" name="f_tag_name" id="f_tag_name" class="form-control" placeholder="Name ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Active</label>
					<div class="col-md-6">
					<?php
						$Aktif = array(0=>'Non Aktif',1=>'Aktif');
						echo form_dropdown('f_tag_active',$Aktif,1,'id="f_tag_active" class="form-control select"');
					?>
					</div>
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
	$('#frmTag').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$('#addTag').click(function()	{
		$('#tableTag_wrapper').hide();
		$('.box-header').hide();
		$('#frmTag').trigger("reset");
		$('#frmTag').show();
		$('#fnButton').html('<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />&nbsp;&nbsp;&nbsp;<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>');
	});
	
	var $f_tag_active = $('#f_tag_active'); 
    $f_tag_active.select2();
    	
<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('webadmin/tag/fnTagDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_tag_id').val(data.f_tag_id);
			$('#f_tag_name').val(data.f_tag_name);
			$('#f_tag_active').val(data.f_tag_active).trigger('change');
		}
	}, "json");

	var url = "<?php echo site_url('webadmin/tag/fnTagUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('webadmin/tag/fnTagSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmTag').submit(function(e){
		var oForm = $('#frmTag');
		var rec = $('#frmTag').serializeArray();
		rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = "<?php echo site_url('webadmin/tag');?>";
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
	window.location.href = "<?php echo site_url('webadmin/tag');?>";
}
</script>



