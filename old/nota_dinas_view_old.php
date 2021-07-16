<?php
	if(!isset($_SESSION)) 
    { 
        //header('Location:'.echo base_url().'pemda/index');
    }	
?>
<?php
	if($id == '')
	{
?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>		
	<style type = "text/css">
		body, input, fieldset, legend { font-family: Tahoma; font-size: 12px}	
		#file_name, .file_dokumen { width:0; height:0; } 			
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){
			var x 	= 1,
				max	= 6;
			
			var base_url	= '<?php echo base_url(); ?>';
				
			var generate_dinas = function(){
				$.ajax({
					url			: base_url + "pemda/generate_dinas",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						$("#txt_kode_unit2").val(hasil['unitkey']);
						$("#txt_kode_unit").val(hasil['kode_unit']);
						$("#txt_nama_unit").val(hasil['nama_unit']);
					}
				})
			},
			
			generate_nota_dinas = function(id_jenis){
				var jenis, bulan, tahun, nomor, no_nota_dinas;
				if(id_jenis == 0)
				{
					jenis = 'PB';
				}
				else
				{
					jenis = 'KB';
				}
				
				bulan	= '<?php echo date('n'); ?>';
				bulan2	= '<?php echo date('m'); ?>';
				tahun	= '<?php echo date('Y'); ?>';
				
				$.ajax({
					url			: base_url + "pemda/cek_num_rows",
					data		: {bulan: bulan, tahun: tahun},
					type		: 'post',
					dataType	: 'json',
					success : function(hasil){						
						if(hasil == 0)
						{
							nomor 			= 1;
							no_nota_dinas	= jenis + '/' + tahun + '/' + bulan2 + '/' + zeroPad(nomor, 5);																					
						}
						else
						{
							nomor			= parseInt(hasil) + 1;
							no_nota_dinas	= jenis + '/' + tahun + '/' + bulan2 + '/' + zeroPad(nomor, 5);	
						}
						
						$("#txt_nota_dinas").val(no_nota_dinas);
						$("#txt_nota_dinas_ext").val(no_nota_dinas);
						$("#txt_nota_dinas_ext1").val(no_nota_dinas);
					}
				})
			},
			
			generate_file_code = function(file_code, nama, revisi){
				$.ajax({
					url			: base_url + "pemda/generate_file_code",
					data		: {file_code: file_code},
					type		: 'post',
					dataType	: 'json',
					success : function(hasil){
						var new_file_code	= hasil['upload_file_code'];
						var dokumen_name	= new_file_code + '_' + nama + '_' + revisi;
						
						$("#txt_dokumen1").val(dokumen_name);
					}
				})
			},
			
			generate_file_code_lampiran = function(file_code, nama, revisi, x){
				$.ajax({
					url			: base_url + "pemda/generate_file_code",
					data		: {file_code: file_code},
					type		: 'post',
					dataType	: 'json',
					success : function(hasil){
						var new_file_code	= hasil['upload_file_code'];
						var dokumen_name	= new_file_code + '_' + nama + '_' + revisi;
						
						$("#txt_dokumen"+x).val(dokumen_name);
					}
				})
			}						
			
			$("#datecustom").val('<?php echo date('d-m-Y'); ?>');
			
			$('#txt_scan_nota_dinas').click(function(e){
				e.preventDefault();
				$('#file_name').click();
			});			
			
			$('#file_name').change(function(){
				var ukuran	= this.files[0];
				if(ukuran > 5120)
				{
					alert("Maximum : 5MB");
					return false;
				}
				$('#txt_scan_nota_dinas').val($(this).val().split('\\').pop());
			})
			
			$("#btnupload").click(function(e){
				e.preventDefault();			
				if(x < max)
				{
					x++;
					$(".input_fields_wrap").append("<div class = 'form-group col-lg-6' id = 'div_add_dokumen_"+x+"'><input type = 'text' class = 'form-control txt_dokumen' txt_dokumen = '"+x+"' name = 'txt_dokumen[]' id = 'txt_dokumen"+x+"'><input type = 'hidden' class = 'form-control txt_dokumen_ext' txt_dokumen_ext = '"+x+"' name = 'txt_dokumen_ext[]' id = 'txt_dokumen_ext"+x+"'><input type='file' id='file_dokumen_"+x+"' name='myfile[]' file_dokumen ='"+x+"' class = 'file_dokumen' onchange = 'readURL(this);' accept = 'image/jpeg, application/pdf' multiple='' />");																								
					
					$('#txt_dokumen'+x).click(function(e){
						e.preventDefault();						
						$('#file_dokumen_'+x).click();
					});			
					
					$('#file_dokumen_'+x).change(function(){						
						var ukuran	= this.files[0];
						if(ukuran > 5120)
						{
							alert("Maximum : 5MB");
							return false;
						}
						
						$('#txt_dokumen_ext'+x).val($(this).val().split('\\').pop());
						
						var lamp 		= 'LAMP'
						var i			= x - 1;
						var file_code	= lamp + i;
						var nama	= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
						var revisi	= 0;
						
						generate_file_code_lampiran(file_code, nama, revisi, x);						
					})	
				}	
			});
			
			$('#txt_dokumen1').click(function(e){
				e.preventDefault();
				if($("#txt_nota_dinas").val() == '')
				{
					alert('Pilih Jenis Dokumen Terlebih Dahulu !');
					return false;
				}
				else
				{
					$('#file_dokumen_1').click();
				}
			});			
			
			$('#file_dokumen_1').change(function(){
				var ukuran	= this.files[0];
				if(ukuran > 5120)
				{
					alert("Maximum : 5MB");
					return false;
				}
				
				$('#txt_dokumen_ext1').val($(this).val().split('\\').pop());
								
				var jenis	= $('input[type=radio][name=optJenis]:checked').val();
				var nama	= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
				var revisi	= 0;
				
				if(jenis == 0)
				{
					var file_code = 'PERBUP';
				}
				else
				{
					var file_code = 'KEPBUP';
				}
				
				generate_file_code(file_code, nama, revisi);
			})						
			
			$('input[type=radio][name=optJenis]').change(function() {
				var id_jenis	= $(this).val();
				generate_nota_dinas(id_jenis);		
			});
			
			$("#btnSave").click(function(){
				var txt_unit	= $("#txt_kode_unit2").val();
				var txt_jenis	= $('input[type=radio][name=optJenis]:checked').val();
				var txt_tgl		= $("#datecustom").val();
				var txt_no_nota	= $("#txt_nota_dinas").val();
				var txt_perihal	= $("#txt_perihal").val();
				var txt_scan	= $("#txt_scan_nota_dinas").val();
				var txt_doc		= $(".txt_dokumen").val();
				
				if(txt_perihal == '')
				{
					alert("Input Perihal Terlebih Dahulu !");
					return false;
				}
				else if(txt_scan == '')
				{
					alert("Input Scan Nota Dinas Terlebih Dahulu !");
					return false;				
				}
				else if(txt_doc == '')
				{
					alert("Input Dokumen Pendukung Terlebih Dahulu !");
					return false;				
				}
				else
				{	
					$.ajax({
						url			: base_url + 'pemda/save_nota_dinas',
						type		: 'post',
						data		: {txt_unit : txt_unit, txt_jenis: txt_jenis, txt_tgl: txt_tgl,
									   txt_no_nota: txt_no_nota, txt_perihal: txt_perihal},
					    dataType	: 'json',
						success : function(hasil){
							if(hasil)
							{
								var formUrl     = base_url + 'pemda/save_doc_nota_dinas';
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
										if(result)
										{
											var formUrl     = base_url + 'pemda/save_document';
											var formData    = new FormData($('#formPendukung')[0]);
											$.ajax({
												url         : formUrl,
												type        : 'POST',
												data        : formData,
												mimeType    : "multipart/form-data",
												contentType : false,
												cache       : false,
												processData : false,                                
												success: function(result){
													if(result){
														swal("Dokumen Telah Tersimpan !");
														window.location.href = base_url + 'pemda/dasboard';
													}
												}
											}); 	
										}
									}
								});							
							}
						}
					})												
				}				
			})
			
			generate_dinas();
		});
		
		function zeroPad(num, places) {
		  var zero = places - num.toString().length + 1;
		  return Array(+(zero > 0 && zero)).join("0") + num;
		}
	</script>
	
	<title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
</head>
<body>
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <div id = "page-wrapper">
				<div class = "row">
					<div class = "col-md-12">
						<h1 class = "page-header">Create Nota Dinas</h1>
						<ol class = "breadcrumb">
							<li class = "active">
								<a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> Create Nota Dinas
							</li>
						</ol>
					</div>
				</div> 
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class = "col-lg-12">	
									<form role = "form" id = "formNota" method = "post" onsubmit = "return false">																	
										<div class = "card card-block">
											<div class = "card-title"><h4>Data Nota Dinas</h4></div>
											<div class = "form-group col-lg-2">
												<label>Dinas</label>
												<input type = "hidden" class = "form-control" name = "txt_kode_unit2" id = "txt_kode_unit2" readonly style = "background-color: lightgrey">
												<input type = "text" class = "form-control" name = "txt_kode_unit" id = "txt_kode_unit" readonly style = "background-color: lightgrey">
											</div>	
											<div class = "form-group col-lg-10">
												<label>&nbsp;</label>
												<input type = "text" class = "form-control" name = "txt_nama_unit" id = "txt_nama_unit" readonly style = "background-color: lightgrey">
											</div>																																	
														
											<div class = "form-group col-lg-2">
												<label>Jenis</label>
												<label>&nbsp;</label>
											</div>	
											<div class = "form-group col-lg-2">											
												<input type = "radio" name = "optJenis" id = "optJenis" value = "0">Perbup
											</div>	
											<div class = "form-group col-lg-2">
												<input type = "radio" name = "optJenis" id = "optJenis" value = "1">Kepbup
											</div>		
											<div class = "form-group col-md-7"></div>	
											
											<div class = "form-group col-lg-6">
												<label>Tanggal Pengajuan</label>
												<div class = 'input-group'>
													<input type = 'text' class = "form-control" id = 'datecustom'/>
													<span class = "input-group-addon">
													<span class = "zmdi zmdi-calendar-note"></span>
													</span>
												</div>
											</div>		

											<div class = "form-group col-lg-6">
												<label>No. Nota Dinas</label>
												<input type = "text" class = "form-control" name = "txt_nota_dinas" id = "txt_nota_dinas" readonly style = "background-color: lightgrey">
											</div>	
											
											<div class = "form-group col-lg-12">
												<label>Perihal</label>
												<textarea class = "form-control" name = "txt_perihal" id = "txt_perihal"></textarea>
											</div>	
										</form>												
									</div>	
									<div class = "col-lg-12">	
										<fieldset>
											<legend><strong> Scan Nota Dinas </strong></legend>											
											<form id = "formUpload" enctype="multipart/form-data">
												<div class = "form-group col-lg-12">															
														<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext" id = "txt_nota_dinas_ext" readonly style = "background-color: lightgrey">
														<input type = "text" class = "form-control" name = "txt_scan_nota_dinas" id = "txt_scan_nota_dinas">	
														<input type='file' id='file_name' name='file_name' onchange = " readURL(this);" accept = "image/jpeg, application/pdf"/>												
												</div>											
											</form>											
										</fieldset>
									</div>	
									<form id = "formPendukung" enctype="multipart/form-data">
										<div class = "col-lg-12">	
											<fieldset>
												<legend><strong> Dokumen Pengajuan Perbup / Kepbup </strong></legend>
												<div class="input_fields_wrap">												
													<div class = "form-group col-lg-6" id = "div_add_dokumen_1">												
														<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext1" id = "txt_nota_dinas_ext1" readonly style = "background-color: lightgrey">
														<input type = "text" class = "form-control txt_dokumen" txt_dokumen = "1" name = "txt_dokumen[]" id = "txt_dokumen1" />	
														<input type = "hidden" class = "form-control txt_dokumen_ext" txt_dokumen_ext = "1" name = "txt_dokumen_ext[]" id = "txt_dokumen_ext1" />	
														<input type='file' id='file_dokumen_1' file_dokumen = '1' name='myfile[]' class = 'file_dokumen' onchange = " readURL(this);" accept = "image/jpeg, application/pdf" multiple=""  />														
													</div>												
												</div>
												<div class = "form-group col-lg-6">	
													<input id='btnupload' class = "btn btn-md btn-secondary" value = "Add" type = "button">
												</div>												
											</fieldset>
										</div>
									</form>
										<p><p>
										<center>
											<div class = "form-group col-lg-12">
												<input class = "btn btn-lg btn-success" id = "btnSave" value = "Save" type = "submit">
												<input class = "btn btn-lg btn-primary" id = "btnSubmit" value = "Submit" type = "submit">
											</div>
										</center>																			
									
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
</body

</html>
<?php
	}
	else
	{
		'edit';
		if($this->session->userdata('unit_key') == '2_')
		{
?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>		
	<style type = "text/css">
		body, input, fieldset, legend { font-family: Tahoma; font-size: 12px}	
		#file_name, .file_dokumen { width:0; height:0; } 	
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){							
			var base_url	= '<?php echo base_url(); ?>';
			var id			= '<?php echo $id; ?>';
			var j 			= $(".txt_jml").val();
			
			var generate_dinas = function(){
				$.ajax({
					url			: base_url + "pemda/generate_dinas",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						$("#txt_kode_unit2").val(hasil['unitkey']);
						$("#txt_kode_unit").val(hasil['kode_unit']);
						$("#txt_nama_unit").val(hasil['nama_unit']);
					}
				})
			},
			
			generate_nota_dinas_by_id	= function(){
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_by_id",
					type		: 'post',
					data		: {id: id},
					dataType	: 'json',
					success : function(result){
						$("input[type=radio]").attr('disabled', true); 
						$("input[name=optJenis][value=" + result['jns_nota_dinas'] + "]").prop('checked', true);
						$("#datecustom").val(result['tgl_nota_dinas']);
						$("#txt_nota_dinas").val(result['no_nota_dinas']);						
						$("#txt_nota_dinas_ext1").val(result['no_nota_dinas']);
						$("#txt_perihal").val(result['perihal']);
						$("#txt_scan_nota_dinas_old").val(result['nota_dinas_doc']);
						$("#txt_scan_nota_dinas").val(result['nota_dinas_doc']);						
						
						generate_nota_dinas_document(result['no_nota_dinas'])
					}					
				})								
			},
			
			generate_nota_dinas_document = function(no_nota_dinas){
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_document",
					type		: 'post',
					data		: {no_nota_dinas: no_nota_dinas},
					dataType	: 'json',
					success : function(result){						
						for(var i = 0; i < result.length; i++)
						{
							var panjang	 	= (result[i].file).length;
							var file_name	= (result[i].file).substring(14,panjang);							
							var x			= i + 1;							
							var dokumen	 = '<div class = "form-group col-lg-6 div_add_dokumen" id = "div_add_dokumen_'+file_name+'">';
								dokumen	+= '<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext'+x+'" id = "txt_nota_dinas_ext'+x+'" readonly style = "background-color: lightgrey" value = "'+no_nota_dinas+'">';	
								dokumen += '<div class = "input-group div_dokumen"><input type = "text" class = "form-control txt_dokumen" txt_dokumen = "'+x+'" name = "txt_dokumen[]" id = "txt_dokumen'+x+'" value = "'+file_name+'" /><span class = "input-group-addon"><span class = "zmdi zmdi-minus" id = "span_remove_'+x+'" span_remove = "'+file_name+x+'" style = "cursor: pointer"></span></span></div>';
								dokumen += '<input type = "hidden" class = "form-control txt_dokumen_ext" txt_dokumen_ext = "'+x+'" name = "txt_dokumen_ext[]" id = "txt_dokumen_ext'+x+'" value = "'+file_name+'" />';
								dokumen += '<input type= "file" id = "file_dokumen_'+x+'" file_dokumen = "'+x+'" name= "myfile[]" class = "file_dokumen" onchange = " readURL(this);" accept = "image/jpeg, application/pdf" multiple=""  />';
								dokumen	+= '</div>';							
							$(".input_fields_wrap").append(dokumen);	
							
							count_div();							

							$("#span_remove_"+x).click(function(){									
								$(this).parent().parent().parent().remove();								
								count_div();							
								var file	= $(this).attr("span_remove");								
								$.ajax({
									url			: base_url + "pemda/delete_dokumen",
									type		: 'post',
									data		: {no_nota_dinas: no_nota_dinas, file: file},
									dataType	: 'json',
									success : function(hasil){										
									}
								});
							});
						}
					}					
				})					
			},
			
			count_div = function(){
				var y  	= $(".input_fields_wrap").children('div').children('div').length;	
				$("#txt_jml").val(y);
			},
			
			generate_file_code = function(file_code, nama, revisi){
				$.ajax({
					url			: base_url + "pemda/generate_file_code",
					data		: {file_code: file_code},
					type		: 'post',
					dataType	: 'json',
					success : function(hasil){
						var new_file_code	= hasil['upload_file_code'];
						var dokumen_name	= new_file_code + '_' + nama + '_' + revisi;
						
						$("#txt_dokumen1").val(dokumen_name);
					}
				})
			},
			
			generate_file_code_lampiran = function(file_code, nama, revisi, x){
				$.ajax({
					url			: base_url + "pemda/generate_file_code",
					data		: {file_code: file_code},
					type		: 'post',
					dataType	: 'json',
					success : function(hasil){
						var new_file_code	= hasil['upload_file_code'];
						var dokumen_name	= new_file_code + '_' + nama + '_' + revisi;
						
						$("#txt_dokumen"+x).val(dokumen_name);
					}
				})
			}			
			
			$('#txt_scan_nota_dinas').click(function(e){
				e.preventDefault();
				$('#file_name').click();
			});			
			
			$('#file_name').change(function(){
				var ukuran	= this.files[0];
				if(ukuran > 5120)
				{
					alert("Maximum : 5MB");
					return false;
				}
				$('#txt_scan_nota_dinas').val($(this).val().split('\\').pop());
			})		

			
			$("#btnupload").click(function(){
				
				alert(j);
				if($("#txt_jml").val() == 0)
				{
					max = 6;
				}
				else if($("#txt_jml").val() == 1)
				{
					max = 5;
				}
				else if($("#txt_jml").val() == 2)
				{
					max = 4;
				}
				else if($("#txt_jml").val() == 3)
				{
					max = 3;
				}
				else if($("#txt_jml").val() == 4)
				{
					max = 2;
				}
				else if($("#txt_jml").val() == 5)
				{
					max = 1;
				}
				else if($("#txt_jml").val() == 6)
				{
					max = 0;
				}
				
				
				if(j < max)
				{	
					var y = j;
					y++;
					alert(y);
					$(".input_fields_wrap").append("<div class = 'form-group col-lg-6' id = 'div_add_dokumen_"+y+"'><input type = 'text' class = 'form-control txt_dokumen' txt_dokumen = '"+y+"' name = 'txt_dokumen[]' id = 'txt_dokumen"+y+"'><input type = 'hidden' class = 'form-control txt_dokumen_ext' txt_dokumen_ext = '"+y+"' name = 'txt_dokumen_ext[]' id = 'txt_dokumen_ext"+y+"'><input type='file' id='file_dokumen_"+y+"' name='myfile[]' file_dokumen ='"+y+"' class = 'file_dokumen' onchange = 'readURL(this);' accept = 'image/jpeg, application/pdf' multiple='' />");																								
										
					$('.txt_dokumen').click(function(e){						
						var i	= $(this).attr('txt_dokumen');		
						alert(i);	
						e.preventDefault();						
						$('#file_dokumen_'+y).click();
					});			
					
					$('#file_dokumen_'+y).change(function(){						
						var ukuran	= this.files[0];
						if(ukuran > 5120)
						{
							alert("Maximum : 5MB");
							return false;
						}
						
						if(y == 1)
						{
							$('#txt_dokumen_ext1').val($(this).val().split('\\').pop());
								
							var jenis	= $('input[type=radio][name=optJenis]:checked').val();
							var nama	= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
							var revisi	= 0;
							
							if(jenis == 0)
							{
								var file_code = 'PERBUP';
							}
							else
							{
								var file_code = 'KEPBUP';
							}
							
							generate_file_code(file_code, nama, revisi);
						}
						else
						{
							$('#txt_dokumen_ext'+y).val($(this).val().split('\\').pop());
							
							var lamp 		= 'LAMP'
							var i			= y - 1;
							var file_code	= lamp + i;
							var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
							var revisi		= 0;
							
							generate_file_code_lampiran(file_code, nama, revisi, y);						
						}
					})	
				}												
			});					
			
			/*
			$("#btnSave").click(function(){
				var formUrl     = base_url + 'pemda/edit_document';
				var formData    = new FormData($('#formPendukung')[0]);
				$.ajax({
					url         : formUrl,
					type        : 'POST',
					data        : formData,
					mimeType    : "multipart/form-data",
					contentType : false,
					cache       : false,
					processData : false,                                
					success: function(result){
						if(result){
							swal("Dokumen Telah Tersimpan !");
							window.location.href = base_url + 'pemda/dasboard';
						}
					}
				}); 
			});*/
			
			$("#btnSubmit").click(function(){
				$.ajax({
					url			: base_url + "pemda/submit_nota_dinas",
					type		: 'post',
					data		: {id: id},
					dataType	: 'json',
					success : function(hasil){
						if(hasil){
							swal("Data Has Been Submitted !");
							window.location.href = base_url + 'pemda/dasboard';
						}
					}
				});
			});
			
			generate_dinas();
			generate_nota_dinas_by_id();
		});
		
		function zeroPad(num, places) {
		  var zero = places - num.toString().length + 1;
		  return Array(+(zero > 0 && zero)).join("0") + num;
		}
	</script>
	
	<title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
</head>
<body>
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <div id = "page-wrapper">
				<div class = "row">
					<div class = "col-md-12">
						<h1 class = "page-header">Create Nota Dinas</h1>
						<ol class = "breadcrumb">
							<li class = "active">
								<a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> Create Nota Dinas
							</li>
						</ol>
					</div>
				</div> 
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class = "col-lg-12">
									
										<form role = "form" id = "formNota" method = "post" onsubmit = "return false">																	
											<div class = "card card-block">
												<div class = "card-title"><h4>Data Nota Dinas</h4></div>
												<div class = "form-group col-lg-2">
													<label>Dinas</label>
													<input type = "hidden" class = "form-control" name = "txt_kode_unit2" id = "txt_kode_unit2" readonly style = "background-color: lightgrey">
													<input type = "text" class = "form-control" name = "txt_kode_unit" id = "txt_kode_unit" readonly style = "background-color: lightgrey">
												</div>	
												<div class = "form-group col-lg-10">
													<label>&nbsp;</label>
													<input type = "text" class = "form-control" name = "txt_nama_unit" id = "txt_nama_unit" readonly style = "background-color: lightgrey">
												</div>																																	
															
												<div class = "form-group col-lg-2">
													<label>Jenis</label>
													<label>&nbsp;</label>
												</div>	
												<div class = "form-group col-lg-2">											
													<input type = "radio" name = "optJenis" id = "optJenis" value = "0">Perbup
												</div>	
												<div class = "form-group col-lg-2">
													<input type = "radio" name = "optJenis" id = "optJenis" value = "1">Kepbup
												</div>		
												<div class = "form-group col-md-7"></div>	
												
												<div class = "form-group col-lg-6">
													<label>Tanggal Pengajuan</label>
													<div class = 'input-group'>
														<input type = 'text' class = "form-control" id = 'datecustom'/>
														<span class = "input-group-addon">
														<span class = "zmdi zmdi-calendar-note"></span>
														</span>
													</div>
												</div>		

												<div class = "form-group col-lg-6">
													<label>No. Nota Dinas</label>
													<input type = "text" class = "form-control" name = "txt_nota_dinas" id = "txt_nota_dinas" readonly style = "background-color: lightgrey">
												</div>	
												
												<div class = "form-group col-lg-12">
													<label>Perihal</label>
													<textarea class = "form-control" name = "txt_perihal" id = "txt_perihal"></textarea>
												</div>	
											</form>												
										</div>	
										<div class = "col-lg-12">	
											<fieldset>
												<legend><strong> Scan Nota Dinas </strong></legend>											
												<form id = "formUpload" enctype="multipart/form-data">
													<div class = "form-group col-lg-12">															
															<input type = "hidden" class = "form-control" name = "txt_scan_nota_dinas_old" id = "txt_scan_nota_dinas_old" readonly style = "background-color: lightgrey">
															<input type = "text" class = "form-control" name = "txt_scan_nota_dinas" id = "txt_scan_nota_dinas">	
															<input type='file' id='file_name' name='file_name' onchange = " readURL(this);" accept = "image/jpeg, application/pdf"/>												
													</div>											
												</form>											
											</fieldset>
										</div>	
										<form id = "formPendukung" enctype="multipart/form-data">
											<input type = "hidden" id = "txt_jml" class = "txt_jml" />
											<div class = "col-lg-12">	
												<fieldset>
													<legend><strong> Dokumen Pengajuan Perbup / Kepbup </strong></legend>
													<div class="input_fields_wrap">												
													
													</div>
																									
												</fieldset>
											</div>
											<div class = "form-group col-lg-6">	
												<input id='btnupload' class = "btn btn-md btn-secondary" value = "Add" type = "button">
											</div>
										</form>
										<p><p>
										<center>
											<div class = "form-group col-lg-12">
												<input class = "btn btn-lg btn-success" id = "btnSave" value = "Save" type = "submit">
												<input class = "btn btn-lg btn-primary" id = "btnSubmit" value = "Submit" type = "submit">
											</div>
										</center>																			
									
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
<?php
		}
		else if($this->session->userdata('unit_key') == '15_')
		{
?>
<head>
	<?php include("assets/component/top.php"); ?>
	<style type = "text/css">
		body, input, fieldset, legend { font-family: Tahoma; font-size: 12px}
		.wrapper
		{
		  width: 100%;
		}
		
		@media(max-width:992px)
		{
			.wrapper
			{
				width:100%;
			} 
		}
		
		.panel-heading 
		{
			padding: 0;
			border:0;
		}
		
		.panel-title>a, .panel-title>a:active
		{
			display			:block;
			padding			:15px;
			color			:#555;
			font-size		:16px;
			font-weight		:bold;
			text-transform	:uppercase;
			letter-spacing	:1px;
			word-spacing	:3px;
			text-decoration	:none;
		}
		
		.panel-heading  a:before 
		{
		   font-family		: 'Glyphicons Halflings';
		   content			: "\e114";
		   float			: right;
		   transition		: all 0.5s;
		}
		
		.panel-heading.active a:before {
			-webkit-transform	: rotate(180deg);
			-moz-transform		: rotate(180deg);
			transform			: rotate(180deg);
		} 	
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){	
		
			var base_url	= '<?php echo base_url(); ?>';
			var id			= '<?php echo $id; ?>';			
			
			$('.panel-collapse').on('show.bs.collapse', function () {
				$(this).siblings('.panel-heading').addClass('active');
			});

			$('.panel-collapse').on('hide.bs.collapse', function () {
				$(this).siblings('.panel-heading').removeClass('active');
			});		
			
			var generate_nota_dinas_by_id	= function(){
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_by_id",
					type		: 'post',
					data		: {id: id},
					dataType	: 'json',
					success : function(result){		
						$("#txt_kode_unit2").val(result['unitkey']);
						$("#txt_kode_unit").val(result['kode_unit']);
						$("#txt_nama_unit").val(result['nama_unit']);					
						$("input[name=optJenis][value=" + result['jns_nota_dinas'] + "]").prop('checked', true);
						$("#datecustom").val(result['tgl_nota_dinas']);
						$("#txt_nota_dinas").val(result['no_nota_dinas']);						
						$("#txt_nota_dinas_ext1").val(result['no_nota_dinas']);
						$("#txt_perihal").val(result['perihal']);						
						$("#div_scan_nota_dinas").html('<a href = "'+base_url+'upload/'+result['nota_dinas_doc']+'" target = "_blank">'+result['nota_dinas_doc']+'</a>');						
						
						$("input[type=radio]").attr('disabled', true); 
						$("#datecustom").attr('disabled', true); 
						$("#txt_perihal").attr('disabled', true); 
						
						generate_nota_dinas_document(result['no_nota_dinas'])
					}					
				})								
			}, 
			
			generate_nota_dinas_document = function(no_nota){
				
			}
						
			generate_nota_dinas_by_id();
		});
	</script>
	<title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
</head>
<body>
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <div id = "page-wrapper">
				<div class = "row">
					<div class = "col-md-12">
						<h1 class = "page-header">Data Nota Dinas</h1>
						<ol class = "breadcrumb">
							<li class = "active">
								<a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> Create Nota Dinas
							</li>
						</ol>
					</div>
				</div> 
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class="wrapper center-block">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading active" role="tab" id="headingOne">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Data Nota Dinas</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body">
													
														<form role = "form" id = "formNota" method = "post" onsubmit = "return false">																																
															<div class = "form-group col-lg-2">
																<label>Dinas</label>
																<input type = "hidden" class = "form-control" name = "txt_kode_unit2" id = "txt_kode_unit2" readonly style = "background-color: lightgrey">
																<input type = "text" class = "form-control" name = "txt_kode_unit" id = "txt_kode_unit" readonly style = "background-color: lightgrey">
															</div>	
															<div class = "form-group col-lg-10">
																<label>&nbsp;</label>
																<input type = "text" class = "form-control" name = "txt_nama_unit" id = "txt_nama_unit" readonly style = "background-color: lightgrey">
															</div>																																	
																		
															<div class = "form-group col-lg-2">
																<label>Jenis</label>
																<label>&nbsp;</label>
															</div>	
															<div class = "form-group col-lg-2">											
																<input type = "radio" name = "optJenis" id = "optJenis" value = "0">Perbup
															</div>	
															<div class = "form-group col-lg-2">
																<input type = "radio" name = "optJenis" id = "optJenis" value = "1">Kepbup
															</div>		
															<div class = "form-group col-md-7"></div>	
															
															<div class = "form-group col-lg-6">
																<label>Tanggal Pengajuan</label>
																<div class = 'input-group'>
																	<input type = 'text' class = "form-control" id = 'datecustom'/>
																	<span class = "input-group-addon">
																	<span class = "zmdi zmdi-calendar-note"></span>
																	</span>
																</div>
															</div>		

															<div class = "form-group col-lg-6">
																<label>No. Nota Dinas</label>
																<input type = "text" class = "form-control" name = "txt_nota_dinas" id = "txt_nota_dinas" readonly style = "background-color: lightgrey">
															</div>	
															
															<div class = "form-group col-lg-12">
																<label>Perihal</label>
																<textarea class = "form-control" name = "txt_perihal" id = "txt_perihal"></textarea>
															</div>	
															
															<div class = "form-group col-lg-2">
																<label>Scan Nota Dinas</label>
																<label>&nbsp;</label>																
															</div>
															<div class = "form-group col-lg-10">
																<div id = "div_scan_nota_dinas"></div>
															</div>
															
															<div class = "form-group col-lg-12">
																<label>Dokumen Pengajuan Perbup / Kepbup</label>
																<div id = "div_dokumen_pendukung">
																</div>
															</div>
														</form>																																																													
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingTwo">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Create Disposisi</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
												<div class="panel-body">
													<form role = "form" id = "formDisposisi" method = "post" onsubmit = "return false">																																
															<div class = "form-group col-lg-2">
																<label>Dinas</label>
																<input type = "hidden" class = "form-control" name = "txt_kode_unit_surat2" id = "txt_kode_unit_surat2" readonly style = "background-color: lightgrey">
																<input type = "text" class = "form-control" name = "txt_kode_unit_surat" id = "txt_kode_unit_surat" readonly style = "background-color: lightgrey">
															</div>	
															<div class = "form-group col-lg-4">
																<label>&nbsp;</label>
																<input type = "text" class = "form-control" name = "txt_nama_unit_surat" id = "txt_nama_unit_surat" readonly style = "background-color: lightgrey">
															</div>																																	
																																														
															<div class = "form-group col-lg-6">
																<label>Diterima Tgl</label>
																<div class = 'input-group'>
																	<input type = 'text' class = "form-control" id = 'datecustom'/>
																	<span class = "input-group-addon">
																	<span class = "zmdi zmdi-calendar-note"></span>
																	</span>
																</div>
															</div>		

															<div class = "form-group col-lg-6">
																<label>No. Surat</label>
																<input type = "text" class = "form-control" name = "txt_nota_surat" id = "txt_nota_surat" readonly style = "background-color: lightgrey">
															</div>	
															<div class = "form-group col-lg-6">
																<label>No. Agenda</label>
																<input type = "text" class = "form-control" name = "txt_nota_agenda" id = "txt_nota_agenda" readonly style = "background-color: lightgrey">
															</div>	
															
															<div class = "form-group col-lg-6">
																<label>Tanggal Surat</label>
																<div class = 'input-group'>
																	<input type = 'text' class = "form-control" id = 'datecustom'/>
																	<span class = "input-group-addon">
																	<span class = "zmdi zmdi-calendar-note"></span>
																	</span>
																</div>
															</div>
															<div class = "form-group col-md-1">
																<label>Sifat</label>
																<label>&nbsp;</label>
															</div>	
															<div class = "form-group col-md-2">											
																<input type = "radio" name = "optSifat" id = "optSifat" value = "0">Sangat Segera
															</div>	
															<div class = "form-group col-md-2">
																<input type = "radio" name = "optSifat" id = "optSifat" value = "1">Segera
															</div>	
															<div class = "form-group col-md-2">
																<input type = "radio" name = "optSifat" id = "optSifat" value = "2">Rahasia
															</div>
															<div class = "form-group col-md-4"></div>
															
															<div class = "form-group col-lg-6">
																<label>Perihal</label>
																<textarea class = "form-control" name = "txt_perihal_disposisi" id = "txt_perihal_disposisi"></textarea>
															</div>	
															<div class = "form-group col-lg-6">
																<label>Diteruskan</label>
																<input type = "text" class = "form-control" name = "txt_diteruskan" id = "txt_diteruskan" readonly style = "background-color: lightgrey">
															</div>	
															
															<div class = "form-group col-lg-12">
																<label>Catatan</label>
																<textarea class = "form-control" name = "txt_catatan" id = "txt_catatan"></textarea>
															</div>	
															<div class = "form-group col-lg-3">
																<label>Dengan hormat harap</label>
																<label>&nbsp;</label>
															</div>	
															<div class = "form-group col-lg-3">											
																<input type = "checkbox" name = "chk_harap" id = "chk_harap" value = "0">Tanggapan Dan Saran
															</div>	
															<div class = "form-group col-lg-3">
																<input type = "checkbox" name = "chk_harap" id = "chk_harap" value = "1">Proses Lebih Lanjut
															</div>	
															<div class = "form-group col-lg-3">
																<input type = "checkbox" name = "chk_harap" id = "chk_harap" value = "2">Koordinasikan/Konfirmasikan
															</div>
														</form>
												</div>
											</div>
										</div>										
									</div>
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
<?php
		}
	}
?>