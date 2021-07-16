<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("assets/component/top.php"); ?>
	<style type = "text/css">
		body, input { font-family: Tahoma; font-size: 12px}					

		.col-xs-3 > i{
			opacity: 0.4;
		}
		
		.panel{
			border-radius: 15px;
		}
		.panel-blue > .panel-heading{
			border-color: #085da0;
			background-color: #085da0;
			color: #fff;
			border: 2px solid #085da0;
			border-radius: 15px;
		}
		
		.panel-yellow > .panel-heading{
			background-color: #e6e600;
		}
			
		.card{
			border-radius: 15px;
		}
		
		.product-preview-card{
			padding:10px 
		}
	</style>

    <title>Sistem Informasi Manajemen Pembentukan Produk Hukum </title>
	
	<link class = " jsbin" href = " http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel = " stylesheet" type = " text/css" />
	<script class = " jsbin" src = " http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script class = " jsbin" src = " http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type = "text/javascript">
		$(document).ready(function(){
			var base_url	= '<?php echo base_url(); ?>';

			var generate_new = function(){
				$.ajax({
					url			: base_url + "pemda/generate_new",
					type		: 'post',
					data		: {},
					dataType	: 'json',
					success : function(hasil){
						var count_new	= '<div class="counter" id = "div_count_new">'+hasil['jumlah']+'</div>';
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
						var count_progress	= '<div class="counter" id = "div_count_progress">'+hasil['jumlah']+'</div>';
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
						var count_reject	= '<div class="counter" id = "div_count_reject">'+hasil['jumlah']+'</div>';
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
						var count_approve	= '<div class="counter" id = "div_count_approve">'+hasil['jumlah']+'</div>';
						$("#div_approve").append(count_approve);
						
						$("#div_count_approve").click(function(){
							$("#div_dokumen").empty();
							generate_dokumen_dashboard(7);
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
									if(id == 1)
									{
										status_desc = 'New';
									}
									else if((id == 2) || (id == 3) || (id == 4) || (id == 6))
									{
										status_desc = 'Waiting For Approval';
									}
									else if(id == 5)
									{
										status_desc = 'Reject';
									}
									else if((id == 7))
									{
										status_desc = 'Aprroved';
									}	
									
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
										
									
									var dokumen	    = '<div class="col-xs-6 col-md-6 m-responsive">';
										dokumen	   += '<div class="card">';
										dokumen	   += '<div class="product-preview" id = "div_detail_dokumen" div_detail_dokumen = "'+hasil['no_nota_dinas']+'" style = "border-radius: 15px;">'; 
										dokumen	   += '<div class="product-preview-card">';
										dokumen	   += '<div>';
										dokumen	   += '<table style="width:100%" class="table">';
										dokumen	   += '<tbody>';
										dokumen	   += '<tr><td style="width:100px">Status </td><td>:</td><td>'+status_desc+'</td></tr>';
										dokumen	   += '<tr><td valign="bottom">No. Nota Dinas </td><td>:</td><td>'+no_nota+'</td></tr>';
										dokumen	   += '<tr><td>Tgl. Pengajuan </td><td>:</td><td>'+tgl_nota+'</td></tr>';
										dokumen	   += '<tr><td class="center">Perihal </td><td>:</td><td>'+perihal+'</td></tr>';
										dokumen	   += '</tbody>';								
										dokumen	   += '</table>';
										dokumen	   += '</div>';
										dokumen	   += '</div>';
										dokumen	   += '<span detail = "'+hasil['id']+'" onClick = "getDetail('+hasil['no_nota_dinas']+')" id = "view" class="product-details" style = " text-align: right;padding-right:10px;">View details</span>';
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
										var id	= $(this).attr("detail");										
										window.location.href = base_url + 'pemda/nota_dinas/' + id;
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
									for(var i = 0; i < hasil.length; i++){
										var status		= hasil[i].status_dokumen_id;
										
										if(id == 1)
										{
											status_desc = 'New';
										}
										else if((id == 2) || (id == 3) || (id == 4) || (id == 6))
										{
											status_desc = 'Waiting For Approval';
										}
										else if(id == 5)
										{
											status_desc = 'Reject';
										}
										else if((id == 7))
										{
											status_desc = 'Aprroved';
										}	
										
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
											
										
										var dokumen	    = '<div class="col-xs-6 col-md-6 m-responsive">';
											dokumen	   += '<div class="card">';
											dokumen	   += '<div class="product-preview" id = "div_detail_dokumen'+i+'" div_detail_dokumen = "'+hasil['no_nota_dinas']+'" style = "border-radius: 15px;">'; 
											dokumen	   += '<div class="product-preview-card">';
											dokumen	   += '<div>';
											dokumen	   += '<table style="width:100%" class="table">';
											dokumen	   += '<tbody>';
											dokumen	   += '<tr><td style="width:100px">Status </td><td>:</td><td>'+status_desc+'</td></tr>';
											dokumen	   += '<tr><td valign="bottom">No. Nota Dinas </td><td>:</td><td>'+no_nota+'</td></tr>';
											dokumen	   += '<tr><td>Tgl. Pengajuan </td><td>:</td><td>'+tgl_nota+'</td></tr>';
											dokumen	   += '<tr><td class="center">Perihal </td><td>:</td><td>'+perihal+'</td></tr>';
											dokumen	   += '</tbody>';								
											dokumen	   += '</table>';
											dokumen	   += '</div>';
											dokumen	   += '</div>';
											dokumen	   += '<span detail = "'+hasil[i]['id']+'" onClick = "getDetail('+hasil['no_nota_dinas']+')" id = "view'+i+'" class="product-details" style = " text-align: right;padding-right:10px;">View details</span>';
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
										
										$("span").click(function () {
											var id	= $(this).attr("detail");											
											window.location.href = base_url + 'pemda/nota_dinas/' + id;
										});		
									}
								}	
							})						
						}		
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
    <div id="wrapper">
		<?php include("header_view.php"); ?>
		<?php include("side_view.php"); ?>
        
        <main>
            <!-- #page-wrapper -->
            <div id="page-wrapper">
               
                     <!-- .row -->
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">Dashboard SKPD</h1>
                            <ol class="breadcrumb" style="background-color:#999999;">
                                <li class="active" style="color:white;">
                                    <a href="javascript:void(0);">Home</a> <i class="zmdi zmdi-circle"></i> Dashboard SKPD
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->                   
               
                    <!-- .row -->
                    <div class="row">						
                        <div class="col-md-3 col-md-6">
                            <div class="panel panel-blue">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="zmdi zmdi-comment-outline zmdi-hc-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge" id = "div_new"></div>
                                            <div>New</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-6">
                            <div class="panel m-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="zmdi zmdi-view-day zmdi-hc-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge" id = "div_progress"></div>
                                            <div>On Progress</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-md-6">
                            <div class="panel m-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="zmdi zmdi-shopping-basket zmdi-hc-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge" id = "div_reject"></div>
                                            <div>Reject</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-md-6">
                            <div class="panel m-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="zmdi zmdi-border-color zmdi-hc-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge" id = "div_approve"></div>
                                            <div>Approve</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
					
					
					<div class="row">
                        <div class="col-md-12">
                            <div class="card card-block">
                                <div class="card-text" id = "div_dokumen">									                             
								</div>
							</div>
						</div>
                    </div>    
            </div>  
            <!-- /#page-wrapper -->
			
			
			
			

        </main>
    </div>
    <!-- /#wrapper -->
    
    <?php include("footer_view.php"); ?>
	<?php include("assets/component/footer.php"); ?>	
</body>

</html>
