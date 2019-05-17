<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");    include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];
$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"];  $tipo_rep=$_GET["tipo_rep"]; } 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";  $c_apli="T";  $tipo_rep="PDF";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="Epre020".$usuario_sia; $php_os=PHP_OS;
$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1; } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;    $criterio2="";  
   
   $tfechah="01/".$mes_hasta."/".$mano; $tfechah=colocar_udiames($tfechah); $criterio1=" AL: ".$tfechah;
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $cant_cat=3; $cant_par=4;
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"]; $cant_cat=$registro["campo550"]; $cant_par=$registro["campo551"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;  $criterio_s="";  $codigo_d=$cod_presup_d; $codigo_h=$cod_presup_h;
   
  
  
  
  
  $cat_desde=substr($cod_presup_d,0,$c); $cat_hasta=substr($cod_presup_h,0,$c); $criterio_s="";
  if($cat_desde==$cat_hasta){
    $sql="SELECT denominacion from pre001 where cod_presup='$cat_desde'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cat_desde." ".$registro["denominacion"]; }
  }
  
  $pos=strrpos($cod_presup_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presup_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presup_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presup_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; $a=$mcontrol[$i-1]; 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
   }else{$criterio="cod_presup>='".$cod_presup_d."' and cod_presup<='".$cod_presup_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
   
  $criterio2=" CODIGO DESDE : ".$codigo_d."   -  HASTA: ".$codigo_h; 
  
  $per_hasta=$mes_hasta;
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido="";
  $sql_TrasladosM=""; $sql_TrasladonM=""; $sql_AdicionM=""; $sql_DisminucionM=""; 
  $sql_compromisom=""; $sql_DiferidoM=""; $sql_causadom=""; $sql_pagadom=""; $sql_Disp_Diferida="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; 
	 $sql_TrasladosM="0 as TrasladosM,";  $sql_TrasladonM="0 as TrasladonM,";  $sql_AdicionM="0 as adicionM,";
     $sql_DisminucionM="0 as DisminucionM,"; $sql_compromisom="0 as compromisom,"; $sql_causadom="0 as causadom,";
     $sql_pagadom="0 as pagadom,"; $sql_DiferidoM="0 as DiferidoM"; $sql_Disp_Diferida="0 as disp_diferida,";	 
	 }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(Compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")";}
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(Compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 	
      $sql_Compromiso=$sql_Compromiso.$scampo4;$sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;	  
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Diferido=$sql_Diferido.") as Diferido";	
	
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(Compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")"; }
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(Compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}	
	  $sql_TrasladosM=$sql_TrasladosM.$scampo;  $sql_TrasladonM=$sql_TrasladonM.$scampo1; $sql_AdicionM=$sql_AdicionM.$scampo2; $sql_DisminucionM=$sql_DisminucionM.$scampo3;  
      $sql_compromisom=$sql_compromisom.$scampo4;$sql_causadom=$sql_causadom.$scampo5; $sql_pagadom=$sql_pagadom.$scampo6; $sql_DiferidoM=$sql_DiferidoM.$scampo7;
	}  
    $sql_TrasladosM=$sql_TrasladosM.") as TrasladosM,"; $sql_TrasladonM=$sql_TrasladonM.") as TrasladonM,";
    $sql_AdicionM=$sql_AdicionM.") as adicionM,"; $sql_DisminucionM=$sql_DisminucionM.") as DisminucionM,";
    $sql_compromisom=$sql_compromisom.") as compromisom,"; $sql_causadom=$sql_causadom.") as causadom,";
    $sql_pagadom=$sql_pagadom.") as pagadom,";   $sql_DiferidoM=$sql_DiferidoM.") as DiferidoM";	
   }   
   $sql_Asignacion="sum(asignado),";   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  $sql_codigo="substr(cod_presup,".$ini.",".$p."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$p."),cod_fuente";
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.",'','','','','','A','F','O','T','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;    //echo $StrSQL,"<br>";  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  /*  */
  for ($i=1; $i<=$cant_par-3; $i++) { $pa=$cant_cat+$i-1;
     $m=$mcontrol[$pa]-$ls-1; 
	 $sql_codigo="substr(cod_presup,".$ini.",".$m."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$m."),cod_fuente";
	 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m."),'00'"; $sql_grupo="substr(cod_presup,".$ini.",".$m.")";}	 
     $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
     $StrSQL=$StrSQL.$sql_Asignacion."sum(disponible),sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as compromisoM,0 as causadoM, 0 as pagadoM, 0 as trasladosM, 0 as trasladonM, 0 as adicionM, 0 as disminucionM, 0 as diferidoM ";
     $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio.$criterioc." group by ".$sql_grupo;
     //echo $StrSQL,"<br>";
	 $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
     $sl=$mcontrol[$pa];
	 $sql_codigo="substr(cod_presup,".$ini.",".$m.") as cod_partida,cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";
	 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m.") as cod_partida,'00' as cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";}
	 $sql="SELECT ".$sql_codigo." FROM PRE001 WHERE length(cod_presup)=".$sl. "  group by ".$sql_grupo; $res=pg_query($sql);
	 while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_partida"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
	    $StrSQL="UPDATE PRE020 SET denominacion='".$denominacion."',cod_partida='".$cod_presup."',denomina_par='".$denominacion."' Where cod_presup='".$cod_presup."' and cod_fuente='".$cod_fuente."'"; $resg=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn);
	 }      
   }
   
  $ordenar=" ORDER BY pre020.cod_partida"; 
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion',denominacion='$denominacion',cod_partida=cod_presup where tipo_registro='M' and nombre_usuario='$cod_mov' and cod_presup='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }  
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.compromisom, pre020.causadom, pre020.pagadom, pre020.diferidom,
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;
			 
	if(($tipo_rep=="PDFL")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $criterio2; global $criterio_s; global $tam_logo; global $Nom_Emp;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(240,10,'EJECUCION FINANCIERA DEL PRESUPUESTO DE GASTOS',0,0,'C');
			$this->SetFont('Arial','',7);
			$this->Cell(50,10,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(240,5,$criterio1,0,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',9);
			$this->Cell(300,5,$criterio2,0,1);
			if ($criterio_s<>''){
			   $this->Cell(200,5,$criterio_s,0,1);
			}
			$this->Ln(3);
			$this->Cell(340,5,'2. ORGANISMO/DEPENDENCIA: '.$Nom_Emp,1,1);
			 
			$y=$this->GetY();	$x=$this->GetX();
		    $this->rect(10,$y,340,204-$y);		   
		    $this->SetFont('Arial','',6);
            $this->Cell(8,3,'3.','TLR',0,'C');
			$this->Cell(8,3,'4.','TLR',0,'C');
			$this->Cell(8,3,'5.','TLR',0,'C');
			$this->Cell(8,3,'6.','TLR',0,'C');
			$this->Cell(8,3,'7.','TLR',0,'C');			
			$this->Cell(100,3,'','LR',0,'C');
			$this->Cell(20,3,'9. ASIGNACIÓN','LR',0,'C');
            $this->Cell(20,3,'10. AUMENTOS','LR',0,'C');
			$this->Cell(20,3,'11. DISMINU-','LR',0,'C');
			$this->Cell(20,3,'12. ASIGNACIÓN','LR',0,'C');
			$this->Cell(20,3,'13. COMPRO-','LR',0,'C');
			$this->Cell(20,3,'14. SALDO POR','LR',0,'C');
			$this->Cell(20,3,'15. MONTO','LR',0,'C');
			$this->Cell(20,3,'16. MONTO POR','LR',0,'C');
			$this->Cell(20,3,'17. MONTO','LR',0,'C');		
			$this->Cell(20,3,'18. MONTO POR','LR',1,'C');

            $this->SetFont('Arial','',6);
			$this->Cell(8,4,'PART.','LR',0,'C');
			$this->Cell(8,4,'GEN.','LR',0,'C');
			$this->Cell(8,4,'ESP.','LR',0,'C');
			$this->Cell(8,4,'S/ESP','LR',0,'C');
			$this->Cell(8,4,'SUB-1','LR',0,'C');			
			$this->Cell(100,4,'8. DENOMINACION','LR',0,'C');			
			$this->Cell(20,4,'ORIGINAL','LR',0,'C');
            $this->Cell(20,4,'','LR',0,'C');
			$this->Cell(20,4,'CIONES','LR',0,'C');
			$this->Cell(20,4,'MODIFICADA','LR',0,'C');
			$this->Cell(20,4,'MISOS','LR',0,'C');
			$this->Cell(20,4,'COMPROMETER','LR',0,'C');
			$this->Cell(20,4,'CAUSADO','LR',0,'C');
			$this->Cell(20,4,'CAUSAR','LR',0,'C');
			$this->Cell(20,4,'PAGADO','LR',0,'C');			
			$this->Cell(20,4,'PAGAR','LR',1,'C');
		   
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,340,$l);
           $this->Line(18,$y,18,198);
           $this->Line(26,$y,26,198);
           $this->Line(34,$y,34,198);
           $this->Line(42,$y,42,198);
		   $this->Line(50,$y,50,198);

		   
           $this->Line(150,$y,150,198);
		   
           $this->Line(170,$y,170,198); 
           $this->Line(190,$y,190,198); 
           $this->Line(210,$y,210,198); 
           $this->Line(230,$y,230,198);
           $this->Line(250,$y,250,198);		   
           $this->Line(270,$y,270,198);	
           $this->Line(290,$y,290,198);	 
           $this->Line(310,$y,310,198);
           $this->Line(330,$y,330,198);		   	
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totald; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);
			$stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); 			
			$this->SetY(-17);			
			$this->SetFont('Arial','B',7);	
			$this->Cell(40,5,'',0,0); 
			$this->Cell(100,5,'TOTALES',0,0,'C');
			$this->Cell(20,5,$stotalg,0,0,'R'); 
			$this->Cell(20,5,$stotalau,0,0,'R'); 
			$this->Cell(20,5,$stotaldi,0,0,'R'); 
			$this->Cell(20,5,$stotalf,0,0,'R');
			$this->Cell(20,5,$stotalc,0,0,'R');	
			$this->Cell(20,5,$stotald,0,0,'R'); 
			$this->Cell(20,5,$stotala,0,0,'R');
			$this->Cell(20,5,$stotaldc,0,0,'R');
			$this->Cell(20,5,$stotalp,0,0,'R');			
			$this->Cell(20,5,$stotaldp,0,1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Legal);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"];		
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==15){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;}
			
		if($asig_actualizada<>0){	
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		if(strlen($cod_partida)==15){ $mfue=$cod_fuente; if($mfue=="00"){ $mfue="PO";}else{$mfue="DEC";}  } else{ $mfue="N/A";}		
		if(strlen($cod_partida)<=9){$pdf->SetFont('Arial','BU',7);} else {$pdf->SetFont('Arial','',7);}
		$pdf->Cell(8,4,$mpart,0,0,'C');
		$pdf->Cell(8,4,$mgen,0,0,'C');
		$pdf->Cell(8,4,$mesp,0,0,'C');
		$pdf->Cell(8,4,$msub,0,0,'C');
		$pdf->Cell(8,4,$msub_e,0,0,'C');   		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(20,4,$asignado,0,0,'R');
        $pdf->Cell(20,4,$aumentos,0,0,'R');  		
		$pdf->Cell(20,4,$disminuciones,0,0,'R');
		$pdf->Cell(20,4,$asig_actualizada,0,0,'R');			
		$pdf->Cell(20,4,$comprometido,0,0,'R');
        $pdf->Cell(20,4,$dispon,0,0,'R');  		
		$pdf->Cell(20,4,$causado,0,0,'R');
		$pdf->Cell(20,4,$deudac,0,0,'R');	
		$pdf->Cell(20,4,$pagado,0,0,'R');
		$pdf->Cell(20,4,$deuda,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,4,$denomina_par,0);
		}
		
		
	}
	
	$pdf->Output(); 
  }
  
  if(($tipo_rep=="PDFC")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $criterio2; global $criterio_s; global $tam_logo; global $Nom_Emp;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(160,10,'EJECUCION FINANCIERA DEL PRESUPUESTO DE GASTOS',0,0,'C');
			$this->SetFont('Arial','',7);
			$this->Cell(50,10,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(160,5,$criterio1,0,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,5,$criterio2,0,1);
			if ($criterio_s<>''){
			   $this->Cell(200,5,$criterio_s,0,1);
			}
			$this->Ln(3);
			$this->Cell(260,5,'2. ORGANISMO/DEPENDENCIA: '.$Nom_Emp,1,1);			 
			$y=$this->GetY();	$x=$this->GetX();
		    $this->rect(10,$y,260,204-$y);		   
		    $this->SetFont('Arial','',5);
            $this->Cell(7,3,'3.','TLR',0,'C');
			$this->Cell(6,3,'4.','TLR',0,'C');
			$this->Cell(6,3,'5.','TLR',0,'C');
			$this->Cell(6,3,'6.','TLR',0,'C');
			$this->Cell(7,3,'7.','TLR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(78,3,'','LR',0,'C');
			$this->Cell(15,3,'9. ASIGNACIÓN','LR',0,'C');
            $this->Cell(15,3,'10. AUMENTOS','LR',0,'C');
			$this->Cell(15,3,'11. DISMINU-','LR',0,'C');
			$this->Cell(15,3,'12. ASIGNACIÓN','LR',0,'C');
			$this->Cell(15,3,'13. COMPRO-','LR',0,'C');
			$this->Cell(15,3,'14. SALDO POR','LR',0,'C');
			$this->Cell(15,3,'15. MONTO','LR',0,'C');
			$this->Cell(15,3,'16. MONTO POR','LR',0,'C');
			$this->Cell(15,3,'17. MONTO','LR',0,'C');		
			$this->Cell(15,3,'18. MONTO POR','LR',1,'C');

            $this->SetFont('Arial','',5);
			$this->Cell(7,4,'PART.','LR',0,'C');
			$this->Cell(6,4,'GEN.','LR',0,'C');
			$this->Cell(6,4,'ESP.','LR',0,'C');
			$this->Cell(6,4,'S/ESP','LR',0,'C');
			$this->Cell(7,4,'SUB-1','LR',0,'C');
			
			$this->Cell(78,4,'8. DENOMINACION','LR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(15,4,'ORIGINAL','LR',0,'C');
            $this->Cell(15,4,'','LR',0,'C');
			$this->Cell(15,4,'CIONES','LR',0,'C');
			$this->Cell(15,4,'MODIFICADA','LR',0,'C');
			$this->Cell(15,4,'MISOS','LR',0,'C');
			$this->Cell(15,4,'COMPROMETER','LR',0,'C');
			$this->Cell(15,4,'CAUSADO','LR',0,'C');
			$this->Cell(15,4,'CAUSAR','LR',0,'C');
			$this->Cell(15,4,'PAGADO','LR',0,'C');			
			$this->Cell(15,4,'PAGAR','LR',1,'C');
		   
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(17,$y,17,198);
           $this->Line(23,$y,23,198);
           $this->Line(29,$y,29,198);
           $this->Line(35,$y,35,198);
		   $this->Line(42,$y,42,198);		   
           $this->Line(120,$y,120,198);
           $this->Line(135,$y,135,198); 
           $this->Line(150,$y,150,198); 
           $this->Line(165,$y,165,198); 
           $this->Line(180,$y,180,198);
           $this->Line(195,$y,195,198);		   
           $this->Line(210,$y,210,198);	
           $this->Line(225,$y,225,198);	 
           $this->Line(240,$y,240,198);
           $this->Line(255,$y,255,198);		   	
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totald; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);
			$stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); 			
			$this->SetY(-17);			
			$this->SetFont('Arial','B',5);	
			$this->Cell(32,5,'',0,0); 
			$this->Cell(78,5,'TOTALES',0,0,'C');
			$this->Cell(15,5,$stotalg,0,0,'R'); 
			$this->Cell(15,5,$stotalau,0,0,'R'); 
			$this->Cell(15,5,$stotaldi,0,0,'R'); 
			$this->Cell(15,5,$stotalf,0,0,'R');
			$this->Cell(15,5,$stotalc,0,0,'R');	
			$this->Cell(15,5,$stotald,0,0,'R'); 
			$this->Cell(15,5,$stotala,0,0,'R');
			$this->Cell(15,5,$stotaldc,0,0,'R');
			$this->Cell(15,5,$stotalp,0,0,'R');			
			$this->Cell(15,5,$stotaldp,0,1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"];		
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==15){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;}
		
        if($asig_actualizada<>0){		
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		if(strlen($cod_partida)==15){ $mfue=$cod_fuente; if($mfue=="00"){ $mfue="PO";}else{$mfue="DEC";}  } else{ $mfue="N/A";}		
		if(strlen($cod_partida)<=9){$pdf->SetFont('Arial','BU',5);} else {$pdf->SetFont('Arial','',5);}
		$pdf->Cell(7,4,$mpart,0,0,'C');
		$pdf->Cell(6,4,$mgen,0,0,'C');
		$pdf->Cell(6,4,$mesp,0,0,'C');
		$pdf->Cell(7,4,$msub,0,0,'C');
		$pdf->Cell(6,4,$msub_e,0,0,'C');   		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=77; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(15,4,$asignado,0,0,'R');
        $pdf->Cell(15,4,$aumentos,0,0,'R');  		
		$pdf->Cell(15,4,$disminuciones,0,0,'R');
		$pdf->Cell(15,4,$asig_actualizada,0,0,'R');			
		$pdf->Cell(15,4,$comprometido,0,0,'R');
        $pdf->Cell(15,4,$dispon,0,0,'R');  		
		$pdf->Cell(15,4,$causado,0,0,'R');
		$pdf->Cell(15,4,$deudac,0,0,'R');	
		$pdf->Cell(15,4,$pagado,0,0,'R');
		$pdf->Cell(15,4,$deuda,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,4,$denomina_par,0);
		}
	}
	
	$pdf->Output(); 
  }
  
