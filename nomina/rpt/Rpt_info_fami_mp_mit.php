<? error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc");  

   $tipo_nominad=$_GET["tipo_nominad"];   $tipo_nominah=$_GET["tipo_nominah"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $parentesco=$_GET["parentesco"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_empleado_h=$_GET["cod_empleado_h"];   $cedula_d=$_GET["cedula_d"];   $cedula_h=$_GET["cedula_h"];
   $sexo=$_GET["sexo"];   $estado_civil=$_GET["estado_civil"];   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"];
   $edad_d=$_GET["edad_d"];   $edad_h=$_GET["edad_h"];   $fecha_ingreso_d=$_GET["fecha_ingreso_d"];   $fecha_ingreso_h=$_GET["fecha_ingreso_h"];
   $estatus=$_GET["estatus"];   $codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"];
   $codigo_departamentod=$_GET["codigo_departamentod"];   $codigo_departamentoh=$_GET["codigo_departamentoh"];   $inf_per=$_GET["inf_per"];   $inf_car=$_GET["inf_car"];
   $date = date("d-m-Y");   $hora = date("H:i:s a");   $Sql="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_d))){$ano1=substr($fecha_ingreso_d,6,9);$mes1=substr($fecha_ingreso_d,3,2);$dia1=substr($fecha_ingreso_d,0,2);}else{$fecha_ingreso_d='';} $fecha_desde_ing=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_h))){$ano1=substr($fecha_ingreso_h,6,9);$mes1=substr($fecha_ingreso_h,3,2);$dia1=substr($fecha_ingreso_h,0,2);} else{$fecha_ingreso_h='';} $fecha_hasta_ing=$ano1.$mes1.$dia1;

   $crit_st="and nom007.sexo ='".$sexo."' and nom007.edo_civil='".$estado_civil."' and  nom006.status ='".$estatus."'"; $crit_st="";
   if($sexo<>"TODOS"){$crit_st=$crit_st."and nom007.sexo ='".$sexo."' ";}
   if($estado_civil<>"TODOS"){$crit_st=$crit_st."and nom007.edo_civil='".$estado_civil."' ";}
   if($estatus<>"TODOS"){
     if($estatus=="ACTIVO/VACACIONES/PERMISO"){ $crit_st=$crit_st."and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='PERMISO')";}	 
       else{ if($estatus=="ACTIVO/VACACIONES/REPOSO"){ $crit_st=$crit_st."and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='REPOSO')";}	 
       else{ $crit_st=$crit_st."and nom006.status='".$estatus."'";}   }   
   }
   if($parentesco<>"TODOS"){
     if($parentesco=="SOLO"){  $crit_st=$crit_st."and (nom009.parentesco='HIJO' or nom009.parentesco='HIJA' or nom009.parentesco='HIJO GUARD' or nom009.parentesco='HIJA GUARD')";}
	 else{ $crit_st=$crit_st."and (nom009.parentesco='".$parentesco."')";}
   }
   $criterio="NOM006.Tipo_Nomina>='".$tipo_nominad."' AND NOM006.Tipo_Nomina<='".$tipo_nominah."' AND
                  NOM006.Cod_Empleado>='".$cod_empleado_d."' AND NOM006.Cod_Empleado<='".$cod_empleado_h."' AND
                  NOM006.cedula>='".$cedula_d."' AND NOM006.cedula<='".$cedula_h."' AND
		          NOM006.cod_cargo>='".$codigo_cargo_d."' AND NOM006.cod_cargo<='".$codigo_cargo_h."' AND
		          NOM006.cod_departam>='".$codigo_departamentod."' AND NOM006.cod_departam<='".$codigo_departamentoh."' AND
                  NOM007.Fecha_Nacimiento>='".$fecha_desde."' AND NOM007.Fecha_Nacimiento<='".$fecha_hasta."'AND
                  NOM009.Edad>='".$edad_d."' AND NOM009.Edad<='".$edad_h."' AND
                  NOM006.Fecha_Ingreso>='".$fecha_desde_ing."' AND NOM006.Fecha_Ingreso<='".$fecha_hasta_ing."' ".$crit_st;
				  
$nomb_rpt="Rpt_info_fami_mp_mit_re.xml";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else {   $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
        
		$fsql = "SELECT count(distinct NOM006.cod_empleado) as cant_trab  FROM NOM001, NOM006, NOM007, NOM009 WHERE NOM006.Cod_Empleado=NOM007.Cod_Empleado AND NOM006.Tipo_Nomina=NOM001.Tipo_Nomina and NOM006.Cod_Empleado = NOM009.Cod_Empleado and  ".$criterio;
        $res=pg_query($fsql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2="Cantidad de Trabjadores: ".$registro["cant_trab"];  }
       
        $sSQL = "SELECT NOM006.cod_empleado, NOM006.Cedula, NOM006.Nombre, NOM006.Tipo_Nomina, NOM001.Descripcion, NOM006.Cod_Cargo, NOM006.Cod_Departam, 
                  NOM009.CI_Partida, NOM009.Nombre as nomb_fam, NOM009.Sexo, to_char(NOM009.Fecha_Nac,'DD/MM/YYYY') as fechan, NOM009.Edad, NOM009.Parentesco
                  FROM NOM001, NOM006, NOM007, NOM009 WHERE NOM006.cod_empleado=NOM007.cod_empleado AND NOM006.Tipo_Nomina=NOM001.Tipo_Nomina and NOM006.Cod_Empleado = NOM009.Cod_Empleado AND
                  ".$criterio." ORDER BY NOM006.cod_empleado, NOM009.CI_Partida";
				  
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
         $oRpt = new PHPReportMaker();
         $oRpt->setXML($nomb_rpt);
         $oRpt->setUser("$user");
         $oRpt->setPassword("$password");
         $oRpt->setConnection("localhost");
         $oRpt->setDatabaseInterface("postgresql");
         $oRpt->setSQL($sSQL);
         $oRpt->setDatabase("$dbname");
         $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
         $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
         $oRpt->run();
         $aBench = $oRpt->getBenchmark();
         $iSec   = $aBench["report_end"]-$aBench["report_start"];
    }	
	if(($tipo_rpt=="PDF")){$res=pg_query($sSQL);  $cod_empleado_grupo=""; 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo;  global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'INFORMACION FAMILIAR',1,0,'C');
			$this->Ln(20);
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
	  $i=0; $cantidad=0; $total_cantidad=0; $prev_cod_empleado=""; $prev_ci_partida="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"];  $nombre=$registro["nombre"];
        if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }	  
        $cedula=$registro["cedula"];  $status=$registro["status"]; $ci_partida=$registro["ci_partida"];
        $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $status_grupo=$status; $ci_partida_grupo=$ci_partida;

	    if($prev_cod_empleado<>$cod_empleado_grupo){ 
		    $pdf->SetFont('Arial','B',6);
			if($cantidad>0){ $cantidad=formato_monto($cantidad);
			  $pdf->Cell(180,4,'Cantidad Familiares : '.$cantidad,0,0,'R');
			  $pdf->Cell(20,4,'',0,1,'C');
			  $pdf->Ln(5); }
			$pdf->SetFont('Arial','B',8);  
			$pdf->Cell(200,2,'-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');
			
			$pdf->Cell(30,3,'Codigo',0,0,'L');  
			$pdf->Cell(20,3,'Cedula',0,0,'L');
			$pdf->Cell(150,3,'Nombre',0,1,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30,4,$cod_empleado_grupo,0,0,'L');  
			$pdf->Cell(20,4,$cedula_grupo,0,0,'L');
			$pdf->Cell(150,4,$nombre_grupo,0,1,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(200,5,'FAMILIARES ',0,1,'C');  
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,3,'CI/Partida ',0,0,'L');  
			$pdf->Cell(110,3,'Nombre',0,0,'L');  
			$pdf->Cell(20,3,'Sexo',0,0,'L');
			$pdf->Cell(20,3,'Fecha Nac.',0,0,'L');
			$pdf->Cell(10,3,'Edad',0,0,'L');
			$pdf->Cell(20,3,'Parentesco',0,1,'L');  
			$prev_cod_empleado=$cod_empleado_grupo; $cantidad=0;} 

        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $ci_partida=$registro["ci_partida"]; $nomb_fam=$registro["nomb_fam"]; 
	    $sexo=$registro["sexo"]; $fechan=$registro["fechan"];$edad=$registro["edad"]; $parentesco=$registro["parentesco"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
        $edad=round($edad); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  $nomb_fam=utf8_decode($nomb_fam);}
        $pdf->SetFont('Arial','',8);
	     $pdf->Cell(20,3,$ci_partida,0,0,'L');  
	     $pdf->Cell(110,3,$nomb_fam,0,0,'L');
	     $pdf->Cell(20,3,$sexo,0,0,'L');
	     $pdf->Cell(20,3,$fechan,0,0,'L');
	     $pdf->Cell(10,3,$edad,0,0,'L');
	     $pdf->Cell(20,3,$parentesco,0,1,'L');
       } $total_cantidad=round($total_cantidad);
	    $pdf->SetFont('Arial','B',6);
          if($cantidad>0){ $cantidad=round($cantidad);
			  $pdf->Cell(180,3,'Cantidad Familiares : '.$cantidad,0,0,'R');
			  $pdf->Cell(20,3,'',0,1,'C'); }
		$pdf->Ln(10);	
        $pdf->SetFont('Arial','B',8);		
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(100,2,$criterio2,0,0,'L');
		$pdf->Cell(80,2,'Total Cantidad Familiares :',0,0,'R');
		$pdf->Cell(20,2,$total_cantidad,0,1,'C');
		$pdf->Output();  
    }
	if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Informacion_Familiar.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
		    <td width="400" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>INFORMACION FAMILIAR</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $prev_cod_empleado=""; $prev_ci_partida=""; $cantidad=0; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"];  $nombre=$registro["nombre"]; 
          $cedula=$registro["cedula"];  $status=$registro["status"]; $ci_partida=$registro["ci_partida"];
          $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $status_grupo=$status; $ci_partida_grupo=$ci_partida;
		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
                if($cantidad>0){ $cantidad=formato_monto($cantidad);
				?>
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="left"></td>	
					  <td width="100" align="right">Cantidad Familiares : </td>			
					  <td width="100" align="right"><? echo $cantidad; ?></td>
				    </tr> 
				    <tr>
				    </tr> 
				<? }?>	
				    <tr>
				    </tr> 
			 	    <tr>
			   		<td width="100" align="left" bgcolor="#99CCFF"></td>
			   		<td width="400" align="left" bgcolor="#99CCFF"></td>
			   		<td width="400" align="left" bgcolor="#99CCFF"></td>
			   		<td width="100" align="center" bgcolor="#99CCFF"></td>
			   		<td width="100" align="center" bgcolor="#99CCFF"></td>
			   		<td width="100" align="center" bgcolor="#99CCFF"></td>
			 	    </tr>
                    <tr>
					  <td width="100" align="left">Codigo: </td>
					  <td width="400" align="left">Cedula: </td>	
					  <td width="400" align="left">Nombre: </td>
				    </tr> 				 
                    <tr>
					  <td width="100" align="left">'<? echo $cod_empleado_grupo; ?></td>
					  <td width="400" align="left">'<? echo $cedula_grupo; ?></td>
					  <td width="400" align="left"><? echo $nombre_grupo; ?></td>	
				    </tr>
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="400" align="center"><strong>FAMILIARES</strong></td>	
				    </tr> 
                    <tr>
					  <td width="100" align="left">CI/Partida: </td>
					  <td width="400" align="left">Nombre: </td>	
					  <td width="400" align="left">Sexo: </td>
					  <td width="100" align="left">Fecha Nac.: </td>
					  <td width="100" align="center">Edad: </td>
					  <td width="100" align="left">Parentesco: </td>
				    </tr> 
            <? $prev_cod_empleado=$cod_empleado_grupo; $cantidad=0; } 
          $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $ci_partida=$registro["ci_partida"]; $nomb_fam=$registro["nomb_fam"]; 
	      $sexo=$registro["sexo"]; $fechan=$registro["fechan"];$edad=$registro["edad"]; $parentesco=$registro["parentesco"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
          $edad=formato_monto($total_cantidad);
		  ?> 
             <tr>
			    <td width="100" align="left">'<? echo $ci_partida; ?></td>
			    <td width="400" align="left"><? echo $nomb_fam; ?></td>	
			    <td width="400" align="left"><? echo $sexo; ?></td>
			    <td width="100" align="left"><? echo $fechan; ?></td>
			    <td width="100" align="center"><? echo $edad; ?></td>
			    <td width="100" align="left"><? echo $parentesco; ?></td>
			</tr>
        <?} $total_cantidad=formato_monto($total_cantidad);
                if($cantidad>0){ $cantidad=formato_monto($cantidad);
				?>
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="left"></td>	
					  <td width="100" align="right">Cantidad Familiares : </td>			
					  <td width="100" align="right"><? echo $cantidad; ?></td>
				    </tr> 				    
				<? }	?>
				<tr>
				</tr>    
			    <tr>
				  <td width="100" align="left"></td>
				  <td width="400" align="left"></td>
				  <td width="400" align="left"></td>
				  <td width="100" align="left"></td>	
				  <td width="100" align="right">Total Cantidad Familiares : </td>			
				  <td width="100" align="right"><? echo $total_cantidad; ?></td>
				</tr> 
		 </tr>
		 </table><?
	}
	
}	
		
	
?>
