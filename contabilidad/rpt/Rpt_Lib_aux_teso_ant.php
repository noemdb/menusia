<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
 $periodo=$_GET["periodo"];  $cod_cuenta_d=$_GET["cod_cuenta_d"]; $cod_cuenta_h=$_GET["cod_cuenta_h"]; $agrupar_dia=$_GET["agrupar_dia"];  $agrupar_dia=substr($agrupar_dia,0,1);
 $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
 if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";} }
 $fecha_d=Armar_Fecha($periodo, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo, 2, $Fec_Ini_Ejer);
 $criterio1="Desde ".$fecha_d." Al ".$fecha_h; $Sql="";
 if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}

  
 $criterio=" (con003.cod_cuenta>='".$cod_cuenta_d."'and con003.cod_cuenta<='".$cod_cuenta_h."') and (con002.fecha>='".$sfecha_d."'and con002.fecha<='".$sfecha_h."') ";
 $criterio=$criterio." and (con002.tipo_asiento<>'TRC') And (con002.tipo_asiento<>'TRD') ";
 $criterio=$criterio." and (con002.tipo_asiento<>'RDP') And (con002.tipo_asiento<>'RNC') "; 
 
 $criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and (con003.cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002'  ) ) )";
 $criterio=$criterio." and ( (substring(con003.cod_cuenta,1,10)='1-1-102-02') or (substring(con003.cod_cuenta,1,10)='1-1-102-03') or (substring(con003.cod_cuenta,1,7)='1-1-110') or (substring(con003.cod_cuenta,1,7)='1-1-122')  or (substring(con003.cod_cuenta,1,7)='1-2-101') 
  or (substring(con003.cod_cuenta,1,7)='1-1-132') or (substring(con003.cod_cuenta,1,7)='1-2-133') or (substring(con003.cod_cuenta,1,7)='1-1-130')  or (substring(con003.cod_cuenta,1,7)='1-2-131') or (substring(con003.cod_cuenta,1,7)='3-2-301') or (substring(con003.cod_cuenta,1,7)='3-2-303')  
  or ((substring(con003.cod_cuenta,1,10)='1-1-128-01') and (con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='DEP') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,7)='1-1-126') and (con002.tipo_asiento='DEP' OR con002.tipo_asiento='NCR') and (modulo='B'))  )";

  
$nro_linea=0; $cod_cuenta=""; $nom_cuenta=""; $c=0;  $prev_cuenta=""; $prev_fecha=""; $prev_deb_cre=""; 
$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','6')"; $resultado=pg_exec($conn,$Sql);$error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
else{ 
  $prev_monto=0;   $gcolumna1=0;  $gcolumna2=0;  $gcolumna3=0; $gcolumna4=0; $gcolumna5=0;  $gcolumna6=0; $gcolumna7=0; $gcolumna8=0; $gcolumna9=0; $gcolumna10=0;
  $mdes1=""; $mdes2=""; $mdes3=""; $mdes4=""; $mdes5=""; $mcuenta_g=""; $mnombre_g=""; $muestra="N";  
  $sql="SELECT con002.referencia,con002.fecha,con002.tipo_comp,con003.debito_credito,con003.cod_cuenta,con002.descripcion,con003.descripcion_a,
  con002.tipo_asiento,con003.monto_asiento,con002.status,con002.modulo,con002.aoperacion,con002.doperacion,con001.nombre_cuenta,con001.clasificacion,con001.tsaldo from con001,con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and (con001.codigo_cuenta=con003.cod_cuenta) and ((con002.modulo='I') OR (con002.modulo='B')) and ".$criterio." order by con002.fecha,con003.cod_cuenta,con003.debito_credito desc";
  $resultado=pg_query($sql);  $c=0; $temp1=$sql;
  while($registro=pg_fetch_array($resultado)){ 
      if($c==0){$c=1; $prev_cuenta=$registro["cod_cuenta"]; $prev_fecha=$registro["fecha"]; $prev_deb_cre=$registro["debito_credito"];   }       
	   if(($prev_cuenta<>$registro["cod_cuenta"])or($prev_fecha<>$registro["fecha"])or($prev_deb_cre<>$registro["debito_credito"])){
	     $mcuenta_g=substr($registro["cod_cuenta"],0,7);
		 $mcuenta_g=substr($cod_cuenta,0,7); $nro_linea=$nro_linea+1; $sfecha=$prev_fecha; $mnombre_g=""; $p=0;		 
		 if($mdes1<>""){ $mnombre_g=$mdes1; $p=$p+1; }		 
		 if($mdes2<>""){ if($p>0){$mnombre_g=$mnombre_g.", ";} $mnombre_g=$mnombre_g.$mdes2; $p=$p+1; }		 
		 if($mdes3<>""){ if($p>0){$mnombre_g=$mnombre_g.", ";} $mnombre_g=$mnombre_g.$mdes3; $p=$p+1; }		 
		 if($mdes4<>""){ if($p>0){$mnombre_g=$mnombre_g.", ";} $mnombre_g=$mnombre_g.$mdes4; $p=$p+1; }		 
		 if($mdes5<>""){ if($p>0){$mnombre_g=$mnombre_g.", ";} $mnombre_g=$mnombre_g.$mdes5; $p=$p+1; }		 
		 $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'$referencia','$sfecha','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_asiento','$mcod_grupo','$doperacion','$status','$cod_cuenta','$nombre_cuenta','$tsaldo','$mcuenta_g','$mnombre_g','$muestra',$gcolumna1,$gcolumna2,$gcolumna3,$gcolumna4,$gcolumna5,$gcolumna6,$gcolumna7,$gcolumna8,$gcolumna9,$prev_monto,'$descripcion','$descripcion_a')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
		 $prev_monto=0;   $gcolumna1=0;  $gcolumna2=0;  $gcolumna3=0; $gcolumna4=0; $gcolumna5=0;  $gcolumna6=0; $gcolumna7=0; $gcolumna8=0; $gcolumna9=0; $gcolumna10=0;
         if($prev_fecha<>$registro["fecha"]){ $mdes1=""; $mdes2=""; $mdes3=""; $mdes4=""; $mdes5="";
           $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='$mnombre_g' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (fecha='$prev_fecha')" ); 
		   $prev_fecha=$registro["fecha"];
		 }
		 $prev_cuenta=$registro["cod_cuenta"]; $prev_fecha=$registro["fecha"]; $prev_deb_cre=$registro["debito_credito"];
	   }
	   $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $fecha=$registro["fecha"]; $debito_credito=$registro["debito_credito"]; $clasificacion=$registro["clasificacion"];
	   $referencia=$registro["referencia"]; $tipo_comp=$registro["tipo_comp"]; $descripcion=$registro["descripcion"]; $descripcion_a=$registro["descripcion_a"]; $tsaldo=$registro["tsaldo"];
	   $tipo_asiento=$registro["tipo_asiento"]; $monto_asiento=$registro["monto_asiento"]; $status=$registro["status"]; $modulo=$registro["modulo"]; $aoperacion=$registro["aoperacion"];  $doperacion=$registro["doperacion"];
       $prev_monto=$prev_monto+$monto_asiento;	   
	   
	   $mcod_grupo="1";  $mcuenta_g=substr($cod_cuenta,0,7); $mnombre_g=""; $muestra="N";
	   If(substr($cod_cuenta,0,10)=="1-1-102-02" ){  $gcolumna1=$gcolumna1+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,10);}
	   else{ If(substr($cod_cuenta,0,10)=="1-1-102-03" ){  $gcolumna2=$gcolumna2+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,10);}
	    else{ If(substr($cod_cuenta,0,7)=="1-1-110" ){  $gcolumna3=$gcolumna3+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,7);}
		 else{ If(substr($cod_cuenta,0,7)=="1-1-122" ){  $gcolumna4=$gcolumna4+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,7); $mdes1="INGRESOS POR RECAUDAR"; $mcod_grupo="1"; $mnombre_g=$mdes1;}
		  else{ If(substr($cod_cuenta,0,7)=="1-2-101" ){  $gcolumna5=$gcolumna5+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,7); $mdes2="CANCELACION ORDENES DE PAGO"; $mcod_grupo="4"; $mnombre_g=$mdes2;}
		   else{ If(substr($cod_cuenta,0,7)=="3-2-301" ){  $gcolumna6=$gcolumna6+$monto_asiento; $mcuenta_g=substr($cod_cuenta,0,7); $mdes3="RECAUDACION DE INGRESOS"; $mcod_grupo="3"; $mnombre_g=$mdes3;}
		    else{ $mcuenta_g=substr($cod_cuenta,0,7); $mcod_grupo="5"; $gcolumna7=$gcolumna7+$monto_asiento; $muestra="S";
			   If(substr($cod_cuenta,0,7)=="1-2-133" ){  $mdes4="DEPOSITOS A TERCEROS"; $mnombre_g=$mdes4;}
			   If(substr($cod_cuenta,0,7)=="1-1-132" ){  $mdes4="FONDOS DE TERCEROS"; $mnombre_g=$mdes4; }
			   
			   If(substr($cod_cuenta,0,7)=="1-2-131" ){  $mdes4="DEPOSITOS ESPECIALES"; $mnombre_g=$mdes4; $mcod_grupo="8";}
			   If(substr($cod_cuenta,0,7)=="1-1-130" ){  $mdes4="FONDOS ESPECIALES"; $mnombre_g=$mdes4; $mcod_grupo="8";}
			   
			   
			   If(substr($cod_cuenta,0,7)=="3-2-303" ){  $mdes5="INGRESOS EXTRAORDINARIOS"; $mnombre_g=$mdes5; $mcod_grupo="2";}
			   If(substr($cod_cuenta,0,7)=="1-1-126" ){  $mdes5="FONDOS EN AVANCE"; $mnombre_g=$mdes5; $mcod_grupo="6";}
			   If(substr($cod_cuenta,0,7)=="3-1-300" ){  $mdes5="GASTOS POR COMISIONES BANCARIAS"; $mnombre_g=$mdes5; $mcod_grupo="7";}
	   } } } } } }

  }
  	   
  if($nro_linea>0){ $fin_rpt=0; $i=0; 
    $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'$referencia','$sfecha','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_asiento','$mcod_grupo','$doperacion','$status','$cod_cuenta','$nombre_cuenta','$tsaldo','$mcuenta_g','$mnombre_g','$muestra',$gcolumna1,$gcolumna2,$gcolumna3,$gcolumna4,$gcolumna5,$gcolumna6,$gcolumna7,$gcolumna8,$gcolumna9,$prev_monto,'$descripcion','$descripcion_a')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
	$res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='$mnombre_g' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (fecha='$prev_fecha')" ); 
	if($agrupar_dia=='N'){
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='INGRESOS POR RECAUDAR' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='1')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='INGRESOS EXTRAORDINARIOS' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='2')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='RECAUDACION DE INGRESOS' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='3')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='CANCELACION ORDENES DE PAGO' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='4')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='DEPOSITOS A TERCEROS/FONDOS DE TERCEROS' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='5')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='FONDOS EN AVANCE' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='6')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='GASTOS POR COMISIONES BANCARIAS' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='7')" ); 
	  $res=pg_exec($conn,"UPDATE CON013 set nombre_cuenta2='DEPOSITOS ESPECIALES/FONDOS ESPECIALES' Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') And (aoperacion='8')" ); 
	  
	}
	
    $sSQL="SELECT * from CON013 Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') order by  fecha,aoperacion";	$res=pg_query($sSQL); 
	  require('../../class/fpdf/fpdf.php');
	  class PDF extends FPDF{
		function Header(){ global $criterio1; global $i; global $tcol1_d; global $tcol1_c; global $tcol2_d; global $tcol2_c; global $tcol3_d; global $tcol3_c;
		     global $tcol4_d; global $tcol4_c;  global $tcol5_d; global $tcol5_c; global $tcol6_d; global $tcol6_c; global $tcol7_d; global $tcol7_c;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',7);
			$this->Cell(20);
			$this->Cell(70,8,'GOBERNACIÓN DEL ESTADO YARACUY',0,0,'L');
			$this->SetFont('Arial','B',15);
			$this->Cell(240,8,'LIBRO AUXILIAR DEL MOVIMIENTO DE TESORERIA',1,1,'C');
			$this->Cell(20);
			$this->SetFont('Arial','B',7);
			$this->Cell(70,4,'DIRECCIÓN DE TESORERIA',0,0,'L');
			$this->SetFont('Arial','B',9);			
			$this->Cell(300,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',5);
			
			$this->Cell(92,3,'','LRT',0);
			$this->Cell(68,3,'Tesoreria del Estado','LRT',0,'C');
			$this->Cell(34,3,'Fondo del Situado Coordinado','LRT',0,'C');
			$this->Cell(34,3,'Ingresos por Recaudar','LRT',0,'C');
			$this->Cell(34,3,'Ordenes de Pago','LRT',0,'C');
			$this->Cell(34,3,'Ingresos','LRT',0,'C');
			$this->Cell(44,3,'Varios','LRT',1,'C');
			
			$this->Cell(92,3,'A/','LR',0);
			$this->Cell(34,3,'CAJA','LR',0,'C');
			$this->Cell(34,3,'BANCO','LR',0,'C');
			$this->Cell(34,3,'','LR',0,'C');
			$this->Cell(34,3,'','LR',0,'C');
			$this->Cell(34,3,'','LR',0,'C');
			$this->Cell(34,3,'','LR',0,'C');
			$this->Cell(44,3,'','LR',1,'C');
			
			$this->Cell(5,3,'A/Nº','LRB',0);
			$this->Cell(12,3,'FECHA','LRB',0);				
			$this->Cell(59,3,'CONCEPTO','LRB',0);
            $this->Cell(16,3,'','LRB',0,'C');			
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');			
			$this->Cell(5,3,'COD','LRB',0,'C');
			$this->Cell(17,3,'DEBE','LRB',0,'C');
			$this->Cell(17,3,'HABER','LRB',0,'C');
			$this->Cell(5,3,'COD','LRB',1,'C');
			
			
			$y=$this->GetY(); $c=205;
			$this->Line(10,$y,10,$c);
			$this->Line(86,$y,86,$c);
			$this->Line(102,$y,102,$c);
			$this->Line(136,$y,136,$c);
			$this->Line(170,$y,170,$c);
			$this->Line(204,$y,204,$c);
			$this->Line(238,$y,238,$c);
			$this->Line(272,$y,272,$c);
			$this->Line(306,$y,306,$c);
			$this->Line(311,$y,311,$c);			
			$this->Line(345,$y,345,$c);
			$this->Line(350,$y,350,$c);	
			
			if($i>0){
			   $mtcol1_d=formato_monto($tcol1_d); $mtcol2_d=formato_monto($tcol2_d); $mtcol3_d=formato_monto($tcol3_d); $mtcol4_d=formato_monto($tcol4_d);			   
			   $mtcol5_d=formato_monto($tcol5_d); $mtcol6_d=formato_monto($tcol6_d); $mtcol7_d=formato_monto($tcol7_d); 
			   $mtcol1_c=formato_monto($tcol1_c); $mtcol2_c=formato_monto($tcol2_c); $mtcol3_c=formato_monto($tcol3_c); $mtcol4_c=formato_monto($tcol4_c);			   
			   $mtcol5_c=formato_monto($tcol5_c); $mtcol6_c=formato_monto($tcol6_c); $mtcol7_c=formato_monto($tcol7_c);
			  
			   $this->Cell(76,3,'VIENEN...   ',0,0,'R');
			   $this->Cell(16,3,'',0,0,'R');			   
			   $this->Cell(17,3,$mtcol1_d,0,0,'R');
			   $this->Cell(17,3,$mtcol1_c,0,0,'R');
			   $this->Cell(17,3,$mtcol2_d,0,0,'R');
			   $this->Cell(17,3,$mtcol2_c,0,0,'R');
			   $this->Cell(17,3,$mtcol3_d,0,0,'R');
			   $this->Cell(17,3,$mtcol3_c,0,0,'R');
			   $this->Cell(17,3,$mtcol4_d,0,0,'R');
			   $this->Cell(17,3,$mtcol4_c,0,0,'R');
			   $this->Cell(17,3,$mtcol5_d,0,0,'R');
			   $this->Cell(17,3,$mtcol5_c,0,0,'R');
			   $this->Cell(17,3,$mtcol6_d,0,0,'R');
			   $this->Cell(17,3,$mtcol6_c,0,0,'R');			   
			   $this->Cell(5,3,'',0,0,'R');
			   $this->Cell(17,3,$mtcol7_d,0,0,'R');
			   $this->Cell(17,3,$mtcol7_c,0,0,'R');
			   $this->Cell(5,3,'',0,1,'R');
            }

			
									
		}
		function Footer(){global $fin_rpt; global $tcol1_d; global $tcol1_c; global $tcol2_d; global $tcol2_c; global $tcol3_d; global $tcol3_c;
		     global $tcol4_d; global $tcol4_c;  global $tcol5_d; global $tcol5_c; global $tcol6_d; global $tcol6_c; global $tcol7_d; global $tcol7_c;
		    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		    $this->Line(10,205,350,205);
			//if($fin_rpt==1){
			   $this->Line(10,200,350,200); $this->SetY(-14);
			   $mtcol1_d=formato_monto($tcol1_d); $mtcol2_d=formato_monto($tcol2_d); $mtcol3_d=formato_monto($tcol3_d); $mtcol4_d=formato_monto($tcol4_d);			   
			   $mtcol5_d=formato_monto($tcol5_d); $mtcol6_d=formato_monto($tcol6_d); $mtcol7_d=formato_monto($tcol7_d); 
			   $mtcol1_c=formato_monto($tcol1_c); $mtcol2_c=formato_monto($tcol2_c); $mtcol3_c=formato_monto($tcol3_c); $mtcol4_c=formato_monto($tcol4_c);			   
			   $mtcol5_c=formato_monto($tcol5_c); $mtcol6_c=formato_monto($tcol6_c); $mtcol7_c=formato_monto($tcol7_c);
			   
			   $this->SetFont('Arial','B',6);
			   if($fin_rpt==1){$this->Cell(76,3,'TOTALES...   ',0,0,'R');}else{ $this->Cell(76,3,'VAN...   ',0,0,'R');}
			   $this->Cell(16,3,'',0,0,'R');			   
			   $this->Cell(17,3,$mtcol1_d,0,0,'R');
			   $this->Cell(17,3,$mtcol1_c,0,0,'R');
			   $this->Cell(17,3,$mtcol2_d,0,0,'R');
			   $this->Cell(17,3,$mtcol2_c,0,0,'R');
			   $this->Cell(17,3,$mtcol3_d,0,0,'R');
			   $this->Cell(17,3,$mtcol3_c,0,0,'R');
			   $this->Cell(17,3,$mtcol4_d,0,0,'R');
			   $this->Cell(17,3,$mtcol4_c,0,0,'R');
			   $this->Cell(17,3,$mtcol5_d,0,0,'R');
			   $this->Cell(17,3,$mtcol5_c,0,0,'R');
			   $this->Cell(17,3,$mtcol6_d,0,0,'R');
			   $this->Cell(17,3,$mtcol6_c,0,0,'R');			   
			   $this->Cell(5,3,'',0,0,'R');
			   $this->Cell(17,3,$mtcol7_d,0,0,'R');
			   $this->Cell(17,3,$mtcol7_c,0,0,'R');
			   $this->Cell(5,3,'',0,1,'R');
			//}else{$this->SetY(-10);}
		    
			 
			$this->SetFont('Arial','I',5);
			$this->Cell(170,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(170,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }		  
	  $pdf=new PDF('L', 'mm', Legal);
	  $pdf->AliasNbPages();
	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  //$pdf->MultiCell(276,4,$temp1,0);
	  $n_asiento=0; $prev_fecha=""; $prev_operacion=""; $t_monto=0;  $c_monto=0; $prev_cod1="";  $prev_cod2=""; $prev_grupo="";
	  $tcol1_d=0;  $tcol2_d=0;  $tcol3_d=0; $tcol4_d=0; $tcol5_d=0;  $tcol6_d=0; $tcol7_d=0; $tcol8_d=0; $tcol9_d=0;
	  $tcol1_c=0;  $tcol2_c=0;  $tcol3_c=0; $tcol4_c=0; $tcol5_c=0;  $tcol6_c=0; $tcol7_c=0; $tcol8_c=0; $tcol9_c=0;

	  $gcolumna1_d=0;  $gcolumna2_d=0;  $gcolumna3_d=0; $gcolumna4_d=0; $gcolumna5_d=0;  $gcolumna6_d=0; $gcolumna7_d=0; $gcolumna8_d=0; $gcolumna9_d=0;
	  $gcolumna1_c=0;  $gcolumna2_c=0;  $gcolumna3_c=0; $gcolumna4_c=0; $gcolumna5_c=0;  $gcolumna6_c=0; $gcolumna7_c=0; $gcolumna8_c=0; $gcolumna9_c=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; $fecha=$registro["fecha"]; $aoperacion=$registro["aoperacion"];
		   $nombre_cuenta2=$registro["nombre_cuenta2"]; $aoperacion=$registro["aoperacion"]; $debito_credito=$registro["debito_credito"]; 	$tcod=substr($codigo_cuenta,4,3);	   
		   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); }	 
		   
		   if($agrupar_dia=='N'){$mgrupo=$fecha.$aoperacion;}else($mgrupo=$fecha);
		   //if($prev_fecha<>$fecha){ 
		   if($prev_grupo<>$mgrupo){ 
		     $pdf->SetFont('Arial','B',6);
			 if($n_asiento>0){ if($t_monto==0){$t_monto=$c_monto;} $montod=formato_monto($t_monto); $i=$i+1;
			   if($gcolumna1_d==0){$col1_d="";}else{$col1_d=formato_monto($gcolumna1_d);}
			   if($gcolumna2_d==0){$col2_d="";}else{$col2_d=formato_monto($gcolumna2_d);}			   
			   if($gcolumna3_d==0){$col3_d="";}else{$col3_d=formato_monto($gcolumna3_d);}
			   if($gcolumna4_d==0){$col4_d="";}else{$col4_d=formato_monto($gcolumna4_d);}
			   if($gcolumna5_d==0){$col5_d="";}else{$col5_d=formato_monto($gcolumna5_d);}
			   if($gcolumna6_d==0){$col6_d="";}else{$col6_d=formato_monto($gcolumna6_d);}
			   if($gcolumna7_d==0){$col7_d="";}else{$col7_d=formato_monto($gcolumna7_d);}
               if($gcolumna1_c==0){$col1_c="";}else{$col1_c=formato_monto($gcolumna1_c);}
			   if($gcolumna2_c==0){$col2_c="";}else{$col2_c=formato_monto($gcolumna2_c);}			   
			   if($gcolumna3_c==0){$col3_c="";}else{$col3_c=formato_monto($gcolumna3_c);}
			   if($gcolumna4_c==0){$col4_c="";}else{$col4_c=formato_monto($gcolumna4_c);}
			   if($gcolumna5_c==0){$col5_c="";}else{$col5_c=formato_monto($gcolumna5_c);}
			   if($gcolumna6_c==0){$col6_c="";}else{$col6_c=formato_monto($gcolumna6_c);}
			   if($gcolumna7_c==0){$col7_c="";}else{$col7_c=formato_monto($gcolumna7_c);}
			   $tcol1_d=$tcol1_d+$gcolumna1_d; $tcol2_d=$tcol2_d+$gcolumna2_d; $tcol3_d=$tcol3_d+$gcolumna3_d; $tcol4_d=$tcol4_d+$gcolumna4_d; $tcol5_d=$tcol5_d+$gcolumna5_d; $tcol6_d=$tcol6_d+$gcolumna6_d; $tcol7_d=$tcol7_d+$gcolumna7_d;
			   $tcol1_c=$tcol1_c+$gcolumna1_c; $tcol2_c=$tcol2_c+$gcolumna2_c; $tcol3_c=$tcol3_c+$gcolumna3_c; $tcol4_c=$tcol4_c+$gcolumna4_c; $tcol5_c=$tcol5_c+$gcolumna5_c; $tcol6_c=$tcol6_c+$gcolumna6_c; $tcol7_c=$tcol7_c+$gcolumna7_c;
			   $pdf->Cell(76,2,'',0,0);
			   $pdf->Cell(16,2,'--------------------',0,1,'R');
			   $pdf->Cell(76,3,'',0,0);
			   $pdf->Cell(16,3,$montod,0,0,'R');			   
			   $pdf->Cell(17,3,$col1_d,0,0,'R');
			   $pdf->Cell(17,3,$col1_c,0,0,'R');
			   $pdf->Cell(17,3,$col2_d,0,0,'R');
			   $pdf->Cell(17,3,$col2_c,0,0,'R');
			   $pdf->Cell(17,3,$col3_d,0,0,'R');
			   $pdf->Cell(17,3,$col3_c,0,0,'R');
			   $pdf->Cell(17,3,$col4_d,0,0,'R');
			   $pdf->Cell(17,3,$col4_c,0,0,'R');
			   $pdf->Cell(17,3,$col5_d,0,0,'R');
			   $pdf->Cell(17,3,$col5_c,0,0,'R');
			   $pdf->Cell(17,3,$col6_d,0,0,'R');
			   $pdf->Cell(17,3,$col6_c,0,0,'R');			   
			   $pdf->Cell(5,3,$prev_cod1,0,0,'R');
			   $pdf->Cell(17,3,$col7_d,0,0,'R');
			   $pdf->Cell(17,3,$col7_c,0,0,'R');
			   $pdf->Cell(5,3,$prev_cod2,0,1,'R');			   
			   $pdf->Ln(4);
			 }
			 $n_asiento=$n_asiento+1; $prev_fecha=$fecha; $prev_grupo=$mgrupo; $t_monto=0; $c_monto=0; $prev_cod1=""; $prev_cod2="";
			 $gcolumna1_d=0;  $gcolumna2_d=0;  $gcolumna3_d=0; $gcolumna4_d=0; $gcolumna5_d=0;  $gcolumna6_d=0; $gcolumna7_d=0; $gcolumna8_d=0; $gcolumna9_d=0;
	         $gcolumna1_c=0;  $gcolumna2_c=0;  $gcolumna3_c=0; $gcolumna4_c=0; $gcolumna5_c=0;  $gcolumna6_c=0; $gcolumna7_c=0; $gcolumna8_c=0; $gcolumna9_c=0;
	         $fechaf=formato_ddmmaaaa($fecha);
			 $pdf->Cell(5,3,$n_asiento,0,0);
			 $pdf->Cell(12,3,$fechaf,0,0);
			 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=59;			 
			 //$pdf->Cell(59,4,$nombre_cuenta2,0,1);
			 $pdf->SetXY($x+$n,$y);
			 $pdf->Cell(16,3,'',0,1);
			 $pdf->SetXY($x,$y);
			 $pdf->MultiCell($n,3,$nombre_cuenta2,0);
			 
		   }
		   $pdf->SetFont('Arial','',6);
		   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; $columna5=$registro["columna5"];
		   $columna6=$registro["columna6"]; $columna7=$registro["columna7"]; $columna8=$registro["columna8"]; $columna9=$registro["columna9"]; $columna10=$registro["columna10"];
		   $montod=formato_monto($columna10); if($debito_credito=='D'){$t_monto=$t_monto+$columna10;} else{$c_monto=$c_monto+$columna10;}
		   
		   if($debito_credito=='D'){ $gcolumna1_d=$gcolumna1_d+$columna1; $gcolumna2_d=$gcolumna2_d+$columna2; $gcolumna3_d=$gcolumna3_d+$columna3; $gcolumna4_d=$gcolumna4_d+$columna4; $gcolumna5_d=$gcolumna5_d+$columna5; $gcolumna6_d=$gcolumna6_d+$columna6; $gcolumna7_d=$gcolumna7_d+$columna7; $gcolumna8_d=$gcolumna8_d+$columna8; $gcolumna9_d=$gcolumna9_d+$columna9;}
		   else{ $gcolumna1_c=$gcolumna1_c+$columna1; $gcolumna2_c=$gcolumna2_c+$columna2; $gcolumna3_c=$gcolumna3_c+$columna3; $gcolumna4_c=$gcolumna4_c+$columna4; $gcolumna5_c=$gcolumna5_c+$columna5; $gcolumna6_c=$gcolumna6_c+$columna6; $gcolumna7_c=$gcolumna7_c+$columna7; $gcolumna8_c=$gcolumna8_c+$columna8; $gcolumna9_c=$gcolumna9_c+$columna9;}
		   
		   if($columna7>0){ if($debito_credito=='D'){$prev_cod1=$tcod;}else{$prev_cod2=$tcod;} }
		   $pdf->Cell(17,3,'',0,0);
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=59; 
		   //$pdf->Cell(60,3,$nombre_cuenta,0,0);
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(16,3,$montod,0,1,'R');
		   $pdf->SetXY($x,$y);	   
		   $pdf->MultiCell($n,3,$nombre_cuenta,0); 
	  } $fin_rpt=1;
	  $pdf->SetFont('Arial','B',6);
		if($n_asiento>0){  $montod=formato_monto($t_monto);
		   if($gcolumna1_d==0){$col1_d="";}else{$col1_d=formato_monto($gcolumna1_d);}
		   if($gcolumna2_d==0){$col2_d="";}else{$col2_d=formato_monto($gcolumna2_d);}			   
		   if($gcolumna3_d==0){$col3_d="";}else{$col3_d=formato_monto($gcolumna3_d);}
		   if($gcolumna4_d==0){$col4_d="";}else{$col4_d=formato_monto($gcolumna4_d);}
		   if($gcolumna5_d==0){$col5_d="";}else{$col5_d=formato_monto($gcolumna5_d);}
		   if($gcolumna6_d==0){$col6_d="";}else{$col6_d=formato_monto($gcolumna6_d);}
		   if($gcolumna7_d==0){$col7_d="";}else{$col7_d=formato_monto($gcolumna7_d);}
		   if($gcolumna1_c==0){$col1_c="";}else{$col1_c=formato_monto($gcolumna1_c);}
		   if($gcolumna2_c==0){$col2_c="";}else{$col2_c=formato_monto($gcolumna2_c);}			   
		   if($gcolumna3_c==0){$col3_c="";}else{$col3_c=formato_monto($gcolumna3_c);}
		   if($gcolumna4_c==0){$col4_c="";}else{$col4_c=formato_monto($gcolumna4_c);}
		   if($gcolumna5_c==0){$col5_c="";}else{$col5_c=formato_monto($gcolumna5_c);}
		   if($gcolumna6_c==0){$col6_c="";}else{$col6_c=formato_monto($gcolumna6_c);}
		   if($gcolumna7_c==0){$col7_c="";}else{$col7_c=formato_monto($gcolumna7_c);}
		   $tcol1_d=$tcol1_d+$gcolumna1_d; $tcol2_d=$tcol2_d+$gcolumna2_d; $tcol3_d=$tcol3_d+$gcolumna3_d; $tcol4_d=$tcol4_d+$gcolumna4_d; $tcol5_d=$tcol5_d+$gcolumna5_d; $tcol6_d=$tcol6_d+$gcolumna6_d; $tcol7_d=$tcol7_d+$gcolumna7_d;
		   $tcol1_c=$tcol1_c+$gcolumna1_c; $tcol2_c=$tcol2_c+$gcolumna2_c; $tcol3_c=$tcol3_c+$gcolumna3_c; $tcol4_c=$tcol4_c+$gcolumna4_c; $tcol5_c=$tcol5_c+$gcolumna5_c; $tcol6_c=$tcol6_c+$gcolumna6_c; $tcol7_c=$tcol7_c+$gcolumna7_c;
			   
		   $pdf->Cell(76,2,'',0,0);
		   $pdf->Cell(16,2,'--------------------',0,1,'R');
		   $pdf->Cell(76,3,'',0,0);
		   $pdf->Cell(16,3,$montod,0,0,'R');			   
		   $pdf->Cell(17,3,$col1_d,0,0,'R');
		   $pdf->Cell(17,3,$col1_c,0,0,'R');
		   $pdf->Cell(17,3,$col2_d,0,0,'R');
		   $pdf->Cell(17,3,$col2_c,0,0,'R');
		   $pdf->Cell(17,3,$col3_d,0,0,'R');
		   $pdf->Cell(17,3,$col3_c,0,0,'R');
		   $pdf->Cell(17,3,$col4_d,0,0,'R');
		   $pdf->Cell(17,3,$col4_c,0,0,'R');
		   $pdf->Cell(17,3,$col5_d,0,0,'R');
		   $pdf->Cell(17,3,$col5_c,0,0,'R');
		   $pdf->Cell(17,3,$col6_d,0,0,'R');
		   $pdf->Cell(17,3,$col6_c,0,0,'R');			   
		   $pdf->Cell(5,3,$prev_cod1,0,0,'R');
		   $pdf->Cell(17,3,$col7_d,0,0,'R');
		   $pdf->Cell(17,3,$col7_c,0,0,'R');
		   $pdf->Cell(5,3,$prev_cod2,0,1,'R');			   
		   $pdf->Ln(4);
		}
	  $pdf->Output(); 
  }
} 
pg_close();?>