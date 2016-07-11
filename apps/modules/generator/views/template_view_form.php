<?php
$html = "<!-- load css dan js -->
<script src=\"<?php echo ASSETS_URL;?>plugins/form/jquery.validate.js\"></script>";
if(in_array('select',$type_form, true))
{
$html .="
<link rel=\"stylesheet\" href=\"<?php echo ASSETS_URL;?>plugins/select2/select2.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo ASSETS_URL;?>plugins/select2/select2.min.js\"></script>";
}
if(in_array('textarea',$type_form, true))
{
$html .="
<link rel=\"stylesheet\" href=\"<?php echo ASSETS_URL;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo ASSETS_URL;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js\"></script>";
}
$html .="\n<!-- end load css dan js -->";

$html .="\n\n<section class=\"content-header\">
	<h1>
		<?php echo \$app_title;?>
		<small><?php echo \$app_desc;?></small>
	</h1>
</section>";

$html .="\n\n<section class=\"content\">
	<div class=\"box box-info\"> <!-- start .box -->
		<div class=\"box-header\"> <!-- start .box-header -->
			<?php echo \$form_header;?>
		</div> <!-- end .box-header -->
		
		<div class=\"box-body\"> <!-- start .box-body -->
			<form name=\"frm".$nm_global."\" id=\"frm".$nm_global."\" method=\"post\" class=\"form-horizontal\">";

foreach($fields_form as $k => $v):
if($type_form[$k] == 'hidden')
{
$html .="
\t\t\t\t<input type=\"hidden\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" value=\"\" >";
}
if($type_form[$k] == 'text')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"text\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'password')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"password\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'datepicker')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"text\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'select')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\">
					<?php
						\$dataTes = array(1=>'Satu',2=>'Dua',3=>'Tiga',4=>'Empat',);
						echo form_dropdown('".$v['nama_form']."',\$dataTes,2,'id=\"".$v['nama_form']."\" class=\"form-control select\"');
					?>
					</div>
				</div>";
}
if($type_form[$k] == 'textarea')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><textarea name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" placeholder=\"".$label_form[$k]."\" rows=\"3\" class=\"form-control textarea\"></textarea></div>
				</div>";
}
endforeach;
				
$html .="	
				<div class=\"col-md-8\" align=\"center\" id=\"fnButton\">
		<?php 	
			if(\$fAct == 'Add')	echo '<input type=\"submit\" name=\"submit\" value=\"Save\" id=\"btnSave\" class=\"btn btn-success\" />';

			if(\$fAct == 'Edit')	echo '<input type=\"submit\" name=\"submit\" value=\"Ubah\" id=\"btnUpdate\" class=\"btn btn-warning\" />';
		?>
				&nbsp;&nbsp;&nbsp;
				<a onClick=\"fnBack()\" class=\"btn btn-danger\"> Cancel</a>
				</div>
			</form>

		</div> <!-- end .box-body -->
		<div class=\"box-footer\" align=\"right\"> <!-- start box-footer -->
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div> <!-- end .box-footer-->
	</div> <!-- end .box -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	$('#frm".$nm_global."').validate({
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}		
	});

	$('#add".$nm_global."').click(function()	{
		$('#table".$nm_global."_wrapper').hide();
		$('.box-header').hide();
		$('#frm".$nm_global."').trigger(\"reset\");
		$('#frm".$nm_global."').show();
		$('#fnButton').html('<input type=\"submit\" name=\"submit\" value=\"Save\" id=\"btnSave\" class=\"btn btn-success\" />&nbsp;&nbsp;&nbsp;<a onClick=\"fnBack()\" class=\"btn btn-danger\"> Cancel</a>');
	});";

if(in_array('select',$type_form, true))
{
foreach($fields_form as $k => $v):
if($type_form[$k] == 'select')
{	
$html .="\n
	var \$".$v['nama_form']." = $('#".$v['nama_form']."'); 
    \$".$v['nama_form'].".select2();
";
}
endforeach;
}

$html .="
<?php if(\$fAct == 'Edit') { ;?>
	$.get(\"<?php echo site_url('".strtolower($nm_controller)."/fn".$nm_global."DataId?id='.\$fId);?>\",function(data){
		if(data)
		{\n";
foreach($fields_form as $nf):
$html .="			$('#".$nf['nama_form']."').val(data.".$nf['nama_form'].");\n";
endforeach;			
$html .="\t\t}
	}, \"json\");

	var url = \"<?php echo site_url('".strtolower($nm_controller)."/fn".$nm_global."Update?id='.\$fId);?>\";
<?php } ?>
";

$html .="
<?php if(\$fAct == 'Add') { ;?>
	var url = \"<?php echo site_url('".strtolower($nm_controller)."/fn".$nm_global."Save');?>\";
<?php } ?>
";

if(in_array('textarea',$type_form, true))
{
$html .= "\n
	var menutext = {
			'font-styles': true, //Font styling, e.g. h1, h2, etc. Default true
			'emphasis': true, //Italics, bold, etc. Default true
			'lists': true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
			'html': false, //Button which allows you to edit the generated HTML. Default false
			'link': false, //Button to insert a link. Default true
			'image': false, //Button to insert an image. Default true,
			'color': false, //Button to change color of font  
			'blockquote': false, //Blockquote
			'size': 'sm' //default: none, other options are xs, sm, lg
		}";	
foreach($fields_form as $k => $v):
if($type_form[$k] == 'textarea')
{	
$html .="
	$('#".$v['nama_form']."').wysihtml5({
		toolbar: menutext 
	});
";
}
endforeach;
}

if(in_array('datepicker',$type_form, true))
{
foreach($fields_form as $k => $v):
if($type_form[$k] == 'datepicker')
{
$html .="
	$('#".$v['nama_form']."').datepicker({
		dateFormat: \"yy-mm-dd\",
		regional: \"id\"
	});
";
}
endforeach;
}
$html .="
	// Menyimpan data
	$('#frm".$nm_global."').submit(function(e){
		var oForm = $('#frm".$nm_global."');
		var rec = $('#frm".$nm_global."').serializeArray();
		rec.push({name: '<?php echo \$this->security->get_csrf_token_name(); ?>',value:'<?php echo \$this->security->get_csrf_hash();?>'});
		e.preventDefault();
		if(oForm[0].checkValidity()) {
			$.post(url, rec, function(msg){
				if(msg)
				{
					window.location.href = \"<?php echo site_url('".strtolower($nm_controller)."');?>\";
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
	window.location.href = \"<?php echo site_url('".strtolower($nm_controller)."');?>\";
}";

if(in_array('select',$type_form, true))
{
$html .="\n
function formatAccount(result)
{
	if (result.loading) return result.text;
	
	var markup = \"<span>\"+result.text+\"<br/>\"+result.contact+\" (\"+result.phone+\" - \"+result.email+\")</span>\";
	return markup;
}";
}

$html .="
</script>
";
echo $html;
?>



