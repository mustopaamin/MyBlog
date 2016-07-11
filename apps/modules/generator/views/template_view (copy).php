<?php
$html = "<!-- load css dan js -->
<link rel=\"stylesheet\" href=\"<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>\"></script>
<script src=\"<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>\"></script>
<script src=\"<?php echo base_url('assets/plugins/datatables/fnPagingInfo.js');?>\"></script>
<script src=\"<?php echo base_url('assets/plugins/datatables/fnReloadAjax.js');?>\"></script>
<script src=\"<?php echo base_url('assets/plugins/form/jquery.validate.js');?>\"></script>";
if(in_array('select',$type_form, true))
{
$html .="
<link rel=\"stylesheet\" href=\"<?php echo base_url('assets/plugins/select2/select2.min.css');?>\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo base_url('assets/plugins/select2/select2.min.js');?>\"></script>";
}
if(in_array('textarea',$type_form, true))
{
$html .="
<link rel=\"stylesheet\" href=\"<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>\"></script>";
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
			<a class=\"btn btn-sm btn-primary\" id=\"add".$nm_global."\"><i class=\"fa fa-plus\"></i> Tambah</a>&nbsp;&nbsp;
		</div> <!-- end .box-header -->
		
		<div class=\"box-body\"> <!-- start .box-body -->
			<table id=\"table".$nm_global."\" class=\"table datares\">
				<thead>
					<tr>";

foreach($thead as $thead):				
$html .="				
						<th>".$thead."</th>";
endforeach;

$html .="\n						<th>Action</th>
					</tr>
				</thead>
			</table>
			<br/>
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
				<div class=\"col-md-8\" align=\"center\" id=\"fnButton\"></div>
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
	$('#frm".$nm_global."').hide();
	$('#frm".$nm_global."').validate();
	oTable = $('#table".$nm_global."').dataTable({
		\"processing\": true,
		\"serverSide\": true,
		\"sAjaxSource\": \"<?php echo site_url();?>/".strtolower($nm_controller)."/fn".$nm_global."DataJson\",
		\"sServerMethod\": \"POST\",
		\"aoColumns\": [ 
			$aoColumns ,{ 'bSortable': false,'sClass':'center' }
		],
		\"fnRowCallback\": function (nRow, aData, iDisplayIndex, DisplayIndexFull) {
		  var page		= this.fnPagingInfo().iPage;
		  var lengt		= this.fnPagingInfo().iLength;
		  var index 	= (page * lengt + (iDisplayIndex +1));
		  $('td:eq(0)', nRow).html(index);
		}
	});
	$(\".dataTables_filter input\").attr(\"placeholder\",\"Cari Kata disini ...\");

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
});

// Menyimpan data
$('#frm".$nm_global."').submit(function(e){
	e.preventDefault();
	var rec = $('#frm".$nm_global."').serialize();
	if($('input[name=\"submit\"]').val()=='Save'){
		// Insert
		$.ajax({
			'url': \"<?php echo site_url();?>/".strtolower($nm_controller)."/fn".$nm_global."Save/\",
			'type': \"POST\",
			'data': rec,
			'dataType': 'json',
			'success': function(html){
				if(html.msg==true)
				{ 
					$('#frm".$nm_global."').hide(); $('.box-header').show(); $('#table".$nm_global."_wrapper').show(); oTable.fnReloadAjax();	infoDialog.realize();
					infoDialog.setTitle('Info').setMessage('Sukses Tambah !!').setType(BootstrapDialog.TYPE_SUCCESS).open();
					$('html, body').animate({	scrollTop: 0	}, 'slow');
				} 
			},
			'error': function(html){ 
				if(html.msg==false)
				{
					infoDialog.realize();
					infoDialog.setTitle('Info').setMessage('Terjadi duplicate !!').setType(BootstrapDialog.TYPE_DANGER).open();
				}
			}
		});	
	} else {
		// Update
		$.ajax({
			'url': \"<?php echo site_url();?>/".strtolower($nm_controller)."/fn".$nm_global."Update?id=\"+$('#".$where_select."').val(),
			'type': \"POST\",
			'data': rec,
			'dataType': 'json',
			'success': function(html){
				if(html.msg==true)
				{
					$(':input','#frm".$nm_global."').not(':button, :submit, :reset').val('');
					$('#frm".$nm_global."').hide(); $('.box-header').show(); $('#table".$nm_global."_wrapper').show(); oTable.fnReloadAjax();	infoDialog.realize();
					infoDialog.setTitle('Info').setMessage('Sukses Update !!').setType(BootstrapDialog.TYPE_INFO).open();
					$('html, body').animate({	scrollTop: 0	}, 'slow');
				} 
			},
			'error': function(html){ 
				if(html.msg==false)
				{
					infoDialog.realize();
					infoDialog.setTitle('Info').setMessage('Terjadi duplicate !!').setType(BootstrapDialog.TYPE_DANGER).open();
				}
			}
		});	
	}
	
});

function fnEdit(idRow)
{
	$('#frm".$nm_global."').trigger(\"reset\");
	$(':input','#frm".$nm_global."').not(':button, :submit, :reset').val('');//.removeAttr('checked').removeAttr('selected');
	$('#table".$nm_global."_wrapper').hide();
	$('.box-header').hide();
	$('#frm".$nm_global."').show();
		
	var urlUpdate='<?php echo site_url();?>/".strtolower($nm_controller)."/fn".$nm_global."DataId?id='+idRow;
	$.getJSON( urlUpdate, function(data){ \n";
			
foreach($fields_form as $nf):
$html .="			$('#".$nf['nama_form']."').val(data.".$nf['nama_form'].");\n";
endforeach;

$html.="
	});
	$('#fnButton').html('<input type=\"submit\" name=\"submit\" value=\"Ubah\" id=\"btnUpdate\" class=\"btn btn-warning\" />&nbsp;&nbsp;&nbsp;<a onClick=\"fnBack()\" class=\"btn btn-danger\"> Cancel</a>');	
}

function fnDelete(idRow)
{
	BootstrapDialog.confirm('Yakin ingin dihapus ?', function(result){
		var urlUpdate='<?php echo site_url();?>/".strtolower($nm_controller)."/fn".$nm_global."Delete/'
		if(result)
		{
			$.post(urlUpdate,{id : idRow},function(html){
				if(html== 'TRUE') { oTable.fnReloadAjax();} 
				else
				{
					infoDialog.realize();
					infoDialog.setTitle('Info').setMessage(html).setType(BootstrapDialog.TYPE_DANGER).open();
				} 
			});
		}	
	}).setType(BootstrapDialog.TYPE_DANGER);
}

function fnBack()
{
	$('#frm".$nm_global."').trigger(\"reset\");
	$('#frm".$nm_global."').hide();	
	$('#table".$nm_global."_wrapper').show();
	$('.box-header').show();
	$('html, body').animate({	scrollTop: 0	}, 'slow');
}

</script>
";
echo $html;
?>



