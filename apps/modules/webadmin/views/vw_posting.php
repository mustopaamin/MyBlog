<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/datatables/dataTables.bootstrap.css" />
<script src="<?php echo ASSETS_URL;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL;?>plugins/datatables/fnPagingInfo.js"></script>
<script src="<?php echo ASSETS_URL;?>plugins/datatables/fnReloadAjax.js"></script>
<script src="<?php echo ASSETS_URL;?>plugins/form/jquery.validate.js"></script>
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
		<?php if($this->rolemodule->check_button('add')) { ?>			
			<a class="btn btn-sm btn-primary" id="addPosting"><i class="fa fa-plus"></i> Tambah</a>&nbsp;&nbsp;
		<?php } ?>
		</div> <!-- end .box-header -->
		
		<div class="box-body"> <!-- start .box-body -->
			<table id="tablePosting" class="table datares">
				<thead>
					<tr>				
						<th>No</th>				
						<th>Name</th>				
						<th>Category</th>				
						<th>Text Posting</th>				
						<th>Tag</th>				
						<th>Date</th>				
						<th>Time</th>				
						<th>Active</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div> <!-- end .box-body -->
		<div class="box-footer" align="right"> <!-- start box-footer -->
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div> <!-- end .box-footer-->
	</div> <!-- end .box -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	oTable = $('#tablePosting').dataTable({
		"processing": true,
		"serverSide": true,
		"sAjaxSource": "<?php echo site_url('webadmin/posting/fnPostingDataJson');?>",
		"sServerMethod": "POST",
		"aoColumns": [ 
			null,null,null,{'mRender': view_text},null,{'mRender': format_date},null,null ,{ 'bSortable': false,'sClass':'center' }
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, DisplayIndexFull) {
		  var page		= this.fnPagingInfo().iPage;
		  var lengt		= this.fnPagingInfo().iLength;
		  var index 	= (page * lengt + (iDisplayIndex +1));
		  $('td:eq(0)', nRow).html(index);
		}
	});
	$(".dataTables_filter input").attr("placeholder","Cari Kata disini ...");

	$('#addPosting').click(function()	{
		window.location.href = "<?php echo site_url('webadmin/posting/fnPostingAdd');?>";

	});

<?php if($this->session->userdata('SUCMSG'))
{	
	echo "infoDialog.realize();";
	echo "infoDialog.setTitle('Info').setMessage('<center>".$this->session->userdata('SUCMSG')."</center>').open();";
	$this->session->unset_userdata('SUCMSG');
}
?>
});

function view_text(x)
{
	str = x.toString().replace(/<\/?[^>]+>/gi, '');
	return str.substr(0,150);
}

function format_date(x)
{
	str = x.split('-');
	return str[2]+' '+str[1]+' '+str[0];
}

function fnEdit(idRow)
{
	window.location.href = "<?php echo site_url('webadmin/posting/fnPostingEdit');?>/"+idRow;
}

function fnDelete(idRow)
{
	BootstrapDialog.confirm('Yakin ingin dihapus ?', function(result){
		var urlUpdate='<?php echo site_url('webadmin/posting/fnPostingDelete');?>'
		if(result)
		{
			$.post(urlUpdate,{id : idRow,<?php echo $this->security->get_csrf_token_name();?>:'<?php echo $this->security->get_csrf_hash(); ?>'},function(html){
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

</script>



