<? 
error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); require ("../../class/fun_numeros.php"); require ("../../class/fun_fechas.php"); $php_os=PHP_OS; 
$fecha_hoy=asigna_fecha_hoy();

$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT * FROM TRABAJADORES where (tipo_nomina>='01' and tipo_nomina<='03') and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='REPOSO') ORDER BY cod_empleado";

$sql = "SELECT nom006.cod_empleado, nom006.nombre, nom006.cedula, nom006.Nacionalidad, nom006.fecha_ingreso, nom006.Status, nom006.tipo_nomina, nom001.Descripcion, nom006.cod_categoria, nom006.tipo_pago, nom006.cta_empleado, nom006.cod_banco, nom006.nombre_banco, nom006.cta_empresa, 
		         nom006.fecha_egreso, nom006.Cont_fijo, nom006.cedula_titular, nom006.campo_str1, nom006.campo_num1, nom007.nombre1, nom007.nombre2, nom007.apellido1, nom007.apellido2, nom007.Sexo,nom007.Edo_civil,nom007.fecha_nacimiento,nom007.edad, nom007.lugar_nacimiento,nom007.direccion,nom007.cod_jerarquia,
				 nom007.cod_postal,nom007.Profesion, nom007.Telefono,nom007.tlf_movil,nom007.Correo,nom007.Estado,nom007.Ciudad,NOM007.grado_inst, nom006.cod_cargo,nom004.Denominacion, nom006.cedula,nom006.cod_departam,nom005.Descripcion_dep,nom006.fecha_asigna_cargo, nom006.sueldo, nom006.compensacion, nom006.nombre, nom006.tipo_nomina, 
				 nom006.cod_tipo_personal, nom015.Des_tipo_personal, nom006.codigo_Ubicacion, nom058.Descripcion_Ubi FROM (nom006 LEFT JOIN nom007 ON (nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion), nom001, nom005, nom004, nom015 
				 where (nom006.tipo_nomina=nom001.tipo_nomina) and (nom006.cod_cargo=nom004.codigo_cargo) and (nom005.codigo_departamento=nom006.cod_departam) and (nom015.cod_tipo_personal=nom006.cod_tipo_personal) And (nom006.tipo_nomina>='01' and nom006.tipo_nomina<='03') and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='REPOSO') order BY nom006.cod_empleado";
			
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Trabajadores.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		   <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE TRABAJADORES</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="400" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NOMBRE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>CEDULA</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF"><strong>VENEZOLANO</strong></td> 
           <td width="150" align="center" bgcolor="#99CCFF"><strong>EXTRANJERO</strong></td>         
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>HOMBRE</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>MUJER</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>LUGAR NACIMIENTO</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>EDAD</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>EDO CIVIL</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>RAMA</strong></td>
		   <td width="400" align="center" bgcolor="#99CCFF" ><strong>CARGO</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>TIEMPO AÑO</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>TIEMPO MESES</strong></td>
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>SUELDO ANTES EMPLEADO</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>SUELDO ANTES OBRERO</strong></td>	
		   <td width="150" align="center" bgcolor="#99CCFF" ><strong>SUELDO EMPLEADO</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF" ><strong>SUELDO OBRERO</strong></td>

           <td width="150" align="center" bgcolor="#99CCFF" ><strong>CANT. CARGA</strong></td>		   
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $res=pg_query($sql);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nombre=conv_cadenas($registro["nombre"],0);
		   $nacionalidad=$registro["nacionalidad"]; $fecha_ingreso=$registro["fecha_ingreso"]; $grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"];
		   $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  
		   $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
		   $sueldo=$registro["sueldo"]; $denominacion=$registro["denominacion"]; $lugar_nacimiento=$registro["lugar_nacimiento"];  $cod_jerarquia=$registro["cod_jerarquia"];
		   if($nacionalidad="VENEZOLANO"){$ven="X"; $ext="";}else{$ven=""; $ext="X";}
		   if($sexo="MASCULINO"){$homb="X"; $muj="";}else{$homb=""; $muj="X";}
		   $rama="AN";
		   if($grado_inst=="PRIMARIA"){$rama="P";} if(($grado_inst=="BASICO")OR($grado_inst=="BACHILLER")){$rama="S";}
		   
		   if($grado_inst=="TECNICO MEDIO"){$rama="T";} 
		   if(($grado_inst=="TECNICO SUPERIOR")OR($grado_inst=="UNIVERSITARIO")OR($grado_inst=="MAESTRIA")OR($grado_inst=="DOCTORADO")){$rama="SUP";}
		   
		   $fecha1=$fecha_ingreso; $fecha2=$fecha_hoy; $f=diferencia_meses($fecha1,$fecha2);
		   
            $f=parte_entera_num($f); $a=$f/12; 
			$a=parte_entera_num($a); $m=$f-($a*12);
			$edad=parte_entera_num($edad); 
			
			$fecha_asigna=$registro["fecha_ingreso"]; $sueldo_ant=0;
			$fsql="Select cod_empleado,fecha_asigna,sueldo from nom008 where cod_empleado='$cod_empleado' and fecha_asigna<'2011-03-01' order by fecha_asigna desc";
			$fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $sueldo_ant=$freg["sueldo"];} 	
			
			$cant_carga=0;
			$fsql="Select * FROM NOM009 where cod_empleado='$cod_empleado' order by ci_partida";
			$fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){ $cant_carga=$filas;}
			
			$sueldo_emp=0; $sueldo_obr=0; $sueldo_emp_ant=0; $sueldo_obr_ant=0;
			if($cod_jerarquia=="04"){ $sueldo_obr=$sueldo; $sueldo_obr_ant=$sueldo_ant;} else{$sueldo_emp=$sueldo; $sueldo_emp_ant=$sueldo_ant; }			
			$sueldo=formato_monto($registro["sueldo"]); $sueldo_obr=formato_monto($sueldo_obr); $sueldo_emp=formato_monto($sueldo_emp);			
			$sueldo_obr_ant=formato_monto($sueldo_obr_ant); $sueldo_emp_ant=formato_monto($sueldo_emp_ant);
	?>	   
		   <tr>
           <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre; ?></td>
           <td width="100" align="left"><? echo $cedula; ?></td>
           <td width="150" align="center"><? echo $ven; ?></td>
           <td width="150" align="center"><? echo $ext; ?></td>
           <td width="100" align="center"><? echo $homb; ?></td>
           <td width="100" align="center"><? echo $muj; ?></td>
		   <td width="150" align="center"><? echo $lugar_nacimiento; ?></td>
		   <td width="100" align="right"><? echo $edad; ?></td>
		   <td width="100" align="center"><? echo substr($edo_civil,0,1); ?></td>
		   <td width="100" align="center"><? echo $rama; ?></td>
		   <td width="400" align="left"><? echo $denominacion; ?></td>
		   <td width="100" align="right"><? echo $a; ?></td>
           <td width="100" align="right"><? echo $m; ?></td>
		   <td width="150" align="right"><? echo $sueldo_emp_ant; ?></td>
		   <td width="150" align="right"><? echo $sueldo_obr_ant; ?></td>
		   <td width="150" align="right"><? echo $sueldo_emp; ?></td>
		   <td width="150" align="right"><? echo $sueldo_obr; ?></td>
		   <td width="150" align="right"><? echo $cant_carga; ?></td>
         </tr>
	<? }   ?>
	  </table><?
	  
pg_close();
	  
?>