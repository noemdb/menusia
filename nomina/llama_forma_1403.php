<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="FORMA".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_empleado=$_GET["txtcod_empleado"];  $fecha_hoy=asigna_fecha_hoy();
?>
<html>
<head>  <title>CARGAR FORMA 1403</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$error=1; $nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $rif_empleado=""; $fecha_ing=""; $fecha_ing_a=""; $ultima_fecha="2015-01-01"; $frec="Q";
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $campo_str1=""; $des_cargo=""; $fecha_egreso="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $cod_cargo=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo="";
$sueldo=0; 
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"];   $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"];   $fecha_ingreso=formato_ddmmaaaa($fecha_ing);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_a);  
  $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"];  $cod_cargo=$registro["cod_cargo"]; $direccion=$registro["direccion"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $fecha_egreso=$registro["fecha_egreso"]; $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
}
IF($nacionalidad=="VENEZOLANO"){$cod_nro="1-";}else{$cod_nro="2-";}
$sueldo_basico=$sueldo; $nro_asegurado=$cod_nro.elimina_puntos($cedula);  $cod_suc=""; $cond_trab=$status; $cod_ocupacion="";
$salario_semanal=($sueldo*12)/52;
$sql="Select * FROM NOM004 where codigo_cargo='$cod_cargo'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $des_cargo=$registro["denominacion"];  }

$salario_semanal=formato_monto($salario_semanal);

?>
<form name="form2" method="post" action="/sia/nomina/rpt/Datos_forma_1403.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
	 <td width="5"><input name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
	 <td width="5"><input name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="<?echo $fecha_ingreso?>" ></td>
	 <td width="5"><input name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
	 <td width="5"><input name="txtnacionalidad" type="hidden" id="txtnacionalidad" value="<?echo $nacionalidad?>"></td>
	 <td width="5"><input name="txtnro_asegurado" type="hidden" id="txtnro_asegurado" value="<?echo $nro_asegurado?>" ></td>
	 <td width="5"><input name="txtcod_suc" type="hidden" id="txtcod_suc" value="<?echo $cod_suc?>"></td>
	 <td width="5"><input name="txtfecha_nacimiento" type="hidden" id="txtfecha_nacimiento" value="<?echo $fecha_nacimiento?>" ></td>
	 <td width="5"><input name="txtcond_trab" type="hidden" id="txtcond_trab" value="<?echo $cond_trab?>"></td>
	 <td width="5"><input name="txtsexo" type="hidden" id="txtsexo" value="<?echo $sexo?>"></td>
	 <td width="5"><input name="txtsalario_semanal" type="hidden" id="txtsalario_semanal" value="<?echo $salario_semanal?>"></td>
	 <td width="5"><input name="txtdireccion" type="hidden" id="txtdireccion" value="<?echo $direccion?>"></td>
	 
	 <td width="5"><input name="txtocupacion" type="hidden" id="txtocupacion" value="<?echo $des_cargo?>"></td>
	 <td width="5"><input name="txtcod_ocupacion" type="hidden" id="txtcod_ocupacion" value="<?echo $cod_ocupacion?>"></td>	
	 <td width="5"><input name="txtfecha_egreso" type="hidden" id="txtfecha_egreso" value="<?echo $fecha_egreso?>" ></td>
	 
     <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
	 <td width="5"><input name="txtnom_emp" type="hidden" id="txtnom_emp" value="<?echo $Nom_Emp?>" ></td> 
	 
	 
	 
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();
/* */
if ($error==0){?><script language="JavaScript">Llamar_Inc_Calculo('S');</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }

?>