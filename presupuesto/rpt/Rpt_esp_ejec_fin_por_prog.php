<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$timestre=$_GET["timestre"];$cod_cat=$_GET["cod_cat"];$cod_part=$_GET["cod_part"]; $tipo_rep=$_GET["tipo_rep"]; } 
else { $timestre="01"; $cod_cat=""; $cod_part=""; $tipo_rep="PDF"; }  $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE";
$asig_global="S"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Mpre020".$usuario_sia; $php_os=PHP_OS;
$cod_fuente_d=""; $cod_fuente_h="zz";
if($timestre=="01"){ $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I TRIMESTRE"; }
if($timestre=="02"){ $mes_desde="04"; $mes_hasta="06"; $mdes_trim="II TRIMESTRE";}
if($timestre=="03"){ $mes_desde="07"; $mes_hasta="09"; $mdes_trim="III TRIMESTRE";}
if($timestre=="04"){ $mes_desde="10"; $mes_hasta="12"; $mdes_trim="IV TRIMESTRE";}
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
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="EJECUCION FINANCIERA DEL ".$mdes_trim." DEL AÑO ".$mano;    $criterio2="";
   
    
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $cant_cat=3; $cant_par=4;
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"]; $cant_cat=$registro["campo550"]; $cant_par=$registro["campo551"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;  $criterio_s=""; $long_part=$p;
   $cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);  
   $msector=""; $den_sector=""; $mprograma=""; $msub_programa=""; $muni_ejec=""; 
   
  
    $sql="SELECT denominacion from pre001 where cod_presup='$cod_cat'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cod_cat." ".$registro["denominacion"]; }
  
	$cod_presup_d=$cod_cat.$cod_part; $cod_presup_h=$cod_cat.$cod_part;
	
	
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
   
  $per_hasta=$mes_hasta; $per_desde=$mes_desde;
  $sql_Asignacion=""; $sql_traslados=""; $sql_trasladon=""; $sql_adicion=""; $sql_disminucion=""; $sql_deudat="";
  $sql_compromiso=""; $sql_diferido=""; $sql_causado=""; $sql_pagado=""; $sql_diferido="";
  $sql_trasladosM=""; $sql_trasladonM=""; $sql_adicionM=""; $sql_disminucionM=""; 
  $sql_compromisom=""; $sql_diferidoM=""; $sql_causadom=""; $sql_pagadom=""; $sql_Disp_Diferida="";
  if($per_desde==1){ $sql_deudat=" 0 as deudat"; }
  If($per_hasta==0){ $sql_traslados="0 as traslados,";  $sql_trasladon="0 as trasladon,";  $sql_adicion="0 as adicion,";
     $sql_disminucion="0 as disminucion,"; $sql_compromiso="0 as compromiso,"; $sql_causado="0 as causado,";
     $sql_pagado="0 as pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_diferido="0 as diferido"; 
	 $sql_trasladosM="0 as trasladosM,";  $sql_trasladonM="0 as trasladonM,";  $sql_adicionM="0 as adicionM,";
     $sql_disminucionM="0 as disminucionM,"; $sql_compromisom="0 as compromisom,"; $sql_causadom="0 as causadom,";
     $sql_pagadom="0 as pagadom,"; $sql_diferidoM="0 as diferidoM"; $sql_Disp_Diferida="0 as disp_diferida,";	 
	 }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(traslados".$pos.")";  $scampo1 = "(sum(trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(compromiso".$pos.")";  $scampo5 = "(sum(causado".$pos.")";
           $scampo6 = "(sum(pagado".$pos.")"; $scampo8 = "(sum(diferido".$pos.")";}
       else{$scampo = "+sum(traslados".$pos.")" ; $scampo1 = "+sum(trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(compromiso".$pos.")";$scampo5 = "+sum(causado".$pos.")";
           $scampo6 = "+sum(pagado".$pos.")";  $scampo8 = "+sum(diferido".$pos.")";}
      $sql_traslados=$sql_traslados.$scampo;  $sql_trasladon=$sql_trasladon.$scampo1; $sql_adicion=$sql_adicion.$scampo2;
      $sql_disminucion=$sql_disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 	
      $sql_compromiso=$sql_compromiso.$scampo4;$sql_causado=$sql_causado.$scampo5; $sql_pagado=$sql_pagado.$scampo6;$sql_diferido=$sql_diferido.$scampo8;	  
	} 
    $sql_traslados=$sql_traslados.") as traslados,"; $sql_trasladon=$sql_trasladon.") as trasladon,";
    $sql_adicion=$sql_adicion.") as adicion,"; $sql_disminucion=$sql_disminucion.") as disminucion,";
    $sql_compromiso=$sql_compromiso.") as compromiso,"; $sql_causado=$sql_causado.") as causado,";
    $sql_pagado=$sql_pagado.") as pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_diferido=$sql_diferido.") as diferido";	
	
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo = "(sum(traslados".$pos.")";  $scampo1 = "(sum(trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(compromiso".$pos.")";  $scampo5 = "(sum(causado".$pos.")";
           $scampo6 = "(sum(pagado".$pos.")"; $scampo8 = "(sum(diferido".$pos.")"; }
       else{$scampo = "+sum(traslados".$pos.")" ; $scampo1 = "+sum(trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(compromiso".$pos.")";$scampo5 = "+sum(causado".$pos.")";
           $scampo6 = "+sum(pagado".$pos.")";  $scampo8 = "+sum(diferido".$pos.")";}	
	  $sql_trasladosM=$sql_trasladosM.$scampo;  $sql_trasladonM=$sql_trasladonM.$scampo1; $sql_adicionM=$sql_adicionM.$scampo2; $sql_disminucionM=$sql_disminucionM.$scampo3;  
      $sql_compromisom=$sql_compromisom.$scampo4;$sql_causadom=$sql_causadom.$scampo5; $sql_pagadom=$sql_pagadom.$scampo6; $sql_diferidoM=$sql_diferidoM.$scampo7;
	}  
	
    $sql_trasladosM=$sql_trasladosM.") as trasladosM,"; $sql_trasladonM=$sql_trasladonM.") as trasladonM,";
    $sql_adicionM=$sql_adicionM.") as adicionM,"; $sql_disminucionM=$sql_disminucionM.") as disminucionM,";
    $sql_compromisom=$sql_compromisom.") as compromisom,"; $sql_causadom=$sql_causadom.") as causadom,";
    $sql_pagadom=$sql_pagadom.") as pagadom,";   $sql_diferidoM=$sql_diferidoM.") as diferidoM";	
   }   
   $sql_Asignacion="sum(asignado),";   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  $sql_codigo="substr(cod_presup,".$ini.",".$p."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$p."),cod_fuente";
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.",'','','','','','A','F','O','T','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_compromiso.$sql_causado.$sql_pagado.$sql_traslados.$sql_trasladon.$sql_adicion.$sql_disminucion.$sql_diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_trasladosM.$sql_trasladonM.$sql_adicionM.$sql_disminucionM.$sql_diferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;    //echo $StrSQL,"<br>";  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  /*  */
  for ($i=1; $i<=$cant_par-2; $i++) { $pa=$cant_cat+$i-1;
     $m=$mcontrol[$pa]-$ls-1; 
	 $sql_codigo="substr(cod_presup,".$ini.",".$m."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$m."),cod_fuente";
	 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m."),'00'"; $sql_grupo="substr(cod_presup,".$ini.",".$m.")";}	 
     $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
     $StrSQL=$StrSQL.$sql_Asignacion."sum(disponible),sum(disp_diferida),".$sql_compromiso.$sql_causado.$sql_pagado.$sql_traslados.$sql_trasladon.$sql_adicion.$sql_disminucion.$sql_diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_trasladosM.$sql_trasladonM.$sql_adicionM.$sql_disminucionM.$sql_diferidoM;
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
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.traslados, pre020.trasladon, pre020.adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.compromisom, pre020.causadom, pre020.pagadom, pre020.diferidom,
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.traslados+pre020.adicion) AS Aumentos, (pre020.trasladon+pre020.disminucion) AS disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion-pre020.compromiso) AS Disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;
			 
  if($tipo_rep=="PDF"){		 
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; global $criterio1; global $criterio_s; global $Nom_Emp;   
		   $ffechar=date("d-m-Y");
		   
		   
		   $this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->Cell(50);
			$this->SetFont('Arial','B',10);
			$this->Cell(160,5,$criterio1,0,1,'C');
			$this->Cell(50);
			$this->Cell(160,5,$Nom_Emp,0,1,'C');
			if ($criterio_s<>''){
			   $this->Cell(50);	
			   $this->Cell(150,5,$criterio_s,0,1,'C');
			}
			$this->Ln(5);
			$x=$this->GetX();   $y=$this->GetY();
			$this->rect(10,$y,260,175);
            $this->SetFillColor(192,192,192);
            $this->SetFont('Arial','B',5.5);					
			$this->Cell(15,5,'CODIGO',1,0,'C',true);
			$this->Cell(50,5,'DENOMINACION',1,0,'C',true);
			$this->Cell(15,5,'ASIGNADO',1,0,'C',true);
			$this->Cell(15,5,'CREDITOS',1,0,'C',true);
			$this->Cell(15,5,'REDUCCION',1,0,'C',true);
			$this->Cell(15,5,'TRAS_AUM',1,0,'C',true);
			$this->Cell(15,5,'TRAS_DIS',1,0,'C',true);			
			$this->Cell(15,5,'ACTUAL',1,0,'C',true);
			$this->Cell(15,5,'COMPROMETIDO',1,0,'L',true);
			$this->Cell(15,5,'CAUSADO',1,0,'L',true);
			$this->Cell(15,5,'PAGADO',1,0,'L',true);
			$this->Cell(15,5,'SALDO COMP',1,0,'L',true);
			$this->Cell(15,5,'SALDO PAG',1,0,'L',true);
			$this->Cell(15,5,'P.PAGAR.T.ANT',1,0,'L',true);
            $this->Cell(15,5,'POR PAGAR A.',1,1,'L',true);
            $x=$this->GetX();   $y=$this->GetY();
		
            $this->Line(25,$y,25,205); 
            $this->Line(75,$y,75,205); 
			$this->Line(90,$y,90,205); 
			$this->Line(105,$y,105,205); 
			$this->Line(120,$y,120,205); 
			$this->Line(135,$y,135,205); 
			
            $this->Line(150,$y,150,205); 
            $this->Line(165,$y,165,205);
            $this->Line(180,$y,180,205);
			$this->Line(195,$y,195,205);
            $this->Line(210,$y,210,205);
            $this->Line(225,$y,225,205); 
            $this->Line(240,$y,240,205);
            $this->Line(255,$y,255,205); 			
/*				
*/			
			
		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totald; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp; global $totalt; global $totaltn; global $totaldt; global $totaldat;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi); $stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); 
            $stotalt=formato_monto($totalt);  $stotaltn=formato_monto($totaltn); $stotaldt=formato_monto($totaldt); $stotaldat=formato_monto($totaldat);	
			$this->SetY(-17);			
			$this->SetFont('Arial','B',5);	
			$this->Cell(15,5,'','T',0); 
			$this->Cell(50,5,'TOTALES','T',0,'C');
			$this->Cell(15,5,$stotalg,'T',0,'R'); 
			$this->Cell(15,5,$stotalau,'T',0,'R'); 
			$this->Cell(15,5,$stotaldi,'T',0,'R');
            $this->Cell(15,5,$stotalt,'T',0,'R'); 
			$this->Cell(15,5,$stotaltn,'T',0,'R');
			$this->Cell(15,5,$stotalf,'T',0,'R');
			$this->Cell(15,5,$stotalc,'T',0,'R');	
			$this->Cell(15,5,$stotala,'T',0,'R');
			$this->Cell(15,5,$stotalp,'T',0,'R');	
			$this->Cell(15,5,$stotald,'T',0,'R');
			$this->Cell(15,5,$stotaldt,'T',0,'R');
			$this->Cell(15,5,$stotaldat,'T',0,'R');
			$this->Cell(15,5,$stotaldp,'T',1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totalt=0; $totaltn=0; $totaldc=0; $totaldp=0; $totaldt=0; $totaldat=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
		$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];
        $adicion=$registro["adicion"]; $disminucion=$registro["disminucion"]; $traslados=$registro["traslados"]; $trasladon=$registro["trasladon"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"]; $deudat=$registro["causadom"]-$registro["pagadom"];	$deudaat=$deuda-$deudat;	
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==$long_part){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$adicion; $totaldi=$totaldi+$disminucion;
		$totalt=$totalt+$traslados; $totaltn=$totaltn+$trasladon; $totaldt=$totaldt+$deudat; $totaldat=$totaldat+$deudaat;	}
		
		
		$porc1=0; if($asig_act_per>0){ $porc1=($causadom*100)/$asig_act_per;  }		$porc2=0; if($asig_act_per>0){ $porc2=($pagadom*100)/$asig_act_per;  }		
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);		
		$adicion=formato_monto($adicion);  $disminucion=formato_monto($disminucion); $traslados=formato_monto($traslados);  $trasladon=formato_monto($trasladon);
		$deudat=formato_monto($deudat); $deudaat=formato_monto($deudaat);
		
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		if(strlen($cod_partida)==$long_part){ $mfue=$cod_fuente;  } else{ $mfue="N/A";}		
		if(strlen($cod_partida)<=9){$pdf->SetFont('Arial','BU',5);} else {$pdf->SetFont('Arial','',5);}
		$pdf->Cell(15,3,$mpartida,0,0,'C');	   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=50; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(15,3,$asignado,0,0,'R');
        $pdf->Cell(15,3,$adicion,0,0,'R');  		
		$pdf->Cell(15,3,$disminucion,0,0,'R');
		$pdf->Cell(15,3,$traslados,0,0,'R');  		
		$pdf->Cell(15,3,$trasladon,0,0,'R');
		$pdf->Cell(15,3,$asig_actualizada,0,0,'R');			
		$pdf->Cell(15,3,$comprometidom,0,0,'R');
        $pdf->Cell(15,3,$causadom,0,0,'R');  		
		$pdf->Cell(15,3,$pagadom,0,0,'R');
		$pdf->Cell(15,3,$dispon,0,0,'R');
		$pdf->Cell(15,3,$deudat,0,0,'R');
		$pdf->Cell(15,3,$deudaat,0,0,'R');
		$pdf->Cell(15,3,$deuda,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$denomina_par,0);
	}
	$pdf->Output(); 
  }
  
 
  if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejec_presup_finan_trim.xls");
		?>
	   <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $Nom_Emp; ?></strong></font></td>
		 </tr>
		 <tr height="20">
			<td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio_s; ?></strong></font></td>
		 </tr>
		 <tr>
			<td width="150" align="left"></td>
		 </tr>	
		 </table></td>
         </tr>
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
		 <tr height="40">
		   <td width="150" align="justify" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>POSICION FINANCIERA</strong></td>
		   <td width="500" align="center" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>ASIGNADO</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>CREDITOS</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>REDUCCION</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>TRAS_AUM</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>TRAS_DIS</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>ACTUAL</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>COMPROME</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>CAUSADO</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>PAGADO</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>SALDO_COM</strong></td> 	
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>SALDO_PAG</strong></td> 
           <td width="150" align="justify" bgcolor="#99CCFF" ><strong>POR PAGAR TRIM ANT.</strong></td> 		
           <td width="150" align="justify" bgcolor="#99CCFF" ><strong>POR PAGAR ACUMULADO</strong></td> 				   
		 </tr>
		
		<?
		$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totalt=0; $totaltn=0; $totaldc=0; $totaldp=0; $totaldt=0; $totaldat=0;
	    $res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ 
			$cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];
			$adicion=$registro["adicion"]; $disminucion=$registro["disminucion"]; $traslados=$registro["traslados"]; $trasladon=$registro["trasladon"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
			$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
			$deuda=$registro["causado"]-$registro["pagado"]; $deudat=$registro["causadom"]-$registro["pagadom"];	$deudaat=$deuda-$deudat;			
			/*
			$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
			$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
			$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
			$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
			*/	

			
			if(strlen($cod_partida)==$long_part){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
			$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
			$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$adicion; $totaldi=$totaldi+$disminucion;
			$totalt=$totalt+$traslados; $totaltn=$totaltn+$trasladon;	$totaldt=$totaldt+$deudat; $totaldat=$totaldat+$deudaat;  }
			$porc1=0; if($asig_act_per>0){ $porc1=($causadom*100)/$asig_act_per;  }		$porc2=0; if($asig_act_per>0){ $porc2=($pagadom*100)/$asig_act_per;  }		
			$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
			$asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
			$causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
			$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
			$porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
			$adicion=formato_monto($adicion);  $disminucion=formato_monto($disminucion); $traslados=formato_monto($traslados);  $trasladon=formato_monto($trasladon);
		    $deudat=formato_monto($deudat); $deudaat=formato_monto($deudaat);
			$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
			$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
			$mfue=$cod_fuente;
			if(strlen($cod_partida)==$long_part){ $mfue=$cod_fuente;  } else{ $mfue="N/A";}		
			$stilo1="mso-number-format:'@';";
			
			?>	   
			<tr>
			   <td width="150" align="center" style="<? echo $stilo1; ?>"><? echo $mpartida; ?></td>
			   <td width="500" align="justify"><? echo $denomina_par; ?></td>				   
			   <td width="150" align="right"><? echo $asignado; ?></td>
			   <td width="150" align="right"><? echo $adicion; ?></td>
			   <td width="150" align="right"><? echo $disminucion; ?></td>
			   <td width="150" align="right"><? echo $traslados; ?></td>
			   <td width="150" align="right"><? echo $trasladon; ?></td>
			   
			   <td width="150" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="150" align="right"><? echo $comprometidom; ?></td>
			   <td width="150" align="right"><? echo $causadom; ?></td>
			   <td width="150" align="right"><? echo $pagadom; ?></td>
			   
			   <td width="150" align="right"><? echo $dispon; ?></td>
			   <td width="150" align="right"><? echo $deudat; ?></td>
			   <td width="150" align="right"><? echo $deudaat; ?></td>
			   <td width="150" align="right"><? echo $deuda; ?></td>
			 </tr>
			<? 			
		}
		
		
        $stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
		$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
		$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
		$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi); $stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); 
		$stotalt=formato_monto($totalt);  $stotaltn=formato_monto($totaltn); $stotaldt=formato_monto($totaldt); $stotaldat=formato_monto($totaldat);	
		?>
		<tr>
			   <td width="150" align="center"><strong></strong></td>  
			   <td width="500" align="justify"><strong>TOTALES</strong></td>				   
			   <td width="150" align="right"><strong><? echo $stotalg; ?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalau;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldi;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalt;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaltn;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalf;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalc;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotala;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalp;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotald;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldt;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldat;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldp; ?></strong></td>
			 </tr>
		</table></td>
         </tr>				
		 </table>
		<?  
		
  }	 
  
/*  
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
 */ 
?>