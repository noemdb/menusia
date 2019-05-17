<?  error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc");
if ($_GET){$codigod=$_GET["cod_presupd"];$codigoh=$_GET["cod_presuph"];$fuented=$_GET["cod_fuented"];$fuenteh=$_GET["cod_fuenteh"];$tipo=$_GET["tipo"];$tipo_rep=$_GET["tipo_rep"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$tipo="";$tipo_rep="HTML";} $php_os=PHP_OS; $mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$long_u=strlen($formato_presup); $long_c=strlen($formato_categoria);   
   $criterio="where (cod_presup>='$codigod' and cod_presup<='$codigoh') and (cod_fuente>='$fuented' and cod_fuente<='$fuenteh')";

   $temp_d=str_replace("X","?",$formato_presup); if($temp_d==$codigod) {$codigod="00";}
   $partida_d=$codigod;   $partida_h=$codigoh;   $fuente_d=$fuented;  $fuente_h=$fuenteh;
  
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($codigod,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $pos=strrpos($partida_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($partida_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$partida_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$partida_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; $a=$mcontrol[$i-1]; 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";}
   }else{$criterio="cod_presup>='".$partida_d."' and cod_presup<='".$partida_h."' and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";}
    
   if($tipo=="C"){ $criterio=$criterio." and (length(cod_presup)<=$long_c) ";}  if($tipo=="U"){ $criterio=$criterio." and (length(cod_presup)=$long_u) ";}
   $sSQL = "select cod_presup, cod_fuente, denominacion, cod_contable, func_inv, cod_unidad_ejec from pre001 where ".$criterio." order by cod_presup, cod_fuente";
   if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
	   $oRpt = new PHPReportMaker();
	   $oRpt->setXML("Catalogo_de_partidas.xml");
	   $oRpt->setUser("$user");
	   $oRpt->setPassword("$password");
	   $oRpt->setConnection("$host");
	   $oRpt->setDatabaseInterface("postgresql");
	   $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
	   $oRpt->setSQL($sSQL);
	   $oRpt->setDatabase("$dbname");
	   $oRpt->run();
	} 
    if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tipo; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(120,10,'CATALOGO PARTIDAS PRESUPUESTARIAS',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',6);	
			$this->Cell(30,5,'CODIGO',1,0);
			$this->Cell(110,5,'DENOMINACION',1,0);
			$this->Cell(10,5,'FUENTE',1,0);
			$this->Cell(20,5,'TIPO GASTO',1,0,'C');
			if($tipo=="C"){$this->Cell(30,5,'UNIDAD EJECUTORA',1,1,'C');}
			else{$this->Cell(30,5,'CODIGO CONTABLE',1,1,'C');}
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
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total=0; $totaln=0; $totalr=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];   $cod_contable=$registro["cod_contable"];  $cod_unidad_ejec=$registro["cod_unidad_ejec"];
           $func_inv=$registro["func_inv"];   $aplicacion=$registro["aplicacion"];   if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORRIENTE";}
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); } 
		   $pdf->Cell(32,3,$cod_presup,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=108; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,3,$cod_fuente,0,0,'C'); 
           $pdf->Cell(20,3,$func_inv,0,0,'C');
		   if($tipo=="C"){ $pdf->Cell(30,3,$cod_unidad_ejec,0,1); }
		   else{ $pdf->Cell(30,3,$cod_contable,0,1); }
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);
		} 
		$pdf->Output(); pg_close();  
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalogo_Partidas_Presup.xls");	
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO PARTIDAS PRESUPUESTARIAS</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="200" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>FUENTE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>TIPO GASTO</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>CODIGO CONTABLE</strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];   $cod_contable=$registro["cod_contable"];
           $func_inv=$registro["func_inv"];   $aplicacion=$registro["aplicacion"];   if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORRIENTE";}
           $denominacion=conv_cadenas($denominacion,0); $cod_unidad_ejec=$registro["cod_unidad_ejec"];
	?>	   
		   <tr>
           <td width="200" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup; ?></td>
           <td width="400" align="justify"><? echo $denominacion; ?></td>
           <td width="50" align="center">'<? echo $cod_fuente; ?></td>
           <td width="100" align="center"><? echo $func_inv; ?></td>
           <td width="150" align="left"><? echo $cod_contable; ?></td>
         </tr>
	<? }   ?>
	  </table><?
	}  
} 	
?>

