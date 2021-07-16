<script type = "text/javascript">
	$(document).ready(function(){
		var base_url	= '<?php echo base_url(); ?>';
		var txt_group_menu	= $("#txt_group_menu").val();
		var txt_nama_group	= $("#txt_nama_group").val();
		var txt_urut	= $("#txt_urut").val();
		
		$("#btnSave").click(function(){		
		
			var txt_group_menu	= $("#txt_group_menu").val();
			var txt_nama_group	= $("#txt_nama_group").val();
			var txt_urut	= $("#txt_urut").val();
	
			if(txt_group_menu == '')
			{
				swal({
						title: "Warning",
						text: "Input Group Menu First !",
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
			else if(txt_nama_group == '')
			{
				swal({
						title: "Warning",
						text: "Input Group Menu Nama First !",
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
			else if(txt_urut == '')
			{
				swal({
						title: "Warning",
						text: "Input Urutan First !",
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
					url			: base_url + "pemda/update_admin_group_menu",
					type		: 'post',
					data		: {txt_group_menu : txt_group_menu, txt_nama_group:txt_nama_group, txt_urut:txt_urut},
					dataType	: 'json',
					success : function(result){
						swal({
                                title: "Success!",
                                text:  "Group Menu Has Been Update",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000); 
					}
				});
			}			
		});
			
		$("#btnAdd2").click(function(){		
			if($("#txt_group_menu").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Group Menu First !",
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
			else if($("#txt_nama_group").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Group Menu Nama First !",
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
			else if($("#txt_urut").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Urutan First !",
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
					url			: base_url + "pemda/cek_group_menu_rows",
					type		: 'post',
					data		: {txt_group_menu: $("#txt_group_menu").val()},
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
									url			: base_url + "pemda/save_admin_group_menu",
									type		: 'post',
									data		: {txt_group_menu: $("#txt_group_menu").val(), txt_nama_group: $("#txt_nama_group").val(), txt_urut: $("#txt_urut").val()},
									dataType	: 'json',
									success : function(result){
										swal({
												title: "Success!",
												text:  "Group Menu Has Been Create",
												type:  "success",
												timer: 5000,
												showConfirmButton: true
											});
											
										window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000); 
									}
								});
						}
						
						
					}
				});
				/* $.ajax({
					url			: base_url + "pemda/save_admin_group_menu",
					type		: 'post',
					data		: {txt_group_menu: $("#txt_group_menu").val(), txt_nama_group: $("#txt_nama_group").val(), txt_urut: $("#txt_urut").val()},
					dataType	: 'json',
					success : function(result){
						swal({
								title: "Success!",
								text:  "Group Menu Has Been Create",
								type:  "success",
								timer: 5000,
								showConfirmButton: true
							});
							
						window.setTimeout(function(){ window.location.href = base_url + 'pemda/group_menu'; } ,1000); 
					}
				}); */
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
<div id = "groupModal" class = "modal fade" role = "dialog" data-backdrop = "static" data-keyboard = "false">
	<div class = "modal-dialog modal-lg">

		<!-- Modal content-->
		<div class = "modal-content">
			<div class = "modal-header">
				<button type = "button" class = "close" data-dismiss = "modal" style = "color:white;top: -5px;right: -5px;">&times;</button>
				<h4 class = "modal-title" >Edit Group Menu</h4>
			</div>
			<div class = "modal-body">
					<div class = "row">
						<div class = "col-md-12">
							<div class = "panel box-shadow">
								<div class = "panel-body center-block">
									<form role = "form" id = "formProfile" method = "post" onsubmit = "return false">
									<table class="table" style="width:100%">
										<tbody>
											<tr><td style="width:20%"><label>Group Menu</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Group Menu" id = "txt_group_menu" value = "" readonly style = "background-color:lightgrey"></td>
											</tr>
											<tr><td><label>Nama Group Menu</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Nama Group Menu" id = "txt_nama_group" value = "" readonly style = "background-color:lightgrey" ></td>
											</tr>
											<tr><td><label>Urutan</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Urutan" id = "txt_urut" value = "" onkeyup="this.value=this.value.replace(/[^\d]/,'')"></td>
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