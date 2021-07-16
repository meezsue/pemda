<script type = "text/javascript">
	$(document).ready(function(){
		var base_url	= '<?php echo base_url(); ?>';
		var username	= $("#txt_username").val();
		var password	= $("#txt_password").val();
		var c_password	= $("#txt_confirm_password").val();
		$("#btnSaveProfile").click(function(){			
			if($("#txt_password").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Confirmation Password First !",
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
			else if($("#txt_confirm_password").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Confirmation Password First !",
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
			else if($("#txt_password").val() != $("#txt_confirm_password").val())
			{
				swal({
						title: "Warning",
						text: "Confirmation Password Is Not Equal With Password",
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
					url			: base_url + "pemda/update_admin_profile",
					type		: 'post',
					data		: {password: $("#txt_password").val(), username: $("#txt_username").val()},
					dataType	: 'json',
					success : function(result){
						swal({
                                title: "Success!",
                                text:  "User Has Been Update",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/user'; } ,1000); 
					}
				});
			}			
		});
			
		$("#btnAddProfile").click(function(){			
			if($("#txt_nama").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Name Field First !",
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
			else if($("#txt_username").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Username Field First !",
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
			else if($("#txt_password").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Confirmation Password First !",
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
			else if($("#txt_confirm_password").val() == '')
			{
				swal({
						title: "Warning",
						text: "Input Confirmation Password First !",
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
			else if($("#txt_password").val() != $("#txt_confirm_password").val())
			{
				swal({
						title: "Warning",
						text: "Confirmation Password Is Not Equal With Password",
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
					url			: base_url + "pemda/save_admin_profile",
					type		: 'post',
					data		: {nama: $("#txt_nama").val(), username: $("#txt_username").val(), password: $("#txt_password").val(), username: $("#txt_username").val()},
					dataType	: 'json',
					success : function(result){
						swal({
								title: "Success!",
								text:  "User Has Been Create",
								type:  "success",
								timer: 5000,
								showConfirmButton: true
							});
							
						window.setTimeout(function(){ window.location.href = base_url + 'pemda/user'; } ,1000); 
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
<div id = "userModal" class = "modal fade" role = "dialog" data-backdrop = "static" data-keyboard = "false">
	<div class = "modal-dialog modal-lg">

		<!-- Modal content-->
		<div class = "modal-content">
			<div class = "modal-header">
				<button type = "button" class = "close" data-dismiss = "modal" style = "color:white;top: -5px;right: -5px;">&times;</button>
				<h4 class = "modal-title"  >Edit User</h4>
			</div>
			<div class = "modal-body">
					<div class = "row">
						<div class = "col-md-12">
							<div class = "panel box-shadow">
								<div class = "panel-body center-block">
									<form role = "form" id = "formProfile" method = "post" onsubmit = "return false">
									<table class="table" style="width:100%">
										<tbody>
											<tr><td style="width:20%"><label>Nama Dinas</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Nama Dinas" id = "txt_nama" value = "" readonly style = "background-color:lightgrey"></td>
											</tr>
											<tr><td><label>Username</label></td>
												<td><input type = "text" class = "form-control" placeholder = "Username" id = "txt_username" value = "" readonly style = "background-color:lightgrey" ></td>
											</tr>
											<tr><td><label>Password</label></td>
												<td><input type = "password" class = "form-control" placeholder = "Password" id = "txt_password" value = "" ></td>
											</tr>
											<tr><td><label>Confirm Password</label>
												<td><input type = "password" class = "form-control" placeholder = "Confirm Password" id = "txt_confirm_password" value = "" ></td>
											</tr>	

											<tr><td><label>tes</label>
												<td> <div class="form-group">
                                                        <select id="disabledSelect" class="form-control">
                                                            <option>Disabled select</option>
															<option>Disabled select2</option>
                                                        </select>
                                                    </div></td>
											</tr>
										</tbody>
									</table>																			
									</form>
								</div>
							</div>
						</div>
					</div>
				
					<div class = "modal-footer">									
						<button type = "button" class = "btn m-indigo" id = "btnSaveProfile">Save</button>					
						<button type = "button" class = "btn m-indigo" id = "btnAddProfile">Save</button>					
					</div>				
			</div>					
		</div>
	</div>
</div>