<link rel="stylesheet" href="<?php echo ASSETS_URL;?>plugins/ckeditor/plugins/codesnippet/lib/highlight/styles/monokai-sublime.css">
<div class="container">
  <div class="row">
    
    <div class="col-md-12"> 
      
      <div class="panel">
        <div class="panel-body">
          <!--/stories--
          <div class="row">    
            <div class="col-md-12 col-sm-9"> -->
              <h3><?php echo $row['f_posting_name'];?></h3>
				<h4>
					<small class="text-info " style="font-family:courier,'new courier';font-weight:bold;"><?php echo tgl_indo($row['f_posting_date']);?> • <?php echo $row['f_posting_time'];?>  • HIT 0 • Coment 2</small>
				</h4>
					<?php echo $row['f_posting_text'];?>
				<h4>
					<small class="text-success" style="font-family:courier,'new courier';font-weight:bold;">Category <?php echo $row['f_category_name'];?> ; Tags <?php echo $row['f_posting_tag'];?></small>
				</h4>              
<!--            </div>
          </div>
          <hr>


          <!--/stories-->
        </div>
      </div>
   	</div><!--/col-12-->
  </div>
</div>

<script src="<?php echo ASSETS_URL;?>plugins/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
