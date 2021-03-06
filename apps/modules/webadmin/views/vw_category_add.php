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
			<form name="frmCategory" id="frmCategory" method="post" class="form-horizontal">
				<input type="hidden" name="f_category_id" id="f_category_id" value="" >
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Name</label>
					<div class="col-md-6"><input type="text" name="f_category_name" id="f_category_name" class="form-control" placeholder="Name ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Parent</label>
					<div class="col-md-6">
					<?php
						$dataTes = array(1=>'Satu',2=>'Dua',3=>'Tiga',4=>'Empat',);
						echo form_dropdown('f_category_parent',$dataTes,2,'id="f_category_parent" class="form-control select"');
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Active</label>
					<div class="col-md-6">
					<?php
						$Aktif = array(0=>'Non Aktif',1=>'Aktif');
						echo form_dropdown('f_category_active',$Aktif,1,'id="f_category_active" class="form-control select"');
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
	$('#frmCategory').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$('#addCategory').click(function()	{
		$('#tableCategory_wrapper').hide();
		$('.box-header').hide();
		$('#frmCategory').trigger("reset");
		$('#frmCategory').show();
		$('#fnButton').html('<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />&nbsp;&nbsp;&nbsp;<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>');
	});

	var $f_category_parent = $('#f_category_parent'); 
    $f_category_parent.select2();


	var $f_category_active = $('#f_category_active'); 
    $f_category_active.select2();

<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('webadmin/category/fnCategoryDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_category_id').val(data.f_category_id);
			$('#f_category_name').val(data.f_category_name);
			$('#f_category_parent').val(data.f_category_parent);
			$('#f_category_active').val(data.f_category_active).trigger('change');
		}
	}, "json");

	var url = "<?php echo site_url('webadmin/category/fnCategoryUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('webadmin/category/fnCategorySave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmCategory').submit(function(e){
		var oForm = $('#frmCategory');
		var rec = $('#frmCategory').serializeArray();
		rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = "<?php echo site_url('webadmin/category');?>";
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
	window.location.href = "<?php echo site_url('webadmin/category');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



