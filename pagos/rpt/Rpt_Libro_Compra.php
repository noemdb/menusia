<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$periodod=$_GET["periodod"];$periodoh=$_GET["periodoh"];  $Sql=""; $tipo_rpt=$_GET["tipo_rpt"];
$criterio1="Mes: "."   ".$periodoh."  "."Periodo :  ".$periodod; 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }    
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
	   FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and mes_libro='".$periodoh."' order by fecha_documento,nro_operacion";    
	$criterio8=0; $criterio81=0; $criterio12=0; $criterio121=0;
	$Sql = "SELECT sum(base_imponible) as base8, sum(monto_iva) as base81  FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and (mes_libro='".$periodoh."') and (tasa_iva=8)";
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio8=$registro["base8"]; $criterio81=$registro["base81"];  }
	$Sql = "SELECT sum(base_imponible) as base12, sum(monto_iva) as base121  FROM PAG032, PRE099 WHERE PAG032.Ced_Rif = PRE099.Ced_Rif and (mes_libro='".$periodoh."') and (tasa_iva=12)";
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio12=$registro["base12"]; $criterio121=$registro["base121"];  }
	 	
    if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Libro_Compra_IVA.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio8"=>$criterio8,"criterio81"=>$criterio81,"criterio12"=>$criterio12,"criterio121"=>$criterio121,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $mes_libro_grupo=""; 	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo; global $mes_libro_grupo;  global $registro; global $nombre_emp; global $ced_rif_emp;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',8);
			$this->Cell(30);
			$this->Cell(130,5,$nombre_emp,0,0,'L');
			$this->Cell(100,5,$criterio1,0,1,'R');	
			$this->Cell(30);
			$this->Cell(30,5,$ced_rif_emp,0,1,'L');
			$this->SetFont('Arial','B',12);
			$this->Cell(260,8,'LIBRO DE COMPRA IVA',0,1,'C');
			$this->SetFont('Arial','B',5);
			$this->SetFillColor(192,192,192);
			$this->Cell(170,4,'',1,0,'L');
			$this->Cell(40,4,'COMPRAS INTERNAS O IMPORTANCIONES',1,0,'C',true);
			$this->Cell(50,4,'',1,1,'R');
			
			$this->SetFont('Arial','B',4);
			$this->Cell(10,3,'','RLT',0,'C',true);
			$this->Cell(13,3,'','LT',0,'C',true);
			$this->Cell(40,3,'','LT',0,'C',true);
			$this->Cell(7,3,'TIPO ','LT',0,'C',true);
			$this->Cell(15,3,'NUMERO ','LT',0,'C',true);
			$this->Cell(15,3,'NUMERO','LT',0,'C',true);
			$this->Cell(10,3,'NUMERO','LT',0,'C',true);
			$this->Cell(10,3,'NUMERO','LT',0,'C',true);
			$this->Cell(10,3,'TIPO ','LT',0,'C',true);
			$this->Cell(10,3,'FACTURA','LT',0,'C',true);
			$this->Cell(15,3,'TOTAL','LT',0,'C',true);
			$this->Cell(15,3,'COMPRAS SIN','LT',0,'C',true);
			$this->Cell(15,3,'BASE.','LT',0,'C',true);
			$this->Cell(10,3,'% ALIC.','LT',0,'C',true);
			$this->Cell(15,3,'IMPUESTO','LT',0,'C',true);
			$this->Cell(15,3,'IVA','LT',0,'C',true);
			$this->Cell(15,3,'','LT',0,'C',true);
			$this->Cell(10,3,'','LT',0,'C',true);
			$this->Cell(10,3,'IVA ','LT',1,'C',true);
			
			$this->Cell(10,3,'FECHA','LB',0,'C',true);
			$this->Cell(13,3,'RIF','LB',0,'C',true);
			$this->Cell(40,3,'NOMBRE','LB',0,'C',true);
			$this->Cell(7,3,'PROV','LB',0,'C',true);
			$this->Cell(15,3,'FACTURA','LB',0,'C',true);
			$this->Cell(15,3,'CONTROL FACT','LB',0,'C',true);
			$this->Cell(10,3,'NOTA DEB','LB',0,'C',true);
			$this->Cell(10,3,'NOTA CRED','LB',0,'C',true);
			$this->Cell(10,3,'TRANS','LB',0,'C',true);
			$this->Cell(10,3,'AFECTADA','LB',0,'C',true);
			$this->Cell(15,3,'COMPRAS IVA','LB',0,'C',true);
			$this->Cell(15,3,'CREDITO IVA','LB',0,'C',true);
			$this->Cell(15,3,'IMPONIBLE.','LB',0,'C',true);
			$this->Cell(10,3,'% ALIC.','LB',0,'C',true);
			$this->Cell(15,3,'IVA','LB',0,'C',true);
			$this->Cell(15,3,'RETENIDO','LB',0,'C',true);
			$this->Cell(15,3,'COMPROBANTE','LB',0,'C',true);
			$this->Cell(10,3,'FECHA','LB',0,'C',true);
			$this->Cell(10,3,'PERCIBIDO','LRB',1,'C',true);
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
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  
		   $mes_libro_grupo=$mes_libro;
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; 
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
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }else{ $nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $h=3; if(strlen($nombre)>=44){$h=6;}
		   
		   $pdf->Cell(10,$h,$fecha_documento,1,0); 
		   $pdf->Cell(13,$h,$ced_rif,1,0); 
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=40;
		   $pdf->SetXY($x+$w,$y);		   
		   $pdf->Cell(7,$h,'',1,0); 
		   $pdf->Cell(15,$h,$nro_fact,1,0,'C'); 
		   $pdf->Cell(15,$h,$nro_con_documento,1,0,'C'); 
		   $pdf->Cell(10,$h,$nro_notadeb,1,0,'C'); 
		   $pdf->Cell(10,$h,$nro_notacre,1,0,'C'); 
		   $pdf->Cell(10,$h,$tipo_transaccion,1,0,'C'); 
		   $pdf->Cell(10,$h,$nro_doc_afectado,1,0,'C'); 
		   $pdf->Cell(15,$h,$monto_documento,1,0,'R'); 
           $pdf->Cell(15,$h,$monto_exento_iva,1,0,'R'); 		   
		   $pdf->Cell(15,$h,$base_imponible,1,0,'R'); 
		   $pdf->Cell(10,$h,$tasa_iva,1,0,'R'); 
		   $pdf->Cell(15,$h,$monto_iva,1,0,'R'); 
		   $pdf->Cell(15,$h,$monto_iva_retenido,1,0,'R');
		   $pdf->Cell(15,$h,$nro_comprobante,1,0,'C');
		   $pdf->Cell(10,$h,$fecha_emision,1,0,'C');
		   $pdf->Cell(10,$h,'',1,1,'R');		   
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$nombre,1); 
			
		} 
		$pdf->SetFont('Arial','B',5);
	    if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);							    
			$pdf->Cell(140,3,'',1,0,'R'); 
			$pdf->Cell(15,3,$sub_total1,1,0,'R'); 
			$pdf->Cell(15,3,$sub_total2,1,0,'R'); 
			$pdf->Cell(15,3,$sub_total3,1,0,'R'); 
			$pdf->Cell(10,3,'',1,0,'R'); 
			$pdf->Cell(15,3,$sub_total4,1,0,'R'); 
			$pdf->Cell(15,3,$sub_total5,1,0,'R');
			$pdf->Cell(35,3,'',1,1,'R'); 
		}		
        $pdf->Ln(5);
		$criterio12=formato_monto($criterio12); $criterio121=formato_monto($criterio121);
		$criterio8=formato_monto($criterio8); $criterio81=formato_monto($criterio81);        
		$ret_sub_total2=0; $ret_sub_total2=formato_monto($ret_sub_total2);
		$pdf->Cell(120,3,'',0,0,'R'); 
        $pdf->Cell(50,3,'Compras Exentas y/o sin derecho a Credito Fiscal ',1,0,'R'); 
		$pdf->Cell(15,3,$sub_total2,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(15,3,$ret_sub_total2,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 		
        $pdf->Cell(120,3,'',0,0,'R'); 
        $pdf->Cell(50,3,'Compras internas Afectadas solo alicuota General ',1,0,'R'); 
		$pdf->Cell(15,3,$criterio12,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(15,3,$criterio121,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 		
		$pdf->Cell(120,3,'',0,0,'R'); 
		$pdf->Cell(50,3,'Compras internas Afectadas solo alicuota Reducida ',1,0,'R'); 
		$pdf->Cell(15,3,$criterio8,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(15,3,$criterio81,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 
		$pdf->Output();     
    }
	
	
	if($tipo_rpt=="PDF2"){ $res=pg_query($sSQL); $mes_libro_grupo=""; 	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo; global $mes_libro_grupo;  global $registro; global $nombre_emp; global $ced_rif_emp;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(130,5,$nombre_emp,0,0,'L');
			$this->Cell(180,5,$criterio1,0,1,'R');	
			$this->Cell(30);
			$this->Cell(30,5,$ced_rif_emp,0,1,'L');
			
			$this->SetFont('Arial','B',14);
			$this->Cell(355,8,'LIBRO DE COMPRA IVA',0,1,'C');
			$this->SetFont('Arial','B',6);
			$this->SetFillColor(192,192,192);
			$this->Cell(220,4,'',0,0,'L');
			$this->Cell(50,4,'COMPRAS INTERNAS O IMPORTANCIONES',1,0,'C',true);
			$this->Cell(50,4,'',0,1,'R');
			$this->SetFont('Arial','B',5);
			$this->rect(9.8,31.80,340.3,6);
			$y=$this->GetY();$x=$this->GetX();
			
			$this->Cell(14,3,' ',0,0,'C',true);
			$this->Cell(15,3,' ',0,0,'C',true);
			$this->Cell(45,3,' ',0,0,'C',true);
			$this->Cell(6,3,'TIPO',0,0,'C',true);			
			$this->Cell(20,3,'NUMERO DE',0,0,'C',true);
			$this->Cell(20,3,'NUMERO CONTROL',0,0,'C',true);
			$this->Cell(15,3,'NUMERO',0,0,'C',true);
			$this->Cell(15,3,'NUMERO',0,0,'C',true);
			$this->Cell(15,3,'TIPO',0,0,'C',true);			
			$this->Cell(15,3,'NUMERO DE',0,0,'C',true);
			$this->Cell(20,3,'TOTAL COMPRAS',0,0,'C',true);
			$this->Cell(20,3,'COMPRAS SIN ',0,0,'C',true);
			$this->Cell(20,3,'BASE',0,0,'C',true);
			$this->Cell(10,3,'',0,0,'C',true);
			$this->Cell(20,3,'IMPUESTO',0,0,'C',true);
			$this->Cell(20,3,'IVA ',0,0,'C',true);
			$this->Cell(20,3,'',0,0,'C',true);
			$this->Cell(15,3,'',0,0,'C',true);
			$this->Cell(15,3,'IVA ',0,1,'C',true);
					
			$this->Cell(14,3,'FECHA',0,0,'C',true);
			$this->Cell(15,3,'RIF',0,0,'C',true);
			$this->Cell(45,3,'NOMBRE',0,0,'C',true);
			$this->Cell(6,3,'PROV',0,0,'C',true);			
			$this->Cell(20,3,'LA FACTURA',0,0,'C',true);
			$this->Cell(20,3,'DE LA FACTURA',0,0,'C',true);
			$this->Cell(15,3,'NOTA DEBITO',0,0,'C',true);
			$this->Cell(15,3,'NOTA CREDITO',0,0,'C',true);
			$this->Cell(15,3,'TRANS',0,0,'C',true);			
			$this->Cell(15,3,'FACT AFECTADA',0,0,'C',true);
			$this->Cell(20,3,'INCLUYENDO IVA',0,0,'C',true);
			$this->Cell(20,3,'CREDITO IVA',0,0,'C',true);
			$this->Cell(20,3,'IMPONIBLE.',0,0,'C',true);
			$this->Cell(10,3,'% ALIC.',0,0,'C',true);
			$this->Cell(20,3,'IVA',0,0,'C',true);
			$this->Cell(20,3,'RETENIDO',0,0,'C',true);
			$this->Cell(20,3,'COMPROBANTE',0,0,'C',true);
			$this->Cell(15,3,'FECHA',0,0,'C',true);
			$this->Cell(15,3,'PERCIBIDO ',0,1,'C',true);
			
			$this->Line(24,$y-0.1,24,$y+6);
			$this->Line(39,$y-0.1,39,$y+6);
			$this->Line(84,$y-0.1,84,$y+6);
			$this->Line(90,$y-0.1,90,$y+6);
			$this->Line(110,$y-0.1,110,$y+6);
			$this->Line(130,$y-0.1,130,$y+6);
			$this->Line(145,$y-0.1,145,$y+6);
			$this->Line(160,$y-0.1,160,$y+6);
			$this->Line(175,$y-0.1,175,$y+6);
			$this->Line(190,$y-0.1,190,$y+6);
			$this->Line(210,$y-0.1,210,$y+6);
			$this->Line(230,$y-0.1,230,$y+6);
			$this->Line(250,$y-0.1,250,$y+6);
			$this->Line(260,$y-0.1,260,$y+6);
			$this->Line(280,$y-0.1,280,$y+6);
			$this->Line(300,$y-0.1,300,$y+6);
			$this->Line(320,$y-0.1,320,$y+6);
			$this->Line(335,$y-0.1,335,$y+6);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(175,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(175,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Legal);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_mes_libro=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  
		   $mes_libro_grupo=$mes_libro;
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; 
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
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }else{ $nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $h=3; if(strlen($nombre)>=45){$h=6;}		   
		   $pdf->Cell(14,$h,$fecha_documento,1,0); 
		   $pdf->Cell(15,$h,$ced_rif,1,0); 
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=45;
		   $pdf->SetXY($x+$w,$y);		   
		   $pdf->Cell(6,$h,'',1,0); 
		   $pdf->Cell(20,$h,$nro_fact,1,0,'C'); 
		   $pdf->Cell(20,$h,$nro_con_documento,1,0,'C'); 
		   $pdf->Cell(15,$h,$nro_notadeb,1,0,'C'); 
		   $pdf->Cell(15,$h,$nro_notacre,1,0,'C'); 
		   $pdf->Cell(15,$h,$tipo_transaccion,1,0,'C'); 
		   $pdf->Cell(15,$h,$nro_doc_afectado,1,0,'C'); 
		   $pdf->Cell(20,$h,$monto_documento,1,0,'R'); 
           $pdf->Cell(20,$h,$monto_exento_iva,1,0,'R'); 		   
		   $pdf->Cell(20,$h,$base_imponible,1,0,'R'); 
		   $pdf->Cell(10,$h,$tasa_iva,1,0,'R'); 
		   $pdf->Cell(20,$h,$monto_iva,1,0,'R'); 
		   $pdf->Cell(20,$h,$monto_iva_retenido,1,0,'R');
		   $pdf->Cell(20,$h,$nro_comprobante,1,0,'C');
		   $pdf->Cell(15,$h,$fecha_emision,1,0,'C');
		   $pdf->Cell(15,$h,'',1,1,'R');		   
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$nombre,1);			
		} 
		$pdf->SetFont('Arial','B',6);
	    if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);							    
			$pdf->Cell(180,3,'',1,0,'R'); 
			$pdf->Cell(20,3,$sub_total1,1,0,'R'); 
			$pdf->Cell(20,3,$sub_total2,1,0,'R'); 
			$pdf->Cell(20,3,$sub_total3,1,0,'R');
			
			$pdf->Cell(10,3,'',1,0,'R'); 
			$pdf->Cell(20,3,$sub_total4,1,0,'R'); 
			$pdf->Cell(20,3,$sub_total5,1,0,'R');
			$pdf->Cell(50,3,'',1,1,'R'); 
		}		
        $pdf->Ln(3);
		$criterio12=formato_monto($criterio12); $criterio121=formato_monto($criterio121);
		$criterio8=formato_monto($criterio8); $criterio81=formato_monto($criterio81);        
		$ret_sub_total2=0; $ret_sub_total2=formato_monto($ret_sub_total2);
		
		$pdf->Cell(150,3,'',0,0,'R'); 
        $pdf->Cell(70,3,'Compras Exentas y/o sin derecho a Credito Fiscal ',1,0,'R'); 
		$pdf->Cell(20,3,$sub_total2,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(20,3,$ret_sub_total2,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 
        $pdf->Cell(150,3,'',0,0,'R'); 
        $pdf->Cell(70,3,'Compras internas Afectadas solo alicuota General ',1,0,'R'); 
		$pdf->Cell(20,3,$criterio12,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(20,3,$criterio121,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 		
		$pdf->Cell(150,3,'',0,0,'R'); 
		$pdf->Cell(70,3,'Compras internas Afectadas solo alicuota Reducida ',1,0,'R'); 
		$pdf->Cell(20,3,$criterio8,1,0,'R');
		$pdf->Cell(10,3,'',1,0,'R'); 
		$pdf->Cell(20,3,$criterio81,1,0,'R'); 
		$pdf->Cell(50,3,'',0,1,'R'); 
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
            <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LIBRO DE COMPRA IVA</strong></font></td>
		 </tr>
	     <tr height="20">
		   <td width="100" align="left" ><strong></strong></td>
		   <td width="100" align="left" ><strong></strong></td>
           <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
		 </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Rif</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Tipo Prov</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Numero de Factura</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Control de la Factura</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Nota Debito</strong></font></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Numero Nota Credito</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Trans</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>Numero Factura Afectada</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Total Compras Incluyendo IVA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Compras sin Derecho a Credito IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Base Imponible</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>% Alic.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Impuesto IVA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>IVA Retenido</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Comprobante</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IVA Percibido</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_mes_libro=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $mes_libro=$registro["mes_libro"];  
		   $mes_libro_grupo=$mes_libro;   $nombre=conv_cadenas($nombre,0);  
		   $fecha_documento=$registro["fecha_documento"]; $nro_comprobante=$registro["nro_comprobante"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=$registro["fecha_emision"]; $nro_con_documento=$registro["nro_con_documento"]; $tipo_documento=$registro["tipo_documento"]; 
		   $nro_documento=$registro["nro_documento"]; $ano_fiscal=$registro["ano_fiscal"];    $mes_fiscal=$registro["mes_fiscal"]; $tipo_transaccion=$registro["tipo_transaccion"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"]; $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
		   $base_imponible=$registro["base_imponible"]; $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];  $monto_iva_retenido=$registro["monto_iva_retenido"];	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; 
		   $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);
		   $nro_fact=""; $nro_notacre="";	$nro_notadeb="";		   
		   if($tipo_documento=="01"){$nro_fact=$nro_documento;}	if($tipo_documento=="02"){$nro_notadeb=$nro_documento;}  if($tipo_documento=="03"){$nro_notacre=$nro_documento;}
		   if($nro_comprobante==""){$fecha_emision="";}else{$fecha_emision;}$nombre=conv_cadenas($nombre,0);  
	?>	   
		   <tr>
           		<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $fecha_documento; ?></td>
           		<td width="100" align="left"><? echo $ced_rif; ?></td>
           		<td width="300" align="justify"><? echo $nombre; ?></td>
           		<td width="50" align="right"></td>
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
           		<td width="100" align="center"><? echo $nro_comprobante; ?></td>
           		<td width="100" align="center"><? echo $fecha_emision; ?></td>
           		<td width="100" align="right"></td>
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
