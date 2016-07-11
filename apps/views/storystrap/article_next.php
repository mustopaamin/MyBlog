<div class="container">
  <div class="row">
    
    <div class="col-md-12"> 
      
      <div class="panel">
        <div class="panel-body">
          
          
          
          <!--/stories-->
			<?php
            foreach($list as $r)
            {
				$isi_berita = strip_tags($r->f_posting_text); // membuat paragraf pada isi berita dan mengabaikan tag html
				$isi = substr($isi_berita,0,250); // ambil sebanyak 100 karakter
				$isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
				$html = "
			<div class=\"row\">
	            <br>
	            <div class=\"col-md-2 col-sm-3 text-center\">
					<a class=\"story-title\" href=\"javascript:void(0);\"><img alt=\"\" src=\"".$r->f_posting_image."\" style=\"width:100px;height:100px\" class=\"img-circle\"></a>
				</div>
				<div class=\"col-md-10 col-sm-9\">
					<h3>".$r->f_posting_name."</h3>
					<h4>
					<small style=\"font-family:courier,'new courier';font-weight:bold;\" class=\"text-info \">".tgl_indo($r->f_posting_date)." • ".$r->f_posting_time."  • HIT ".$r->f_posting_read." • Coment 2</small>
					</h4>
					<div class=\"row\">
						<div class=\"col-xs-9\">
							<p>".$isi." ... <a href=\"#\" class=\"text-muted btn btn-info btn-xs\">Read More>> </a></p>
							<h4>
							<small style=\"font-family:courier,'new courier';font-weight:bold;\" class=\"text-success\">Category ".$r->f_category_name." ; Tags ".$r->f_posting_tag."</small>
							</h4>
						</div>
						<div class=\"col-xs-3\"></div>
					</div>
				</div>
			</div>
			<hr/>";
				echo $html;	
				
			}
            ?>

          <!--/stories-->
          <div class="row" align="center">
			  <?php echo $pagination;?>
          </div>
          
        </div>
      </div>
   	</div><!--/col-12-->
  </div>
</div>

