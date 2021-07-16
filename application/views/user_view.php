<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>	
	<style>
		body, table { font-family: Tahoma; font-size: 12px}	
		.page-header
		{
			border-bottom	: 2px solid #3F51B5 !important;
		}	
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){

			var base_url		= '<?php echo base_url(); ?>';
	
			var generate_user	= function(){
				$.ajax({
					url			: base_url + 'pemda/generate_user',
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(result){
						var data = [];
						var no 	 = 0;
						for(var i = 0 ; i < result.length ; i++) 
						{							
							no = no + 1;	
						    var button_detail = "<center><span class = 'zmdi zmdi-edit' style = 'cursor:pointer;'  title = 'Edituser' onclick = \"Edituser('"+result[i].user_id+"');\"></span>&nbsp;&nbsp;<span class = 'zmdi zmdi-delete' style = 'cursor:pointer;'  title = 'Deleteuser' onclick = \"Deleteuser('"+result[i].user_id+"');\"></span></center>";
						    data.push([no, result[i].username, result[i].nama, result[i].create_date, button_detail] );
						}
						
						$('#dataTables-example').DataTable( {
							data            : data,
							deferRender     : true,
							processing      : true,
							ordering        : false,
							retrieve        : false,
							paging          : true,
							"bDestroy"      : true,
							"autoWidth"     : false,
							"deferLoading"  : 57,
							"bFilter"       : true,
							"sFilter"       : "dataTables_filter custom_filter_class",
							"sLength"       : "dataTables_length custom_length_class"
					   });                   
				    },
				    beforeSend: function(){
				   
				    },
				    complete: function(){

				    }						
				});
			}
			
			generate_user();
			
			$("#btnAddUser").click(function(){
				$("#userModal").modal('show');
				
				$("#btnSaveProfile").hide();
				$("#btnAddProfile").show();
				
				$("#txt_nama").attr('readonly', false);
				$("#txt_username").attr('readonly', false);
				
				$("#txt_nama").css('background-color', 'white');
				$("#txt_username").css('background-color', 'white');
			});
			
		});
		
		function Edituser(i){			

			var base_url	= '<?php echo base_url(); ?>';
			
			$("#userModal").modal('show');
			$.ajax({
				url			: base_url + "pemda/generate_admin_profile",
				data		: {user_id: i},
				type		: 'post',
				dataType 	: 'json',
				success : function(hasil){
					
					var nama		= (hasil['nama']).toUpperCase();
					var username	= hasil['username'];
					var password	= hasil['password'];
					
					$("#div_name").html(nama);
					$("#txt_nama").val(nama);
					$("#txt_username").val(username);					
					
					$("#btnSaveProfile").show();
					$("#btnAddProfile").hide();
				}
			});
		}
		
		function Deleteuser(i){			
			var base_url	= '<?php echo base_url(); ?>';
			
			swal({
				  title: "Confirmation",
				  text: "Are you sure to delete this row?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#3F51B5 !important",
				  confirmButtonText: "Yes",
				  cancelButtonText: "No",
				  closeOnConfirm: false
				},
				function(){
					$.ajax({
						url			: base_url + "pemda/delete_admin_profile",
						type		: 'post',
						data		: {user_id: i},
						dataType	: 'json',
						success : function(hasil){		
							swal({
									title: "Success!",
									text:  "User Has Been Delete",
									type:  "success",
									timer: 5000,
									showConfirmButton: true
							});
								
							window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000);
						}
					});
				});
						
			/* $.ajax({
				url			: base_url + "pemda/delete_admin_profile",
				data		: {user_id: i},
				type		: 'post',
				dataType 	: 'json',
				success : function(hasil){
					
					swal({
                                title: "Success!",
                                text:  "User Has Been Delete",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                        });
							
					window.setTimeout(function(){ window.location.href = base_url + 'pemda/user'; } ,1000); 					
				}
			}); */
		}
	</script>
</head>
<body>
<div id = "wrapper">
	<?php include("header_view.php"); ?>
	<?php include("side_view.php"); ?>
	
	<main>
		<div id = "page-wrapper">
			<div class = "row">
				<div class = "col-md-12">
					<h1 class = "page-header">List User</h1>
				</div>
			</div>
			<div class = "row">
				<div class = "col-lg-12">
					<div style = "float: right; margin-right: 1%"><button type = "button" class = "btn m-indigo" id = "btnAddUser">Add</button></div>	
				</div>
			</div>
			<div class = "row">
				<div class = "col-lg-12">
					<div class = "panel-body">
						<div class = "row">
							<div class = "col-lg-12">														
								<div class="panel panel-default">
									<div class="panel-heading">
										<table style="width:100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th>No</th>
												<th>UserName</th>
												<th>Name</th>
												<th>Created Date</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody id = "isi_users"></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('user_modal_view'); ?>
		</div>
	<main>
</div>
	
	<?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>=	
</body>
</html>