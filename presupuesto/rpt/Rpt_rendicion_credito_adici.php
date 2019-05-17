<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$ref_credito=$_GET["ref_credito"]; $cod_presupd=$_GET["cod_presupd"]; $cod_presuph=$_GET["cod_presuph"];$fuente_d=$_GET["fuente_d"];  $fuente_h=$_GET["fuente_h"]; $fecha_d=$_GET["fecha_d"];  $fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"]; $subt_cod=$_GET["subt_cod"];
$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $cod_fuented=$fuente_d; $cod_fuenteh=$fuente_h; $criterio1=""; $criterio2="";  $php_os=PHP_OS; 
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
else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";} } 
  $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $Rif_Emp=$registro["campo007"]; $criterio3=$registro["campo005"]; }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;  $buscaf_ant="N"; $monto_cred=0;  
  $sql="select * from pre009 where (referencia_modif='$ref_credito') and (tipo_modif = '1')";  $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
  if($filas>0){$registro=pg_fetch_array($resultado); $fecha_d=$registro["fecha_modif"];  $fecha_d=formato_ddmmaaaa($fecha_d);  }
  $sql="select sum(monto) as total_cred from pre039 where (referencia_modif='$ref_credito') and (tipo_modif = '1')"; $resultado=pg_query($sql); 
  if ($registro=pg_fetch_array($resultado,0)){$monto_cred=$registro["total_cred"]; }  $monto_cred=formato_monto($monto_cred);  
  $criterio1="Rendicion del Credito Adicional Decreto Numero ".$ref_credito;   $criterio2="Monto Bs. ".$monto_cred;  
  $cod_mov="pre012".$usuario_sia; $sfechad=formato_aaaammdd($fecha_d); $sfechah=formato_aaaammdd($fecha_h);
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
   $res=pg_exec($conn,"SELECT ACTUALIZA_REND_CREDITO('E','$cod_mov','A','$ref_credito','$sfechad','$sfechah')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
    $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'A' as Tipo_Registro, cod_presup, cod_fuente, denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
    $StrSQL=$StrSQL."asignado,disponible,disp_diferida,0 as compromiso,0 as causado, 0 as pagado, 0 as traslados, 0 as trasladon, 0 as adicion, 0 as disminucion, 0 as Diferido,0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
    $StrSQL=$StrSQL." FROM pre001 WHERE (length(cod_presup)=".$l_c.") and (text(cod_presup)||text(cod_fuente) in (select text(cod_presup)||text(fuente_financ) from pre039 where pre039.referencia_modif='$ref_credito') ) and ".$criterio;  
    $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT ACTUALIZA_REND_CREDITO('M','$cod_mov','A','$ref_credito','$sfechad','$sfechah')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $ordenado="ORDER BY PRE012.Fecha_Doc, PRE012.Tipo_Registro, PRE012.Referencia_Doc";
	if($subt_cod=="S"){$ordenado="ORDER BY PRE012.Cod_Presup, PRE012.Fecha_Doc, PRE012.Tipo_Registro, PRE012.Referencia_Doc";}
    $sSQL = "SELECT PRE012.Nombre_Usuario, PRE012.Status, PRE012.Cod_Presup, PRE012.Denominacion, PRE012.Tipo_Registro, PRE012.Fecha_Doc, PRE012.Referencia_Doc, PRE012.Tipo_Doc, PRE012.Nombre_Abrev_Doc, PRE012.Referencia_Comp, PRE012.Tipo_Comp, PRE012.Referencia_Caus, PRE012.Tipo_Caus, PRE012.Referencia_Pago, PRE012.Tipo_Pago, PRE012.Descripcion_Doc, PRE012.Ced_Rif, PRE012.Afecta, PRE012.Monto, PRE099.Nombre, PRE012.Comprometido, PRE012.Causado, PRE012.Pagado, PRE012.Traslados, PRE012.Adicion, PRE012.Ajuste_Comp, PRE012.Ajuste_Caus, PRE012.Ajuste_Pago  
	        FROM  PRE012, PRE099  WHERE  PRE012.Ced_Rif = PRE099.Ced_Rif and (pre012.tipo_registro='A') and (pre012.nombre_Usuario='$cod_mov') ".$ordenado;
	  
	if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php"); 
	      $nomb_rpt="Rpt_rendicion_credito_adicional.xml"; if($subt_cod=="S"){ $nomb_rpt="Rpt_rendicion_credito_adic_codigo.xml"; }
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
   if($tipo_rep=="PDF"){ $res=pg_query($sSQL); $cod_presup_grupo=""; $prev_y=0; $fin=0;
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $criterio2; global $tam_logo;  global $criterio3;  global $registro; global $prev_y;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Ln(5);
			$this->SetFont('Arial','B',10);
			$this->Cell(200,5,$criterio3,0,1,'C');	
			$this->Cell(200,5,$criterio1,0,1,'C');	
			$this->Cell(200,5,$criterio2,0,1,'C');	
			$this->SetFillColor(192,192,192);
			$this->SetFont('Arial','B',7);			
			$this->Cell(20,4,'NUMERO DE','RLT',0,'C',true);
			$this->Cell(17,4,'NRO ORDEN ','LT',0,'C',true);
			$this->Cell(63,4,'','LT',0,'C',true);
			$this->Cell(80,4,'','LT',0,'C',true);
			$this->Cell(20,4,'','RLT',1,'C',true);
			$this->Cell(20,4,'CHEQUE O CTA','LB',0,'C',true);
			$this->Cell(17,4,'DE PAGO','LB',0,'C',true);
			$this->Cell(63,4,'BENEFICIARIO','LB',0,'C',true);
			$this->Cell(80,4,'CONCEPTO','LB',0,'C',true);
			$this->Cell(20,4,'MONTO','RLB',1,'C',true);			
			$prev_y=$this->GetY();
		}
		function Footer(){global $fin;   global $prev_y; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 		    
			$this->SetY(-10);
			if ($fin==0){
			$y=$this->GetY(); $y=$y-8; $this->Line(10,$y,210,$y);
			$this->Line(10,$prev_y,10,$y);
			$this->Line(30,$prev_y,30,$y);
			$this->Line(47,$prev_y,47,$y);
			$this->Line(110,$prev_y,110,$y);
			$this->Line(190,$prev_y,190,$y);
		    $this->Line(210,$prev_y,210,$y);
			}
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total_monto=0; $sub_total_monto=0; $prev_cod_presup=""; 
		  while($registro=pg_fetch_array($res)){  $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion);}$cod_presup_grupo=$cod_presup; $denominacion_grupo=$denominacion;
		    if(($prev_cod_presup<>$cod_presup_grupo)and($subt_cod=="S")){ $pdf->SetFont('Arial','B',7);
			   if(($sub_total_monto<>0)or ($i>0)){ $sub_total_monto=formato_monto($sub_total_monto); 
			     $pdf->Ln(1);	$y=$pdf->GetY(); if ($y<=257){$y=$y-0.5; $pdf->Line(10,$y,210,$y);}
			  	 $pdf->Cell(180,4,'SUB-TOTAL : '.$prev_cod_presup.' ',0,0,'R');
				 $pdf->Cell(20,4,$sub_total_monto,0,1,'R');
				 $pdf->Ln(1);	$y=$pdf->GetY(); if ($y<=254){$y=$y-0.5;  $pdf->Line(10,$y,210,$y);}
			   }	$temp_den=substr($denominacion_grupo,0,50);
               $pdf->Cell(37,3,"",0,0,'C'); 			   
			   $pdf->Cell(63,5,$cod_presup_grupo,0,0,'L'); 
			   $pdf->Cell(80,5,$temp_den,0,1,'L'); 
			   $i=$i+1; 
			   $prev_cod_presup=$cod_presup_grupo; $sub_total_monto=0; 
			}
		   $referencia_doc=$registro["referencia_doc"]; $referencia_caus=$registro["referencia_caus"]; $nombre=$registro["nombre"]; $descripcion_doc=$registro["descripcion_doc"]; 			   $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; 
		   $total_monto=$total_monto+$monto; $sub_total_monto=$sub_total_monto+$monto;
		   $monto=formato_monto($monto); $h=3; $long=strlen($descripcion_doc);
		   $n=$long/$h;$y=$pdf->GetY();	       
		   if (($i>0)and($y<=257)){  $pdf->Ln(1);
		   $y=$pdf->GetY(); $y=$y-0.5; $pdf->Line(10,$y,210,$y);	 }		   
		   if($y>=253){ $nombre=substr($nombre,0,38);}
		   $pdf->SetFont('Arial','',7); 
		   $pdf->Cell(20,3,$referencia_doc,0,0,'C'); 
		   $pdf->Cell(17,3,$referencia_caus,0,0,'C'); 
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=63; $w=80;		   
		   $pdf->SetXY($x+$w+$n,$y);		   
		   $pdf->Cell(20,3,$monto,0,1,'R'); 		   
		   if(strlen(trim($descripcion_doc))>strlen(trim($nombre))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$descripcion_doc,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$descripcion_doc,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0); 
		   } 
			$i=$i+1; 	
		  } $total_monto=formato_monto($total_monto); 
		  $pdf->SetFont('Arial','B',7);  $fin=1;
		  $y=$pdf->GetY();
		  $pdf->Line(10,$prev_y,10,$y);
		  $pdf->Line(30,$prev_y,30,$y);
		  $pdf->Line(47,$prev_y,47,$y);
		  $pdf->Line(110,$prev_y,110,$y);
		  $pdf->Line(190,$prev_y,190,$y);
		  $pdf->Line(210,$prev_y,210,$y);
		  if(($subt_cod=="S")){  $sub_total_monto=formato_monto($sub_total_monto);
				$pdf->Cell(180,4,'SUB-TOTAL : '.$prev_cod_presup.' ',1,0,'R');
				$pdf->Cell(20,4,$sub_total_monto,1,1,'R');}
		  $pdf->SetFont('Arial','B',7);
		  $pdf->Cell(180,5,'TOTAL GENERAL ',1,0,'R');
		  $pdf->Cell(20,5,$total_monto,1,1,'R');
		  $pdf->Output();  
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_rendicion_credito_adicional.xls");		
	?>
       <table border="1" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		  <td width="100" align="left" ><strong></strong></td>
		  <td width="100" align="left" ><strong></strong></td>
          <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio3; ?></strong></font></td>
	    </tr>
	    <tr height="20">
		  <td width="100" align="left" ><strong></strong></td>
		  <td width="100" align="left" ><strong></strong></td>
		  <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	    </tr>
		<tr height="20">
		  <td width="100" align="left" ><strong></strong></td>
		  <td width="100" align="left" ><strong></strong></td>
		  <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio2; ?></strong></font></td>
	    </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Nro Cheque o Cta</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Nro Orden Pago</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF" ><strong>Concepto</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
         </tr>
         <?  $i=0; $total_monto=0; $sub_total_monto=0; $prev_cod_presup=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"];  $cod_presup_grupo=$cod_presup; $denominacion_grupo=$denominacion;
			  if(($prev_cod_presup<>$cod_presup_grupo)and($subt_cod=="S")){
			    if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);?>	 
				    <tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="500" align="right">SUB-TOTAL : <strong><? echo $prev_cod_presup; ?></strong></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>	
			        <tr>
				        <td width="100" align="left"></td>
			        </tr>	
                  <?} ?>	   
			      <tr>
				   <td width="100" align="left"></td>
				   <td width="100" align="left"></td>
				   <td width="400" align="left"><? echo $cod_presup_grupo; ?></td>
				   <td width="500" align="left"><? echo $denominacion_grupo; ?></td>
			      </tr>
			      <tr>
				    <td width="100" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_cod_presup=$cod_presup_grupo; $sub_total_monto=0; }

			   $referencia_doc=$registro["referencia_doc"]; $referencia_caus=$registro["referencia_caus"]; $nombre=$registro["nombre"]; $descripcion_doc=$registro["descripcion_doc"]; 			   $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; 
			   $total_monto=$total_monto+$monto; $sub_total_monto=$sub_total_monto+$monto;
			   $monto=formato_monto($monto);	  $nombre=conv_cadenas($nombre,0);  $descripcion_doc=conv_cadenas($descripcion_doc,0); 
			    ?>	   
        		<tr>
           			<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $referencia_doc; ?></td>
           			<td width="100" align="left">'<? echo $referencia_caus; ?></td>
           			<td width="400" align="justify"><? echo $nombre; ?></td>
           			<td width="500" align="justify"><? echo $descripcion_doc; ?></td>
           			<td width="100" align="right"><? echo $monto; ?></td>
         		</tr>
	<?      } $total_monto=formato_monto($total_monto); 
			    if(($sub_total_monto>0)and($subt_cod=="S")){ $sub_total_monto=formato_monto($sub_total_monto);  		
			     ?>	 				 
					<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="500" align="right"><strong>SUB-TOTAL : <? echo $prev_cod_presup; ?></strong></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>			
			        <tr>
				        <td width="100" align="left"></td>
			        </tr>	
                <?}	?>	 	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="500" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?
        }
}		  
?>
