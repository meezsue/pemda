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
	
			var generate_daftar_dinas	= function(){
				$.ajax({
					url			: base_url + 'pemda/generate_daftar_dinas',
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(result){
						var data = [];
						var no 	 = 0;
						for(var i = 0 ; i < result.length ; i++) 
						{							
							no = no + 1;	
						    var button_detail = "<center><span class = 'zmdi zmdi-edit' style = 'cursor:pointer;'  title = 'EditMenu' onclick = \"EditMenu('"+result[i].unitkey+"');\"></span>&nbsp;&nbsp;<span class = 'zmdi zmdi-delete' style = 'cursor:pointer;'  title = 'Deletegroup' onclick = \"Deletegroup('"+result[i].unitkey+"');\"></span></center>";
						    data.push([no, result[i].unitkey, result[i].kode_unit,result[i].nama_unit, result[i].create_user, result[i].create_date, button_detail] );
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
			
			generate_daftar_dinas();
			
			$("#btnAdd").click(function(){
				$("#DaftarDinasModal").modal('show');
				
				$("#btnSave").hide();
				$("#btnAdd2").show();
				
				$("#txt_unitkey").attr('readonly', false);
				$("#txt_kode_dinas").attr('readonly', false);
				
				$("#txt_unitkey").css('background-color', 'white');
				$("#txt_kode_dinas").css('background-color', 'white');
			});  
			
		});
		
		function EditMenu(i){			

			var base_url	= '<?php echo base_url(); ?>';
			
			$("#DaftarDinasModal").modal('show');
			$.ajax({
				url			: base_url + "pemda/generate_admin_daftar_dinas",
				data		: {txt_id: i},
				type		: 'post',
				dataType 	: 'json',
				success : function(hasil){
					var unitkey		= hasil['unitkey']; 
					var kode_unit	= hasil['kode_unit'];
					var nama_unit	= hasil['nama_unit'];
					
					$("#div_name").html(nama_unit);
					$("#txt_unitkey").val(unitkey);
					$("#txt_kode_dinas").val(kode_unit);
					$("#txt_nama_dinas").val(nama_unit);					
					
					
					$("#txt_nama_dinas").attr('readonly', false);
					$("#txt_nama_dinas").css('background-color', 'white');
					
					
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
						url			: base_url + "pemda/delete_admin_daftar_dinas",
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
								
							window.setTimeout(function(){ window.location.href = base_url + 'pemda/daftar_dinas'; } ,1000);
						}
					});
				});
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
					<h1 class = "page-header">Daftar Dinas</h1>
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
												<th>Unitkey</th>
												<th>Kode Dinas</th>
												<th>Nama Dinas</th>
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
			<?php $this->load->view('daftar_dinas_modal_view'); ?>
		</div>
	<main>
</div>
	
	<?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>=	
</body>
</html>