<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$doc_comp_d=$_GET["doc_comp_d"]; $doc_comp_h=$_GET["doc_comp_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$tipo_comp_d=$_GET["tipo_comp_d"]; $tipo_comp_h=$_GET["tipo_comp_h"]; $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];  $tipo_rep=$_GET["tipo_rep"];}
else{$fecha="";$tipo_rep="HTML";} $php_os=PHP_OS;  $equipo=getenv("COMPUTERNAME"); $cod_mov="pre021m".$usuario_sia;

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
  $cfecha_h=formato_aaaammdd($fecha_h); $cfecha_d=formato_aaaammdd($fecha_d); $criterio_est=""; $fecha_hoy=asigna_fecha_hoy();  $sfecha=formato_aaaammdd($fecha_hoy);
  $hora= date ( "h:i:s" , time () );  $criterio1="Fecha Desde : ".$fecha_d."        "."Hasta : ".$fecha_h;
  $criterio4=" (pre006.tipo_compromiso>='$doc_comp_d' and pre006.tipo_compromiso<='$doc_comp_h') and (pre006.cod_tipo_comp>='$tipo_comp_d' and pre006.cod_tipo_comp<='$tipo_comp_h') and (pre006.referencia_comp>='$referencia_d' and pre006.referencia_comp<='$referencia_h') and (pre006.Fecha_Compromiso>='$cfecha_d' and pre006.Fecha_Compromiso<='$cfecha_h') ";
  $criterio5=" (pre007.tipo_compromiso>='$doc_comp_d' and pre007.tipo_compromiso<='$doc_comp_h') and (pre007.referencia_comp>='$referencia_d' and pre007.referencia_comp<='$referencia_h')  and (pre007.fecha_causado>='$cfecha_d' and pre007.fecha_causado<='$cfecha_h')  and ( text(pre007.tipo_compromiso)||text(pre007.referencia_comp) in (select text(pre012.tipo_comp)||text(pre012.referencia_comp) from pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."') ))";
  $criterio6=" (pre008.tipo_compromiso>='$doc_comp_d' and pre008.tipo_compromiso<='$doc_comp_h') and (pre008.referencia_comp>='$referencia_d' and pre008.referencia_comp<='$referencia_h')  and (pre008.fecha_pago>='$cfecha_d' and pre008.fecha_pago<='$cfecha_h')  and ( text(pre008.tipo_compromiso)||text(pre008.referencia_comp) in (select text(pre012.tipo_comp)||text(pre012.referencia_comp) from pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."') ))";
  $criterio7=" (pre005.refierea='COMPROMISO') and (pre011.tipo_compromiso>='$doc_comp_d' and pre011.tipo_compromiso<='$doc_comp_h') and (pre011.referencia_comp>='$referencia_d' and pre011.referencia_comp<='$referencia_h')  and (pre011.fecha_ajuste>='$cfecha_d' and pre011.fecha_ajuste<='$cfecha_h')  and ( text(pre011.tipo_compromiso)||text(pre011.referencia_comp) in (select text(pre012.tipo_comp)||text(pre012.referencia_comp) from pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."') ))";
  $criterio8=" (pre005.refierea='CAUSADO') and (pre011.tipo_compromiso>='$doc_comp_d' and pre011.tipo_compromiso<='$doc_comp_h') and (pre011.referencia_comp>='$referencia_d' and pre011.referencia_comp<='$referencia_h')  and (pre011.fecha_ajuste>='$cfecha_d' and pre011.fecha_ajuste<='$cfecha_h')  and ( text(pre011.tipo_compromiso)||text(pre011.referencia_comp) in (select text(pre012.tipo_comp)||text(pre012.referencia_comp) from pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."') ))";
  $criterio9=" (pre005.refierea='PAGO') and (pre011.tipo_compromiso>='$doc_comp_d' and pre011.tipo_compromiso<='$doc_comp_h') and (pre011.referencia_comp>='$referencia_d' and pre011.referencia_comp<='$referencia_h')  and (pre011.fecha_ajuste>='$cfecha_d' and pre011.fecha_ajuste<='$cfecha_h')  and ( text(pre011.tipo_compromiso)||text(pre011.referencia_comp) in (select text(pre012.tipo_comp)||text(pre012.referencia_comp) from pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."') ))";
 
   
  $StrSQL="DELETE FROM pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."')"; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 

  
  $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre036.cod_presup,pre036.fuente_financ,pre001.denominacion,'1',pre006.fecha_Compromiso as fecha_doc,pre006.referencia_comp,pre006.tipo_compromiso,pre002.nombre_abrev_comp,
    pre006.referencia_comp,pre006.tipo_compromiso,'' as referencia_caus,'' as tipo_caus,'' as referencia_pago,'' as tipo_pago, pre006.ced_rif, 'C',pre036.monto,pre036.monto as comprometido,0 as causado, 0 as pagado,0,0,0,0,0,0,0,0,0,pre036.ref_imput_presu,'C' as tipo_rep,pre099.nombre as nombre_benef,pre006.nro_documento as campo_str1,'' as campo_str2,pre006.inf_usuario,pre006.descripcion_comp as descripcion_doc
    FROM pre001,pre002,pre006, pre036, pre099  where pre001.cod_presup=pre036.cod_presup and pre036.fuente_financ=pre001.cod_fuente and pre002.tipo_compromiso=pre006.tipo_compromiso and pre006.tipo_compromiso=pre036.tipo_compromiso and 
    pre006.referencia_comp=pre036.referencia_comp and pre006.fecha_compromiso=pre036.fecha_compromiso and pre006.ced_rif=pre099.ced_rif and ".$criterio4; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
  
  
    
 $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre031.cod_presup,pre031.fuente_financ,pre001.denominacion,'2',pre011.fecha_ajuste as fecha_doc,pre011.referencia_ajuste,pre011.tipo_ajuste,pre005.nombre_abrev_ajuste,
    pre011.referencia_comp,pre011.tipo_compromiso,'' as referencia_caus,'' as tipo_caus,'' as referencia_pago,'' as tipo_pago, pre006.ced_rif, 'C',pre031.monto,(pre031.monto*-1) as comprometido,0 as causado, 0 as pagado,0,0,0,0,0,0,0,0,0,'P','C' as tipo_rep,pre099.nombre as nombre_benef,'' as campo_str1,'' as campo_str2,pre011.inf_usuario,pre011.descripcion as descripcion_doc
    FROM pre001,pre005,pre006,pre011,pre031, pre099  where pre001.cod_presup=pre031.cod_presup and pre031.fuente_financ=pre001.cod_fuente and 
	 pre005.tipo_ajuste=pre011.tipo_ajuste and pre006.tipo_compromiso=pre011.tipo_compromiso and pre006.referencia_comp=pre011.referencia_comp and 
	 (pre011.referencia_ajuste=pre031.referencia_ajuste) and (pre011.tipo_ajuste=pre031.tipo_ajuste) and (pre011.tipo_pago=pre031.tipo_pago) and (pre011.referencia_pago=pre031.referencia_pago) and (pre011.tipo_causado=pre031.tipo_causado) and (pre011.referencia_caus=pre031.referencia_caus) and (pre011.tipo_compromiso=pre031.tipo_compromiso) and (pre011.referencia_comp=pre031.referencia_comp) and 
	pre006.ced_rif=pre099.ced_rif and ".$criterio7; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
  
  
  
	   
  $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre037.cod_presup,pre037.fuente_financ,pre001.denominacion,'3',pre007.fecha_causado as fecha_doc,pre007.referencia_caus,pre007.tipo_causado,pre003.nombre_abrev_caus,
    pre007.referencia_comp,pre007.tipo_compromiso,pre007.referencia_caus,pre007.tipo_causado as tipo_caus,'' as referencia_pago,'' as tipo_pago, pre007.ced_rif, 'C',pre037.monto,0 as comprometido,pre037.monto as causado, 0 as pagado,0,0,0,0,0,0,0,0,0,pre037.ref_imput_presu,'C' as tipo_rep,pre099.nombre as nombre_benef,'' as campo_str1,'' as campo_str2,pre007.inf_usuario,pre007.descripcion_caus as descripcion_doc
    FROM pre001,pre003,pre007,pre037,pre099 where pre001.cod_presup=pre037.cod_presup and pre037.fuente_financ=pre001.cod_fuente and 
    pre007.tipo_causado=pre003.tipo_causado and  pre007.tipo_compromiso=pre037.tipo_compromiso and pre007.referencia_comp=pre037.referencia_comp AND
    pre007.referencia_caus=pre037.referencia_caus and pre007.tipo_causado=pre037.tipo_causado and pre007.ced_rif=pre099.ced_rif and ".$criterio5; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
  
  
  $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre031.cod_presup,pre031.fuente_financ,pre001.denominacion,'4',pre011.fecha_ajuste as fecha_doc,pre011.referencia_ajuste,pre011.tipo_ajuste,pre005.nombre_abrev_ajuste,
    pre011.referencia_comp,pre011.tipo_compromiso,'' as referencia_caus,'' as tipo_caus,'' as referencia_pago,'' as tipo_pago, pre007.ced_rif, 'C',pre031.monto,0 as comprometido,(pre031.monto*-1) as causado, 0 as pagado,0,0,0,0,0,0,0,0,0,'P','C' as tipo_rep,pre099.nombre as nombre_benef,'' as campo_str1,'' as campo_str2,pre011.inf_usuario,pre011.descripcion as descripcion_doc
    FROM pre001,pre005,pre007,pre011,pre031, pre099  where pre001.cod_presup=pre031.cod_presup and pre031.fuente_financ=pre001.cod_fuente and 
	 pre005.tipo_ajuste=pre011.tipo_ajuste and pre007.tipo_compromiso=pre011.tipo_compromiso and pre007.referencia_comp=pre011.referencia_comp and  pre007.referencia_caus=pre011.referencia_caus and pre007.tipo_causado=pre011.tipo_causado and
	 (pre011.referencia_ajuste=pre031.referencia_ajuste) and (pre011.tipo_ajuste=pre031.tipo_ajuste) and (pre011.tipo_pago=pre031.tipo_pago) and (pre011.referencia_pago=pre031.referencia_pago) and (pre011.tipo_causado=pre031.tipo_causado) and (pre011.referencia_caus=pre031.referencia_caus) and (pre011.tipo_compromiso=pre031.tipo_compromiso) and (pre011.referencia_comp=pre031.referencia_comp) and 
	pre007.ced_rif=pre099.ced_rif and ".$criterio8; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
 
  
  $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre038.cod_presup,pre038.fuente_financ,pre001.denominacion,'5',pre008.fecha_pago as fecha_doc,pre008.referencia_pago,pre008.tipo_pago,pre004.nombre_abrev_pago,
    pre008.referencia_comp,pre008.tipo_compromiso,pre008.referencia_caus,pre008.tipo_causado as tipo_caus,pre008.referencia_pago,pre008.tipo_pago, pre008.ced_rif, 'C',pre038.monto,0 as comprometido,0 as causado, pre038.monto as pagado,0,0,0,0,0,0,0,0,0,pre038.ref_imput_presu,'C' as tipo_rep,pre099.nombre as nombre_benef,'' as campo_str1,'' as campo_str2,pre008.inf_usuario,pre008.descripcion_pago as descripcion_doc
    FROM pre001,pre004,pre008,pre038,pre099 where pre001.cod_presup=pre038.cod_presup and pre038.fuente_financ=pre001.cod_fuente and 	
    pre008.tipo_pago=pre004.tipo_pago and  pre008.tipo_compromiso=pre038.tipo_compromiso and pre008.referencia_comp=pre038.referencia_comp and pre038.referencia_pago=pre008.referencia_pago and pre038.tipo_pago=pre008.tipo_pago and
    pre008.referencia_caus=pre038.referencia_caus and pre008.tipo_causado=pre038.tipo_causado and pre008.ced_rif=pre099.ced_rif and ".$criterio6; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
  
  $StrSQL= "INSERT INTO pre012 SELECT '$cod_mov' as nombre_usuario,'C' as status,'$sfecha' as fecha_generado,'$hora' as hora_generado,pre031.cod_presup,pre031.fuente_financ,pre001.denominacion,'6',pre011.fecha_ajuste as fecha_doc,pre011.referencia_ajuste,pre011.tipo_ajuste,pre005.nombre_abrev_ajuste,
    pre011.referencia_comp,pre011.tipo_compromiso,'' as referencia_caus,'' as tipo_caus,'' as referencia_pago,'' as tipo_pago, pre008.ced_rif, 'C',pre031.monto,0 as comprometido,0 as causado, (pre031.monto*-1) as pagado,0,0,0,0,0,0,0,0,0,'P','C' as tipo_rep,pre099.nombre as nombre_benef,'' as campo_str1,'' as campo_str2,pre011.inf_usuario,pre011.descripcion as descripcion_doc
    FROM pre001,pre005,pre008,pre011,pre031, pre099  where pre001.cod_presup=pre031.cod_presup and pre031.fuente_financ=pre001.cod_fuente and 
	 pre005.tipo_ajuste=pre011.tipo_ajuste and pre008.tipo_compromiso=pre011.tipo_compromiso and pre008.referencia_comp=pre011.referencia_comp and  pre008.referencia_caus=pre011.referencia_caus and pre008.tipo_causado=pre011.tipo_causado and pre008.referencia_pago=pre011.referencia_pago and pre008.tipo_pago=pre011.tipo_pago and
	 (pre011.referencia_ajuste=pre031.referencia_ajuste) and (pre011.tipo_ajuste=pre031.tipo_ajuste) and (pre011.tipo_pago=pre031.tipo_pago) and (pre011.referencia_pago=pre031.referencia_pago) and (pre011.tipo_causado=pre031.tipo_causado) and (pre011.referencia_caus=pre031.referencia_caus) and (pre011.tipo_compromiso=pre031.tipo_compromiso) and (pre011.referencia_comp=pre031.referencia_comp) and 
	pre008.ced_rif=pre099.ced_rif and ".$criterio9; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 
 
   
  $sSQL = "SELECT pre012.nombre_Usuario, pre012.Status, pre012.cod_presup,  pre012.denominacion, pre012.fuente_financ,  substr(pre012.denominacion,1,85) as denom_cort, 
pre012.Tipo_Registro, pre012.fecha_doc, pre012.Referencia_Doc, pre012.Tipo_Doc,  pre012.nombre_Abrev_Doc, pre012.Referencia_Comp, pre012.Tipo_Comp, 
pre012.Referencia_Caus,  pre012.Tipo_Caus, pre012.Referencia_Pago, pre012.Tipo_Pago, pre012.descripcion_doc as descripcion,SUBSTRING(pre012.descripcion_Doc,1,180) AS descripcion_doc, pre012.ced_rif, pre012.Afecta, pre012.Monto, 
pre012.nombre_benef,   pre012.Comprometido, pre012.Causado, pre012.Pagado, pre012.Traslados, pre012.Adicion,  pre012.Ajuste_Comp, pre012.Ajuste_Caus, pre012.Ajuste_Pago, (pre012.Adicion+pre012.Traslados) AS modificaciones,
pre012.Ref_Imput_Presu, pre012.disponible, pre012.asig_actualizada, to_char(pre012.fecha_doc,'DD/MM/YYYY') as fechad, SUBSTRING(pre012.cod_presup,".$ini.",".$p.") as cod_part,pre012.campo_str1  
FROM  pre012  where (pre012.Tipo_Rep='C') and (nombre_usuario='$cod_mov') ORDER BY referencia_comp,tipo_comp,pre012.fecha_doc,pre012.tipo_registro,pre012.referencia_doc,pre012.tipo_doc,pre012.ref_imput_presu,pre012.cod_presup,pre012.fuente_financ";

  if(($tipo_rep=="HTML")){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_mov_compromiso.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    }
  if($tipo_rep=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(130,10,'MOVIMIENTOS DE COMPROMISOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
            $this->SetFont('Arial','B',6);					
			$this->Cell(15,5,'FECHA',1,0);
			$this->Cell(10,5,'TIPO',1,0);
			$this->Cell(20,5,'REFERENCIA',1,0);
			$this->Cell(90,5,'DESCRIPCION',1,0);
			$this->Cell(65,5,'BENEFICIARIO',1,0);
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $totalm=0; $totalc=0; $totala=0; $totalp=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $prev_clave="";  $prev_doc="";
	  while($registro=pg_fetch_array($res)){ $asignado=$registro["asignado"];		$asignado=formato_monto($asignado);  $nombre=$registro["nombre_benef"];
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denom_cort"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_part=$registro["cod_part"];  
			$referencia_comp=$registro["referencia_comp"]; $tipo_comp=$registro["tipo_comp"]; $referencia_doc=$registro["referencia_doc"]; $tipo_doc=$registro["tipo_doc"];
			$clave=$tipo_comp.$referencia_comp;		$clave_doc=$tipo_doc.$referencia_doc;
			if($php_os=="WINNT"){$denominacion=$registro["denom_cort"]; }   else{$nombre=utf8_decode($nombre); $denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalc>0)or($sub_totala>0)or($sub_totalp>0)or($i>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(200,2,'',0,0);
					$pdf->Cell(20,2,'-----------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------',0,1,'R');
					$pdf->Cell(200,5,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalp,0,1,'R'); 
					$pdf->AddPage();	$i=0; 				
				}
				$pdf->SetFont('Arial','',6);	
				$prev_clave=$clave;  $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0;
            }
			$referencia=$registro["referencia_doc"]; $fecha=$registro["fecha_doc"];  $tipo=$registro["nombre_abrev_doc"];  $nombre=$registro["nombre_benef"];
			if(trim($registro["campo_str1"])==""){$descripcion=$registro["descripcion"];}else{$descripcion=$registro["campo_str1"]." ".$registro["descripcion"]; }
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["comprometido"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $disponible=$registro["disponible"];
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; $fechaf=formato_ddmmaaaa($fecha);
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$nombre=utf8_decode($nombre); $descripcion=utf8_decode($descripcion);} $disponible=formato_monto($disponible);
		    if($clave_doc<>$prev_doc){
			  $pdf->Ln(2);
		      $pdf->Cell(15,3,$fechaf,0,0); 
		      $pdf->Cell(10,3,$tipo,0,0);
              $pdf->Cell(20,3,$referencia,0,0); 
		      $x=$pdf->GetX();   $y=$pdf->GetY(); $n=65; $w=90;	
              $nombre_temp=substr($nombre,0,45); 			  
		      $pdf->SetXY($x+$w,$y);
			  $pdf->Cell($n,3,$nombre_temp,0,1); 
			  $pdf->SetXY($x,$y);	
		      $pdf->MultiCell($w,3,$descripcion,0);  			  
			  $prev_doc=$clave_doc;
			}  
		   $pdf->Cell(5,3,'',0,0,'R'); 
		   $pdf->Cell(40,3,$cod_presup."   ".$fuente_financ,0,0,'L'); 
		   $pdf->Cell(155,3,$denominacion,0,0,'L'); 
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,1,'R'); 	   
		   
			$i=$i+1; 
		}$sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(200,2,'',0,0);
		$pdf->Cell(20,2,'-----------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------',0,1,'R');
		$pdf->Cell(200,5,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,5,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,5,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,5,$sub_totalp,0,1,'R');  
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Movmientos_Compromisos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MOVIMIENTOS DE COMPROMISOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1;?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="200" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>		 
			 </tr>
		  <?  $i=0;  $totalm=0; $totalc=0; $totala=0; $totalp=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $prev_clave="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $asignado=$registro["asignado"];		$asignado=formato_monto($asignado);  
		       $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denom_cort"]; 
			   $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_part=$registro["cod_part"];			   
		       $denominacion=conv_cadenas($denominacion,0); $clave=$cod_presup.$fuente_financ;
			   $referencia_comp=$registro["referencia_comp"]; $tipo_comp=$registro["tipo_comp"]; $referencia_doc=$registro["referencia_doc"]; $tipo_doc=$registro["tipo_doc"];
			  $clave=$tipo_comp.$referencia_comp;		$clave_doc=$tipo_doc.$referencia_doc;
		       if($prev_clave<>$clave){ 
			     if(($sub_totalc>0)or($sub_totala>0)or($sub_totalp>0)or($i>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
					?>	 				 
                    <tr>
				      <td width="90" align="left"></td>
					  <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="200" align="right"><? echo "Totales : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
						 
			    $prev_clave=$clave;  $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $i=0;
			   }
		       $referencia=$registro["referencia_doc"]; $fecha=$registro["fecha_doc"];  $tipo=$registro["nombre_abrev_doc"];  $descripcion=$registro["campo_str1"]." ".$registro["descripcion"]; $nombre=$registro["nombre_benef"];
			   $modificaciones=$registro["modificaciones"]; $comprometido=$registro["comprometido"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $disponible=$registro["disponible"];
               $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
			   $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;
			   $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $disponible=formato_monto($disponible);
			   $fechaf=formato_ddmmaaaa($fecha);  $descripcion=conv_cadenas($descripcion,0); $nombre=conv_cadenas($nombre,0);
			   
			   if($clave_doc<>$prev_doc){ 
			   ?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $fechaf; ?></td>
				   <td width="80" align="left"><? echo $tipo; ?></td>
				   <td width="80" align="left">'<? echo $referencia; ?></td>				  
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="200" align="justify"><? echo $nombre; ?></td>		
				   <td width="120" align="right"></td>
				   <td width="120" align="right"></td>
				   <td width="120" align="right"></td>
				 </tr>
			   <?  $prev_doc=$clave_doc; }	

               ?>	   
				<tr>
				   <td width="90" align="left"></td>
				   <td width="80" align="left"></td>
				   <td width="80" align="left"></td>				  
				   <td width="400" align="justify"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="200" align="justify"><? echo $denominacion; ?></td>		
				   <td width="120" align="right"><? echo $comprometido; ?></td>
				   <td width="120" align="right"><? echo $causado; ?></td>
				   <td width="120" align="right"><? echo $pagado; ?></td>
				 </tr>
			   <?	$i=$i+1;		   
		  }
		  if(($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		  ?>	 				 
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="200" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totalc; ?></td>
			  <td width="120" align="right"><? echo $sub_totala; ?></td>
			  <td width="120" align="right"><? echo $sub_totalp; ?></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
    }	
    $StrSQL="DELETE FROM pre012 where (tipo_rep='C') and (nombre_usuario='".$cod_mov."')"; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); 

?>