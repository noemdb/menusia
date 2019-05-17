<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"];   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
   $ordenar="  order by cod_departam, to_number(cedula,'999999999999'), cod_empleado,  cod_concepto";
   $mes_desde=substr($fecha_desde,3,2); $mes_hasta=substr($fecha_hasta,3,2); $mano=substr($fecha_hasta,6,4); 
   $cfechan=formato_aaaammdd($fecha_hasta);       $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);   
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}

   if (!(empty($fecha_desde))){$ano1=substr($fecha_desde,6,9);$mes1=substr($fecha_desde,3,2);$dia1=substr($fecha_desde,0,2);}else{$fecha_desde='';} $tfecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_hasta))){$ano2=substr($fecha_hasta,6,9);$mes2=substr($fecha_hasta,3,2);$dia2=substr($fecha_hasta,0,2);}else{$fecha_hasta='';} $tfecha_hasta=$ano2.$mes2.$dia2;

$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

    $criterio1="FECHA DESDE : ".$fecha_desde." HASTA ".$fecha_hasta;
	
	$fechadb=operacion_mes($fecha_desde,-1); $fechadb=colocar_pdiames($fechadb); $fechahb=colocar_pdiames($fechadb); $fechahb=colocar_udiames($fechahb);
	$dfechab=formato_aaaammdd($fechadb); $hfechab=formato_aaaammdd($fechahb);
	
	$criterio=" (nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."') and (nom006.tipo_nomina>='".$tipo_nomina_d."' and nom006.tipo_nomina<='".$tipo_nomina_h."') 
	      and (nom006.cod_departam>='".$cod_departd."' and nom006.cod_departam<='".$cod_departh."' ) and (nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."') 
		  and (nom006.cod_tipo_personal>='".$tipo_personal_d."' and nom006.cod_tipo_personal<='".$tipo_personal_h."') ";
	   
	   
    $sSQL = "SELECT nom006.cod_empleado,nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom006.status, to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, date_part('year', fecha_ingreso), date_part('month', fecha_ingreso), date_part('day', fecha_ingreso),nom006.tipo_nomina,nom001.descripcion
             	FROM nom006,nom001 Where (nom006.tipo_nomina=nom001.tipo_nomina) and (date_part('day', fecha_ingreso)>=".$dia1." and date_part('month', fecha_ingreso)>=".$mes1.") and (date_part('day', fecha_ingreso)<=".$dia2." and date_part('month', fecha_ingreso)<=".$mes2.") and
                (NOM006.Status='ACTIVO' or NOM006.Status='PERMISO RE' or NOM006.Status='VACACIONES' or NOM006.Status='REPOSO') and ".$criterio." order by date_part('month', fecha_ingreso),date_part('year', fecha_ingreso),nom006.cod_empleado";


	//echo $sSQL;
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula=""; $prev_cod_empleado=""; $prev_cod_cat="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["descripcion"];	   
        $fecha_ingreso=$registro["fecha_ingreso"]; $cod_departam=$registro["cod_departam"]; $cedula=$registro["cedula"];  $nombre=$registro["nombre"];	
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $nombre=utf8_decode($nombre);}
		$prev_cod_empleado=$cod_empleado;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $tipo_nomina_d; global $tipo_nomina_h;  global $criterio4; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,16);
			$this->SetFont('Arial','B',11);
			$this->Cell(50);
			$this->Cell(160,7,"LISTADO DE VACACIONES",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(160,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			$this->Cell(160,5,$criterio1,0,1,'L');			
            $this->Ln(5); 	
            $this->SetFont('Arial','B',8); 			
			$this->Cell(15,5,'Cedula',1,0,'L');
			$this->Cell(105,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(20,5,'Fecha Ing.',1,0,'C');
			$this->Cell(20,5,'Antiguedad.',1,0,'C');
			$this->Cell(20,5,'Bono Vac',1,0,'C');
			$this->Cell(20,5,'Vacaciones',1,0,'C');
			$this->Cell(20,5,'Salario Integral',1,0,'C');
			$this->Cell(20,5,'Salario Diario',1,0,'C');
			$this->Cell(20,5,'M. Bono Vac.',1,1,'C');
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
	  $pdf->SetFont('Arial','',8);
	  $i=0; $total_monto=0;  $prev_cod_empleado=""; $bono_vac=40; $dias_vac=15; $cant_emp=0;
	  $criterio_conc="(  (cod_concepto='101') )";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["descripcion"];	   
        $fecha_ingreso=$registro["fecha_ingreso"]; $cod_departam=$registro["cod_departam"]; $cedula=$registro["cedula"];  $nombre=$registro["nombre"];
	    $fecha_i=formato_ddmmaaaa($fecha_ingreso);
		$f=diferencia_años($fecha_i,$fecha_hasta); if($f<0){$f=0;}
		
		if($f<=5){ $dias_vac=15; } else{   if($f<=10){ $dias_vac=18; } else{   if($f<=15){ $dias_vac=21; }  else{   if($f>15){ $dias_vac=25; } }} }
		
		$sqlb="select * from nom019 where ((fecha_p_desde>='".$dfechab."') and (fecha_p_hasta<='".$hfechab."') ) and (cod_empleado='$cod_empleado') and (tipo_nomina='$tipo_nomina') and ".$criterio_conc;
		$resb=pg_query($sqlb); $sueldo_int=0;
		while($regb=pg_fetch_array($resb)){ $monto=$regb["monto"]; $sueldo_int=$sueldo_int+$monto; }
		$sueldo_dia=$sueldo_int/30; $monto_bono_vac=$sueldo_dia*$f;
		$total_monto=$total_monto+$monto_bono_vac;
		
		$monto1=formato_monto($sueldo_int); $monto2=formato_monto($sueldo_dia); $monto3=formato_monto($monto_bono_vac);
		$pdf->SetFont('Arial','',8);
	    $pdf->Cell(20,5,$cedula,0,0,'L'); 
	    $pdf->Cell(100,5,$nombre,0,0,'L'); 
	    $pdf->Cell(20,5,$fecha_i,0,0,'C'); 
        $pdf->Cell(20,5,$f,0,0,'C'); 
        $pdf->Cell(20,5,$bono_vac,0,0,'C'); 
        $pdf->Cell(20,5,$dias_vac,0,0,'C');
        $pdf->Cell(20,5,$monto1,0,0,'R'); 
        $pdf->Cell(20,5,$monto2,0,0,'R');
        $pdf->Cell(20,5,$monto3,0,1,'R'); 		
	  
	    $cant_emp=$cant_emp+1; 
	  }	
	   $monto3=formato_monto($total_monto);
	  $pdf->Cell(120,5,'NRO.TRABAJADORES : '.$cant_emp,0,0,'L');
	  $pdf->Cell(120,5,'TOTAL GENERAL : ',0,0,'R');
	  $pdf->Cell(20,5,$monto3,'T',1,'R');

        $y=$pdf->GetY();  $t=10;
        if($y>180){$t=10; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<185){$t=185-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);
        $pdf->Cell(50,4,'Elaborado por Analista','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(50,4,'Revisado por','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
		$pdf->Cell(50,4,'Conformado por ','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(50,4,'Aprobado por Contralor(a)','T',1,'C');
		
        $pdf->Cell(60,3,' ',0,0,'C');
		$pdf->Cell(50,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
		$pdf->Cell(10,4,'',0,0);
        $pdf->Cell(50,3,'Dir. Administracion y Presupuesto',0,0,'C');
        $pdf->Cell(10,4,'',0,0);		
        $pdf->Cell(50,3,'Interventora de la CEBM',0,1,'C'); 	  

    $pdf->Output(); 	  
}
?>