
<head>
	<?php include("assets/component/top.php"); ?>
	<style type = "text/css">
		body, input, table, .panel-title-accordion { font-family: Tahoma; font-size: 12px}					

		.col-xs-3 > i
		{
			opacity: 0.4;
		}
		
		.panel
		{
			border-radius: 15px;
		}
		
		.panel-blue > .panel-heading
		{
			border-color		: #085da0;
			background-color	: #085da0;
			color				: #fff;
			border				: 2px solid #085da0;
			border-radius		: 15px;
		}
		
		.panel-yellow > .panel-heading
		{
			background-color: #e6e600;
		}
			
		.card
		{
			border-radius: 15px;
		}
		
		.product-preview-card
		{
			padding:10px 
		}
		
		.modal-lg 
		{
			max-width: 900px;
		}
		@media (min-width: 768px) 
		{
			.modal-lg 
			{
				width: 100%;
			} 
		}
		@media (min-width: 992px) 
		{
			.modal-lg 
			{
				width: 900px;
			}
		}
		
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
		
		.panel-heading-accordion 
		{
			padding	: 0;
			border	: 0;
		}
		
		.panel-title-accordion>a, .panel-title-accordion>a:active
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
		
		.panel-heading-accordion  a:before 
		{
		   font-family		: 'Glyphicons Halflings';
		   content			: "\e114";
		   float			: right;
		   transition		: all 0.5s;
		}
		
		.panel-heading-accordion.active a:before {
			-webkit-transform	: rotate(180deg);
			-moz-transform		: rotate(180deg);
			transform			: rotate(180deg);
		} 	

		.page-header
		{
			border-bottom	: 2px solid #3F51B5 !important;
		}
		
		.td
		{
			height:20;
		}
			
	</style>

    <title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
	<script type = "text/javascript">
		$(document).ready(function(){
			var base_url	= '<?php echo base_url(); ?>';
			var urut		= '<?php echo $this->session->userdata('urut'); ?>';
			var unit_key	= '<?php echo $this->session->userdata('unit_key'); ?>';

			var generate_new = function(){
				$.ajax({
					url			: base_url + "pemda/generate_new",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						var count_new	= '<div class = "counter" id = "div_count_new">'+hasil['jumlah']+'</div>';
						$("#div_new").append(count_new);
						
						$("#div_count_new").click(function(){							
							$("#div_dokumen").empty();
							generate_dokumen_dashboard(1);
						});
					}
				})			
			},
			
			generate_progress = function(){
				$.ajax({
					url			: base_url + "pemda/generate_progress",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						var count_progress	= '<div class = "counter" id = "div_count_progress">'+hasil['jumlah']+'</div>';
						$("#div_progress").append(count_progress);
						
						$("#div_count_progress").click(function(){
							$("#div_dokumen").empty();
							generate_dokumen_dashboard(2);
						});
					}
				})			
			},	

			generate_reject = function(){
				$.ajax({
					url			: base_url + "pemda/generate_reject",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						var count_reject	= '<div class = "counter" id = "div_count_reject">'+hasil['jumlah']+'</div>';
						$("#div_reject").append(count_reject);
						
						$("#div_count_reject").click(function(){
							$("#div_dokumen").empty();
							generate_dokumen_dashboard(5);
						});
					}
				})			
			},	
			
			generate_approve = function(){
				$.ajax({
					url			: base_url + "pemda/generate_approve",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						var count_approve	= '<div class = "counter" id = "div_count_approve">'+hasil['jumlah']+'</div>';
						$("#div_approve").append(count_approve);
						
						$("#div_count_approve").click(function(){
							$("#div_dokumen").empty();
							generate_dokumen_dashboard(9);
						});
					}
				})			
			},				
			
			generate_dokumen_dashboard = function(id){
				$.ajax({
					url			: base_url + "pemda/generate_dokumen_dashboard",
					type		: 'post',
					data		: {id: id},
					dataType	: 'json',
					success : function(hasil){
						
						var status_desc;
						if(hasil == 1)
						{											
							$.ajax({
								url			: base_url + "pemda/generate_dokumen",
								type		: 'post',
								data		: {id: id, jml : '1'},
								dataType	: 'json',
								success : function(hasil){	
									var status		= hasil['status_dokumen_id'];
									var status_desc	= hasil['status_dokumen'];
									
									if(hasil['no_nota_dinas'] == undefined)
									{
										no_nota	= '-';
									}
									else
									{
										no_nota	= hasil['no_nota_dinas'];
									}
									
									if(hasil['tgl_nota_dinas'] == undefined)
									{
										tgl_nota	= '-';
									}
									else							
									{
										tgl_nota	= hasil['tgl_nota_dinas'];
									}

									if(hasil['perihal'] == undefined)
									{
										perihal	= '-';
									}	
									else							
									{
										perihal	= hasil['perihal'];
									}							
										
									
									var dokumen	    = '<div class = "col-xs-6 col-md-6 m-responsive">';
										dokumen	   += '<div class = "card">';
										dokumen	   += '<div class = "product-preview" id = "div_detail_dokumen" div_detail_dokumen = "'+hasil['no_nota_dinas']+'" style = "border-radius: 15px;">'; 
										dokumen	   += '<div class = "product-preview-card">';
										dokumen	   += '<div>';
										dokumen	   += '<table style = "width:100%" class = "table">';
										dokumen	   += '<tbody>';
										dokumen	   += '<tr><td style = "width:100px">Status </td><td>:</td><td>'+status_desc+'</td></tr>';
										dokumen	   += '<tr><td valign = "bottom">No. Nota Dinas </td><td>:</td><td>'+no_nota+'</td></tr>';
										dokumen	   += '<tr><td>Tgl. Pengajuan </td><td>:</td><td>'+tgl_nota+'</td></tr>';
										dokumen	   += '<tr><td class = "center">Perihal </td><td>:</td><td>'+perihal+'</td></tr>';
										dokumen	   += '</tbody>';								
										dokumen	   += '</table>';
										dokumen	   += '</div>';
										dokumen	   += '</div>';
										dokumen	   += '<span detail = "'+hasil['id']+'" id = "view" class = "product-details" style = " text-align: right;padding-right:10px;">View details</span>';
										dokumen	   += '</div>';
										dokumen	   += '</div>';
										dokumen	   += '</div>';	
								
									$("#div_dokumen").append(dokumen);		

									if(id == 1)
									{	
										$('#div_detail_dokumen').css('background-color', '#ccddff');
										$("#view").css("background-color", "#085da0");
									}	
									else if((id == 2) || (id == 3) || (id == 4)|| (id == 6))
									{
										$('#div_detail_dokumen').css("background-color", "#ffff99");
										$("#view").css("background-color", "#FFEB3B");
									}	
									else if(id == 5)
									{										
										$('#div_detail_dokumen').css("background-color", "#ffcccc");
										$("#view").css("background-color", "#AE1B10");
									}							
									else if((id == 7))
									{
										$('#div_detail_dokumen').css("background-color", "#80ff80");
										$("#view").css("background-color", "#19900C");
									}	
									
									$("span").click(function () {										
										var id_detail	= $(this).attr("detail");	

										$('#txt_id_modal_skpd').val(id_detail);
										$('#txt_id_modal_kabag').val(id_detail);
										$('#txt_unit_key_modal').val(unit_key);
										$('#txt_status_modal').val(id);	
										
										if(urut == 1)
										{		
											
											if(status == 1)
											{
												window.location.href = base_url + 'pemda/nota_dinas/' + id_detail;
											}
											else if(status == 2)
											{												
												$('#myModal').modal('show');	

												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").hide();	
												$("#div_three").hide();	
												$("#div_four").hide();	
												
												generate_nota_dinas_by_id(id_detail);													
											}
											else if(status == 3)
											{												
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").hide();													
												$("#div_four").hide();

												generate_nota_dinas_by_id(id_detail);	
												generate_disposisi_by_id(id_detail, urut);													
											}
											else if(status == 5)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();	
												
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);													
											}
											else if(status == 6)
											{												
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();

												generate_nota_dinas_by_id(id_detail);	
												generate_disposisi_by_id(id_detail, urut);
												generate_ceklist_dokumen(id_detail);		
											}
											else if(status == 7)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").show();
												
												$("#div_one").hide();
												$("#div_one_ext").show();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();												
													
												generate_dinas();
												generate_nota_dinas_by_id_ext(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);
											}
											else if(status == 8)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();												
													
												generate_dinas();
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);
											}
											else if(status == 9)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();											
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();	
												$("#btnReturnModal").hide();	
												$("#btnApprovePelaksana").hide();	
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();
												$("#div_four").show();
												
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);
												generate_ceklist_dokumen(id_detail);
												generate_history_approval(id_detail);
											}
										}
										else
										{			
											$('.panel-collapse').on('show.bs.collapse', function () {
												$(this).siblings('.panel-heading-accordion').addClass('active');
											});

											$('.panel-collapse').on('hide.bs.collapse', function () {
												$(this).siblings('.panel-heading-accordion').removeClass('active');
											});			
											
											$('#txt_id_modal_skpd').val(id_detail);
											$('#txt_id_modal_kabag').val(id_detail);
											$('#txt_unit_key_modal').val(unit_key);
											$('#txt_status_modal').val(id);
											$('#myModal').modal('show');
											
											if(urut == 2)
											{
												if(status == 2)
												{
													$("#btnSaveModal").show();
													$("#btnSubmitModal").show();
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").hide();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
												}
												else if(status == 3)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").hide();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
												}
												else if(status == 5)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
											else if(urut == 3)											
											{											
												if(status == 3)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 5)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
											else
											{
												if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").show();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
										}
									});									
								}	
							})
						}
						else
						{							
							$.ajax({
								url			: base_url + "pemda/generate_dokumen",
								type		: 'post',
								data		: {id: id, jml : '2'},
								dataType	: 'json',
								success : function(hasil){
									for(var i = 0; i < hasil.length; i++)
									{										
										var status_desc	= hasil[i].status_dokumen;
										
										if(hasil[i].no_nota_dinas == undefined)
										{
											no_nota	= '-';
										}
										else
										{
											no_nota	= hasil[i].no_nota_dinas;
										}
										
										if(hasil[i].tgl_nota_dinas == undefined)
										{
											tgl_nota	= '-';
										}
										else							
										{
											tgl_nota	= hasil[i].tgl_nota_dinas;
										}

										if(hasil[i].perihal == undefined)
										{
											perihal	= '-';
										}	
										else							
										{
											perihal	= hasil[i].perihal;
										}							
											
										
										var dokumen	    = '<div class = "col-xs-6 col-md-6 m-responsive" >';
											dokumen	   += '<div class = "card">';
											dokumen	   += '<div class = "product-preview" id = "div_detail_dokumen'+i+'" div_detail_dokumen = "'+hasil['no_nota_dinas']+'" style = "border-radius: 15px;">'; 
											dokumen	   += '<div class = "product-preview-card">';
											dokumen	   += '<div>';
											dokumen	   += '<table style = "width:100%">';
											dokumen	   += '<tbody>';
											dokumen	   += '<tr><td style = "width:100px; font-size: 12px">Status </td><td>:</td><td>'+status_desc+'</td></tr>';
											dokumen	   += '<tr><td valign = "bottom">No. Nota Dinas </td><td>:</td><td>'+no_nota+'</td></tr>';
											dokumen	   += '<tr><td>Tgl. Pengajuan </td><td>:</td><td>'+tgl_nota+'</td></tr>';
											dokumen	   += '<tr><td class = "center">Perihal </td><td>:</td><td>'+perihal+'</td></tr>';
											dokumen	   += '</tbody>';								
											dokumen	   += '</table>';
											dokumen	   += '</div>';
											dokumen	   += '</div>';
											dokumen	   += '<span detail = "'+hasil[i]['id']+'" status = "'+hasil[i]['status_dokumen_id']+'" id = "view'+i+'" class = "product-details" style = " text-align: right;padding-right:10px;">View details</span>';
											dokumen	   += '</div>';
											dokumen	   += '</div>';
											dokumen	   += '</div>';	
									
										$("#div_dokumen").append(dokumen);		

										if(id == 1)
										{	
											$('#div_detail_dokumen'+i).css('background-color', '#ccddff');
											$("#view"+i).css("background-color", "#085da0");
										}	
										else if((id == 2) || (id == 3) || (id == 4)|| (id == 6))
										{
											$('#div_detail_dokumen'+i).css("background-color", "#ffff99");
											$("#view"+i).css("background-color", "#FFEB3B");
										}	
										else if(id == 5)
										{
											
											$('#div_detail_dokumen'+i).css("background-color", "#ffcccc");
											$("#view"+i).css("background-color", "#AE1B10");
										}							
										else if((id == 7))
										{
											$('#div_detail_dokumen'+i).css("background-color", "#80ff80");
											$("#view"+i).css("background-color", "#19900C");
										}	
									}
									
									$("span").click(function () {										
										var id_detail	= $(this).attr("detail");	
										var status	    = $(this).attr("status");
										
										if(urut == 1)
										{											
											if(status == 1)
											{
												window.location.href = base_url + 'pemda/nota_dinas/' + id_detail;
											}
											else if(status == 2)
											{												
												$('#myModal').modal('show');	

												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").hide();	
												$("#div_three").hide();	
												$("#div_four").hide();	
												
												generate_nota_dinas_by_id(id_detail);													
											}
											else if(status == 3)
											{												
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").hide();													
												$("#div_four").hide();

												generate_nota_dinas_by_id(id_detail);	
												generate_disposisi_by_id(id_detail, urut);													
											}
											else if(status == 5)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();	
												
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);													
											}
											else if(status == 6)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();

												generate_nota_dinas_by_id(id_detail);	
												generate_disposisi_by_id(id_detail, urut);
												generate_ceklist_dokumen(id_detail);		
											}
											else if(status == 7)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").show();
												
												$("#div_one").hide();
												$("#div_one_ext").show();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();												
													
												generate_dinas();
												generate_nota_dinas_by_id_ext(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);
											}
											else if(status == 8)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();	
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();
												$("#btnReturnModal").hide();
												$("#btnApprovePelaksana").hide();
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();													
												$("#div_four").hide();												
													
												generate_dinas();
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);	
												generate_ceklist_dokumen(id_detail);
											}
											else if(status == 9)
											{
												$('#myModal').modal('show');
												
												$("#btnSaveModal").hide();
												$("#btnSubmitModal").hide();											
												$("#btnApproveModal").hide();
												$("#btnRejectModal").hide();	
												$("#btnReturnModal").hide();	
												$("#btnApprovePelaksana").hide();	
												$("#btnSubmitReturn").hide();
												
												$("#div_one").show();
												$("#div_one_ext").hide();
												$("#div_two").show();	
												$("#div_three").show();
												$("#div_four").show();
												
												generate_nota_dinas_by_id(id_detail);
												generate_disposisi_by_id(id_detail, urut);
												generate_ceklist_dokumen(id_detail);
												generate_history_approval(id_detail);
											}
										}
										else
										{			
											$('.panel-collapse').on('show.bs.collapse', function () {
												$(this).siblings('.panel-heading-accordion').addClass('active');
											});

											$('.panel-collapse').on('hide.bs.collapse', function () {
												$(this).siblings('.panel-heading-accordion').removeClass('active');
											});			
											
											$('#txt_id_modal_skpd').val(id_detail);
											$('#txt_id_modal_kabag').val(id_detail);
											$('#txt_unit_key_modal').val(unit_key);
											$('#txt_status_modal').val(id);
											$('#myModal').modal('show');
											
											if(urut == 2)
											{
												if(status == 2)
												{
													$("#btnSaveModal").show();
													$("#btnSubmitModal").show();
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").hide();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
												}
												else if(status == 3)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").hide();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
												}
												else if(status == 5)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
											else if(urut == 3)											
											{											
												if(status == 3)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 5)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
											else
											{
												if(status == 6)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").show();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
												else if(status == 7)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 8)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").show();
													$("#btnRejectModal").show();	
													$("#btnReturnModal").show();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").hide();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
												}
												else if(status == 9)
												{
													$("#btnSaveModal").hide();
													$("#btnSubmitModal").hide();											
													$("#btnApproveModal").hide();
													$("#btnRejectModal").hide();	
													$("#btnReturnModal").hide();	
													$("#btnApprovePelaksana").hide();	
													$("#btnSubmitReturn").hide();
													
													$("#div_one").show();
													$("#div_one_ext").hide();
													$("#div_two").show();	
													$("#div_three").show();
													$("#div_four").show();
													
													generate_nota_dinas_by_id(id_detail);
													generate_disposisi_by_id(id_detail, urut);
													generate_ceklist_dokumen(id_detail);
													generate_history_approval(id_detail);
												}
											}
										}	
									});									
								}	
							});						
						}		
					}
				})
			},
			
			generate_nota_dinas_by_id	= function(id_detail){
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_by_id",
					type		: 'post',
					data		: {id: id_detail},
					dataType	: 'json',
					success : function(result){		
						$("#txt_kode_unit_modal2").val(result['unitkey']);
						$("#txt_kode_unit_modal").val(result['kode_unit']);
						$("#txt_nama_unit_modal").val(result['nama_unit']);					
						$("input[name=optJenis][value = " + result['jns_nota_dinas'] + "]").prop('checked', true);
						$("#txt_tgl_pengajuan").val(result['tgl_nota_dinas']);
						$("#txt_nota_dinas_modal").val(result['no_nota_dinas']);
						$("#txt_nota_surat_kabag").val(result['no_nota_dinas']);
						$("#txt_perihal_modal").val(result['perihal']);						
						$("#div_scan_nota_dinas").html('<a href = "'+base_url+'upload/nota_dinas/'+result['folder']+'/'+result['nota_dinas_doc']+'" target = "_blank">'+result['nota_dinas_doc']+'</a>');						
						
						$("input[name=optJenis]").attr('disabled', true); 
						$("#txt_tgl_pengajuan").attr('disabled', true); 
						$("#txt_perihal_modal").attr('disabled', true); 
						
						$("#txt_kode_unit_surat2").val(result['unitkey']);
						$("#txt_kode_unit_surat").val(result['kode_unit']);
						$("#txt_nama_unit_surat").val(result['nama_unit']);							
						
						generate_nota_dinas_document(result['no_nota_dinas']);
					}					
				})								
			},			
			
			generate_nota_dinas_document = function(no_nota){
				$("#div_dokumen_pendukung").empty();
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_document",
					type		: 'post',
					data		: {no_nota_dinas: no_nota},
					dataType	: 'json',
					success : function(result){						
						for(var i = 0; i < result.length; i++){
							var panjang	 	= (result[i].file).length;
							var file_name	= (result[i].file).substring(37,panjang);	
							var folder		= result[i].folder;
							var x			= i + 1;							
							
							var dokumen	 = '<div class = "form-group col-lg-6 div_add_dokumen" id = "div_add_dokumen_'+file_name+'"><a href = "'+base_url+'upload/lampiran/'+folder+'/'+file_name+'" target = "_blank">'+file_name+'</a></div>';															
							$("#div_dokumen_pendukung").append(dokumen);															
						}
					}
				});
			},
			
			generate_disposisi_by_id = function(id_detail, urut){
				$.ajax({
					url			: base_url + "pemda/generate_disposisi_by_id",
					type		: 'post',
					data		: {id_detail: id_detail},
					dataType	: 'json',
					success : function(result){							
						if(result != '')
						{
							$("#txt_tgl_terima").val(result['tgl_terima']);	
							$("#txt_nota_surat").val(result['no_surat_disposisi']);	
							$("#txt_nota_surat_ext").val(result['no_surat_disposisi']);	
							$("#txt_nota_agenda").val(result['no_agenda']);	
							$("#txt_tgl_surat").val(result['tgl_surat']);	
							$("input[name=optSifat][value = " + result['sifat'] + "]").prop('checked', true);	
							$("#txt_perihal_disposisi").val(result['perihal']);	
							$("#txt_catatan").val(result['catatan']);	
							$("#txt_diteruskan").val(result['send_to']);	
							$("#txt_kota").val(result['kota_disposisi']);	
							$("#txt_tgl_ttd").val(result['tgl_ttd']);	
							$("input[name=chk_harap][value = " + result['status_note'] + "]").prop('checked', true);		

							if((urut == 1) || (urut > 2))
							{
								$("#txt_tgl_terima").attr('disabled', true); 
								$("#txt_nota_surat").attr('disabled', true); 
								$("#txt_nota_agenda").attr('disabled', true); 
								$("#txt_tgl_surat").attr('disabled', true); 
								$("#txt_perihal_disposisi").attr('disabled', true); 
								$("#txt_catatan").attr('disabled', true); 
								$("#txt_diteruskan").attr('disabled', true); 
								$("#txt_kota").attr('disabled', true); 
								$("#txt_tgl_ttd").attr('disabled', true); 
								$("input[name=optSifat]").attr('disabled', true); 
								$("input[name=chk_harap]").attr('disabled', true); 
							}																
						}
					}
				});
			},
			
			generate_ceklist_dokumen = function(id_detail){
				$.ajax({
					url			: base_url + "pemda/generate_ceklist_dokumen",
					type		: 'post',
					data		: {id: id_detail},
					dataType	: 'json',					
					success : function(hasil){	
					
						$("#isi_ceklist").empty();
						for(var i = 0; i < hasil.length; i++)
						{
							if(hasil[i].keterangan == null)
							{
								var keterangan = '-';
							}
							else
							{
								var keterangan = hasil[i].keterangan;
							}
							
							var html	= "<tr>";
								html   += "<td><center>"+hasil[i].no_urut+"</center></td>";
								html   += "<td>"+hasil[i].upload_file_name+"<input type = 'hidden' name = 'txt_file_name' class = 'txt_upload_file_name' id = 'txt_file_name_"+hasil[i].upload_file_name+"' value = '"+hasil[i].upload_file_name+"'/><input type = 'hidden' name = 'txt_file_code' class = 'txt_file_code' id = 'txt_file_code_"+hasil[i].upload_file_code+"' value = '"+hasil[i].upload_file_code+"' /></td>";
								html   += "<td><center><input type = 'hidden' name = 'txt_upload' id = 'txt_upload_"+hasil[i].upload_file_code+"' class = 'txt_upload' value = '0' /><input type = 'checkbox' name = 'chk_upload' class = 'chk_upload' id = 'chk_upload_"+hasil[i].upload_file_code+"' chk_upload = '"+hasil[i].upload_file_code+"' /><center></td>";
								html   += "<td><input type = 'text' name = 'txt_keterangan' class = 'txt_keterangan' id = 'txt_keterangan_"+hasil[i].upload_file_code+"' style = 'width: 100%' value = '"+keterangan+"' /></td>";
								html   += "</tr>";
							
							$("#isi_ceklist").append(html);		

							if(hasil[i].is_ready == 1)
							{									
								$("#chk_upload_"+hasil[i].upload_file_code).prop('checked', true);
							}
							else
							{
								$("#chk_upload_"+hasil[i].upload_file_code).prop('checked', false);
							}
							
							$("#chk_upload_"+hasil[i].upload_file_code).change(function(){																
								var no_urut	= $(this).attr('chk_upload');
								if($(this).is(":checked"))
								{									
									$("#txt_upload_"+no_urut).val('1');
								}
								else
								{									
									$("#txt_upload_"+no_urut).val('0');
								}
							})
						}
					}
				});
			},
			
			generate_dinas = function(){
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
			
			generate_history_approval = function(id_detail){
				$.ajax({
					url			: base_url + "pemda/generate_history_approval",
					type		: 'post',
					data		: {id_detail: id_detail},
					dataType	: 'json',
					success : function(hasil)
					{	
						$("#span_draft").empty();
						if(hasil['draft_dokumen'] != null)
						{
							$("#txt_approval_kabag").val(hasil['tgl_approval_kabag']);
							$("#txt_approval_kasubag").val(hasil['tgl_approval_kasubag']);
							$("#txt_keterangan").val(hasil['keterangan']);
							
							var html = '<a href = "'+base_url+'upload/'+hasil['draft_dokumen']+'" target = "_blank">'+hasil['draft_dokumen']+'</a>';
							$("#span_draft").append(html);
							
							$("#txt_draft").hide();
							
							$("#txt_keterangan").attr('readonly', true);
						}
						else
						{
							$("#txt_approval_kabag").val(hasil['tgl_approval_kabag']);
							$("#txt_approval_kasubag").val(hasil['tgl_approval_kasubag']);
							$("#txt_keterangan").val(hasil['keterangan']);
							
							$("#txt_draft").show();
							$("#span_draft").html('');
							
							$("#txt_keterangan").attr('readonly', false);
						}
						
						$("#txt_approval_kabag").attr('readonly', true);
						$("#txt_approval_kasubag").attr('readonly', true);						
												
					}
				});
			},
			
			generate_nota_dinas_by_id_ext	= function(id_detail, jml){
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_by_id",
					type		: 'post',
					data		: {id: id_detail},
					dataType	: 'json',
					success : function(result){
						$("input[type=radio]").attr('disabled', true); 
						$("input[name=optJenis][value = " + result['jns_nota_dinas'] + "]").prop('checked', true);
						$("#datecustom").val(result['tgl_nota_dinas']);
						$("#txt_nota_dinas").val(result['no_nota_dinas']);						
						$("#txt_nota_dinas_ext1").val(result['no_nota_dinas']);
						$("#txt_perihal").val(result['perihal']);						
						$("#txt_scan_nota_dinas_old").val(result['no_nota_dinas']);
						$("#txt_scan_nota_dinas").val(result['nota_dinas_doc']);	
						$("#txt_jml").val(jml);
						
						generate_nota_dinas_document_ext(result['no_nota_dinas'])
						
						$("#datecustom").attr('disabled', true);
						$("#txt_perihal").attr('disabled', true);
					}					
				})								
			},
			
			generate_nota_dinas_document_ext = function(no_nota_dinas){										
			
				count_revisi(no_nota_dinas);
				var b = 0;
				
				$.ajax({
					url			: base_url + "pemda/generate_nota_dinas_document",
					type		: 'post',
					data		: {no_nota_dinas: no_nota_dinas},
					dataType	: 'json',
					success : function(result){	
						$(".input_fields_wrap").empty();								
					
						for(var i = 0; i < result.length; i++)
						{
							b 				= b + 1;
							var panjang	 	= (result[i].file).length;
							var file_name	= (result[i].file).substring(37,panjang);
							var x			= i + 1;									
							
							var dokumen	 = '<div class = "form-group col-lg-6 div_add_dokumen" id = "div_add_dokumen_'+file_name+'" class = "div_add_dokumen">';
								dokumen	+= '<input type = "hidden" class = "form-control" name = "txt_nota_dinas_ext'+x+'" id = "txt_nota_dinas_ext'+x+'" readonly style = "background-color: lightgrey" value = "'+no_nota_dinas+'">';	
								dokumen += '<input type = "text" class = "form-control txt_dokumen" txt_dokumen = "'+x+'" name = "txt_dokumen[]" id = "txt_dokumen'+x+'" value = "'+file_name+'" style = "width: 100%" />';
								dokumen += '<input type = "hidden" class = "form-control txt_dokumen_ext" txt_dokumen_ext = "'+x+'" name = "txt_dokumen_ext[]" id = "txt_dokumen_ext'+x+'" value = "'+file_name+'" />';
								dokumen += '<input type = "hidden" class = "form-control txt_dokumen_new" txt_dokumen_new = "'+x+'" name = "txt_dokumen_new[]" id = "txt_dokumen_new'+x+'" value = "'+file_name+'" />';
								dokumen += '<input type= "file" id = "file_dokumen_'+x+'" file_dokumen = "'+x+'" name= "myfile[]" class = "file_dokumen" accept = "image/jpeg, application/pdf" multiple = ""  />';
								dokumen	+= '</div>';	
								
							$(".input_fields_wrap").append(dokumen);

							$("#txt_jml").val(b);								
												
							$('#txt_dokumen'+x).click(function(e){	
								e.preventDefault();																				
								$('#file_dokumen_'+x).click();
							});		
							
							$('#file_dokumen_'+x).change(function(){	
								var y		= $(this).attr('file_dokumen');	
								$('#txt_dokumen_new'+y).val($(this).val().split('\\').pop());
																																								
								var ukuran	= this.files[0];
								
								if(ukuran > 5120)
								{
									alert("Maximum : 5MB");
									return false;
								}
																														
								if(y == 1)
								{
									//alert('1');
									var jenis	= $('input[type=radio][name=optJenis]:checked').val();
																							
									if(jenis == 0)
									{
										var file_code = 'PERBUP';
									}
									else
									{
										var file_code = 'KEPBUP';
									}
									var nama	= ($("#txt_nota_dinas").val()).replace(/\//g,'');

									setTimeout(function(){generate_file_code(file_code, nama, $("#txt_revisi").val());}, 300);
								}
								else
								{
									//alert('2');
									var lamp 		= 'LAMP'
									var i			= ($('#txt_dokumen_ext'+y).val().substr(4, 1));											
									var file_code	= lamp + i;
							
									var nama		= ($("#txt_nota_dinas").val()).replace(/\//g,'');
									
									setTimeout(function(){generate_file_code_lampiran(file_code, nama, $("#txt_revisi").val(), y);}, 300);
								}
							})	
						}
					}					
				})					
			},
			
			count_revisi = function(no_nota_dinas){
				$.ajax({
					url			: base_url + "pemda/generate_revisi_nota_dinas",
					type		: 'post',
					data		: {no_nota_dinas: no_nota_dinas},
					dataType	: 'json',
					success : function(hasil){												
						var revisi	= parseInt(hasil['revisi']) + 1;	
						$("#txt_revisi").val(revisi);
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
			
			generate_new();
			generate_progress();
			generate_reject();
			generate_approve();
			generate_dokumen_dashboard(1);
						
		});
	</script>	
</head>

<body>

    <!-- #wrapper -->
    <div id = "wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <!-- #page-wrapper -->
            <div id = "page-wrapper">
               
                     <!-- .row -->
                    <div class = "row">
                        <div class = "col-md-12">
                            <h1 class = "page-header">Dashboard</h1>
                            <!--ol class = "breadcrumb" style = "background-color:#999999;">
                                <li class = "active" style = "color:white;">
                                    <a href = "javascript:void(0);">Home</a> <i class = "zmdi zmdi-circle"></i> Dashboard SKPD
                                </li>
                            </ol!-->
                        </div>
                    </div>
                    <!-- /.row -->                   
               
                    <!-- .row -->
                    <div class = "row">						
                        <div class = "col-md-3 col-md-6">
                            <div class = "panel panel-blue">
                                <div class = "panel-heading">
                                    <div class = "row">
                                        <div class = "col-xs-3">
                                            <i class = "zmdi zmdi-comment-outline zmdi-hc-5x"></i>
                                        </div>
                                        <div class = "col-xs-9 text-right">
                                            <div class = "huge" id = "div_new"></div>
                                            <div>New</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<?php 
							if($this->session->userdata('urut') != 4)
							{
						?>
                        <div class = "col-md-3 col-md-6">
                            <div class = "panel m-yellow">
                                <div class = "panel-heading">
                                    <div class = "row">
                                        <div class = "col-xs-3">
                                            <i class = "zmdi zmdi-view-day zmdi-hc-5x"></i>
                                        </div>
                                        <div class = "col-xs-9 text-right">
                                            <div class = "huge" id = "div_progress"></div>
                                            <div>On Progress</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
												
                        <div class = "col-md-3 col-md-6">
                            <div class = "panel m-red">
                                <div class = "panel-heading">
                                    <div class = "row">
                                        <div class = "col-xs-3">
                                            <i class = "zmdi zmdi-shopping-basket zmdi-hc-5x"></i>
                                        </div>
                                        <div class = "col-xs-9 text-right">
                                            <div class = "huge" id = "div_reject"></div>
                                            <div>Reject</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<?php
							}
						?>
						
                        <div class = "col-md-3 col-md-6">
                            <div class = "panel m-green">
                                <div class = "panel-heading">
                                    <div class = "row">
                                        <div class = "col-xs-3">
                                            <i class = "zmdi zmdi-border-color zmdi-hc-5x"></i>
                                        </div>
                                        <div class = "col-xs-9 text-right">
                                            <div class = "huge" id = "div_approve"></div>
                                            <div>Approve</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
					
					
					<div class = "row">
                        <div class = "col-md-12">
                            <div class = "card card-block">
                                <div class = "card-text" id = "div_dokumen">									                             
								</div>
							</div>
						</div>
                    </div>  

					<?php $this->load->view('dashboard_modal_view'); ?>
            </div>  
            <!-- /#page-wrapper -->
        </main>
    </div>
    <!-- /#wrapper -->
    
    <?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>	
</body>

