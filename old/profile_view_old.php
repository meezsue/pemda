<?php echo $this->session->userdata('user_id'); ?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>		
	<style type = "text/css">
		body, input { font-family: Tahoma; font-size: 12px}					
		
		.circle {
			width					: 100%;
			height					: 150px;
			-moz-border-radius		: 50%; 
			-webkit-border-radius	: 50%; 
			border-radius			: 50%;
			background				: lightgreen;
		}
		
		#file_name { width:0; height:0; } 
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){
			$("#div_pic").hide();
			$(".circle").show();
			
			var user_id		= '<?php echo $this->session->userdata('user_id'); ?>';
			var base_url	= '<?php echo base_url(); ?>';
			
			var generate_profile = function(user_id){
				$.ajax({
					url			: base_url + "pemda/generate_profile",
					data		: {user_id: user_id},
					type		: 'post',
					dataType 	: 'json',
					success : function(hasil){
						
						var nama		= (hasil['nama']).toUpperCase();
						var username	= hasil['username'];
						var password	= hasil['password'];
						
						$("#div_name").html(nama);
						$("#txt_nama").val(nama);
						$("#txt_username").val(username);
						$("#txt_password").val(password);
						$("#txt_confirm_password").val(password);
						
						$(".circle").hide();
												
						$("#div_pic").show();
						
						var imgSrc = '<?php echo base_url(); ?>upload/'+hasil['foto'];						
						$('#blah').attr('src',imgSrc);
						
					}
				});
			}
			
			generate_profile();
			
			$('#btn-upload').click(function(e){
				e.preventDefault();
				$('#file_name').click();}
			);
			
			$("#formProfile").submit(function(e){
				var password			= $("#txt_password").val();
				var confirm_password	= $("#txt_confirm_password").val();

				if(password != confirm_password)
				{
					alert("Confirmation Password Is Not Equal With Password");
					return false;
				}
				else
				{
					$.ajax({
						url			: base_url + "pemda/edit_profile",
						type		: 'post',
						data		: {user_id: user_id, password: password, confirm_password: confirm_password},
						dataType	: 'json',
						success : function(hasil){							
							if(hasil)
							{	
								var formUrl     = base_url + 'pemda/edit_photo';
								var formData    = new FormData($('#formUpload')[0]);
								$.ajax({
									url         : formUrl,
									type        : 'POST',
									data        : formData,
									mimeType    : "multipart/form-data",
									contentType : false,
									cache       : false,
									processData : false,                                
									success: function(result){
										swal("Profile Has Been Update");
									}
								}); 
							}
						}
					});
				}
			});
		});	
		
		function readURL(input) {
			$(".circle").hide();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
				
				
				$("#div_pic").show();
            }
        }
	</script>
	
	<title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
	
	<link class = " jsbin" href = " http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel = " stylesheet" type = " text/css" />
	<script class = " jsbin" src = " http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script class = " jsbin" src = " http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	
</head>
<body>
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <div id = "page-wrapper">
				<div class = "row">
					<div class = "col-md-12">
						<h1 class = "page-header">View Profile</h1>
						<ol class = "breadcrumb">
							<li class = "active">
								<a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> View Profile
							</li>
						</ol>
					</div>
				</div> 
				<div class = "row">
					<div class = "col-md-3">
					<div class = "profile-sidebar box-shadow">
							<form id = "formUpload" enctype="multipart/form-data">
								<div class = "circle"></div>
								<div align = "center" class = "img-responsive center-block" id = "div_pic"><img src = '#' id = "blah" /></div>
								<p>
								<div class = "profile-username text-center" id = "div_name">
									
								</div>
								<p>
								<!--div class = "profile-button">
									<button type = "button" class = "btn btn-success btn-sm">Follow</button>
									<button type = "button" class = "btn btn-danger btn-sm">Message</button>
								</div!-->
								
								<input type='file' id='file_name' name='file_name' onchange = " readURL(this);" accept = "image/jpeg" />
								<button id='btn-upload' class = "btn btn-success btn-block">Upload</button>
							</form>
					</div>
					</div>
					<div class = "col-md-9">
						<div class = "panel box-shadow">
							<div class = "panel-body center-block">
								<form role = "form" id = "formProfile" method = "post" onsubmit = "return false">
									<fieldset>
										<div class = "form-group col-lg-12">
											<label>Nama Dinas</label>
											<input type = "text" class = "form-control" placeholder = "Nama Dinas" id = "txt_nama" value = "" readonly style = "background-color:lightgrey">
										</div>
										<div class = "form-group col-lg-12">
											<label>Username</label>
											<input type = "text" class = "form-control" placeholder = "Username" id = "txt_username" value = "" readonly style = "background-color:lightgrey" >
										</div>										
										<div class = "form-group col-lg-6">
											<label>Password</label>
											<input type = "password" class = "form-control" placeholder = "Password" id = "txt_password" value = "" >
										</div>
										<div class = "form-group col-lg-6">
											<label>Confirm Password</label>
											<input type = "password" class = "form-control" placeholder = "Confirm Password" id = "txt_confirm_password" value = "" >
										</div>										
										<button class = "btn btn-success btn-block" type = "submit">Update</button>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>  
        </main>
    </div>
    <!-- /#wrapper -->
    
	<?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>	
</body>

</html>
