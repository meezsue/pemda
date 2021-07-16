<script type = "text/javascript">
	$(document).ready(function(){
		
		var base_url		= '<?php echo base_url(); ?>';
		var dataOrg  		= [] ; 
		var jml_max 		= 7;		
		
		$("#btnSaveModal").hide();
		$("#btnSubmitModal").hide();
		$("#btnApproveModal").hide();
		$("#btnRejectModal").hide();
		$("#btnReturnModal").hide();		

		$('#txt_tgl_terima').bootstrapMaterialDatePicker({ weekStart : 0, time: false });		
		$('#txt_tgl_surat').bootstrapMaterialDatePicker({ weekStart : 0, time: false });		
		$('#txt_tgl_ttd').bootstrapMaterialDatePicker({ weekStart : 0, time: false });	

		$("#btnupload").click(function(e){
			e.preventDefault();
			var j	= parseInt($("#txt_jml").val()) + 1;	
			$("#txt_jml").val(j);
			
			if(j < jml_max)
			{									
				var k = j-1;
				
				var txt_doc_pendukung	= $("#txt_dokumen"+k).val();
				
				if(txt_doc_pendukung != ""){
					$(".input_fields_wrap").append("<div class = 'form-group col-lg-6 div_add_dokumen' id = 'div_add_dokumen_"+j+"'><input type = 'hidden' class = 'form-control' name = 'txt_nota_dinas_ext"+j+"' id = 'txt_nota_dinas_ext"+j+"' readonly style = 'background-color: lightgrey'><input type = 'text' class = 'form-control txt_dokumen' txt_dokumen = '"+j+"' name = 'txt_dokumen[]' class = 'txt_dokumen' id = 'txt_dokumen"+j+"' /><input type = 'hidden' class = 'form-control txt_dokumen_ext' txt_dokumen_ext = '"+j+"' name = 'txt_dokumen_ext[]' id = 'txt_dokumen_ext"+j+"'><input type = 'hidden' class = 'form-control txt_dokumen_new' txt_dokumen_new = '"+j+"' name = 'txt_dokumen_new[]' id = 'txt_dokumen_new"+j+"'><input type='file' id='file_dokumen_"+j+"' name='myfile[]' file_dokumen ='"+j+"' class = 'file_dokumen' accept = 'image/jpeg, application/pdf' multiple='' /></div>");																								
					
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
						$('#txt_dokumen_new'+j).val($(this).val().split('\\').pop());
						
						var lamp 		= 'LAMP'
						var i			= j - 1;
						var file_code	= lamp + i;
						var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');	
						var revisi;
						
						$.ajax({
							url			: base_url + "pemda/generate_revisi_nota_dinas",
							type		: 'post',
							data		: {no_nota_dinas: $("#txt_nota_dinas").val()},
							dataType	: 'json',
							success : function(hasil){									
								revisi	= parseInt(hasil['revisi']) + 1;	
								$("#txt_revisi").val(revisi);
							}
						})
						
						if(j==1)
						{											
							setTimeout(function(){ generate_file_code(file_code, nama, $("#txt_revisi").val()); }, 300);
						}
						else
						{									
							setTimeout(function(){ generate_file_code_lampiran(file_code, nama, $("#txt_revisi").val(), j); }, 300);							
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
					
					$("#txt_jml").val(j);
					return false;	
				}	
								
			} 					
		});		
		
		var generate_file_code = function(file_code, nama, revisi){
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
		
		$("#btnSubmitReturn").click(function(){
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
			else
			{
				var formUrl     = base_url + 'pemda/cek_edit_document';
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
							swal({
                                title: "Success!",
                                text:  "Document Has Been Revised",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
							window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);
						}
					}
				}); 				
			}
		});
			
		/*Kabag*/
		$("#btnSaveModal").click(function(){
			var txt_kode_unit			= $("#txt_kode_unit_surat2").val(),
				txt_nama_unit			= $("#txt_nama_unit_surat").val(),
				txt_tgl_terima			= $("#txt_tgl_terima").val(),
				txt_tgl_ttd				= $("#txt_tgl_ttd").val(),
				txt_nota_surat			= $("#txt_nota_surat").val(),
				txt_nota_surat_ext		= $("#txt_nota_surat_ext").val(),
				txt_nota_dinas_modal	= $("#txt_nota_dinas_modal").val(),
				txt_nota_agenda			= $("#txt_nota_agenda").val(),
				txt_tgl_surat			= $("#txt_tgl_surat").val(),
				txt_sifat				= $('input[type=radio][name=optSifat]:checked').val(),
				txt_perihal_disposisi	= $("#txt_perihal_disposisi").val(),
				txt_catatan				= $("#txt_catatan").val(),
				txt_diteruskan			= $("#txt_diteruskan").val(),
				txt_kota				= $("#txt_kota").val(),				
				txt_harap				= $('input[type=radio][name=chk_harap]:checked').val();

					
			if(txt_kode_unit == "" || txt_nama_unit == ""  || txt_tgl_terima == "" || txt_tgl_ttd == "" || txt_nota_agenda == "" || txt_tgl_surat == "" || txt_sifat =="" || txt_perihal_disposisi == "" || txt_catatan == "" || txt_diteruskan == "" || txt_kota =="" || txt_harap ==""){
				
				swal({
					title: "Warning",
					text: "Data tidak boleh kosong!",
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
			
			$.ajax({
				url			: base_url + "pemda/save_nota_disposisi",
				type		: 'post',
				data		: {txt_kode_unit: txt_kode_unit, txt_nama_unit: txt_nama_unit, txt_tgl_terima: txt_tgl_terima, txt_tgl_ttd: txt_tgl_ttd, txt_nota_surat: txt_nota_surat,
							   txt_nota_surat_ext: txt_nota_surat_ext, txt_nota_dinas_modal: txt_nota_dinas_modal, txt_nota_agenda: txt_nota_agenda, txt_tgl_surat: txt_tgl_surat, txt_sifat: txt_sifat, 
							   txt_perihal_disposisi: txt_perihal_disposisi, txt_catatan: txt_catatan, txt_diteruskan: txt_diteruskan, txt_kota: txt_kota, txt_harap: txt_harap},
			   dataType		: 'json',
			   success : function(hasil){
					if(hasil)
					{
						swal({
                                title: "Success!",
                                text:  "Disposisi Has Been Created",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);                        	
					}				    
			   }
			});
			
			return false;
		})	
		
		$("#btnSubmitModal").click(function(e){	
			e.preventDefault();
			
			var id_detail		= $("#txt_id_modal_kabag").val();
			var txt_nota_surat	= $("#txt_nota_surat").val();
										
			if($("#txt_nota_surat_ext").val() == '')
			{
				var txt_kode_unit		= $("#txt_kode_unit_surat2").val(),
				txt_nama_unit			= $("#txt_nama_unit_surat").val(),
				txt_tgl_terima			= $("#txt_tgl_terima").val(),
				txt_tgl_ttd				= $("#txt_tgl_ttd").val(),
				txt_nota_surat			= $("#txt_nota_surat").val(),
				txt_nota_surat_ext		= $("#txt_nota_surat_ext").val(),
				txt_nota_dinas_modal	= $("#txt_nota_dinas_modal").val(),
				txt_nota_agenda			= $("#txt_nota_agenda").val(),
				txt_tgl_surat			= $("#txt_tgl_surat").val(),
				txt_sifat				= $('input[type=radio][name=optSifat]:checked').val(),
				txt_perihal_disposisi	= $("#txt_perihal_disposisi").val(),
				txt_catatan				= $("#txt_catatan").val(),
				txt_diteruskan			= $("#txt_diteruskan").val(),
				txt_kota				= $("#txt_kota").val(),				
				txt_harap				= $('input[type=radio][name=chk_harap]:checked').val();

				$.ajax({
					url			: base_url + "pemda/save_nota_disposisi",
					type		: 'post',
					data		: {txt_kode_unit: txt_kode_unit, txt_nama_unit: txt_nama_unit, txt_tgl_terima: txt_tgl_terima, txt_tgl_ttd: txt_tgl_ttd, txt_nota_surat: txt_nota_surat,
								   txt_nota_surat_ext: txt_nota_surat_ext, txt_nota_dinas_modal: txt_nota_dinas_modal, txt_nota_agenda: txt_nota_agenda, txt_tgl_surat: txt_tgl_surat, txt_sifat: txt_sifat, 
								   txt_perihal_disposisi: txt_perihal_disposisi, txt_catatan: txt_catatan, txt_diteruskan: txt_diteruskan, txt_kota: txt_kota, txt_harap: txt_harap},
				   dataType		: 'json',
				   async		: false,
				   success : function(hasil){
						if(hasil)
						{
							$.ajax({
								url			: base_url + "pemda/submit_nota_disposisi",
								type		: 'post',
								data		: {id_detail: id_detail, txt_nota_surat: txt_nota_surat},
								dataType	: 'json',
								async		: false,
								success : function(hasil){
									if(hasil)
									{
										swal({
												title: "Success!",
												text:  "Disposisi Has Been Submitted",
												type:  "success",
												timer: 5000,
												showConfirmButton: true
											});
											
										//window.open(base_url+ 'pemda/print_disposisi/'+id_detail,'PRINT DISPOSISI', "_blank");	
										window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,2000);                        	
									}				    
								}
							});                      	
						}				    
				    }
				});
			}
			else
			{
				$.ajax({
				url			: base_url + "pemda/submit_nota_disposisi",
				type		: 'post',
				data		: {id_detail: id_detail, txt_nota_surat: txt_nota_surat},
			    dataType	: 'json',
			    success : function(hasil){
					if(hasil)
					{
						swal({
                                title: "Success!",
                                text:  "Disposisi Has Been Submitted",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
						//window.open(base_url+ 'pemda/print_disposisi/'+id_detail,'PRINT DISPOSISI', "_blank");
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,2000);                        	
					}				    
			    }
				});
			}				
		});		
		/*Sampai Sini*/
		
		
		/*Kasubag*/
		$("#btnApproveModal").click(function(){			
			var dataOrg  		= [] ; 
			var txt_nota_dinas	= $("#txt_nota_dinas_modal").val();
			var id_modal		= $("#txt_id_modal_skpd").val();
			var chk_upload;
			var chkDoc 			= 0;
		
            $('.isi_ceklist tr').each(function(row, tr){
				
				var keterangan			= $(this).find('input.txt_keterangan').val(),
					upload				= $(this).find('input.txt_upload').val(),
					upload_file_code	= $(this).find('input.txt_file_code').val(),
					upload_file_name	= $(this).find('input.txt_upload_file_name').val();
				
				dataOrg[row] = {
					"keterangan"    : keterangan,
					"cheklist"		: upload,
					"file_code"		: upload_file_code,
					"file_name"		: upload_file_name
				}
				
				if(dataOrg[row].cheklist == "1"){
					chkDoc = chkDoc + 1;
				}
				
            });	
			
			
			if(chkDoc < dataOrg.length){	
				swal({
					title: "Warning",
					text: "Ceklist Dokumen tidak Lengkap !",
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
			
			$.ajax({
				url			: base_url + "pemda/save_ceklist_dokumen",
				type		: 'post',
				data		: {id_modal: id_modal, dataOrg: dataOrg, txt_nota_dinas: txt_nota_dinas, aksi: 'A'},
				dataType	: 'json',
				success : function(hasil){
					if(hasil)
					{
						
						swal({
                                title: "Success!",
                                text:  "CekList Document Has Been Approved",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);           
						                      	
					}	
				}
			}) 
		});
		
		$("#btnRejectModal").click(function(){
			
			var txt_nota_dinas	= $("#txt_nota_dinas_modal").val();
			var id_modal		= $("#txt_id_modal_skpd").val();
			var chk_upload;
					
            $('.isi_ceklist tr').each(function(row, tr){
				
				var keterangan			= $(this).find('input.txt_keterangan').val(),
					upload				= $(this).find('input.txt_upload').val(),
					upload_file_code	= $(this).find('input.txt_file_code').val(),
					upload_file_name	= $(this).find('input.txt_upload_file_name').val();
				
				dataOrg[row] = {
					"keterangan"    : keterangan,
					"cheklist"		: upload,
					"file_code"		: upload_file_code,
					"file_name"		: upload_file_name
				}
            });		
			
			
			$.ajax({
				url			: base_url + "pemda/save_ceklist_dokumen",
				type		: 'post',
				data		: {id_modal: id_modal, dataOrg: dataOrg, txt_nota_dinas: txt_nota_dinas, aksi: 'R'},
				dataType	: 'json',
				success : function(hasil){
					if(hasil)
					{
						swal({
                                title: "Success!",
                                text:  "CekList Document Has Been Rejected",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);                        	
					}	
				}
			})
		});
		
		
		$("#btnReturnModal").click(function(){
			var txt_nota_dinas	= $("#txt_nota_dinas_modal").val();
			var id_modal		= $("#txt_id_modal_skpd").val();
			var chk_upload;
			
            $('.isi_ceklist tr').each(function(row, tr){
				
				var keterangan			= $(this).find('input.txt_keterangan').val(),
					upload				= $(this).find('input.txt_upload').val(),
					upload_file_code	= $(this).find('input.txt_file_code').val(),
					upload_file_name	= $(this).find('input.txt_upload_file_name').val();
				
				dataOrg[row] = {
					"keterangan"    : keterangan,
					"cheklist"		: upload,
					"file_code"		: upload_file_code,
					"file_name"		: upload_file_name
				}
            });			
			
			$.ajax({
				url			: base_url + "pemda/save_ceklist_dokumen",
				type		: 'post',
				data		: {id_modal: id_modal, dataOrg: dataOrg, txt_nota_dinas: txt_nota_dinas, aksi: 'T'},
				dataType	: 'json',
				success : function(hasil){
					if(hasil)
					{
						swal({
                                title: "Success!",
                                text:  "CekList Document Has Been Returned",
                                type:  "success",
                                timer: 5000,
                                showConfirmButton: true
                            });
							
                        window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);                        	
					}	
				}
			})
		});
		/*Sampai Sini Kasubag*/
		
		/*Pelaksana*/
		$('#txt_draft').click(function(e){
			e.preventDefault();
			$('#file_draft').click();
		});			
		
		$('#file_draft').change(function(){
			var ukuran	= this.files[0];
			if(ukuran > 5120)
			{
				alert("Maximum : 5MB");
				return false;
			}
			$('#txt_draft').val($(this).val().split('\\').pop());
		})		

		$("#btnApprovePelaksana").click(function(){
			var id_modal	= $("#txt_id_modal_skpd").val();
			$.ajax({
				url			: base_url + "pemda/save_history_approval",
				type		: 'post',
				data		: {id_modal: id_modal},
				dataType	: 'json',
				success : function(result){
					if(result){
						var formUrl     = base_url + 'pemda/save_draft';
						var formData    = new FormData($('#formUploadDraft')[0]);
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
									swal({
											title: "Success!",
											text:  "Document Has Been Approved",
											type:  "success",
											timer: 5000,
											showConfirmButton: true
										});
										
									window.setTimeout(function(){ window.location.href = base_url + 'pemda/dasboard'; } ,1000);  
								}
							}
						}); 						
					}
				}
			});
		});

		$('#txt_tgl_terima').val('<?php echo date('Y-m-d'); ?>');			
		$('#txt_tgl_surat').val('<?php echo date('Y-m-d'); ?>');			
		$('#txt_tgl_ttd').val('<?php echo date('Y-m-d'); ?>');			
		
		$('#txt_tgl_terima').dateTimePicker("setDate", new Date());		
		$('#txt_tgl_surat').dateTimePicker("setDate", new Date());		
		$('#txt_tgl_ttd').dateTimePicker("setDate", new Date());			
		/*Sampai Sini Pelaksana*/
	});
</script>
<style type = "text/css">
	#file_draft { width:0; height:0; } 
	legend {font-size: 12px;}
	.modal-header{ background :#3F51B5 !important; }
	
	h4{
		margin-top		: 1px;
		margin-bottom	: 10.5px;
	}
	
	.modal-body{ padding: 1px;	}
	
	.row
	{
		margin-left		: -1px;
		margin-right	: -1px;
	}
	
	.col-lg-12
	{
		padding-left	: 1px;
		padding-right	: 1px;
	}
	
	.panel-body
	{
		padding:0px;
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
<div id = "myModal" class = "modal fade" role = "dialog" data-backdrop = "static" data-keyboard = "false">
	<div class = "modal-dialog modal-lg">

		<!-- Modal content-->
		<div class = "modal-content">
			<div class = "modal-header">
				<button type = "button" class = "close" data-dismiss = "modal" style = "color:white;top: -5px;right: -5px;">&times;</button>
				<h4 style = "color:white;">Data Detail</h4>
			</div>
			<div class = "modal-body">
				
				<input type = "hidden" name = "txt_unit_key_modal" id = "txt_unit_key_modal" />
				<input type = "hidden" name = "txt_status_modal" id = "txt_status_modal" />
				<div class = "row">
					<div class = "col-lg-12">
						<div class = "panel-body">
							<div class = "row">
								<div class = "wrapper center-block">
									<div class = "panel-group" id = "accordion" role = "tablist" aria-multiselectable = "true">
										<div class = "panel panel-default" id = "div_one">
											<div class = "panel-heading-accordion active" role = "tab" id = "headingOne">
												<div class = "panel-title-accordion" style = "font-size: 14px;background:rgb(179, 179, 179);">
													<a role = "button" data-toggle = "collapse" data-parent = "#accordion" href = "#collapseOne" aria-expanded = "false" aria-controls = "collapseOne" style="padding-top: 5px;padding-bottom: 5px;text-transform: none;">Data Nota Dinas</a>
												</div>
											</div>
											<div id = "collapseOne" class = "panel-collapse collapse in" role = "tabpanel" aria-labelledby = "headingOne">
												<div class = "panel-body" style="padding-top: 15px;">
													
														<form role = "form" id = "formNota" method = "post" onsubmit = "return false">
															<input type = "hidden" name = "txt_id_modal_skpd" id = "txt_id_modal_skpd" />
															<div class = "form-group col-lg-2">
																<label>Dinas</label>
																<input type = "hidden" class = "form-control" name = "txt_kode_unit_modal2" id = "txt_kode_unit_modal2" readonly style = "background-color: lightgrey">
																<input type = "text" class = "form-control" name = "txt_kode_unit_modal" id = "txt_kode_unit_modal" readonly style = "background-color: lightgrey">
															</div>	
															<div class = "form-group col-lg-10">
																<label>&nbsp;</label>
																<input type = "text" class = "form-control" name = "txt_nama_unit_modal" id = "txt_nama_unit_modal" readonly style = "background-color: lightgrey">
															</div>												
																		
															<div class = "form-group col-lg-2">
																<label>Jenis</label>
																<label>&nbsp;</label>
															</div>	
															<div class = "form-group col-lg-2">											
																<input type = "radio" name = "optJenis" id = "optJenis" value = "0">Perbup
															</div>	
															<div class = "form-group col-lg-3">
																<input type = "radio" name = "optJenis" id = "optJenis" value = "1">Kepbup
															</div>		
															<div class = "form-group col-lg-7"></div>												
															
															<div class = "form-group col-lg-6">
																<label>Tanggal Pengajuan</label>
																<input type = 'text' class = "form-control" id = 'txt_tgl_pengajuan'/>																		
															</div>		

															<div class = "form-group col-lg-6">
																<label>No. Nota Dinas</label>
																<input type = "text" class = "form-control" name = "txt_nota_dinas_modal" id = "txt_nota_dinas_modal" readonly style = "background-color: lightgrey">
															</div>	
															
															<div class = "form-group col-lg-12" style="padding-left: 15px;padding-right: 15px;">
																<label>Perihal</label>
																<textarea class = "form-control" name = "txt_perihal_modal" id = "txt_perihal_modal"></textarea>
															</div>	
															
															<div class = "form-group col-lg-3">
																<label>Scan Nota Dinas</label>
																<label>&nbsp;</label>																
															</div>
															<div class = "form-group col-lg-8">
																<div id = "div_scan_nota_dinas"></div>
															</div>
															
															<div class = "form-group col-lg-12" style="padding-left: 15px;padding-right: 15px;">
																<label>Dokumen Pengajuan Perbup / Kepbup</label>
																<div id = "div_dokumen_pendukung">
																</div>
															</div>
														</form>																																																													
												</div>
											</div>
										</div>																			
										<div class = "panel panel-default" id = "div_one_ext">
											<div class = "panel-heading-accordion active" role = "tab" id = "headingOneExt">
												<div class = "panel-title-accordion" style = "font-size: 14px;background:rgb(179, 179, 179);">
													<a role = "button" data-toggle = "collapse" data-parent = "#accordion" href = "#collapseOneExt" aria-expanded = "false" aria-controls = "collapseOneExt" style="padding-top: 5px;padding-bottom: 5px;text-transform: none;">Data Nota Dinas</a>
												</div>
											</div>
											<div id = "collapseOneExt" class = "panel-collapse collapse in" role = "tabpanel" aria-labelledby = "headingOneExt">
												<div class = "panel-body" style="padding-top: 15px;">													
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
																<input type = 'text' class = "form-control" id = 'datecustom'  />
																<span class = "input-group-addon">
																<span class = "zmdi zmdi-calendar-note"></span>
																</span>
															</div>
														</div>		

														<div class = "form-group col-lg-6">
															<label>No. Nota Dinas</label>
															<input type = "text" class = "form-control" name = "txt_nota_dinas" id = "txt_nota_dinas" readonly style = "background-color: lightgrey">
														</div>	
														
														<div class = "form-group col-lg-12" style = "padding-left: 10px">
															<label>Perihal</label>
															<textarea class = "form-control" name = "txt_perihal" id = "txt_perihal" style = "width: 98%"></textarea>
														</div>	
													</form>
													
													<form id = "formUpload" enctype = "multipart/form-data">
														<div class = "form-group col-lg-12" style = "padding-left: 10px">	
															<label>Scan Nota Dinas</label>
															<input type = "hidden" class = "form-control" name = "txt_scan_nota_dinas_old" id = "txt_scan_nota_dinas_old" readonly style = "background-color: lightgrey">
															<input type = "text" class = "form-control" name = "txt_scan_nota_dinas" id = "txt_scan_nota_dinas" style = "width: 98%" readonly>																
														</div>											
													</form>	

													<form id = "formPendukung" enctype = "multipart/form-data">
														<input type = "hidden" id = "txt_revisi" name = "txt_revisi" />		
														<input type = "hidden" id = "txt_jml" />	
														<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext" id = "txt_nota_dinas_ext1" readonly style = "background-color: lightgrey">
														<div class = "form-group col-lg-12" style = "padding-left: 10px">
															<label><strong> Dokumen Pengajuan Perbup / Kepbup </strong></label>
															<div class = "input_fields_wrap">												
																
															</div>
														</div>
														<div class = "form-group col-lg-6">	
															<input id='btnupload' class = "btn m-indigo legitRipple" value = "Add" type = "button">
														</div>
													</form>																																																												
												</div>
											</div>
										</div>
										<div class = "panel panel-default" id = "div_two">
											<div class = "panel-heading-accordion" role = "tab" id = "headingTwo">
												<div class = "panel-title-accordion"  style = "font-size: 14px;background:rgb(179, 179, 179);">
													<a class = "collapsed" role = "button" data-toggle = "collapse" data-parent = "#accordion" href = "#collapseTwo" aria-expanded = "false" aria-controls = "collapseTwo" style="padding-top: 5px;padding-bottom: 5px;text-transform: none;">Create Disposisi</a>
												</div>
											</div>
											<div id = "collapseTwo" class = "panel-collapse collapse" role = "tabpanel" aria-labelledby = "headingTwo">
												<div class = "panel-body" style="padding-top: 15px;">
													<form role = "form" id = "formDisposisi" method = "post" onsubmit = "return false">	
														<input type = "hidden" name = "txt_id_modal_kabag" id = "txt_id_modal_kabag" />
														<div class = "form-group col-lg-2">
															<label>Surat Dari</label>
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
																<input type = 'text' class = "form-control input-group date" id = 'txt_tgl_terima' />
																<span class = "input-group-addon">
																	<span class = "zmdi zmdi-calendar-note"></span>
																</span>
															</div>
														</div>		

														<div class = "form-group col-lg-6">
															<label>No. Surat</label>
															<input type = "hidden" class = "form-control" name = "txt_nota_surat_ext" id = "txt_nota_surat_ext"  >
															<input type = "text" class = "form-control" name = "txt_nota_surat" id = "txt_nota_surat"  >
														</div>	
														<div class = "form-group col-lg-6">
															<label>No. Agenda</label>
															<input type = "text" class = "form-control" name = "txt_nota_agenda" id = "txt_nota_agenda"  >
														</div>	
														
														<div class = "form-group col-lg-6">
															<label>Tanggal Surat</label>
															<div class = 'input-group'>
																<input type = 'text' class = "form-control input-group date" id = 'txt_tgl_surat' />
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
															<input type = "radio" name = "optSifat" id = "optSifat" value = "1">Sangat Segera
														</div>	
														<div class = "form-group col-md-2">
															<input type = "radio" name = "optSifat" id = "optSifat" value = "2">Segera
														</div>	
														<div class = "form-group col-md-2">
															<input type = "radio" name = "optSifat" id = "optSifat" value = "3">Rahasia
														</div>																				
														
														<div class = "form-group col-lg-6">
															<label>Perihal</label>
															<textarea class = "form-control" name = "txt_perihal_disposisi" id = "txt_perihal_disposisi"></textarea>
														</div>	
														
														<div class = "form-group col-lg-6">
															<label>Catatan</label>
															<textarea class = "form-control" name = "txt_catatan" id = "txt_catatan"></textarea>
														</div>							
														
														<div class = "form-group col-lg-12" style="padding-left: 15px;padding-right: 15px;">
															<label>Diteruskan</label>
															<input type = "text" class = "form-control" name = "txt_diteruskan" id = "txt_diteruskan"  >
														</div>		
														
														<div class = "form-group col-lg-6">
															<label>Kota Disposisi</label>
															<input type = "text" class = "form-control" name = "txt_kota" id = "txt_kota"  >
														</div>	
														<div class = "form-group col-lg-6">
															<label>Tanggal Tanda Tangan</label>
															<div class = 'input-group'>
																<input type = 'text' class = "form-control input-group date" id = 'txt_tgl_ttd' />
																<span class = "input-group-addon">
																<span class = "zmdi zmdi-calendar-note"></span>
																</span>
															</div>
														</div>																
														
														<div class = "form-group col-lg-3">
															<label>Dengan hormat harap</label>
															<label>&nbsp;</label>
														</div>	
														<div class = "form-group col-lg-3">											
															<input type = "radio" name = "chk_harap" id = "chk_harap" value = "1">Tanggapan Dan Saran
														</div>	
														<div class = "form-group col-lg-3">
															<input type = "radio" name = "chk_harap" id = "chk_harap" value = "2">Proses Lebih Lanjut
														</div>	
														<div class = "form-group col-lg-3">
															<input type = "radio" name = "chk_harap" id = "chk_harap" value = "3">Koordinasikan/Konfirmasikan
														</div>
													</form>
												</div>
											</div>
										</div>
										
										<div class = "panel panel-default" id = "div_three">
											<div class = "panel-heading-accordion" role = "tab" id = "headingThree">
												<div class = "panel-title-accordion" style="font-size: 14px;background:rgb(179, 179, 179);">
													<a role = "button" data-toggle = "collapse" data-parent = "#accordion" href = "#collapseThree" aria-expanded = "true" aria-controls = "collapseThree" style="padding-top: 5px;padding-bottom: 5px;text-transform: none;">Ceklist Dokumen</a>
												</div>
											</div>
											<div id = "collapseThree" class = "panel-collapse collapse" role = "tabpanel" aria-labelledby = "headingThree">
												<div class = "panel-body">															
														<form role = "form" id = "formCeklist" method = "post" onsubmit = "return false">																																
															<table class = "table table-bordered">
																<thead>
																	<tr>
																		<th style = "width: 2%"><center>No</center></th>
																		<th style = "width: 10%"><center>Kelengkapan</center></th>
																		<th style = "width: 2%">&nbsp;</th>
																		<th style = "width: 10%"><center>Keterangan</center></th>
																	</tr>
																</thead>
																<tbody id = "isi_ceklist" class = "isi_ceklist"></tbody>
															</table>																	
														</form>																																																													
												</div>
											</div>
										</div>												
										
										<div class = "panel panel-default" id = "div_four">
											<div class = "panel-heading-accordion" role = "tab" id = "headingFour">
												<div class = "panel-title-accordion" style="font-size: 14px;background:rgb(179, 179, 179);">
													<a role = "button" data-toggle = "collapse" data-parent = "#accordion" href = "#collapseFour" aria-expanded = "true" aria-controls = "collapseFour" style="padding-top: 5px;padding-bottom: 5px;text-transform: none;">Upload Dokumen Draft Perbup & Kepbup</a>
												</div>
											</div>
											<div id = "collapseFour" class = "panel-collapse collapse" role = "tabpanel" aria-labelledby = "headingFour">
												<div class = "panel-body" style="padding-top: 15px;">	
														<div class = "form-group col-lg-6">
															<form role = "form" id = "formDraft" method = "post" onsubmit = "return false">																																
																<div class = "form-group col-lg-12">
																	<label>Tanggal Approval Kabag Hukum</label>
																	<input type = "text" class = "form-control input-group" id = "txt_approval_kabag" style = "background-color: lightgrey" readonly />
																</div>																	
																<div class = "form-group col-lg-12">
																	<label>Tanggal Approval Kasubag</label>
																	<input type = 'text' class = "form-control input-group" id = 'txt_approval_kasubag' style = "background-color: lightgrey" readonly />					
																</div>									
															</form>	
														</div>
														<div class = "form-group col-lg-6">
															<form id = "formUploadDraft" enctype = "multipart/form-data">
																<input type = "hidden" class = "form-control" name = "txt_nota_surat_kabag" id = "txt_nota_surat_kabag"  >
																<div class = "form-group col-lg-12">	
																	<fieldset>
																		<legend><strong> Dokumen Draft Perbup / Kepbup </strong></legend>
																		<div class = "input_fields_wrap">												
																			<div class = "form-group col-lg-12">												
																				<input type = "hidden" class = "form-control" name = "txt_draft_ext" id = "txt_draft_ext" readonly style = "background-color: lightgrey" readonly />
																				<input type = "text" class = "form-control txt_draft" txt_draft = "1" name = "txt_draft" id = "txt_draft"  />																					
																				<input type='file' id='file_draft' file_draft = '1' name='file_draft' class = 'file_draft' accept = "image/jpeg, application/pdf" multiple = ""  />														
																				<span id = "span_draft"></span>
																			</div>	
																			<div class = "form-group col-lg-12">
																				<label>Keterangan</label>
																				<textarea class = "form-control" name = "txt_keterangan" id = "txt_keterangan"></textarea>
																			</div>
																		</div>																											
																	</fieldset>
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
					<div class = "modal-footer">									
						<button type = "button" class = "btn m-indigo" id = "btnSaveModal">Save</button>
						<button type = "button" class = "btn m-indigo" id = "btnSubmitModal">Submit</button>
						<button type = "button" class = "btn m-indigo" id = "btnApproveModal">Approve</button>
						<button type = "button" class = "btn m-indigo" id = "btnRejectModal">Reject</button>						
						<button type = "button" class = "btn m-indigo" id = "btnReturnModal">Return</button>						
						<button type = "button" class = "btn m-indigo" id = "btnApprovePelaksana">Approve</button>						
						<button type = "button" class = "btn m-indigo" id = "btnSubmitReturn">Submit</button>						
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>