<? error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc");  
   $tipo_nominad=$_GET["tipo_nominad"];   $tipo_nominah=$_GET["tipo_nominah"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_empleado_h=$_GET["cod_empleado_h"];   $cedula_d=$_GET["cedula_d"];   $cedula_h=$_GET["cedula_h"];
   $sexo=$_GET["sexo"];   $estado_civil=$_GET["estado_civil"];   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"];
   $edad_d=$_GET["edad_d"];   $edad_h=$_GET["edad_h"];   $fecha_ingreso_d=$_GET["fecha_ingreso_d"];   $fecha_ingreso_h=$_GET["fecha_ingreso_h"];
   $estatus=$_GET["estatus"];   $codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"];
   $codigo_departamentod=$_GET["codigo_departamentod"];   $codigo_departamentoh=$_GET["codigo_departamentoh"];   $inf_per=$_GET["inf_per"];   $inf_car=$_GET["inf_car"];
   $date = date("d-m-Y");   $hora = date("H:i:s a");   $Sql="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_d))){$ano1=substr($fecha_ingreso_d,6,9);$mes1=substr($fecha_ingreso_d,3,2);$dia1=substr($fecha_ingreso_d,0,2);}else{$fecha_ingreso_d='';}$fecha_desde_ing=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_h))){$ano1=substr($fecha_ingreso_h,6,9);$mes1=substr($fecha_ingreso_h,3,2);$dia1=substr($fecha_ingreso_h,0,2);} else{$fecha_ingreso_h='';} $fecha_hasta_ing=$ano1.$mes1.$dia1;
   $crit_st="and nom007.sexo ='".$sexo."' and nom007.edo_civil='".$estado_civil."' and  nom006.status ='".$estatus."'"; $crit_st="";
   if($sexo<>"TODOS"){$crit_st=$crit_st."and nom007.sexo ='".$sexo."' ";}
   if($estado_civil<>"TODOS"){$crit_st=$crit_st."and nom007.edo_civil='".$estado_civil."' ";}
   if($estatus<>"TODOS"){if($estatus=="ACTIVO/VACACIONES/PERMISO"){ $crit_st=$crit_st."and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='PERMISO')";}	 else{$crit_st=$crit_st."and nom006.status='".$estatus."'";}   }
$nomb_rpt="Rpt_info_labo_mp_mit_re.xml";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else { $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

        $sSQL = "SELECT nom006.cod_empleado, nom006.Nombre, nom006.Cedula, nom006.Nacionalidad, nom006.Status, nom006.Tipo_Nomina, nom001.Descripcion,
                  nom006.Cod_Categoria, nom006.Tipo_Pago, nom006.Cta_Empleado, nom006.Cod_Banco, nom006.Nombre_Banco, nom006.Cta_Empresa, to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as fechaingadm, 
				  nom006.Tipo_Cuenta, nom006.Calculo_Grupos, nom006.Tiene_lph, nom006.Banco_lph, nom006.Cta_lph, to_char(nom006.Fecha_lph,'DD/MM/YYYY') as fechalph, nom006.Tiene_Dec_Jurada, 
				  to_char(nom006.Fecha_Declaracion,'DD/MM/YYYY') as fechadecla,  nom006.Monto_Declaracion, to_char(nom006.Fecha_Fin_Con,'DD/MM/YYYY') as fechafincon, to_char(nom006.Fecha_Egreso,'DD/MM/YYYY') as fechaegre, 
				  nom006.Motivo_Egreso, nom006.Tiene_Aus_Pro, nom006.Motivo_Ausencia, to_char(nom006.Fecha_Aus_Desde,'DD/MM/YYYY') as fechaaudes,to_char(nom006.Fecha_Aus_Hasta,'DD/MM/YYYY') as fechaauhas, nom006.Cod_Cargo, 
				  to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechaing, to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as fechaadm, nom006.codigo_ubicacion, nom007.Sexo, nom007.Edo_Civil, nom007.rif_empleado,
                  nom007.Fecha_Nacimiento, nom007.Edad, nom007.Lugar_Nacimiento, nom007.Direccion, nom007.Cod_Postal, nom007.Telefono, nom007.Correo, nom007.Estado, nom007.Ciudad, nom007.profesion, to_char(nom007.Fecha_Nacimiento,'DD/MM/YYYY') as fechan
                  FROM nom001, nom006, nom007 WHERE nom006.cod_empleado=nom007.cod_empleado and nom001.Tipo_Nomina = nom006.Tipo_Nomina  and nom006.Tipo_Nomina>='".$tipo_nominad."' and nom006.Tipo_Nomina<='".$tipo_nominah."' and
                  nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."' and  nom006.Cedula>='".$cedula_d."' and nom006.Cedula<='".$cedula_h."' and
	              nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."' and nom006.cod_departam>='".$codigo_departamentod."' and nom006.cod_departam<='".$codigo_departamentoh."' and nom006.fecha_ingreso>='".$fecha_desde_ing."' and nom006.fecha_ingreso<='".$fecha_hasta_ing."' ".$crit_st."  order by nom006.cod_empleado";

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
			$this->Cell(100,10,'INFORMACION LABORAL',1,0,'C');
			$this->Ln(15);
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
	  $i=0; $total_monto=0;  $prev_cod_empleado=""; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $status=$registro["status"]; $fechai=$registro["fechai"]; 
	      $des_departam=$registro["des_departam"]; $cod_categoria=$registro["cod_categoria"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; 
	      $nombre_banco=$registro["nombre_banco"]; $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
          $tipo_pago=$registro["tipo_pago"]; $nacionalidad=$registro["nacionalidad"]; $rif_empleado=$registro["rif_empleado"]; $cta_empresa=$registro["cta_empresa"];
          $codigo_ubicacion=$registro["codigo_ubicacion"]; $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fechan=$registro["fechan"]; $edad=$registro["edad"];
          $lugar_nacimiento=$registro["lugar_nacimiento"]; $profesion=$registro["profesion"]; $correo=$registro["correo"]; $direccion=$registro["direccion"];
          $ciudad=$registro["ciudad"]; $estado=$registro["estado"]; $telefono=$registro["telefono"];		  
		  $tiene_aus_pro=$registro["tiene_aus_pro"]; $motivo_ausencia=$registro["motivo_ausencia"]; $fechaaudes=$registro["fechaaudes"]; $fechaauhas=$registro["fechaauhas"];
		  if($tiene_aus_pro=="S"){$tiene_aus_pro="SI";}else{$tiene_aus_pro="NO";}
		  if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion); $profesion=utf8_decode($profesion); 
		      $des_cargo=utf8_decode($des_cargo);  $des_departamento=utf8_decode($des_departamento); $direccion=utf8_decode($direccion);} 
          
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo; $status_grupo=$status; $fechai_grupo=$fechai; $des_departam_grupo=$des_departam; $cod_categoria_grupo=$cod_categoria; $fechad_grupo=$fechad; 
          $fechah_grupo=$fechah; $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; $cta_empleado_grupo=$cta_empleado; $tipo_nomina_grupo=$tipo_nomina; 
	      $descripcion_grupo=$descripcion; $tipo_pago_grupo=$tipo_pago; $nacionalidad_grupo=$nacionalidad; $rif_empleado_grupo=$rif_empleado; 
          $cta_empresa_grupo=$cta_empresa;   $codigo_ubicacion_grupo=$codigo_ubicacion; $sexo_grupo=$sexo; $edo_civil_grupo=$edo_civil; $fechan_grupo=$fechan; $edad_grupo=$edad; 
	      $lugar_nacimiento_grupo=$lugar_nacimiento; $profesion_grupo=$profesion; $direccion_grupo=$direccion; $ciudad_grupo=$ciudad; $estado_grupo=$estado;
          $telefono_grupo=$telefono; $fechai=formato_ddmmaaaa($fechai); $fechan=formato_ddmmaaaa($fechan);
		  
			$pdf->Ln(3);
			$pdf->Cell(200,2,'_________________________________________________________________________________________________________________________________________________________________________',0,1,'L');
			$pdf->Cell(30,4,'CODIGO : '.$cod_empleado_grupo,0,0,'L');  
			$pdf->Cell(140,4,'NOMBRE : '.$nombre_grupo,0,0,'L');
			$pdf->Cell(30,4,'CEDULA : '.$cedula_grupo,0,1,'L');
			$pdf->Cell(30,4,'STATUS : '.$status_grupo,0,0,'L');  
			$pdf->Cell(140,4,'NOMINA : '.$tipo_nomina_grupo."   ".$descripcion_grupo,0,0,'L');
			$pdf->Cell(30,4,'FECHA INGRESO : '.$fechai_grupo,0,1,'L');
			$pdf->Cell(50,4,'COD CATEGORIA : '.$cod_categoria_grupo,0,0,'L');  
			$pdf->Cell(70,4,'TIPO PAGO : '.$tipo_pago_grupo,0,0,'L');
			$pdf->Cell(50,4,'CUENTA : '.$cta_empleado_grupo,0,0,'L');
			$pdf->Cell(30,4,'NACIONALIDAD : '.$nacionalidad_grupo,0,1,'L');
			$pdf->Cell(30,4,'RIF : '.$rif_empleado_grupo,0,0,'L');  
			$pdf->Cell(140,4,'CUENTA EMPRESA : '.$cta_empresa_grupo."   ".$nombre_banco_grupo,0,0,'L');
			$pdf->Cell(30,4,'UBICACION : '.$codigo_ubicacion_grupo,0,1,'L');
			$pdf->Cell(30,4,'SEXO : '.$sexo_grupo,0,0,'L');  
			$pdf->Cell(90,4,'EDO CIVIL : '.$edo_civil_grupo,0,0,'L');
			$pdf->Cell(50,4,'FECHA NAC : '.$fechan_grupo,0,0,'L');
			$pdf->Cell(30,4,'EDAD : '.$edad_grupo,0,1,'L');
			$pdf->Cell(50,4,'LUGAR DE NAC : '.$lugar_nacimiento_grupo,0,0,'L');  
			$pdf->Cell(120,4,'PROFESION : '.$profesion_grupo,0,0,'L');
			$pdf->Cell(30,4,'EMAIL : '.$correo_grupo,0,1,'L');
			$pdf->Cell(30,4,'DIRECCION :'.$direccion_grupo,0,1,'L');
			$pdf->Cell(30,4,'CIUDAD : '.$ciudad_grupo,0,0,'L');  
			$pdf->Cell(140,4,'ESTADO :'.$estado_grupo,0,0,'L');
			$pdf->Cell(30,4,'TELEFONO :'.$telefono_grupo,0,1,'L');			
			$pdf->Cell(50,4,'TIENE AUSENCIA PROGRAMADA : '.$tiene_aus_pro,0,0,'L');
			$pdf->Cell(90,4,'MOTIVO : '.$motivo_ausencia,0,0,'L');
			$pdf->Cell(30,4,'FECHA DESDE : '.$fechaaudes,0,0,'L');
			$pdf->Cell(30,4,'FECHA HASTA : '.$fechaauhas,0,1,'L');			
			$prev_cod_empleado=$cod_empleado_grupo; 
        } 		
		$pdf->Output();  
    }
		
}	
	
?>
