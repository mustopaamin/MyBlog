<!-- load css dan js -->
<script src="<?php echo ASSETS_URL;?>plugins/form/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo ASSETS_URL;?>plugins/select2/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/fancybox/jquery.fancybox.css">
<script src="<?php echo ASSETS_URL;?>plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo ASSETS_URL;?>plugins/fancybox/jquery.fancybox.js"></script>
<style type="text/css">
	img{ margin: 20px 0; border: 8px double #CCC; width:100%;max-height:275px;}
</style>
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
			<form name="frmPosting" id="frmPosting" method="post" class="form-horizontal">
			<div class="row">
				<div class="col-md-9">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" id="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" >
					<input type="hidden" name="f_posting_id" id="f_posting_id" value="" >
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Name</label>
						<div class="col-md-12"><input type="text" name="f_posting_name" id="f_posting_name" class="form-control" placeholder="Name ..." value="" ></div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<textarea name="f_posting_text" id="f_posting_text" placeholder="Text Posting" rows="3" class="form-control textarea"></textarea>
						</div>
					</div>
				</div> <!-- end .col-md -->
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Category</label>
						<div class="col-md-12">
						<?php
							echo form_dropdown('f_category_id',$category,false,'id="f_category_id" class="form-control select" style="width:100%;"');
						?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Tag</label>
						<div class="col-md-12">
						<?php
							echo form_multiselect('f_posting_tag[]',$tag,false,'id="f_posting_tag" class="form-control select" style="width:100%;"');
						?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Image</label>
						<div class="col-md-12 text-center">
							<img src="<?php echo ASSETS_URL;?>images/noimages.jpg" alt="" title="" id="prev_img">
							<input type="hidden" name="f_posting_image" id="f_posting_image" class="form-control" placeholder="Image ..." value="<?php echo ASSETS_URL;?>images/noimages.jpg" >
							<a href="<?php echo ASSETS_URL;?>filemanager/dialog.php?type=1&field_id=f_posting_image" data-fancybox-type="iframe" class="btn btn-xs btn-success fancy"> Choose Image</a>
							<a class="btn btn-xs btn-danger" onClick="clear_img()"/>Remove Image</a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Active</label>
						<div class="col-md-12">
						<?php
							$Aktif = array(0=>'Non Aktif',1=>'Aktif');
							echo form_dropdown('f_posting_active',$Aktif,1,'id="f_posting_active" class="form-control select" style="width:100%;"');
						?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Date</label>
						<div class="col-md-12"><input type="text" name="f_posting_date" id="f_posting_date" disabled class="form-control" placeholder="Date (Otomatis) ..." value="" ></div>
					</div>
					<div class="form-group">
						<label class="col-md-2" style="padding-top:7px;">Time</label>
						<div class="col-md-12"><input type="text" name="f_posting_time" id="f_posting_time" disabled class="form-control" placeholder="Time (Otomatis) ..." value="" ></div>
					</div>
				</div> <!-- end .col-md -->
			</div> <!-- end .row -->



				<div class="col-md-12" align="center" id="fnButton">
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
	CKEDITOR.replace('f_posting_text',{
		language: 'id',
		uiColor: '#6A9CFF',
		height:'400px',
		codeSnippet_theme :'monokai-sublime',
		filebrowserBrowseUrl:'<?php echo ASSETS_URL;?>filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
		filebrowserUploadUrl:'<?php echo ASSETS_URL;?>filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
		});
$(document).ready(function(){
	$('#frmPosting').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$(".fancy").fancybox({
		minHeight	: 500,
		});
			
	$('#addPosting').click(function()	{
		$('#tablePosting_wrapper').hide();
		$('.box-header').hide();
		$('#frmPosting').trigger("reset");
		$('#frmPosting').show();
		$('#fnButton').html('<input type="submit" name="submit" value="Save" id="btnSave" class="btn btn-success" />&nbsp;&nbsp;&nbsp;<a onClick="fnBack()" class="btn btn-danger"> Cancel</a>');
	});

	var $f_category_id = $('#f_category_id'); 
    $f_category_id.select2();


	var $f_posting_tag = $('#f_posting_tag'); 
    $f_posting_tag.select2();


	var $f_posting_active = $('#f_posting_active'); 
    $f_posting_active.select2();

<?php if($fAct == 'Edit') { ;?>
	$.get("<?php echo site_url('webadmin/posting/fnPostingDataId?id='.$fId."&".$this->security->get_csrf_token_name()."=".$this->security->get_csrf_hash());?>",function(data){
		if(data)
		{
			$('#f_posting_id').val(data.f_posting_id);
			$('#f_posting_name').val(data.f_posting_name);
			$('#f_posting_slug').val(data.f_posting_slug);
			$('#f_category_id').val(data.f_category_id).trigger('change');
			//$('#f_posting_text').val(data.f_posting_text);
			CKEDITOR.instances['f_posting_text'].setData(data.f_posting_text)
			var $tag = data.f_posting_tag.split(',');
			console.log($tag);
			$('#f_posting_tag').val($tag).trigger('change');
			$('#f_posting_image').val(data.f_posting_image);
			$("#prev_img").attr('src',data.f_posting_image);
			$('#f_posting_date').val(data.f_posting_date);
			$('#f_posting_time').val(data.f_posting_time);
			$('#f_posting_active').val(data.f_posting_active).trigger('change');
		}
	}, "json");

	var url = "<?php echo site_url('webadmin/posting/fnPostingUpdate?id='.$fId);?>";
<?php } ?>

<?php if($fAct == 'Add') { ;?>
	var url = "<?php echo site_url('webadmin/posting/fnPostingSave');?>";
<?php } ?>


	// Menyimpan data
	$('#frmPosting').submit(function(e){
		for (instance in CKEDITOR.instances) {
		        CKEDITOR.instances[instance].updateElement();
		    }
		var oForm = $('#frmPosting');
		var rec = $('#frmPosting').serialize();
		//rec.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>',value:'<?php echo $this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = "<?php echo site_url('webadmin/posting');?>";
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

function responsive_filemanager_callback(field_id)
{
	var image = $("#"+ field_id).val();
	$("#prev_img").attr('src',image);
}

function clear_img()
{
	var images = '<?php echo ASSETS_URL;?>images/noimages.jpg';
	$("#prev_img").attr('src',images);
	$("#f_posting_image").val('');
}

function fnBack()
{
	window.location.href = "<?php echo site_url('webadmin/posting');?>";
}

function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = "<span>"+result.text+"<br/>"+result.contact+" ("+result.phone+" - "+result.email+")</span>";
	return markup;
}
</script>



