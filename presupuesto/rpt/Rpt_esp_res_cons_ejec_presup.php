<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");    include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];
$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $c_apli=$_GET["c_apli"]; $s_ultimo=$_GET["s_ultimo"]; $tipo_rep=$_GET["tipo_rep"]; } 
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

   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $cant_cat=3; $cant_par=4;
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"]; $cant_cat=$registro["campo550"]; $cant_par=$registro["campo551"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;
   $pos=strrpos($cod_presup_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presup_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presup_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presup_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];}
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
   }else{$criterio="cod_presup>='".$cod_presup_d."' and cod_presup<='".$cod_presup_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
  $per_hasta=$mes_hasta;
  
  $mascara_part=$formato_partida; $mascara_part=str_replace("X","0",$mascara_part);  
  $tcat_d=substr($cod_presup_d,0,$c);  $tcat_h=substr($cod_presup_h,0,$c);  
  $tcat_d=str_replace("?","",$tcat_d); $tcat_h=str_replace("?","",$tcat_h);
  $tcat_d=str_replace("--","",$tcat_d); $tcat_h=str_replace("--","",$tcat_h);
  
  
  $tlc=strlen($tcat_d)-1; if(substr($tcat_d,$tlc,1)=="-") { $tcat_d=substr($tcat_d,0,$tlc); }
  
  $tlc=strlen($tcat_h)-1; if(substr($tcat_h,$tlc,1)=="-") { $tcat_h=substr($tcat_h,0,$tlc); }
  /**/
  
  $cat_desde=substr($cod_presup_d,0,$c); $cat_hasta=substr($cod_presup_h,0,$c); 
  
  $cat_desde=$tcat_d; $cat_hasta=$tcat_h;
  
  $criterio_s="";
  if($cat_desde==$cat_hasta){
    $tsql="SELECT denominacion from pre001 where cod_presup='$cat_desde'"; $res=pg_query($tsql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cat_desde." ".$registro["denominacion"]; }
  }

  
  
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido ="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; }
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; }
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 		   
	} 
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo4 = "(sum(Compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")"; }
       else{$scampo4 = "+sum(Compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}
      $sql_Compromiso=$sql_Compromiso.$scampo4;$sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;		   
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Asignacion="asignado,"; $sql_Diferido=$sql_Diferido.") as Diferido";	
   }
   if($asig_global=="S"){$sql_Asignacion="sum(asignado),";}   
   if($c_apli<>"T"){ $criterioc=" and (pre001.aplicacion='".$c_apli."') ";  } else {$criterioc="";}    
   
   $StrSQL = "DELETE FROM pre020 Where (tipo_registro='E') And (nombre_usuario='".$cod_mov."')";   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0,61);
   
   //echo $cant_par,"<br>";
   
   for ($i=1; $i<=$cant_par; $i++) { $pa=$cant_cat+$i-1;	 $m=$mcontrol[$pa]-$ls-1; 
	  if ($s_ultimo=="S"){	$continua=0; if($i==$cant_par) {$continua=1;  }
	  } else { $continua=1; }
	  if($continua==1){
		 $sql_codigo="substr(cod_presup,".$ini.",".$m."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$m."),cod_fuente";
		 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m."),'00'"; $sql_grupo="substr(cod_presup,".$ini.",".$m.")";}	 
		 $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'E' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
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
   }
   $ordenar=" ORDER BY pre020.cod_partida,pre020.cod_fuente ";
   $sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida, substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, 
			(pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Modificaciones, (pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad
			 FROM pre020 WHERE tipo_registro='E' and nombre_usuario='$cod_mov'  ".$ordenar;

   
   if(($tipo_rep=="PDF")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $criterio_s; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(160,10,'RESUMEN CONSOLIDADO DE LA EJECUCION DEL PRESUPUESTO',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
			if ($criterio_s<>''){
			   $this->Cell(150,5,$criterio_s,0,1);
			}
			$x=$this->GetX();   $y=$this->GetY();
			$this->rect(10,$y,260,165);
            $this->SetFillColor(192,192,192);
            $this->SetFont('Arial','B',5.5);					
			$this->Cell(16,5,'CODIGO',1,0,'C',true);
			$this->Cell(103,5,'DENOMINACION',1,0,'C',true);
			$this->Cell(20,5,'ASIGNACION',1,0,'C',true);
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C',true);
			$this->Cell(21,5,'ASIG. ACTUALIZADA',1,0,'C',true);
			$this->Cell(20,5,'COMPROMETIDO %',1,0,'L',true);
			$this->Cell(20,5,'     CAUSADO     %',1,0,'L',true);
			$this->Cell(20,5,'     PAGADO      %',1,0,'L',true);
            $this->Cell(20,5,'     DISPONIBLE    %',1,1,'L',true);
            $x=$this->GetX();   $y=$this->GetY();			
            $this->Line(26,$y,26,198); 
            $this->Line(129,$y,129,198); 
            $this->Line(149,$y,149,198); 
            $this->Line(169,$y,169,198);
            $this->Line(190,$y,190,198);
            $this->Line(210,$y,210,198);
            $this->Line(230,$y,230,198); 
            $this->Line(250,$y,250,198); 			
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
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $prev_part="";
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	
      while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["partida"]; $categoria=$cod_categoria;		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$mpart=substr($cod_partida,0,3);
			
			if($prev_part==""){ $prev_part=$mpart;} if ($prev_part<>$mpart) {$pdf->AddPage();  $prev_part=$mpart; } 
			
			if(strlen($cod_partida)==9){
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;
		    }
			
			$porc1=0; if($asig_actualizada<>0) {  $porc1=($comprometido/$asig_actualizada)*100; } $porc1=formato_monto($porc1); 
			$porc2=0; if($asig_actualizada<>0) {  $porc2=($causado/$asig_actualizada)*100; } $porc2=formato_monto($porc2); 
			$porc3=0; if($asig_actualizada<>0) {  $porc3=($pagado/$asig_actualizada)*100; } $porc3=formato_monto($porc3); 
			$porc4=0; if($asig_actualizada<>0) {  $porc4=($disponible/$asig_actualizada)*100; } $porc4=formato_monto($porc4); 
			
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
			$disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
			$muestra=0;
			if(strlen($cod_partida)<=6){$pdf->SetFont('Arial','BU',5);} else {$pdf->SetFont('Arial','',5);}
			if(strlen($cod_partida)==9){ $muestra=1; }
			if($muestra==0){ $lcp=strlen($cod_partida);  $tlp=strlen($mascara_part); $mtc=$lcp;  $temp="-00-00-00-00"; 	$temp=substr($mascara_part,$mtc,$tlp);			
				$mpartida=$cod_presup.$temp;$mpartida=substr($mpartida,0,$p);
				$pdf->Cell(16,3,$mpartida,0,0); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=103; 		   
				$pdf->SetXY($x+$n,$y);
				$pdf->Cell(20,3,$asignado,0,0,'R'); 
				$pdf->Cell(20,3,$modificaciones,0,0,'R'); 
				$pdf->Cell(21,3,$asig_actualizada,0,0,'R'); 	
				$pdf->Cell(14,3,$comprometido,0,0,'R');
				$pdf->Cell(6,3,$porc1,0,0,'R');
				$pdf->Cell(14,3,$causado,0,0,'R'); 
				$pdf->Cell(6,3,$porc2,0,0,'R');
				$pdf->Cell(14,3,$pagado,0,0,'R');
				$pdf->Cell(6,3,$porc3,0,0,'R');
				$pdf->Cell(14,3,$disponible,0,0,'R');
				$pdf->Cell(6,3,$porc4,0,1,'R');
				$pdf->SetXY($x,$y);
				$pdf->MultiCell($n,3,$denominacion,0);
			}
			$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
							
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		
		$porc1=0; if($totalf<>0) {  $porc1=($totalc/$totalf)*100; } $porc1=formato_monto($porc1); 
		$porc2=0; if($totalf<>0) {  $porc2=($totala/$totalf)*100; } $porc2=formato_monto($porc2); 
		$porc3=0; if($totalf<>0) {  $porc3=($totalp/$totalf)*100; } $porc3=formato_monto($porc3); 
		$porc4=0; if($totalf<>0) {  $porc4=($totald/$totalf)*100; } $porc4=formato_monto($porc4); 
			
			
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$x=$pdf->GetX();   $y=$pdf->GetY();
		$pdf->Line(10,$y,270,$y);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(119,4,"TOTAL GENERAL : ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,0,0,'R'); 
		$pdf->Cell(21,4,$totalm,0,0,'R'); 
		$pdf->Cell(20,4,$totalf,0,0,'R');
		
		$pdf->Cell(14,4,$totalc,0,0,'R');
        $pdf->Cell(6,3,$porc1,0,0,'R');		
		$pdf->Cell(14,4,$totala,0,0,'R'); 
		$pdf->Cell(6,3,$porc2,0,0,'R');
		$pdf->Cell(14,4,$totalp,0,0,'R');
        $pdf->Cell(6,3,$porc3,0,0,'R');		
		$pdf->Cell(14,4,$totald,0,0,'R'); 
		$pdf->Cell(6,3,$porc4,0,1,'R');
		$x=$pdf->GetX();   $y=$pdf->GetY();
		$pdf->Line(10,$y,270,$y);
		
		$pdf->Output();   
    }
	
	if($tipo_rep=="EXCEL"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Res_cons_ejec_presup.xls");
		?>
	   <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RESUMEN CONSOLIDADO DE LA EJECUCION DEL PRESUPUESTO</strong></font></td>
		 </tr>
		 <tr height="20">
			<td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <?
		 if ($criterio_s<>''){
		?>
		 <tr height="20">
			<td width="150" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio_s; ?></strong></font></td>
		 </tr>
		 <? } ?>
		 <tr>
			<td width="150" align="left"></td>
		 </tr>	
		 </table></td>
         </tr>
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
		 <tr height="40">
		   <td width="150" align="justify" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
		   <td width="500" align="center" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>ASIGNACION</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>MODIFICACION</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>ASIG ACUATLIZADA</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>COMROMEETIDO</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF" ><strong>%</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>CAUSADO</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF" ><strong>%</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>PAGADO</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF" ><strong>%</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>DISPONIBLE</strong></td> 	
		   <td width="50" align="center" bgcolor="#99CCFF" ><strong>%</strong></td> 				   
		 </tr>
		
		<?
		
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $prev_part="";
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["partida"]; $categoria=$cod_categoria;		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$mpart=substr($cod_partida,0,3);
			
			if($prev_part==""){ $prev_part=$mpart;} if ($prev_part<>$mpart) { //$pdf->AddPage();  
			 $prev_part=$mpart; } 
			
			if(strlen($cod_partida)==9){
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;
		    }
			
			$porc1=0; if($asig_actualizada<>0) {  $porc1=($comprometido/$asig_actualizada)*100; } $porc1=formato_monto($porc1); 
			$porc2=0; if($asig_actualizada<>0) {  $porc2=($causado/$asig_actualizada)*100; } $porc2=formato_monto($porc2); 
			$porc3=0; if($asig_actualizada<>0) {  $porc3=($pagado/$asig_actualizada)*100; } $porc3=formato_monto($porc3); 
			$porc4=0; if($asig_actualizada<>0) {  $porc4=($disponible/$asig_actualizada)*100; } $porc4=formato_monto($porc4); 
			
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
			$disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
			$muestra=0;
			//if(strlen($cod_partida)<=6){$pdf->SetFont('Arial','BU',5);} else {$pdf->SetFont('Arial','',5);}
			if(strlen($cod_partida)==9){ $muestra=1; }
			if($muestra==0){$lcp=strlen($cod_partida);  $tlp=strlen($mascara_part); $mtc=$lcp;  $temp="-00-00-00-00"; 	$temp=substr($mascara_part,$mtc,$tlp);			
				$mpartida=$cod_presup.$temp; $mpartida=substr($mpartida,0,$p);
				$stilo1="mso-number-format:'@';";
			
			?>	   
			<tr>
			   <td width="150" align="center" style="<? echo $stilo1; ?>"><? echo $mpartida; ?></td>
			   <td width="500" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="150" align="right"><? echo $asignado; ?></td>
			   <td width="150" align="right"><? echo $modificaciones; ?></td>
			   <td width="150" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="150" align="right"><? echo $comprometido; ?></td>
			   <td width="50" align="right"><? echo $porc1; ?></td>			   
			   <td width="150" align="right"><? echo $causado; ?></td>
			   <td width="50" align="right"><? echo $porc2; ?></td>
			   <td width="150" align="right"><? echo $pagado; ?></td>
			   <td width="50" align="right"><? echo $porc3; ?></td>			   
			   <td width="150" align="right"><? echo $disponible; ?></td>
			   <td width="50" align="right"><? echo $porc4; ?></td>
			 </tr>
			<? 	
			}
			$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
							
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		
		$porc1=0; if($totalf<>0) {  $porc1=($totalc/$totalf)*100; } $porc1=formato_monto($porc1); 
		$porc2=0; if($totalf<>0) {  $porc2=($totala/$totalf)*100; } $porc2=formato_monto($porc2); 
		$porc3=0; if($totalf<>0) {  $porc3=($totalp/$totalf)*100; } $porc3=formato_monto($porc3); 
		$porc4=0; if($totalf<>0) {  $porc4=($totald/$totalf)*100; } $porc4=formato_monto($porc4); 
			
			
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		
		?>
		<tr>
			   <td width="150" align="center"><strong></strong></td>  
			   <td width="500" align="justify"><strong>TOTAL GENERAL</strong></td>				   
			   <td width="150" align="right"><strong><? echo $stotalg; ?></strong></td>
			   <td width="150" align="right"><strong><? echo $totalm;?></strong></td>
			   <td width="150" align="right"><strong><? echo $totalf;?></strong></td>
			   <td width="150" align="right"><strong><? echo $totalc;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc1;?></strong></td>
			   <td width="150" align="right"><strong><? echo $totala;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc2;?></strong></td>
			   <td width="150" align="right"><strong><? echo $totalp;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc3;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotald;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc4;?></strong></td>
			 </tr>
		</table></td>
         </tr>				
		 </table>
		<?  
		
  }	 


?>