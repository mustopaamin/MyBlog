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
			<form name="frmModule" id="frmModule" method="post" class="form-horizontal">
				<input type="hidden" name="f_module_id" id="f_module_id" value="" >
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Class</label>
					<div class="col-md-6"><input type="text" name="f_module_class" id="f_module_class" class="form-control" placeholder="Class ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Name</label>
					<div class="col-md-6"><input type="text" name="f_module_name" id="f_module_name" class="form-control" placeholder="Name ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Description</label>
					<div class="col-md-6"><input type="text" name="f_module_desc" id="f_module_desc" class="form-control" placeholder="Description ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Icon</label>
					<div class="col-md-6"><input type="text" name="f_module_icon" id="f_module_icon" class="form-control" placeholder="Icon ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Level Menu</label>
					<div class="col-md-6">
					<?php
						$Level = array(0=>'None',1=>'Satu',2=>'Dua',3=>'Tiga');
						echo form_dropdown('f_module_level',$Level,0,'id="f_module_level" class="form-control select"');
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Parent</label>
					<div class="col-md-6">
					<?php
						$Parent = array(0=>'None',);
						echo form_dropdown('f_module_parent',$Parent,false,'id="f_module_parent" class="form-control select"');
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Sort</label>
					<div class="col-md-6"><input type="text" name="f_module_urut" id="f_module_urut" class="form-control" placeholder="Sort ..." value="" ></div>
				</div>
				<div class="form-group">
					<label class="col-md-2" style="padding-top:7px;">Active</label>
					<div class="col-md-6">
					<?php
						$Aktif = array(0=>'Non Aktif',1=>'Aktif');
						echo form_dropdown('f_module_active',$Aktif,1,'id="f_module_active" class="form-control select"');
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
	$('#frmModule').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$('#addModule').click(function()	{
		$('#tableModule_wrapper').hide();
		$('.box-header').hide();
		$('#frmModule').trigger("reset");
		$('#frmModule').show();
		$('#fnButton').html('<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />&nbsp;&nbsp;&nbsp;<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>');
	});

	var $f_module_level = $('#f_module_level'); 
    $f_module_level.select2();

	$f_module_level.change(function(){
		if($(this).val() > 0)
		{
			$.post('<?php echo site_url('module/fnModuleComboDataLevel');?>',{level : $(this).val()},
				function(data)
				{
					console.log(data);
					var opt = '';
					if(data)
					{
						$.each(data,function(k,v){
							opt += '<option value="'+k+'">'+v+'</option>';
						});
					}
					else
					{
						opt += '<option value="0">None</option>';
					}
					$("#f_module_parent").html(opt).trigger('change');
				}
			,'json');
		}
	});

	var $f_module_parent = $('#f_module_parent'); 
    $f_module_parent.select2();


	var $f_module_active = $('#f_module_active'); 
    $f_module_active.select2();

<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('module/fnModuleDataId?id='.$fId);?>",function(data){
		if(data)
		{
			$('#f_module_id').val(data.f_module_id);
			$('#f_module_class').val(data.f_module_class);
			$('#f_module_name').val(data.f_module_name);
			$('#f_module_desc').val(data.f_module_desc);
			$('#f_module_icon').val(data.f_module_icon);
			$('#f_module_level').val(data.f_module_level).trigger('change');
			$('#f_module_parent').val(data.f_module_parent);
			$('#f_module_urut').val(data.f_module_urut);
			$('#f_module_active').val(data.f_module_active).trigger('change');
		}
	}, "json");

	var url = "<?php echo site_url('module/fnModuleUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('module/fnModuleSave');?>";
<?php } ?>

	// Menyimpan data
	$('#frmModule').submit(function(e){
		var oForm = $('#frmModule');
		var rec = $('#frmModule').serializeArray();
		rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash(); ?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = "<?php echo site_url('module');?>";
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
	window.location.href = "<?php echo site_url('module');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



