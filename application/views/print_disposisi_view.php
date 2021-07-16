<?php 
    ini_set('memory_limit','1280M');
    include "./application/libraries/mpdf/mpdf.php";
	
	$mpdf = new mPDF('', 'A4','','',6.35,6.35,50,15,15,15,'P');   
	$mpdf->SetHTMLHeader('<table width = "100%" border = "0" cellspacing = "0">
                            <tr>
								<td align = "center"><img src = "' . base_url() . '/assets/img/LOGO_KABUPATEN_GARUT.png" height = "5%" width = "5%" ></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align = "center" style = "font-weight: bold">CONTOH PRINT DISPOSISI</td>
							</tr>
							<tr>
								<td align = "center" style = "font-weight: bold">PEMERINTAH DAERAH GARUT</td>
							</tr>
                        </table>');
    
    if(!function_exists("mb_check_encoding"))
    {
        die('mbstring extension is not enabled');
    }   

	ob_start();
?>
<html>
<title>PRINT DISPOSISI</title>
<style>
	body {font-family: "Tahoma"; margin-top : 50pt} 	
</style>
<body>
	<table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
		<tr>
			<td style = "width: 20%">No Nota Dinas</td>
			<td style = "width: 1%">:</td>
			<td style = "width: 79%"><?php echo $disposisi['no_nota_dinas'];?></td>
		</tr>
	</table>
</body>
</html>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    
    $mpdf->SetDisplayMode('fullwidth');
    $mpdf->SetHTMLFooter('
                            <table width="100%" style="vertical-align: bottom; font-family: Courier; 
                                font-size: 8pt; color: #000000; font-weight: bold; font-style: italic; margin-bottom: 70px">
                                <tr>                                    
                                    <td width="33%" align = "right">{PAGENO} Of {nbpg}</td>        
                                </tr>
                            </table>');  
	
    $mpdf->WriteHTML($html);
    
    ////$html adalah komponen HTML yang akan dijadikan PDF
    $mpdf->Output();
?>