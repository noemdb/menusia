<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"]; $tipo_rep=$_GET["tipo_rep"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$tipo_rep="HTML";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE020".$usuario_sia; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? }  else{  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  $criterio="(cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') and (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";
  $StrSQL= "INSERT INTO PRE020 SELECT '".$cod_mov."' as Nombre_Usuario,'5' as Tipo_Registro, Cod_Presup, Cod_Fuente, Denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio;
  $efiscal=substr($Fec_Fin_Ejer,0,4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;
  $sSQL = "SELECT Cod_Presup, cod_fuente, Denominacion, Disponible FROM PRE001 WHERE ".$criterio." order by Cod_Presup, cod_fuente";       
  if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
         $oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_Disponibilidad_Actualizada_Partida.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1));          
        $oRpt->run();
  }
  if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,8,'DISPONIBILIDAD PRESUPUESTARIA ACTUALIZADA POR PARTIDA',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1);
            $this->SetFont('Arial','B',7);			
			$this->Cell(45,5,'CODIGO',1,0);
			$this->Cell(133,5,'DENOMINACION',1,0);
			$this->Cell(22,5,'DISPONIBILIDAD',1,1,'C');
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
	  $pdf->SetFont('Arial','',8);
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $disponible=$registro["disponible"]; $total=$total+$disponible; $disponible=formato_monto($disponible); 
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); }
		   $pdf->Cell(38,4,$cod_presup,0,0); 
           $pdf->Cell(7,4,$cod_fuente,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=133; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(22,4,$disponible,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$denominacion,0);
			
		}  
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Disponibilidad_Actualizada_Partida.xls");

?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="220" align="left" ><strong></strong></td>
                    <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DISPONIBILIDAD PRESUPUESTARIA ACTUALIZADA POR PARTIDA</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="220" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>DISPONIBILIDAD</strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $disponible=$registro["disponible"]; $total=$total+$disponible; $disponible=formato_monto($disponible);           
		   $denominacion=conv_cadenas($denominacion,0);  
	?>	   
		   <tr>
           <td width="220" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup; ?></td>
           <td width="400" align="justify"><? echo $denominacion; ?></td>
           <td width="120" align="right"><? echo $disponible; ?></td>
         </tr>
	<? } 
	
	  
	}
pg_close();	
?>
