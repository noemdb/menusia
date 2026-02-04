<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$ref_credito=$_GET["ref_credito"]; $cod_presupd=$_GET["cod_presupd"]; $cod_presuph=$_GET["cod_presuph"];  $fuente_d=$_GET["fuente_d"];  $fuente_h=$_GET["fuente_h"]; $fecha_d=$_GET["fecha_d"];  $fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"]; $most_modif=$_GET["most_modif"];
$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $cod_fuented=$fuente_d; $cod_fuenteh=$fuente_h; $criterio1="Fecha Desde: ".$fecha_d; $criterio2="";      $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
  $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $Rif_Emp=$registro["campo007"]; }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;  $buscaf_ant="N";  $monto_cred=0;
  
  $sql="select * from pre009 where (referencia_modif='$ref_credito') and (tipo_modif = '1')";  $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
  if($filas>0){$registro=pg_fetch_array($resultado);$fecha_d=$registro["fecha_modif"];  $fecha_d=formato_ddmmaaaa($fecha_d);}
  
  $sql="select sum(monto) as total_cred from pre039 where (referencia_modif='$ref_credito') and (tipo_modif = '1')"; $resultado=pg_query($sql); 
  if ($registro=pg_fetch_array($resultado,0)){$monto_cred=$registro["total_cred"]; } 
  $criterio1="Credito Adicional : ".$ref_credito."   Fecha Desde : ".$fecha_d."        "."Hasta : ".$fecha_h;  $cod_mov="pre012".$usuario_sia; $sfechad=formato_aaaammdd($fecha_d); $sfechah=formato_aaaammdd($fecha_h);
  $criterio="(cod_presup>='$cod_presupd' and cod_presup<='$cod_presuph') And (cod_fuente>='$cod_fuented' and cod_fuente<='$cod_fuenteh')";

   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];}
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$cod_fuented."' and cod_fuente<='".$cod_fuenteh."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$cod_fuented."' and cod_fuente<='".$cod_fuenteh."'";}
   }else{$criterio="cod_presup>='".$cod_presupd."' and cod_presup<='".$cod_presuph."' and  cod_fuente>='".$cod_fuented."' and cod_fuente<='".$cod_fuenteh."'";}
   $res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('E','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'A' as Tipo_Registro, cod_presup, cod_fuente, denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
    $StrSQL=$StrSQL."asignado,disponible,disp_diferida,0 as compromiso,0 as causado, 0 as pagado, 0 as traslados, 0 as trasladon, 0 as adicion, 0 as disminucion, 0 as Diferido,0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
    $StrSQL=$StrSQL." FROM pre001 WHERE (length(cod_presup)=".$l_c.") and (text(cod_presup)||text(cod_fuente) in (select text(cod_presup)||text(fuente_financ) from pre039 where pre039.referencia_modif='$ref_credito' and (tipo_modif='1' or tipo_modif='2')) ) and ".$criterio;  
    $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('M','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('C','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('A','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('P','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    if($most_modif=="S"){$res=pg_exec($conn,"SELECT ACTUALIZA_DISP_CREDITO('T','$cod_mov','A','$ref_credito','$sfechad','$sfechah','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }}
    $sSQL = "SELECT pre012.Nombre_Usuario, pre012.Status, pre012.Cod_Presup, pre012.Denominacion, pre012.Fuente_Financ, PRE095.Des_Fuente_Financ, pre012.Tipo_Registro, pre012.Fecha_Doc, pre012.Referencia_Doc, pre012.Tipo_Doc, pre012.Nombre_Abrev_Doc, pre012.Referencia_Comp, pre012.Tipo_Comp, pre012.Referencia_Caus, pre012.Tipo_Caus, pre012.Referencia_Pago, pre012.Tipo_Pago, pre012.Descripcion_Doc, pre012.Ced_Rif, pre012.Afecta, pre012.Monto, pre012.Comprometido, pre012.Causado, pre012.Pagado, pre012.Traslados, pre012.Adicion, pre012.Ajuste_Comp, pre012.Ajuste_Caus, pre012.Ajuste_Pago, pre012.Ref_Imput_Presu  
             FROM  PRE012, PRE095 WHERE  pre012.Fuente_Financ = PRE095.Cod_Fuente_Financ and (pre012.tipo_registro='A') and (pre012.nombre_Usuario='$cod_mov') ORDER BY pre012.Cod_Presup, pre012.Fuente_Financ ";
	  
    if($tipo_rep=="HTML"){include ("../../class/phpreports/PHPReportMaker.php");	 $nomb_rpt="Rpt_ejecucion_credito_adicional.xml"; if($most_modif=="S"){ $nomb_rpt="Rpt_ejecucion_credito_adic_modif.xml";} 
	      $oRpt = new PHPReportMaker();
          $oRpt->setXML($nomb_rpt);
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if(($tipo_rep=="PDF")and($most_modif=="N")){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'EJECUCION DE CREDITO ADICIONAL',1,0,'C');
			$this->Ln(15);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,10,$criterio1,0,1,'L');	
			$this->SetFont('Arial','B',7);
			$this->Cell(78,5,'CODIGO PRESUPUESTARIO / DENOMINACION',1,0);
			$this->Cell(22,5,'MONTO CREDITO',1,0,'C');
			$this->Cell(20,5,'COMPROMISO',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'DEUDA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);

			// INI NMDB 30-04-2018
			// $this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			// $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	        $this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	        $this->Cell(100,5,' ',0,0,'R');
	        // FIN NMDB 30-04-2018
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"]; $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
           $denominacion=$registro["denominacion"]; $cod_fuente=$registro["fuente_financ"]; $dispon=$monto-$comprometido; $deuda=$causado-$pagado;
		   $total1=$total1+$monto; $total2=$total2+$comprometido; $total3=$total3+$causado; $total4=$total4+$pagado; $total5=$total5+$monto-$comprometido; $total6=$total6+$causado-$pagado;
		   $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $causado=formato_monto($causado); $pagado=formato_monto($pagado);
		   $dispon=formato_monto($dispon); $deuda=formato_monto($deuda);
		   $pdf->Cell(80,3,$cod_presup."   ".$cod_fuente,0,0); 
		   $pdf->Cell(20,3,$monto,0,0,'R'); 
		   $pdf->Cell(20,3,$comprometido,0,0,'R');
		   $pdf->Cell(20,3,$causado,0,0,'R'); 
		   $pdf->Cell(20,3,$pagado,0,0,'R'); 
		   $pdf->Cell(20,3,$dispon,0,0,'R');  
		   $pdf->Cell(20,3,$deuda,0,1,'R'); 
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);  		   

		} $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(80,2,'',0,0);
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,1,'R');
		$pdf->Cell(80,5,'Total : ',0,0,'R');
		$pdf->Cell(20,5,$total1,0,0,'R'); 
		$pdf->Cell(20,5,$total2,0,0,'R'); 
		$pdf->Cell(20,5,$total3,0,0,'R'); 
		$pdf->Cell(20,5,$total4,0,0,'R'); 
		$pdf->Cell(20,5,$total5,0,0,'R'); 
		$pdf->Cell(20,5,$total6,0,1,'R'); 		 
		$pdf->Output();   
    }
	if(($tipo_rep=="PDF")and($most_modif=="S")){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'EJECUCION DE CREDITO ADICIONAL',1,0,'C');
			$this->Ln(15);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,10,$criterio1,0,1,'L');	
			$this->SetFont('Arial','B',7);
			$this->Cell(70,5,'CODIGO PRESUPUESTARIO / DENOMINACION',1,0);
			$this->Cell(22,5,'MONTO CREDITO',1,0,'C');
			$this->Cell(18,5,'TRASLADOS',1,0,'C');
			$this->Cell(18,5,'COMPROMISO',1,0,'C');
			$this->Cell(18,5,'CAUSADO',1,0,'C');
			$this->Cell(18,5,'PAGADO',1,0,'C');
			$this->Cell(18,5,'DISPONIBLE',1,0,'C');
			$this->Cell(18,5,'DEUDA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $total7=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"]; $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
           $denominacion=$registro["denominacion"]; $cod_fuente=$registro["fuente_financ"]; $traslados=$registro["traslados"]; $dispon=$monto+$traslados-$comprometido; $deuda=$causado-$pagado;
		   $total1=$total1+$monto; $total2=$total2+$comprometido; $total3=$total3+$causado; $total4=$total4+$pagado; $total5=$total5+$dispon; $total6=$total6+$deuda; $total7=$total7+$traslados;
		   $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $causado=formato_monto($causado); $pagado=formato_monto($pagado);
		   $dispon=formato_monto($dispon); $deuda=formato_monto($deuda); $traslados=formato_monto($traslados); 
		   $pdf->Cell(74,3,$cod_presup."   ".$cod_fuente,0,0); 
		   $pdf->Cell(18,3,$monto,0,0,'R');
		   
		   $pdf->Cell(18,3,$traslados,0,0,'R');
		   $pdf->Cell(18,3,$comprometido,0,0,'R');
		   $pdf->Cell(18,3,$causado,0,0,'R'); 
		   $pdf->Cell(18,3,$pagado,0,0,'R'); 
		   $pdf->Cell(18,3,$dispon,0,0,'R');  
		   $pdf->Cell(18,3,$deuda,0,1,'R'); 
		   
		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=74; 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);  		   

		} $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6); $total7=formato_monto($total7); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(74,2,'',0,0);
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(18,2,'============',0,1,'R');
		$pdf->Cell(74,5,'Total : ',0,0,'R');
		$pdf->Cell(18,5,$total1,0,0,'R'); 
		$pdf->Cell(18,5,$total7,0,0,'R'); 
		$pdf->Cell(18,5,$total2,0,0,'R'); 
		$pdf->Cell(18,5,$total3,0,0,'R'); 
		$pdf->Cell(18,5,$total4,0,0,'R'); 
		$pdf->Cell(18,5,$total5,0,0,'R'); 
		$pdf->Cell(18,5,$total6,0,1,'R'); 		 
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_ejecucion_credito_adicional.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
            	<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>EJECUCION DE CREDITO ADICIONAL</strong></font></td>
	    </tr>
		  <tr height="20">
		    <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	          </tr>
         <tr height="20">
           <td width="400" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Monto Credito</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Comprometido</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Causado</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Pagado</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Disponible</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Deuda</strong></font></td>
         </tr>
         <tr height="20">
           <td width="400" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Denominacion</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong></strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong></strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong></strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong></strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong></strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong></strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"]; $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
                   $denominacion=$registro["denominacion"]; $dispon=$monto-$comprometido; $deuda=$causado-$pagado;
		   $total1=$total1+$monto; $total2=$total2+$comprometido; $total3=$total3+$causado; $total4=$total4+$pagado; $total5=$total5+$monto-$comprometido; $total6=$total6+$causado-$pagado;
		   $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $causado=formato_monto($causado); $pagado=formato_monto($pagado);
		   $denominacion=conv_cadenas($denominacion,0);  $dispon=formato_monto($dispon); $deuda=formato_monto($deuda);
	?>	   
        <tr>
           <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $cod_presup."   ".$cod_fuente; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="100" align="right"><? echo $comprometido; ?></td>
           <td width="100" align="right"><? echo $causado; ?></td>
           <td width="100" align="right"><? echo $pagado; ?></td>
           <td width="100" align="right"><? echo $dispon; ?></td>
           <td width="100" align="right"><? echo $deuda; ?></td>
         </tr>
        <tr>
           <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $denominacion; ?></td>
         </tr>
	<? } $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6); 
        ?>
		<tr> <td>&nbsp;</td>
	   <tr>
		<td width="400" align="right"><strong>TOTAL :</strong></td>
		<td width="100" align="right"><strong><? echo $total1; ?></strong></td>
		<td width="100" align="right"><strong><? echo $total2; ?></strong></td>
		<td width="100" align="right"><strong><? echo $total3; ?></strong></td>
		<td width="100" align="right"><strong><? echo $total4; ?></strong></td>
		<td width="100" align="right"><strong><? echo $total5; ?></strong></font></td>
		<td width="100" align="right"><strong><? echo $total6; ?></strong></font></td>
      </tr>
  
	  </table><?
	}

   }
?>
