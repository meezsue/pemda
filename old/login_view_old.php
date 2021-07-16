<?php site_url(); ?>
<!DOCTYPE html>
<html lang = "en">
<head> 
	<title>Login</title>
	<?php include("assets/component/top.php"); ?>	
	<script type = "text/javascript">
		$(document).ready(function(){
			var base_url = '<?php echo base_url();?>';
				
			$("form").submit(function(e){
			var username	= $("#username").val(),
				password	= $("#password").val();
				
				if($("#username").val() == '')
				{
					alert("Silakan Isi Username Terlebih Dahulu!");
					$("#username").focus();
					
					return false;									
				}				
				if($("#password").val() == '')
				{
					alert("Silakan Isi Password Terlebih Dahulu!");
					$("#password").focus();
					
					return false;									
				}
				else
				{

					$.ajax({
						url			: base_url + "pemda/validasi_login",	
						type		: 'POST',
						data		:  $("#formLogin").serialize(),
						dataType	: 'JSON',
						success : function(result){
							if(!result)
							{
								alert('Username atau password tidak terdaftar !');
								return false;
							}
							else
							{
								window.location.href = '<?php echo site_url('pemda/dasboard')?>';
							}
						}
					});
				}
			});
		});
	</script>
</head>
<body id = "pages">
<article>
<div id = "pages-form" class = "container animated fadeIn">
	<section>
	<div class = "row">
		<div class = "col-md-4 col-md-offset-4">
			<div class = "panel box-shadow">
				<div class = "panel-body center-block">
					<div class = "pages-header text-center">
						<div class = "pages-box-icon"><i class = "zmdi zmdi-account-o"></i></div>
						<h4>Login to your account</h4>
					</div>
					<form role = "form" id = "formLogin" method = "post" onsubmit = "return false">
					<fieldset>
						<div class = "form-group"><input class = "form-control" placeholder = "Username" name = "username" id = "username" type = "text" autofocus></div>
						<div class = "form-group"><input class = "form-control" placeholder = "Password" name = "password" id = "password" type = "password" value = ""></div>
						<!--div class = "row pages-padbot">
							<div class = "col-sm-6"><input name = "remember" type = "checkbox" value = "Remember">Remember</div>
							<div class = "col-sm-6 text-right"><a href = "../pages/forgot_password.html" title = "Forgot password?">Forgot password?</a></div>
						</div!-->

						<!-- Change this to a button or input when using this as a form -->
						<input class = "btn btn-success btn-block" id = "btnLogin" value = "Login" type = "submit">
						<p class = "text-center pages-padtop"></p>
					</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
</article>
<?php include("assets/component/footer.php"); ?>	
</body>
</html>
