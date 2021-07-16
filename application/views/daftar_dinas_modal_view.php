<script type = "text/javascript">
	$(document).ready(function(){
		var base_url		= '<?php echo base_url(); ?>';
		var txt_unitkey		= $("#txt_unitkey").val();
		var txt_kode_dinas	= $("#txt_kode_dinas").val();
		var txt_nama_dinas	= $("#txt_nama_dinas").val();
		
		$("#btnSave").click(function(){		
		
			var txt_unitkey		= $("#txt_unitkey").val();
			var txt_kode_dinas	= $("#txt_kode_dinas").val();
			var txt_nama_dinas	= $("#txt_nama_dinas").val();
	
			if(txt_unitkey == '')
			{
				swal({
						title: "Warning",
						text: "Input Unitkey First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else if(txt_kode_dinas == '')
			{
				swal({
						title: "Warning",
						text: "Input Kode Dinas First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else if(txt_nama_dinas == '')
			{
				swal({
						title: "Warning",
						text: "Input Nama Dinas First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else
			{
				$.ajax({
					url			: base_url + "pemda/update_admin_daftar_dinas",
					type		: 'post',
					data		: {txt_unitkey : txt_unitkey, txt_kode_dinas:txt_kode_dinas, txt_nama_dinas:txt_nama_dinas},
					dataType	: 'json',
					success : function(result){
						swal({
                                title: "Success!",
                                text:  "Group Menu Has Been Update",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/daftar_dinas'; } ,1000); 
					}
				});
			}			
		});
			
		$("#btnAdd2").click(function(){		
			if($("#txt_unitkey").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Unitkey First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else if($("#txt_kode_dinas").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Kode Dinas First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else if($("#txt_nama_dinas").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Nama Dinas First !",
						type: "warning",
						showCancelButton: false,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'OK',
						cancelButtonText: false,
						closeOnConfirm: false,
						closeOnCancel: false
					 });
					 
					return false;
			}
			else
			{
				$.ajax({
					url			: base_url + "pemda/cek_daftar_dinas_rows",
					type		: 'post',
					data		: {txt_unitkey: $("#txt_unitkey").val()},
					dataType	: 'json',
					success : function(result){
						if(result != 0){
							swal({
								title: "Failed!",
								text:  "Data Already Exists !",
								type:  "error",
								timer: 5000,
								showConfirmButton: true
							});
						}else{
							$.ajax({
									url			: base_url + "pemda/save_admin_daftar_dinas",
									type		: 'post',
									data		: {txt_unitkey: $("#txt_unitkey").val(), txt_kode_dinas: $("#txt_kode_dinas").val(), txt_nama_dinas: $("#txt_nama_dinas").val()},
									dataType	: 'json',
									success : function(result){
										swal({
												title: "Success!",
												text:  "Group Menu Has Been Create",
												type:  "success",
												timer: 5000,
												showConfirmButton: true
											});
											
										window.setTimeout(function(){ window.location.href = base_url + 'pemda/daftar_dinas'; } ,1000); 
									}
								});
						}
						
						
					}
				});
			}
		});
	});
</script>
<style type = "text/css">
	.modal-header{
		background :#3F51B5 !important;
	}
	.modal-content{
		background: #e6e6e6;
	}
	h4{
		color:white;
		padding-bottom: 15px;
	}
</style>
<div id = "DaftarDinasModal" class = "modal fade" role = "dialog" data-backdrop = "static" data-keyboard = "false">
	<div class = "modal-dialog modal-lg">

		<!-- Modal content-->
		<div class = "modal-content">
			<div class = "modal-header">
				<button type = "button" class = "close" data-dismiss = "modal" style = "color:white;top: -5px;right: -5px;">&times;</button>
				<h4 class = "modal-title" >Edit Daftar Dinas</h4>
			</div>
			<div class = "modal-body">
					<div class = "row">
						<div class = "col-md-12">
							<div class = "panel box-shadow">
								<div class = "panel-body center-block">
									<form role = "form" id = "formProfile" method = "post" onsubmit = "return false">
									<table class="table" style="width:100%">
										<tbody>
											<tr><td style="width:20%"><label>Unitkey</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Unitkey" id = "txt_unitkey" value = "" readonly style = "background-color:lightgrey"></td>
											</tr>
											<tr><td><label>Kode Dinas</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Kode Dinas" id = "txt_kode_dinas" value = "" readonly style = "background-color:lightgrey" ></td>
											</tr>
											<tr><td><label>Nama Dinas</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Nama Dinas" id = "txt_nama_dinas" value = ""></td>
											</tr>										
										</tbody>
									</table>																			
									</form>
								</div>
							</div>
						</div>
					</div>
				
					<div class = "modal-footer">									
						<button type = "button" class = "btn m-indigo" id = "btnSave">Save</button>					
						<button type = "button" class = "btn m-indigo" id = "btnAdd2">Save</button>					
					</div>				
			</div>					
		</div>
	</div>
</div>