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
		
		.page-header
		{
			border-bottom	: 2px solid #3F51B5 !important;
		}	
		
		input[type=file] {
			position	: absolute;
			top			: 0;
			left		: 0;
			right		: 0;
			bottom		: 0;
			opacity		: 0;
			cursor		: pointer;
		  }			
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
				var txt_doc		= $(".txt_dokumen").val();
				if(txt_doc == '')
				{
					swal({
						title				: "Warning",
						text				: "Dokumen Pendukung tidak boleh Kosong!",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					 });
					return false;				
				}
				
				e.preventDefault();
				if(x < max)
				{					
					x++;
					var j = x-1;
					var txt_doc_pendukung	= $("#txt_dokumen"+j).val();
					
					if(txt_doc_pendukung != "")
					{
						$(".input_fields_wrap").append("<div class = 'form-group col-lg-6 div_add_dokumen' id = 'div_add_dokumen_"+x+"'><input type = 'hidden' class = 'form-control' name = 'txt_nota_dinas_ext"+x+"' id = 'txt_nota_dinas_ext"+x+"' readonly style = 'background-color: lightgrey'><div class = 'input-group div_dokumen'><input type = 'text' class = 'form-control txt_dokumen' txt_dokumen = '"+x+"' name = 'txt_dokumen[]' id = 'txt_dokumen"+x+"' readonly/><span class = 'input-group-addon'><span class = 'zmdi zmdi-minus' id = 'span_remove_"+x+"' style = 'cursor: pointer'></span></span></div><input type = 'hidden' class = 'form-control txt_dokumen_ext' txt_dokumen_ext = '"+x+"' name = 'txt_dokumen_ext[]' id = 'txt_dokumen_ext"+x+"'><input type='file' id='file_dokumen_"+x+"' name='myfile[]' file_dokumen ='"+x+"' class = 'file_dokumen' accept = 'image/jpeg, application/pdf' multiple='' /></div>");																								
						
						$('#txt_dokumen'+x).click(function(e){
							e.preventDefault();		
							$('#file_dokumen_'+x).click();
						});		
						
						$('#span_remove_'+x).click(function(){
							var intId 	= $(this).attr('id');
							var intId2 	= parseInt(intId.substr(intId.length - 1, 1));

							if(intId2 !== parseInt(x))
							{
								swal({
									title					: "Warning",
									text					: "File yang di delete harus yang terakhir!",
									type					: "warning",
									showCancelButton		: false,
									confirmButtonColor		: '#DD6B55',
									confirmButtonText		: 'OK',
									cancelButtonText		: false,
									closeOnConfirm			: false,
									closeOnCancel			: false
								});
								
								return false;	
							}
							else
							{
								$(this).parent().parent().parent().remove();
								x--;
							}
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
							var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
							var revisi		= 0;
							
							generate_file_code_lampiran(file_code, nama, revisi, x);
						})		
					}
					else
					{
						x--;
						swal({
								title				: "Warning",
								text				: "Dokumen Lampiran tidak boleh Kosong!",
								type				: "warning",
								showCancelButton	: false,
								confirmButtonColor	: '#DD6B55',
								confirmButtonText	: 'OK',
								cancelButtonText	: false,
								closeOnConfirm		: false,
								closeOnCancel		: false
						});
						
						return false;	
					}
				}
				/* e.preventDefault();			
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
				}	 */
			});
			
			$('#txt_dokumen1').click(function(e){
				e.preventDefault();
				if($("#txt_nota_dinas").val() == '')
				{
					swal({
							title				: "Warning",
							text				: "Pilih Jenis Dokumen Terlebih Dahulu !",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
					});
					
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
					swal({
						title				: "Warning",
						text				: "Maximum : 5MB",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
						 
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
				
				if(txt_no_nota == '')
				{
					swal({
							title				: "Warning",
							text				: "Pilih Jenis Dokumen Terlebih Dahulu !",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
					});
					
					return false;
				}
				else if(txt_perihal == '')
				{
					swal({
						title					: "Warning",
						text					: "Input Perihal Terlebih Dahulu !",
						type					: "warning",
						showCancelButton		: false,
						confirmButtonColor		: '#DD6B55',
						confirmButtonText		: 'OK',
						cancelButtonText		: false,
						closeOnConfirm			: false,
						closeOnCancel			: false
					});
					 
					return false;
				}
				else if(txt_scan == '')
				{
					swal({
						title					: "Warning",
						text					: "Input Scan Nota Dinas Terlebih Dahulu !",
						type					: "warning",
						showCancelButton		: false,
						confirmButtonColor		: '#DD6B55',
						confirmButtonText		: 'OK',
						cancelButtonText		: false,
						closeOnConfirm			: false,
						closeOnCancel			: false
					});
					 
					return false;				
				}
				else if(txt_doc == '')
				{
					swal({
						title					: "Warning",
						text					: "Input Dokumen Pendukung Terlebih Dahulu !",
						type					: "warning",
						showCancelButton		: false,
						confirmButtonColor		: '#DD6B55',
						confirmButtonText		: 'OK',
						cancelButtonText		: false,
						closeOnConfirm			: false,
						closeOnCancel			: false
					});
					
					return false;				
				}
				else
				{	
					var jmlLamp		= $("input[name='txt_dokumen[]']").length;
					var jmlLamp 	= jmlLamp - 1;
					var dataKosong 	= 'FALSE';
					
					var txt_doc		= $(".txt_dokumen").val();
					
					for(var i = 0; i < jmlLamp	; i++)
					{
						var j = i + 2;
						var txt_doc_pendukung	= $("#txt_dokumen"+j).val();
						
						if(txt_doc_pendukung == '')
						{
							dataKosong = 'TRUE';
							break;
						}
					}	
					
					if(dataKosong == 'TRUE' )
					{
						swal({
							title				: "Warning",
							text				: "Lampiran tidak boleh Kosong!",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
						});
						
						return false;		
					}
					
					//cek scan nota dinas nama file sudah ada /belum
					var formData    = new FormData($('#formUpload')[0]);	
					$.ajax({
						url			: base_url + 'pemda/cek_scan_nota_dinas',
						type        : 'POST',
						data        : formData,
						mimeType    : "multipart/form-data",
						contentType : false,
						cache       : false,
						processData : false,
						dataType	: 'json',
						success 	: function(result){
							if(result != 0)
							{
								 	swal({
										title				: "Failed!",
										text				:  "File Scan Nota Dinas Already Exists !",
										type				:  "error",
										timer				: 5000,
										showConfirmButton	: true
									}); 
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
						}
					})									
				}	
			})
			
			$("#btnSubmit").click(function(){
				var txt_unit	= $("#txt_kode_unit2").val();
				var txt_jenis	= $('input[type=radio][name=optJenis]:checked').val();
				var txt_tgl		= $("#datecustom").val();
				var txt_no_nota	= $("#txt_nota_dinas").val();
				var txt_perihal	= $("#txt_perihal").val();
				var txt_scan	= $("#txt_scan_nota_dinas").val();
				var txt_doc		= $(".txt_dokumen").val();
				
				if(txt_no_nota == '')
				{
					swal({
							title				: "Warning",
							text				: "Pilih Jenis Dokumen Terlebih Dahulu !",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
					});
					
					return false;
				}
				else if(txt_perihal == '')
				{
					swal({
						title				: "Warning",
						text				: "Input Perihal Terlebih Dahulu !",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
					 
					return false;
				}
				else if(txt_scan == '')
				{
					swal({
						title				: "Warning",
						text				: "Input Scan Nota Dinas Terlebih Dahulu !",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
					 
					return false;				
				}
				else if(txt_doc == '')
				{
					swal({
						title				: "Warning",
						text				: "Input Dokumen Pendukung Terlebih Dahulu !",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
					 
					return false;				
				}
				else
				{	
					var jmlLamp		= $("input[name='txt_dokumen[]']").length;
					var jmlLamp 	= jmlLamp - 1;
					var dataKosong 	= 'FALSE';
					
					var txt_doc		= $(".txt_dokumen").val();
					
					for(var i = 0; i < jmlLamp	; i++)
					{
						var j = i + 2;
						var txt_doc_pendukung	= $("#txt_dokumen"+j).val();
						
						if(txt_doc_pendukung == ''){
							dataKosong = 'TRUE';
							break;
						}
					}	
					
					if(dataKosong == 'TRUE' ){
						swal({
							title				: "Warning",
							text				: "Lampiran tidak boleh Kosong!",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
						});
						
						return false;		
					}
					
					//cek scan nota dinas nama file sudah ada /belum
					var formData    = new FormData($('#formUpload')[0]);	
					$.ajax({
						url			: base_url + 'pemda/cek_scan_nota_dinas',
						type        : 'POST',
						data        : formData,
						mimeType    : "multipart/form-data",
						contentType : false,
						cache       : false,
						processData : false,
						dataType	: 'json',
						success 	: function(result){
							if(result != 0)
							{
								swal({
									title				:  "Failed!",
									text				:  "File Scan Nota Dinas Already Exists !",
									type				:  "error",
									timer				: 5000,
									showConfirmButton	: true
								}); 
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
																if(result)
																{
																	$.ajax({
																		url			: base_url + "pemda/submit_nota_dinas_save",
																		type		: 'post',
																		data		: {txt_no_nota: txt_no_nota},
																		dataType	: 'json',
																		success : function(hasil){
																			if(hasil){
																				swal("Data Has Been Submitted !");
																				window.location.href = base_url + 'pemda/dasboard'; 
																			}
																		}
																	});
																}
															}
														});
													}
												}
											});		 				
										}
									}
								});	
							}
						}
					});
				}	
			});

			generate_dinas();
			
			$('#datecustom').val('<?php echo date('Y-m-d'); ?>');			
			$('#datecustom').dateTimePicker("setDate", new Date());			
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
					</div>
				</div> 
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class = "col-lg-12">	
									<div class="panel-heading" style ="font-size: 16px;background-color: rgb(179, 179, 179);">Data Nota Dinas</div>
									<div class = "card card-block">
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
													<input type = 'text' class = "form-control" id = 'datecustom' />
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
											<form id = "formUpload" enctype = "multipart/form-data">
												<div class = "form-group col-lg-12">	
													<label>Scan Nota Dinas</label>
													<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext" id = "txt_nota_dinas_ext" readonly style = "background-color: lightgrey">
													<input type = "text" class = "form-control" name = "txt_scan_nota_dinas" id = "txt_scan_nota_dinas" readonly>	
													<input type='file' id='file_name' name='file_name' accept = "image/jpeg, application/pdf"/>		
												</div>	
											</form>
										
											
											<form id = "formPendukung" enctype = "multipart/form-data">
												<div class = "form-group col-lg-12">
													<label><strong> Dokumen Pengajuan Perbup / Kepbup </strong></label>
														<div class = "input_fields_wrap">												
															<div class = "form-group col-lg-6" id = "div_add_dokumen_1">												
																<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext1" id = "txt_nota_dinas_ext1" readonly style = "background-color: lightgrey">
																<input type = "text" class = "form-control txt_dokumen" txt_dokumen = "1" name = "txt_dokumen[]" id = "txt_dokumen1" readonly />	
																<input type = "hidden" class = "form-control txt_dokumen_ext" txt_dokumen_ext = "1" name = "txt_dokumen_ext[]" id = "txt_dokumen_ext1" />	
																<input type='file' id='file_dokumen_1' file_dokumen = '1' name='myfile[]' class = 'file_dokumen' accept = "image/jpeg, application/pdf" multiple = ""  />		
															</div>												
														</div>
														<div class = "form-group col-lg-6">	
															<input id='btnupload' class = "btn m-indigo legitRipple" value = "Add" type = "button">
														</div>				
												</div>
											</form>												
									</div>
									<p><p>
									<center>
										<div class = "form-group col-lg-12">
											<input class = "btn m-indigo legitRipple" id = "btnSave" value = "Save" type = "submit">
											<input class = "btn m-indigo legitRipple" id = "btnSubmit" value = "Submit" type = "submit">
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
?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<?php include("assets/component/top.php"); ?>		
	<style type = "text/css">
		body, input, fieldset, legend { font-family: Tahoma; font-size: 12px}	
		#file_name, .file_dokumen { width:0; height:0; } 
		.page-header
		{
			border-bottom	: 2px solid #3F51B5 !important;
		}	
		
		input[type=file] 
		{
			position	: absolute;
			top			: 0;
			left		: 0;
			right		: 0;
			bottom		: 0;
			opacity		: 0;
			cursor		: pointer;
		  }	
	</style>
	<script type = "text/javascript">
		$(document).ready(function(){							
			var base_url	= '<?php echo base_url(); ?>';
			var id			= '<?php echo $id; ?>';
			//var j 			= $(".txt_jml").val();
			var jml_max 	= 6;
			var j			= 1;			
			
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
						$("input[name=optJenis][value = " + result['jns_nota_dinas'] + "]").prop('checked', true);
						$("#datecustom").val(result['tgl_nota_dinas']);
						$("#txt_nota_dinas").val(result['no_nota_dinas']);						
						$("#txt_nota_dinas_ext1").val(result['no_nota_dinas']);
						$("#txt_perihal").val(result['perihal']);
						//$("#txt_scan_nota_dinas_old").val(result['nota_dinas_doc']);
						$("#txt_scan_nota_dinas_old").val(result['no_nota_dinas']);
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
							var file_name	= (result[i].file).substring(37,panjang);
							var x			= i + 1;							
							var dokumen	 = '<div class = "form-group col-lg-6 div_add_dokumen" id = "div_add_dokumen_'+file_name+'">';
								dokumen	+= '<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext'+x+'" id = "txt_nota_dinas_ext'+x+'" readonly style = "background-color: lightgrey" value = "'+no_nota_dinas+'">';	
								dokumen += '<div class = "input-group div_dokumen"><input type = "text" class = "form-control txt_dokumen" txt_dokumen = "'+x+'" name = "txt_dokumen[]" id = "txt_dokumen'+x+'" value = "'+file_name+'" readonly /><span class = "input-group-addon"><span class = "zmdi zmdi-minus" id = "span_remove_'+x+'" span_remove = "'+file_name+'" style = "cursor: pointer"></span></span></div>';
								dokumen += '<input type = "hidden" class = "form-control txt_dokumen_ext" txt_dokumen_ext = "'+x+'" name = "txt_dokumen_ext[]" id = "txt_dokumen_ext'+x+'" value = "'+file_name+'" />';
								dokumen += '<input type= "file" id = "file_dokumen_'+x+'" file_dokumen = "'+x+'" name= "myfile[]" class = "file_dokumen" onchange = " readURL(this);" accept = "image/jpeg, application/pdf" multiple = ""  />';
								dokumen	+= '</div>';							
							$(".input_fields_wrap").append(dokumen);	
							
							count_div();	

							j	= $("#txt_jml").val();	
							
							$('#txt_dokumen'+j).click(function(e){
								e.preventDefault();		
								$('#file_dokumen_'+j).click();
							});		
							
							$('#file_dokumen_'+j).change(function(){
								var ukuran	= this.files[0];
								if(ukuran > 5120)
								{
									alert("Maximum : 5MB");
									return false;
								}
								
								$('#txt_dokumen_ext'+j).val($(this).val().split('\\').pop());
								
								
								if(j == 1)
								{
									var jenis	= $('input[type=radio][name=optJenis]:checked').val();
									var revisi	= 0;
					
									if(jenis == 0)
									{
										var file_code = 'PERBUP';
									}
									else
									{
										var file_code = 'KEPBUP';
									}
									var nama	= ($("#txt_nota_dinas").val()).replace(/\//g,'');
									
									generate_file_code(file_code, nama, revisi);
								}
								else
								{
									var lamp 		= 'LAMP'
									var i			= j - 1;
									var file_code	= lamp + i;
									var revisi		= 0;									
									var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');
									
									generate_file_code_lampiran(file_code, nama, revisi, j);
								}
							})		
							
							$("#span_remove_"+x).click(function(){									
								if(j==1)
								{
									return false;	
								}
								var intId 	= $(this).attr('id');
								var intId2 	= parseInt(intId.substr(intId.length - 1, 1));
								
								if(intId2 !== parseInt(j))
								{
									swal({
										title				: "Warning",
										text				: "File yang di delete harus yang terakhir!",
										type				: "warning",
										showCancelButton	: false,
										confirmButtonColor	: '#DD6B55',
										confirmButtonText	: 'OK',
										cancelButtonText	: false,
										closeOnConfirm		: false,
										closeOnCancel		: false
									});
									
									return false;	
								}
								else
								{
										var file	= $(this).attr("span_remove");	
										var elementToRemove = $(this).parent().parent().parent();
										
										swal({
											  title					: "Confirmation",
											  text					: "Are you sure to delete this file?",
											  type					: "warning",
											  showCancelButton		: true,											 
											  confirmButtonColor	: "#3F51B5 !important",
											  confirmButtonText		: "Yes",
											  cancelButtonText		: "No",
											  closeOnConfirm		: false
										},
										function(){
											elementToRemove.remove();
								
											count_div();		
											$.ajax({
												url			: base_url + "pemda/delete_dokumen",
												type		: 'post',
												data		: {no_nota_dinas: no_nota_dinas, file: file},
												dataType	: 'json',
												success : function(hasil){										
												}
											});
											j--;
											swal("Deleted!", "Your imaginary file has been deleted.", "success");
										});

									
									/* $(this).parent().parent().parent().remove();
									
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
									j--; */
								}
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

			
			$("#btnupload").click(function(e){
				e.preventDefault();

				if(j < jml_max)
				{
					j++;
					var k = j-1;
					
					var txt_doc_pendukung	= $("#txt_dokumen"+k).val();
					
					if(txt_doc_pendukung != ""){
						$(".input_fields_wrap").append("<div class = 'form-group col-lg-6 div_add_dokumen' id = 'div_add_dokumen_"+j+"'><input type = 'hidden' class = 'form-control' name = 'txt_nota_dinas_ext"+j+"' id = 'txt_nota_dinas_ext"+j+"' readonly style = 'background-color: lightgrey'><div class = 'input-group div_dokumen'><input type = 'text' class = 'form-control txt_dokumen' txt_dokumen = '"+j+"' name = 'txt_dokumen[]' id = 'txt_dokumen"+j+"' readonly/><span class = 'input-group-addon'><span class = 'zmdi zmdi-minus' id = 'span_remove_"+j+"' style = 'cursor: pointer'></span></span></div><input type = 'hidden' class = 'form-control txt_dokumen_ext' txt_dokumen_ext = '"+j+"' name = 'txt_dokumen_ext[]' id = 'txt_dokumen_ext"+j+"'><input type='file' id='file_dokumen_"+j+"' name='myfile[]' file_dokumen ='"+j+"' class = 'file_dokumen' accept = 'image/jpeg, application/pdf' multiple='' /></div>");																								
						
						$('#txt_dokumen'+j).click(function(e){
							e.preventDefault();		
							$('#file_dokumen_'+j).click();
						});		
						
						
						$('#span_remove_'+j).click(function(){
							var intId 	= $(this).attr('id');
							var intId2 	= parseInt(intId.substr(intId.length - 1, 1));
							
							if(intId2 !== parseInt(j))
							{
								swal({
									title				: "Warning",
									text				: "File yang di delete harus yang terakhir!",
									type				: "warning",
									showCancelButton	: false,
									confirmButtonColor	: '#DD6B55',
									confirmButtonText	: 'OK',
									cancelButtonText	: false,
									closeOnConfirm		: false,
									closeOnCancel		: false
								});
								
								return false;	
							}
							else
							{
								$(this).parent().parent().parent().remove();
								j--;
							}
						});	
						
						$('#file_dokumen_'+j).change(function(){
							var ukuran	= this.files[0];
							if(ukuran > 5120)
							{
								alert("Maximum : 5MB");
								return false;
							}
							
							$('#txt_dokumen_ext'+j).val($(this).val().split('\\').pop());
							
							var lamp 		= 'LAMP'
							var i			= j - 1;
							var file_code	= lamp + i;
							var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');				
							var revisi		= 0;
							
							if(j==1)
							{
								generate_file_code(file_code, nama, revisi);
							}
							else
							{
								generate_file_code_lampiran(file_code, nama, revisi, j);
							}
						})		
					}
					else
					{
						j--;
						swal({
								title				: "Warning",
								text				: "Dokumen Lampiran tidak boleh Kosong!",
								type				: "warning",
								showCancelButton	: false,
								confirmButtonColor	: '#DD6B55',
								confirmButtonText	: 'OK',
								cancelButtonText	: false,
								closeOnConfirm		: false,
								closeOnCancel		: false
						});
						
						return false;	
					}
					
					
				} 
				/* if($("#txt_jml").val() == 0)
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
				}			 */										
			});					
			
			$("#btnSave").click(function(){	
				var txt_tgl		= $("#datecustom").val();
				var txt_no_nota	= $("#txt_nota_dinas").val();
				var txt_perihal	= $("#txt_perihal").val();
				var txt_scan	= $("#txt_scan_nota_dinas").val();
				var txt_doc		= $(".txt_dokumen").val();
				
				if(txt_no_nota == '')
				{
					swal({
							title					: "Warning",
							text					: "Pilih Jenis Dokumen Terlebih Dahulu !",
							type					: "warning",
							showCancelButton		: false,
							confirmButtonColor		: '#DD6B55',
							confirmButtonText		: 'OK',
							cancelButtonText		: false,
							closeOnConfirm			: false,
							closeOnCancel			: false
					});
					
					return false;
				}
				else if(txt_perihal == '')
				{
					swal({
						title					: "Warning",
						text					: "Input Perihal Terlebih Dahulu !",
						type					: "warning",
						showCancelButton		: false,
						confirmButtonColor		: '#DD6B55',
						confirmButtonText		: 'OK',
						cancelButtonText		: false,
						closeOnConfirm			: false,
						closeOnCancel			: false
					});
					 
					return false;
				}
				else if(txt_scan == '')
				{
					swal({
						title				: "Warning",
						text				: "Input Scan Nota Dinas Terlebih Dahulu !",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
					 
					return false;				
				}
				else if(txt_doc == '')
				{
					swal({
						title				: "Warning",
						text				: "Input Dokumen Pendukung Terlebih Dahulu !",
						type				: "warning",
						showCancelButton	: false,
						confirmButtonColor	: '#DD6B55',
						confirmButtonText	: 'OK',
						cancelButtonText	: false,
						closeOnConfirm		: false,
						closeOnCancel		: false
					});
					
					return false;				
				}
				else
				{	
					var jmlLamp		= $("input[name='txt_dokumen[]']").length;
					var jmlLamp 	= jmlLamp - 1;
					var dataKosong 	= 'FALSE';
					
					var txt_doc		= $(".txt_dokumen").val();
					
					for(var i = 0; i < jmlLamp	; i++)
					{
						var j = i + 2;
						var txt_doc_pendukung	= $("#txt_dokumen"+j).val();
						
						if(txt_doc_pendukung == ''){
							dataKosong = 'TRUE';
							break;
						}
					}	
					
					if(dataKosong == 'TRUE' ){
						swal({
							title				: "Warning",
							text				: "Lampiran tidak boleh Kosong!",
							type				: "warning",
							showCancelButton	: false,
							confirmButtonColor	: '#DD6B55',
							confirmButtonText	: 'OK',
							cancelButtonText	: false,
							closeOnConfirm		: false,
							closeOnCancel		: false
						});
						
						return false;		
					}
					
					
					//cek scan nota dinas nama file sudah ada /belum
					var formData    = new FormData($('#formUpload')[0]);	
					$.ajax({
						url			: base_url + 'pemda/cek_scan_nota_dinas',
						type        : 'POST',
						data        : formData,
						mimeType    : "multipart/form-data",
						contentType : false,
						cache       : false,
						processData : false,
						dataType	: 'json',
						success 	: function(result){
							if(result != 0)
							{
								swal({
									title				: "Failed!",
									text				:  "File Scan Nota Dinas Already Exists !",
									type				:  "error",
									timer				: 5000,
									showConfirmButton	: true
								}); 
							}
							else
							{
								$.ajax({
									url			: base_url + 'pemda/save_edit_nota_dinas',
									type		: 'post',
									data		: {txt_tgl: txt_tgl,txt_no_nota: txt_no_nota, txt_perihal: txt_perihal},
									dataType	: 'json',
									success : function(hasil){
										if(hasil)
										{
											var formUrl     = base_url + 'pemda/save_edit_doc_nota_dinas';
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
														var formUrl     = base_url + 'pemda/save_edit_document';
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
						}
					})
					
																	
				}
			});
			
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
			
			$('#datecustom').val('<?php echo date('Y-m-d'); ?>');			
			$('#datecustom').dateTimePicker("setDate", new Date());			
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
					</div>
				</div> 
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class = "col-lg-12">
									<div class="panel-heading" style ="font-size: 16px;background-color: rgb(179, 179, 179);">Data Nota Dinas</div>
										<div class = "card card-block">
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
											</form>
											
											<form id = "formUpload" enctype = "multipart/form-data">
												<div class = "form-group col-lg-12">	
													<label>Scan Nota Dinas</label>
													<input type = "hidden" class = "form-control" name = "txt_scan_nota_dinas_old" id = "txt_scan_nota_dinas_old" readonly style = "background-color: lightgrey">
													<input type = "text" class = "form-control" name = "txt_scan_nota_dinas" id = "txt_scan_nota_dinas" readonly>	
													<input type='file' id='file_name' name='file_name' onchange = " readURL(this);" accept = "image/jpeg, application/pdf"/>												
												</div>											
											</form>	

											<form id = "formPendukung" enctype = "multipart/form-data">
												<input type = "hidden" id = "txt_jml" class = "txt_jml" />	
												<div class = "form-group col-lg-12">
													<label><strong> Dokumen Pengajuan Perbup / Kepbup </strong></label>
													<div class = "input_fields_wrap">												
														
													</div>
												</div>
												<div class = "form-group col-lg-6">	
													<input id='btnupload' class = "btn m-indigo legitRipple" value = "Add" type = "button">
												</div>
											</form>	
										</div>	
										<p><p>
										<center>
											<div class = "form-group col-lg-12">
												<input class = "btn m-indigo legitRipple" id = "btnSave" value = "Save" type = "submit">
												<input class = "btn m-indigo legitRipple" id = "btnSubmit" value = "Submit" type = "submit">
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
?>