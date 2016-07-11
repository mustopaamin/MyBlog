<?php
$this->load->view('webadmin/header');
$this->load->view('webadmin/sidebar');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php
$this->load->view($content);
echo "</div><!-- /.content-wrapper -->";
$this->load->view('webadmin/footer');
?>
