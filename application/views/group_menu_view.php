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
	
			var generate_group_menu	= function(){
				$.ajax({
					url			: base_url + 'pemda/generate_group_menu',
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(result){
						var data = [];
						var no 	 = 0;
						for(var i = 0 ; i < result.length ; i++) 
						{							
							no = no + 1;	
						    var button_detail = "<center><span class = 'zmdi zmdi-edit' style = 'cursor:pointer;'  title = 'EditMenu' onclick = \"EditMenu('"+result[i].group_menu_id+"');\"></span>&nbsp;&nbsp;<span class = 'zmdi zmdi-delete' style = 'cursor:pointer;'  title = 'Deletegroup' onclick = \"Deletegroup('"+result[i].group_menu_id+"');\"></span></center>";
						    data.push([no, result[i].group_menu_id, result[i].nama_group_menu,result[i].urut, result[i].create_user, result[i].create_date, button_detail] );
						}
						
						$('#dataTables-example').DataTable( {
							data            : data,
							deferRender     : true,
							processing      : true,
							ordering        : true,
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
			
			generate_group_menu();
			
			$("#btnAdd").click(function(){
				$("#groupModal").modal('show');
				
				$("#btnSave").hide();
				$("#btnAdd2").show();
				
				$("#txt_group_menu").attr('readonly', false);
				$("#txt_nama_group").attr('readonly', false);
				
				$("#txt_group_menu").css('background-color', 'white');
				$("#txt_nama_group").css('background-color', 'white');
			});  
			
		});
		
		function EditMenu(i){			

			var base_url	= '<?php echo base_url(); ?>';
			
			$("#groupModal").modal('show');
			$.ajax({
				url			: base_url + "pemda/generate_admin_group_menu",
				data		: {txt_id: i},
				type		: 'post',
				dataType 	: 'json',
				success : function(hasil){
					var group_menu_id	= hasil['group_menu_id']; 
					var nama_group_menu	= hasil['nama_group_menu'];
					var urut			= hasil['urut'];
					
					$("#div_name").html(nama_group_menu);
					$("#txt_group_menu").val(group_menu_id);
					$("#txt_nama_group").val(nama_group_menu);
					$("#txt_urut").val(urut);					
					
					
					$("#txt_nama_group").attr('readonly', false);
					$("#txt_nama_group").css('background-color', 'white');
					
					
					$("#btnSave").show();
					$("#btnAdd2").hide();
				}
			});
		} 
		
		function Deletegroup(i){			
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
						url			: base_url + "pemda/delete_admin_group_menu",
						type		: 'post',
						data		: {txt_id: i},
						dataType	: 'json',
						success : function(hasil){		
							swal({
									title: "Success!",
									text:  "Group Menu Has Been Delete",
									type:  "success",
									timer: 5000,
									showConfirmButton: true
							});
								
							window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000);
						}
					});
				});
											
			/* $.ajax({
				url			: base_url + "pemda/delete_admin_group_menu",
				data		: {txt_id: i},
				type		: 'post',
				dataType 	: 'json',
				success : function(hasil){
					swal({
                                title: "Success!",
                                text:  "Group Menu Has Been Delete",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                        });
							
					window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000); 					
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
					<h1 class = "page-header">List Group Menu</h1>
				</div>
			</div>
			<div class = "row">
				<div class = "col-lg-12">
					<div style = "float: right; margin-right: 1%"><button type = "button" class = "btn m-indigo" id = "btnAdd">Add</button></div>	
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
												<th>Group Menu</th>
												<th>Nama Group Menu</th>
												<th>Urutan</th>
												<th>Create User</th>
												<th>Created Date</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody id = "isi_group"></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('group_menu_modal_view'); ?>
		</div>
	<main>
</div>
	
	<?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>=	
</body>
</html>