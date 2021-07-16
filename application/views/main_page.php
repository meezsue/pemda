
<!DOCTYPE html>
<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>	
	<style type = "text/css">
		body, input, fieldset, legend { font-family: Tahoma; font-size: 12px}	
		#file_name, .file_dokumen { width:0; height:0; } 			
	</style>	
</head>
<body>
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <div id = "page-wrapper">
				<div class = "row">
					<div class = "col-md-12">
						<h1 class = "page-header">Dashboard</h1>
						<ol class = "breadcrumb">
							<li class = "active">
								<a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> Create Nota Dinas
							</li>
						</ol>
					</div>
				</div> 
				<!--
				<div class = "row">
					<div class = "col-md-12">
						<ul class = "nav nav-tabs">
						  <li class = "active"><a href = "#tab-1">Data Nota Dinas</a></li>
						  <li><a href = "#tab-2">Ceklist & Upload Dokumen</a></li>
						</ul>						
					</div>							
				</div> 


				<div class="tab-content">
					<div id="tab-1" class="tab-pane fade in active">
					  <h3>HOME</h3>
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					</div>
					<div id="tab-2" class="tab-pane fade">
					  <h3>Menu 1</h3>
					  <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div>
				!-->
				<?php $this->load->view('dashboard_skpd_view'); ?>
            </div>  
        </main>
    </div>
    <!-- /#wrapper -->
    
	<?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>	
</body>

</html>
