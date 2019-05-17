<?error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$periodod=$_GET["periodod"];$periodoh=$_GET["periodoh"];  $Sql=""; $tipo_rpt=$_GET["tipo_rpt"]; $excedente=$_GET["excedente"];
$criterio1="Mes: "."   ".$periodoh."  "."Periodo :  ".$periodod; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}


    $excedente=formato_monto($excedente);
    
	$direccion_ag=""; $nombre=""; $nom_comp=""; $rif=""; $nit=""; $telefono_ag=""; $fax=""; $str1="NO"; $fecha_ini="2011-01-01"; $fecha_fin="2011-12-31"; $periodo="01"; $correo=""; $tasa_iva=0; $monto_ut=0; $definicion="N";
	$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
	if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
	$direccion_ag=$registro["campo006"]; $nombre=$registro["campo004"]; $nom_comp=$registro["campo005"]; $rif=$registro["campo007"]; $nit=$registro["campo008"];  $definicion=$registro["campo034"];
	$telefono_ag=$registro["campo012"];$fax=$registro["campo013"]; $fecha_ini=$registro["campo031"];$fecha_fin=$registro["campo032"]; $periodo=$registro["campo033"]; $pagina=$registro["campo015"]; $parroquia=$registro["campo040"];
	$region=$registro["campo041"];$estado=$registro["campo010"];$municipio=$registro["campo011"];$ciudad=$registro["campo009"]; $correo=$registro["campo014"]; $str1=$registro["campo049"]; $tasa_iva=$registro["campo056"]; $monto_ut=$registro["campo055"]; }
	if($fecha_ini==""){$fecha_ini="";}else{$fecha_ini=formato_ddmmaaaa($fecha_ini);} if($fecha_fin==""){$fecha_fin="";}else{$fecha_fin=formato_ddmmaaaa($fecha_fin);}
	$nombre_emp=$nombre;$ced_rif_emp=$rif;
	
	
	$sSQL = "SELECT pag032.mes_libro,pag032.ced_rif,pag032.nro_documento,pag032.tipo_documento,pag032.ano_fiscal,pag032.mes_fiscal,pag032.nro_comprobante,pag032.fecha_emision,pag032.nro_operacion,pag032.nro_con_documento,
	   pag032.fecha_documento,pag032.tipo_operacion,pag032.nro_doc_afectado,pag032.tipo_transaccion,pag032.monto_documento,pag032.monto_exento_iva,pag032.base_importacion,pag032.tasa_iva_imp, pag032.monto_iva_imp,pag032.base_imponible,pag032.tasa_iva,pag032.monto_iva,pag032.tasa_retencion,pag032.monto_iva_retenido,pag032.status_1,pag032.status_2,pag032.campo_str1,pag032.campo_str2,
	   pag032.campo_num1,pag032.campo_num2,pag032.inf_usuario,to_char(pag032.fecha_documento,'DD/MM/YYYY') as fechad,to_char(pag032.fecha_emision,'DD/MM/YYYY') as fechae, PRE099.Nombre 
	   FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and mes_libro='".$periodoh."' order by nro_operacion";
    
	$criterio8=0; $criterio81=0; $criterio12=0; $criterio121=0;
	$Sql = "SELECT sum(base_imponible) as base8, sum(monto_iva) as base81, sum(monto_iva_retenido) as ret8 FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and (mes_libro='".$periodoh."') and (tasa_iva=8)";
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio8=$registro["base8"]; $criterio81=$registro["base81"];  $criterio82=$registro["ret8"]; }
	$Sql = "SELECT sum(base_imponible) as base12, sum(monto_iva) as base121, sum(monto_iva_retenido) as ret12  FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and (mes_libro='".$periodoh."') and (tasa_iva=12)";
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio12=$registro["base12"]; $criterio121=$registro["base121"]; $criterio122=$registro["ret12"]; }
	 	
    
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $mes_libro_grupo=""; 	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $mes_libro_grupo;  global $registro; global $nombre_emp; global $ced_rif_emp;
			$this->Image('../../imagenes/Logo_emp.png',10,10,20);
			$this->SetFont('Arial','B',8);
			$this->Cell(30);
			$this->Cell(130,5,$nombre_emp,0,0,'L');
			$this->Cell(100,5,$criterio1,0,1,'R');	
			$this->Cell(30);
			$this->Cell(30,5,$ced_rif_emp,0,1,'L');
			$this->SetFont('Arial','B',12);
			$this->Cell(260,8,'LIBRO DE COMPRAS',0,1,'C');
			$this->SetFont('Arial','B',4);
			$this->SetFillColor(192,192,192);
			$this->Cell(173,4,'',0,0,'L');
			$this->Cell(45,4,'COMPRAS INTERNAS O IMPORTANCIONES',1,0,'C',true);
			$this->Cell(32,4,'',0,1,'R');
			
			$this->SetFont('Arial','B',4);
			$this->Cell(5,3,'.','RLT',0,'C',true);
			$this->Cell(11,3,'','RLT',0,'C',true);
			$this->Cell(12,3,'','LT',0,'C',true);
			$this->Cell(30,3,'','LT',0,'C',true);
			$this->Cell(30,3,'','LT',0,'C',true);			
			$this->Cell(5,3,' ','LT',0,'C',true);			
			$this->Cell(12,3,'','LT',0,'C',true);	
			$this->Cell(15,3,' ','LT',0,'C',true);
			$this->Cell(15,3,'NUMERO','LT',0,'C',true);
			$this->Cell(10,3,'NUMERO','LT',0,'C',true);
			$this->Cell(10,3,'NUMERO','LT',0,'C',true);			
			$this->Cell(8,3,' ','LT',0,'C',true);
			$this->Cell(10,3,'NUMERO DE','LT',0,'C',true);			
			$this->Cell(15,3,'TOTAL','LT',0,'C',true);
			$this->Cell(15,3,'COMPRAS SIN','LT',0,'C',true);			
			$this->Cell(15,3,'.','LT',0,'C',true);
			$this->Cell(8,3,'','LT',0,'C',true);
			$this->Cell(15,3,'','LT',0,'C',true);
			$this->Cell(12,3,'NUMERO DE','LT',0,'C',true);
			$this->Cell(12,3,'','LTR',1,'C',true);
			
			$this->Cell(5,2,'OPER.','RL',0,'C',true);
			$this->Cell(11,2,'','RL',0,'C',true);
			$this->Cell(12,2,'','L',0,'C',true);
			$this->Cell(30,2,'','L',0,'C',true);
			$this->Cell(30,2,'','L',0,'C',true);			
			$this->Cell(5,2,'TIPO ','L',0,'C',true);			
			$this->Cell(12,2,'','L',0,'C',true);	
			$this->Cell(15,2,'NUMERO DE','L',0,'C',true);
			$this->Cell(15,2,'CONTROL DE','L',0,'C',true);
			$this->Cell(10,2,'NOTA DE','L',0,'C',true);
			$this->Cell(10,2,'NOTA DE','L',0,'C',true);			
			$this->Cell(8,2,'TIPO ','L',0,'C',true);
			$this->Cell(10,2,'FACTURA','L',0,'C',true);			
			$this->Cell(15,2,'COMPRAS','L',0,'C',true);
			$this->Cell(15,2,'DERECHO','L',0,'C',true);			
			$this->Cell(15,2,'BASE.','L',0,'C',true);
			$this->Cell(8,2,'%','L',0,'C',true);
			$this->Cell(15,2,'IMPUESTO','L',0,'C',true);
			$this->Cell(12,2,'IVA','L',0,'C',true);
			$this->Cell(12,2,'ANTICIPO','LR',1,'C',true);
			
			
			
			$this->Cell(5,3,'No.','LB',0,'C',true);
			$this->Cell(11,3,'FECHA','LB',0,'C',true);
			$this->Cell(12,3,'RIF','LB',0,'C',true);
			$this->Cell(30,3,'NOMBRE','LB',0,'C',true);
			$this->Cell(30,3,'CONCEPTO','LB',0,'C',true);
			$this->Cell(5,3,'PROV','LB',0,'C',true);
			$this->Cell(12,3,'COMPROBANTE','LB',0,'C',true);
			$this->Cell(15,3,'LA FACTURA','LB',0,'C',true);
			$this->Cell(15,3,'LA FACTURA','LB',0,'C',true);
			$this->Cell(10,3,'DEBITO','LB',0,'C',true);
			$this->Cell(10,3,'CREDITO','LB',0,'C',true);
			$this->Cell(8,3,'TRANS','LB',0,'C',true);
			$this->Cell(10,3,'AFECTADA','LB',0,'C',true);
			$this->Cell(15,3,'INCLUYE IVA','LB',0,'C',true);			
			$this->Cell(15,3,'CREDITO IVA','LB',0,'C',true);
			$this->Cell(15,3,'IMPONIBLE.','LB',0,'C',true);
			$this->Cell(8,3,'ALIC.','LB',0,'C',true);
			$this->Cell(15,3,'IVA','LB',0,'C',true);
			$this->Cell(12,3,'RETENIDO','LB',0,'C',true);			
			$this->Cell(12,3,'IVA IMP.','LRB',1,'C',true);
			
			
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',5);
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_mes_libro=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  $nro_operacion=$registro["nro_operacion"]; 
		   $mes_libro_grupo=$mes_libro;
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; $concepto=$registro["campo_str2"];
		   $nro_documento=$registro["nro_documento"]; $ano_fiscal=$registro["ano_fiscal"];    $mes_fiscal=$registro["mes_fiscal"]; $tipo_transaccion=$registro["tipo_transaccion"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"]; $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
		   $base_imponible=$registro["base_imponible"]; $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];  $monto_iva_retenido=$registro["monto_iva_retenido"];	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; 
		   $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);	 $nro_fact=""; $nro_notacre="";	$nro_notadeb="";		   
		   if($tipo_documento=="01"){$nro_fact=$nro_documento;}	if($tipo_documento=="02"){$nro_notadeb=$nro_documento;}  if($tipo_documento=="03"){$nro_notacre=$nro_documento;}
		   if($nro_comprobante==""){$fecha_emision="";}else{$fecha_emision;}
		   if($php_os=="WINNT"){$concepto=$registro["campo_str2"]; }else{ $nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $tipo_prov=""; $pr=substr($ced_rif,0,1);
		   if(($pr=="J")or($pr=="G")){$tipo_prov="R";}  if(($pr=="V")or($pr=="E")){$tipo_prov="D";}	 
		   $ln=strlen($nombre); $nro_lin=1; $nomb2=""; $nomb3=""; $nomb4=""; $nomb5=""; $conc2=""; $conc3=""; $conc4=""; $conc5="";
		   $h=3;  $nomb1=$nombre; $conc1=$concepto;		   
		   if($ln>=25){$nro_lin=2; $nomb1=substr($nombre,0,25);  $nomb2=substr($nombre,25,25);   $conc1=substr($concepto,0,25); $conc2=substr($concepto,25,25);  } 
		   if($ln>=50){$nro_lin=3; $nomb3=substr($nombre,50,25); $conc3=substr($concepto,50,25);  }
		   if($ln>=75){$nro_lin=4; $nomb4=substr($nombre,75,25); $conc4=substr($concepto,75,25);  }
		   if($ln>=100){$nro_lin=5; $nomb5=substr($nombre,100,25); $conc5=substr($concepto,100,25);  }		   
		   $pdf->Cell(5,$h,$nro_operacion,'LR',0,'c'); 
		   $pdf->Cell(11,$h,$fecha_documento,'LR',0); 
		   $pdf->Cell(12,$h,$ced_rif,'LR',0); 
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=30; $z=30;
		   $pdf->Cell($w,$h,$nomb1,'LR',0,'L');
		   $pdf->Cell($z,$h,$conc1,'LR',0,'L');		   
		   $pdf->Cell(5,$h,$tipo_prov,0,0,'C'); 		   
		   $pdf->Cell(12,$h,$nro_comprobante,'LR',0,'C');		   
		   $pdf->Cell(15,$h,$nro_fact,'LR',0,'C'); 
		   $pdf->Cell(15,$h,$nro_con_documento,'LR',0,'C'); 
		   $pdf->Cell(10,$h,$nro_notadeb,'LR',0,'C'); 
		   $pdf->Cell(10,$h,$nro_notacre,'LR',0,'C'); 
		   $pdf->Cell(8,$h,$tipo_transaccion,'LR',0,'C'); 
		   $pdf->Cell(10,$h,$nro_doc_afectado,'LR',0,'C'); 
		   $pdf->Cell(15,$h,$monto_documento,'LR',0,'R'); 
           $pdf->Cell(15,$h,$monto_exento_iva,'LR',0,'R'); 		   
		   $pdf->Cell(15,$h,$base_imponible,'LR',0,'R'); 
		   $pdf->Cell(8,$h,$tasa_iva,'LR',0,'R'); 
		   $pdf->Cell(15,$h,$monto_iva,'LR',0,'R'); 
		   $pdf->Cell(12,$h,$monto_iva_retenido,'LR',0,'R');
		   $pdf->Cell(12,$h,'','LR',1,'R');		

		   if($nro_lin>=2){
		    $pdf->Cell(5,$h,'','LR',0,'c'); 
		    $pdf->Cell(11,$h,'','LR',0); 
		    $pdf->Cell(12,$h,'','LR',0); 
			$pdf->Cell($w,$h,$nomb2,'LR',0,'L');
		    $pdf->Cell($z,$h,$conc2,'LR',0,'L');		   
		    $pdf->Cell(5,$h,'',0,0); 		   
		    $pdf->Cell(12,$h,'','LR',0,'C');		   
		    $pdf->Cell(15,$h,'','LR',0,'C'); 
		    $pdf->Cell(15,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(8,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
            $pdf->Cell(15,$h,'','LR',0,'R'); 		   
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
		    $pdf->Cell(8,$h,'','LR',0,'R'); 
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
		    $pdf->Cell(12,$h,'','LR',0,'R');
		    $pdf->Cell(12,$h,'','LR',1,'R');		
		   }
	       if($nro_lin>=3){
		    $pdf->Cell(5,$h,'','LR',0,'c'); 
		    $pdf->Cell(11,$h,'','LR',0); 
		    $pdf->Cell(12,$h,'','LR',0); 
			$pdf->Cell($w,$h,$nomb3,'LR',0,'L');
		    $pdf->Cell($z,$h,$conc3,'LR',0,'L');		   
		    $pdf->Cell(5,$h,'',0,0); 		   
		    $pdf->Cell(12,$h,'','LR',0,'C');		   
		    $pdf->Cell(15,$h,'','LR',0,'C'); 
		    $pdf->Cell(15,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(8,$h,'','LR',0,'C'); 
		    $pdf->Cell(10,$h,'','LR',0,'C'); 
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
            $pdf->Cell(15,$h,'','LR',0,'R'); 		   
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
		    $pdf->Cell(8,$h,'','LR',0,'R'); 
		    $pdf->Cell(15,$h,'','LR',0,'R'); 
		    $pdf->Cell(12,$h,'','LR',0,'R');
		    $pdf->Cell(12,$h,'','LR',1,'R');		
		   } 
		} 
		$pdf->SetFont('Arial','B',5); $temp5=$sub_total5;
	    if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);							    
			$pdf->Cell(173,3,'',1,0,'R'); 
			$pdf->Cell(15,3,$sub_total1,1,0,'R'); 
			$pdf->Cell(15,3,$sub_total2,1,0,'R'); 
			$pdf->Cell(15,3,$sub_total3,1,0,'R'); 
			$pdf->Cell(8,3,'',1,0,'R'); 
			$pdf->Cell(15,3,$sub_total4,1,0,'R'); 
			$pdf->Cell(12,3,$sub_total5,1,0,'R');
			$pdf->Cell(12,3,'',1,1,'R');
		}		
        $pdf->Ln(5);
		$totalb=$criterio12+$criterio8; $totalir=$criterio121+$criterio81; $totalr=$criterio122+$criterio82;
		$totalb=formato_monto($totalb); $totalir=formato_monto($totalir); $totalr=formato_monto($totalr);
		$criterio12=formato_monto($criterio12); $criterio121=formato_monto($criterio121); $criterio122=formato_monto($criterio122);
		$criterio8=formato_monto($criterio8); $criterio81=formato_monto($criterio81);  $criterio82=formato_monto($criterio82);        
		$ret_sub_total2=0; $ret_sub_total2=formato_monto($ret_sub_total2);
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'RESUMEN DE COMPRAS '.$criterio1,'LRT',0,'C'); 
		$pdf->Cell(16,3,'Base Imponible','LRT',0,'C');
		$pdf->Cell(16,3,'Credito Fiscal','LRT',0,'C'); 
		$pdf->Cell(16,3,'Iva Retenido','LRT',0,'C'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->Cell(130,2,'',0,0,'R'); 
        $pdf->Cell(60,2,'','LR',0,'C'); 
		$pdf->Cell(16,2,'','LR',0,'R');
		$pdf->Cell(16,2,'','LR',0,'R'); 
		$pdf->Cell(16,2,'(a terceros)','LR',0,'C'); 
		$pdf->Cell(22,2,'',0,1,'R'); 
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Compras no gravadas y/ o sin derecho a credito fiscal',1,0,'L'); 
		$pdf->Cell(16,3,$sub_total2,1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 	
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Importaciones gavadas por alicuota general',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 

        $pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Importaciones internas gavadas por alicuota general mas adicional',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 

        $pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Importaciones  internas gravadas por alicuota reducida',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
 		
		
        $pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Compras internas gravadas por alicuota general ',1,0,'L'); 
		$pdf->Cell(16,3,$criterio12,1,0,'R');
		$pdf->Cell(16,3,$criterio121,1,0,'R'); 
		$pdf->Cell(16,3,$criterio122,1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 	
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Compras internas gravadas por alicuota mas adicional',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->Cell(130,3,'',0,0,'R'); 
		$pdf->Cell(60,3,'Compras internas gravadas por alicuota reducida',1,0,'L'); 
		$pdf->Cell(16,3,$criterio8,1,0,'R');		
		$pdf->Cell(16,3,$criterio81,1,0,'R'); 
		$pdf->Cell(16,3,$criterio82,1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Total compras y créditos fiscales del Período',1,0,'L'); 
		$pdf->Cell(16,3,$totalb,1,0,'R');
		$pdf->Cell(16,3,$totalir,1,0,'R'); 
		$pdf->Cell(16,3,$totalr,1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Excedente del mes anterior',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,$excedente,1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->Cell(130,3,'',0,0,'R'); 
        $pdf->Cell(60,3,'Ajuste a los Creditos fiscales de periodos anteriores',1,0,'L'); 
		$pdf->Cell(16,3,$totalb,1,0,'R');
		$pdf->Cell(16,3,$totalir,1,0,'R'); 
		$pdf->Cell(16,3,$totalr,1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(50,3,'---------------------------------',0,0,'C'); 
		$pdf->Cell(50,3,'---------------------------------',0,0,'C'); 
		$pdf->Cell(30,3,'',0,0,'R'); 
		$pdf->SetFont('Arial','B',5);
        $pdf->Cell(60,3,'Total compras y créditos fiscales del Período',1,0,'L'); 
		$pdf->Cell(16,3,'',1,0,'R');
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(16,3,'',1,0,'R'); 
		$pdf->Cell(22,3,'',0,1,'R'); 
		
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(50,3,'Elaborado Por:',0,0,'C'); 
		$pdf->Cell(50,3,'Revisado Por:',0,0,'C');
		$pdf->Cell(100,3,'',0,1,'R'); 
		
		
		$pdf->Output();     
    }
	
	
	if($tipo_rpt=="PDF2"){ $res=pg_query($sSQL); $mes_libro_grupo=""; 	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $mes_libro_grupo;  global $registro; global $nombre_emp; global $ced_rif_emp;
			$this->Image('../../imagenes/Logo_emp.png',10,10,20);
			$this->SetFont('Arial','B',8);
			$this->Cell(30);
			$this->Cell(170,5,$nombre_emp,0,0,'L');
			$this->Cell(140,5,$criterio1,0,1,'R');	
			$this->Cell(30);
			$this->Cell(30,5,$ced_rif_emp,0,1,'L');
			$this->SetFont('Arial','B',12);
			$this->Cell(340,8,'LIBRO DE COMPRAS',0,1,'C');
			$this->SetFont('Arial','B',6);
			$this->SetFillColor(192,192,192);
			$this->Cell(242,4,'',0,0,'L');
			$this->Cell(59,4,'COMPRAS INTERNAS O IMPORTANCIONES',1,0,'C',true);
			$this->Cell(39,4,'',0,1,'R');
			
			$this->SetFont('Arial','B',6);
			$this->Cell(8,3,'.','RLT',0,'C',true);
			$this->Cell(12,3,'','RLT',0,'C',true);
			$this->Cell(14,3,'','LT',0,'C',true);
			$this->Cell(35,3,'','LT',0,'C',true);
			$this->Cell(35,3,'','LT',0,'C',true);			
			$this->Cell(8,3,' ','LT',0,'C',true);			
			$this->Cell(18,3,'','LT',0,'C',true);	
			$this->Cell(18,3,' ','LT',0,'C',true);
			$this->Cell(18,3,'NUMERO','LT',0,'C',true);
			$this->Cell(18,3,'NUMERO','LT',0,'C',true);
			$this->Cell(18,3,'NUMERO','LT',0,'C',true);			
			$this->Cell(9,3,'TIPO','LT',0,'C',true);
			$this->Cell(14,3,'NUMERO DE','LT',0,'C',true);			
			$this->Cell(17,3,'TOTAL','LT',0,'C',true);
			$this->Cell(17,3,'COMPRAS SIN','LT',0,'C',true);			
			$this->Cell(17,3,'.','LT',0,'C',true);
			$this->Cell(8,3,'','LT',0,'C',true);
			$this->Cell(17,3,'','LT',0,'C',true);
			$this->Cell(17,3,'NUMERO DE','LT',0,'C',true);
			$this->Cell(22,3,'','LTR',1,'C',true);
			
			$this->Cell(8,2,'OPER.','RL',0,'C',true);
			$this->Cell(12,2,'','RL',0,'C',true);
			$this->Cell(14,2,'','L',0,'C',true);
			$this->Cell(35,2,'','L',0,'C',true);
			$this->Cell(35,2,'','L',0,'C',true);			
			$this->Cell(8,2,'TIPO ','L',0,'C',true);			
			$this->Cell(18,2,'','L',0,'C',true);	
			$this->Cell(18,2,'NUMERO DE','L',0,'C',true);
			$this->Cell(18,2,'CONTROL DE','L',0,'C',true);
			$this->Cell(18,2,'NOTA DE','L',0,'C',true);
			$this->Cell(18,2,'NOTA DE','L',0,'C',true);			
			$this->Cell(9,2,'DE','L',0,'C',true);
			$this->Cell(14,2,'FACTURA','L',0,'C',true);			
			$this->Cell(17,2,'COMPRAS','L',0,'C',true);
			$this->Cell(17,2,'DERECHO','L',0,'C',true);			
			$this->Cell(17,2,'BASE.','L',0,'C',true);
			$this->Cell(8,2,'%','L',0,'C',true);
			$this->Cell(17,2,'IMPUESTO','L',0,'C',true);
			$this->Cell(17,2,'IVA','L',0,'C',true);
			$this->Cell(22,2,'ANTICIPO IVA','LR',1,'C',true);
			
			
			
			$this->Cell(8,3,'No.','LB',0,'C',true);
			$this->Cell(12,3,'FECHA','LB',0,'C',true);
			$this->Cell(14,3,'RIF','LB',0,'C',true);
			$this->Cell(35,3,'NOMBRE','LB',0,'C',true);
			$this->Cell(35,3,'CONCEPTO','LB',0,'C',true);
			$this->Cell(8,3,'PROV','LB',0,'C',true);
			$this->Cell(18,3,'COMPROBANTE','LB',0,'C',true);
			$this->Cell(18,3,'LA FACTURA','LB',0,'C',true);
			$this->Cell(18,3,'LA FACTURA','LB',0,'C',true);
			$this->Cell(18,3,'DEBITO','LB',0,'C',true);
			$this->Cell(18,3,'CREDITO','LB',0,'C',true);
			$this->Cell(9,3,'TRANS','LB',0,'C',true);
			$this->Cell(14,3,'AFECTADA','LB',0,'C',true);
			$this->Cell(17,3,'INCLUYE IVA','LB',0,'C',true);			
			$this->Cell(17,3,'CREDITO IVA','LB',0,'C',true);
			$this->Cell(17,3,'IMPONIBLE.','LB',0,'C',true);
			$this->Cell(8,3,'ALIC.','LB',0,'C',true);
			$this->Cell(17,3,'IVA','LB',0,'C',true);
			$this->Cell(17,3,'RETENIDO','LB',0,'C',true);			
			$this->Cell(22,3,'(IMPORTACIONES)','LRB',1,'C',true);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(170,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(170,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Legal);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_mes_libro=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  $nro_operacion=$registro["nro_operacion"];   $mes_libro_grupo=$mes_libro;
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; $concepto=$registro["campo_str2"];
		   $nro_documento=$registro["nro_documento"]; $ano_fiscal=$registro["ano_fiscal"];    $mes_fiscal=$registro["mes_fiscal"]; $tipo_transaccion=$registro["tipo_transaccion"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"]; $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
		   $base_imponible=$registro["base_imponible"]; $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];  $monto_iva_retenido=$registro["monto_iva_retenido"];	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; 
		   $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);	 $nro_fact=""; $nro_notacre="";	$nro_notadeb="";		   
		   if($tipo_documento=="01"){$nro_fact=$nro_documento;}	if($tipo_documento=="02"){$nro_notadeb=$nro_documento;}  if($tipo_documento=="03"){$nro_notacre=$nro_documento;}
		   if($nro_comprobante==""){$fecha_emision="";}else{$fecha_emision;}
		   if($php_os=="WINNT"){$concepto=$registro["campo_str2"]; }else{ $nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $tipo_prov=""; $pr=substr($ced_rif,0,1);
		   if(($pr=="J")or($pr=="G")){$tipo_prov="R";}  if(($pr=="V")or($pr=="E")){$tipo_prov="D";}	
		   $ln=strlen($nombre); $nro_lin=1; $nomb2=""; $nomb3=""; $nomb4=""; $nomb5=""; $conc2=""; $conc3=""; $conc4=""; $conc5="";
		   $h=3;  $nomb1=$nombre; $conc1=$concepto;		   
		   if($ln>=25){$nro_lin=2; $nomb1=substr($nombre,0,25);  $nomb2=substr($nombre,25,25);   $conc1=substr($concepto,0,25); $conc2=substr($concepto,25,25);  } 		   
		   if($ln>=50){$nro_lin=3; $nomb3=substr($nombre,50,25); $conc3=substr($concepto,50,25);  }
		   if($ln>=75){$nro_lin=4; $nomb4=substr($nombre,75,25); $conc4=substr($concepto,75,25);  }
		   if($ln>=100){$nro_lin=5; $nomb5=substr($nombre,100,25); $conc5=substr($concepto,100,25);  }	
		   $pdf->Cell(8,$h,$nro_operacion,'LR',0,'c'); 
		   $pdf->Cell(12,$h,$fecha_documento,'LR',0); 
		   $pdf->Cell(14,$h,$ced_rif,'LR',0); 
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=35; $z=35;
		   $pdf->Cell($w,$h,$nomb1,'LR',0,'L');
		   $pdf->Cell($z,$h,$conc1,'LR',0,'L');		   
		   $pdf->Cell(8,$h,$tipo_prov,0,0,'C'); 		   
		   $pdf->Cell(18,$h,$nro_comprobante,'LR',0,'C');		   
		   $pdf->Cell(18,$h,$nro_fact,'LR',0,'C'); 
		   $pdf->Cell(18,$h,$nro_con_documento,'LR',0,'C'); 
		   $pdf->Cell(18,$h,$nro_notadeb,'LR',0,'C'); 
		   $pdf->Cell(18,$h,$nro_notacre,'LR',0,'C'); 
		   $pdf->Cell(9,$h,$tipo_transaccion,'LR',0,'C'); 
		   $pdf->Cell(14,$h,$nro_doc_afectado,'LR',0,'C'); 
		   $pdf->Cell(17,$h,$monto_documento,'LR',0,'R'); 
           $pdf->Cell(17,$h,$monto_exento_iva,'LR',0,'R'); 		   
		   $pdf->Cell(17,$h,$base_imponible,'LR',0,'R'); 
		   $pdf->Cell(8,$h,$tasa_iva,'LR',0,'R'); 
		   $pdf->Cell(17,$h,$monto_iva,'LR',0,'R'); 
		   $pdf->Cell(17,$h,$monto_iva_retenido,'LR',0,'R');
		   $pdf->Cell(22,$h,'','LR',1,'R');		

		   if($nro_lin>=2){
		    $pdf->Cell(8,$h,'','LR',0,'c'); 
		    $pdf->Cell(12,$h,'','LR',0); 
		    $pdf->Cell(14,$h,'','LR',0); 
			$pdf->Cell($w,$h,$nomb2,'LR',0,'L');
		    $pdf->Cell($z,$h,$conc2,'LR',0,'L');		   
		    $pdf->Cell(8,$h,'',0,0); 		   
		    $pdf->Cell(18,$h,'','LR',0,'C');		   
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(9,$h,'','LR',0,'C'); 
		    $pdf->Cell(14,$h,'','LR',0,'C'); 
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
            $pdf->Cell(17,$h,'','LR',0,'R'); 		   
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
		    $pdf->Cell(8,$h,'','LR',0,'R'); 
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
		    $pdf->Cell(17,$h,'','LR',0,'R');
		    $pdf->Cell(22,$h,'','LR',1,'R');		
		   }

	       if($nro_lin>=3){
		    $pdf->Cell(8,$h,'','LR',0,'c'); 
		    $pdf->Cell(12,$h,'','LR',0); 
		    $pdf->Cell(14,$h,'','LR',0); 
			$pdf->Cell($w,$h,$nomb3,'LR',0,'L');
		    $pdf->Cell($z,$h,$conc3,'LR',0,'L');		   
		    $pdf->Cell(8,$h,'',0,0); 		   
		    $pdf->Cell(18,$h,'','LR',0,'C');		   
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(18,$h,'','LR',0,'C'); 
		    $pdf->Cell(9,$h,'','LR',0,'C'); 
		    $pdf->Cell(14,$h,'','LR',0,'C'); 
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
            $pdf->Cell(17,$h,'','LR',0,'R'); 		   
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
		    $pdf->Cell(8,$h,'','LR',0,'R'); 
		    $pdf->Cell(17,$h,'','LR',0,'R'); 
		    $pdf->Cell(17,$h,'','LR',0,'R');
		    $pdf->Cell(22,$h,'','LR',1,'R');	
		   }	   
		   
			
		} 
		$pdf->SetFont('Arial','B',6); $temp5=$sub_total5;
	    if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);							    
			$pdf->Cell(225,3,'',1,0,'R'); 
			$pdf->Cell(17,3,$sub_total1,1,0,'R'); 
			$pdf->Cell(17,3,$sub_total2,1,0,'R'); 
			$pdf->Cell(17,3,$sub_total3,1,0,'R'); 
			$pdf->Cell(8,3,'',1,0,'R'); 
			$pdf->Cell(17,3,$sub_total4,1,0,'R'); 
			$pdf->Cell(17,3,$sub_total5,1,0,'R');
			$pdf->Cell(22,3,'',1,1,'R');
		}		
        $pdf->Ln(5);
		$totalb=$criterio12+$criterio8; $totalir=$criterio121+$criterio81; $totalr=$criterio122+$criterio82;
		$totalb=formato_monto($totalb); $totalir=formato_monto($totalir); $totalr=formato_monto($totalr);
		$criterio12=formato_monto($criterio12); $criterio121=formato_monto($criterio121); $criterio122=formato_monto($criterio122);
		$criterio8=formato_monto($criterio8); $criterio81=formato_monto($criterio81);  $criterio82=formato_monto($criterio82);      
		$ret_sub_total2=0; $ret_sub_total2=formato_monto($ret_sub_total2);
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'RESUMEN DE COMPRAS '.$criterio1,'LRT',0,'C'); 
		$pdf->Cell(20,3,'Base Imponible','LRT',0,'C');
		$pdf->Cell(20,3,'Credito Fiscal','LRT',0,'C'); 
		$pdf->Cell(20,3,'Iva Retenido','LRT',0,'C'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->Cell(180,2,'',0,0,'R'); 
        $pdf->Cell(80,2,'','LR',0,'C'); 
		$pdf->Cell(20,2,'','LR',0,'R');
		$pdf->Cell(20,2,'','LR',0,'R'); 
		$pdf->Cell(20,2,'(a terceros)','LR',0,'C'); 
		$pdf->Cell(20,2,'',0,1,'R'); 
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Compras no gravadas y/ o sin derecho a credito fiscal',1,0,'L'); 
		$pdf->Cell(20,3,$sub_total2,1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 	
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Importaciones gavadas por alicuota general',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 

        $pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Importaciones internas gavadas por alicuota general mas adicional',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 

        $pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Importaciones  internas gravadas por alicuota reducida',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
 		
		
        $pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Compras internas gravadas por alicuota general ',1,0,'L'); 
		$pdf->Cell(20,3,$criterio12,1,0,'R');		
		$pdf->Cell(20,3,$criterio121,1,0,'R'); 
		$pdf->Cell(20,3,$criterio122,1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 	
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Compras internas gravadas por alicuota mas adicional',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->Cell(180,3,'',0,0,'R'); 
		$pdf->Cell(80,3,'Compras internas gravadas por alicuota reducida',1,0,'L'); 
		$pdf->Cell(20,3,$criterio8,1,0,'R');
		$pdf->Cell(20,3,$criterio81,1,0,'R'); 
		$pdf->Cell(20,3,$criterio82,1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Total compras y créditos fiscales del Período',1,0,'L'); 
		$pdf->Cell(20,3,$totalb,1,0,'R');
		$pdf->Cell(20,3,$totalir,1,0,'R'); 
		$pdf->Cell(20,3,$totalr,1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Excedente del mes anterior',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,$excedente,1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->Cell(180,3,'',0,0,'R'); 
        $pdf->Cell(80,3,'Ajuste a los Creditos fiscales de periodos anteriores',1,0,'L'); 
		$pdf->Cell(20,3,'',1,0,'R');
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(70,3,'--------------------------------------',0,0,'C'); 
		$pdf->Cell(70,3,'--------------------------------------',0,0,'C'); 
		$pdf->Cell(40,3,'',0,0,'R'); 
		$pdf->SetFont('Arial','B',6);
        $pdf->Cell(80,3,'Total compras y créditos fiscales del Período',1,0,'L'); 
		$pdf->Cell(20,3,$totalb,1,0,'R');
		$pdf->Cell(20,3,$totalir,1,0,'R'); 
		$pdf->Cell(20,3,$totalr,1,0,'R'); 
		$pdf->Cell(20,3,'',0,1,'R'); 
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(70,3,'Elaborado Por:',0,0,'C'); 
		$pdf->Cell(70,3,'Revisado Por:',0,0,'C');
		$pdf->Cell(100,3,'',0,1,'R'); 
		
		$pdf->Output();     
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Libro_Compras.xls");		
	?>
       <table border="1" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LIBRO DE COMPRAS</strong></font></td>
		 </tr>
	     <tr height="20">
		   <td width="100" align="left" ><strong></strong></td>
		   <td width="100" align="left" ><strong></strong></td>
           <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
		 </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Oper. Nro.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Rif</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Tipo Prov</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>Comprobante</strong></td>			
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Numero de la Factura</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Control de la Factura</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Nota de Debito</strong></font></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Numero Nota de Credito</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Trans</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Factura Afectada</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Total Compras Incluyendo IVA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Compras sin Derecho a Credito IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Base Imponible</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>% Alic.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Impuesto IVA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>IVA Retenido</strong></td>          
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Anticipo IVA (Importaciones)</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_mes_libro=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  $nro_operacion=$registro["nro_operacion"];
		   $mes_libro_grupo=$mes_libro;   $nombre=conv_cadenas($nombre,0);  
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; 
		   $nro_documento=$registro["nro_documento"]; $ano_fiscal=$registro["ano_fiscal"];    $mes_fiscal=$registro["mes_fiscal"]; $tipo_transaccion=$registro["tipo_transaccion"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"]; $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; $concepto=$registro["campo_str2"];
		   $base_imponible=$registro["base_imponible"]; $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];  $monto_iva_retenido=$registro["monto_iva_retenido"];	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; 
		   $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);
		   $nro_fact=""; $nro_notacre="";	$nro_notadeb="";		   
		   if($tipo_documento=="01"){$nro_fact=$nro_documento;}	if($tipo_documento=="02"){$nro_notadeb=$nro_documento;}  if($tipo_documento=="03"){$nro_notacre=$nro_documento;}
		   if($nro_comprobante==""){$fecha_emision="";}else{$fecha_emision;}$nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0); 
		   $tipo_prov=""; $pr=substr($ced_rif,0,1);   if(($pr=="J")or($pr=="G")){$tipo_prov="R";}  if(($pr=="V")or($pr=="E")){$tipo_prov="D";}	
	?>	   
		   <tr>
           		<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_operacion; ?></td>
				<td width="100" align="left"><? echo $fecha_documento; ?></td>
           		<td width="100" align="left"><? echo $ced_rif; ?></td>
           		<td width="300" align="justify"><? echo $nombre; ?></td>
				<td width="300" align="justify"><? echo $concepto; ?></td>
           		<td width="50" align="center"><? echo $tipo_prov; ?></td>
				<td width="100" align="center"><? echo $nro_comprobante; ?></td>
           		<td width="100" align="right"><? echo $nro_fact; ?></td>
           		<td width="100" align="right"><? echo $nro_con_documento; ?></td>
          		<td width="100" align="right"><? echo $nro_notadeb; ?></td>
           		<td width="100" align="right"><? echo $nro_notacre; ?></td>
           		<td width="100" align="center"><? echo $tipo_transaccion; ?></td>
           		<td width="100" align="center"><? echo $nro_doc_afectado; ?></td>
           		<td width="100" align="right"><? echo $monto_documento; ?></td>
           		<td width="100" align="right"><? echo $monto_exento_iva; ?></td>
           		<td width="100" align="right"><? echo $base_imponible; ?></td>
           		<td width="100" align="right"><? echo $tasa_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva_retenido; ?></td>
           		<td width="150" align="right"></td>
           </tr>
	    <? 
	}  
        if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);	
			?>	 				 
                <tr>
			          <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="300" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="right"><strong><? echo $sub_total1; ?></strong></td>
			          <td width="100" align="right"><strong><? echo $sub_total2; ?></strong></td>
			          <td width="100" align="right"><strong><? echo $sub_total3; ?></strong></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right"><strong><? echo $sub_total4; ?></strong></td>
			          <td width="100" align="right"><strong><? echo $sub_total5; ?></strong></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></font></td>
			    </tr>	
		      <? }  $criterio12=formato_monto($criterio12); $criterio121=formato_monto($criterio121);
		            $criterio8=formato_monto($criterio8); $criterio81=formato_monto($criterio81); 
					$ret_sub_total2=0; $ret_sub_total2=formato_monto($ret_sub_total2);
					?>	 				 
   		 
		        <tr>
			          <td width="100" align="left"></td>
				</tr>	
                <tr>
			          <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="300" align="left">Compras Exentas y/o sin derecho a Credito Fiscal</td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong><? echo $sub_total2; ?></strong></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right"><strong><? echo $ret_sub_total2; ?></strong></td>
			          <td width="100" align="right"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></font></td>
			    </tr>					
                <tr>
			          <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="300" align="left">Compras internas Afectadas solo alicuota General</td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong><? echo $criterio12; ?></strong></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right"><strong><? echo $criterio121; ?></strong></td>
			          <td width="100" align="right"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></font></td>
			    </tr>	
                <tr>
			          <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="300" align="left">Compras internas Afectadas solo alicuouta Reducida</td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong></strong></td>
			          <td width="100" align="right"><strong><? echo $criterio8; ?></strong></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right"><strong><? echo $criterio81; ?></strong></td>
			          <td width="100" align="right"><strong></strong></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></font></td>
			    </tr>			 				
		</table><?
        }		  
    }

?>
