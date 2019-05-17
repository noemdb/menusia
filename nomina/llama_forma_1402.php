<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="FORMA".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_empleado=$_GET["txtcod_empleado"];  $fecha_hoy=asigna_fecha_hoy();
?>
<html>
<head>  <title>CARGAR FORMA 1402</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$error=1; $nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $rif_empleado=""; $fecha_ing=""; $fecha_ing_a=""; $ultima_fecha="2015-01-01"; $frec="Q";
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $campo_str1=""; $des_cargo="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $cod_cargo=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo="";
$sueldo=0; 
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"];   $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"];   $fecha_ingreso=formato_ddmmaaaa($fecha_ing);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_a);  
  $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"];  $cod_cargo=$registro["cod_cargo"]; $direccion=$registro["direccion"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  
}
IF($nacionalidad=="VENEZOLANO"){$cod_nro="1-";}else{$cod_nro="2-";}
$sueldo_basico=$sueldo; $nro_asegurado=$cod_nro.elimina_puntos($cedula);  $cod_suc=""; $cond_trab=$status; $cod_ocupacion="";
$salario_semanal=($sueldo*12)/52;
$sql="Select * FROM NOM004 where codigo_cargo='$cod_cargo'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $des_cargo=$registro["denominacion"];  }

$salario_semanal=formato_monto($salario_semanal);

$nombref1="";$parentescof1=""; $sexof1=""; $edadf1=0; $fecha_nacf1=""; $cedulaf1="";
$nombref2="";$parentescof2=""; $sexof2=""; $edadf2=0; $fecha_nacf2=""; $cedulaf2="";
$nombref3="";$parentescof3=""; $sexof3=""; $edadf3=0; $fecha_nacf3=""; $cedulaf3="";
$nombref4="";$parentescof4=""; $sexof4=""; $edadf4=0; $fecha_nacf4=""; $cedulaf4="";
$nombref5="";$parentescof5=""; $sexof5=""; $edadf5=0; $fecha_nacf5=""; $cedulaf5="";
$nombref6="";$parentescof6=""; $sexof6=""; $edadf6=0; $fecha_nacf6=""; $cedulaf6="";
$sql="SELECT * FROM NOM009 where cod_empleado='$cod_empleado' order by ci_partida"; $res=pg_query($sql); $i=0;
while($registro=pg_fetch_array($res)){ $i=$i+1;
  if($i==1){$nombref1=$registro["nombre"]; $cedulaf1=$registro["ci_partida"]; $parentescof1=$registro["parentesco"];  $sexof1=$registro["sexo"]; $edadf1=$registro["edad"]; $edadf1=round($edadf1); $sfecha=$registro["fecha_nac"];  $fecha_nacf1=formato_ddmmaaaa($sfecha); }
  if($i==2){$nombref2=$registro["nombre"]; $cedulaf2=$registro["ci_partida"]; $parentescof2=$registro["parentesco"];  $sexof2=$registro["sexo"]; $edadf2=$registro["edad"]; $edadf2=round($edadf2); $sfecha=$registro["fecha_nac"];  $fecha_nacf2=formato_ddmmaaaa($sfecha); }
  if($i==3){$nombref3=$registro["nombre"]; $cedulaf3=$registro["ci_partida"]; $parentescof3=$registro["parentesco"];  $sexof3=$registro["sexo"]; $edadf3=$registro["edad"]; $edadf3=round($edadf3); $sfecha=$registro["fecha_nac"];  $fecha_nacf3=formato_ddmmaaaa($sfecha); }
  if($i==4){$nombref4=$registro["nombre"]; $cedulaf4=$registro["ci_partida"]; $parentescof4=$registro["parentesco"];  $sexof4=$registro["sexo"]; $edadf4=$registro["edad"]; $edadf4=round($edadf4); $sfecha=$registro["fecha_nac"];  $fecha_nacf4=formato_ddmmaaaa($sfecha); }
  if($i==5){$nombref5=$registro["nombre"]; $cedulaf5=$registro["ci_partida"]; $parentescof5=$registro["parentesco"];  $sexof5=$registro["sexo"]; $edadf5=$registro["edad"]; $edadf5=round($edadf5); $sfecha=$registro["fecha_nac"];  $fecha_nacf5=formato_ddmmaaaa($sfecha); }
  if($i==6){$nombref6=$registro["nombre"]; $cedulaf6=$registro["ci_partida"]; $parentescof6=$registro["parentesco"];  $sexof6=$registro["sexo"]; $edadf6=$registro["edad"]; $edadf6=round($edadf6); $sfecha=$registro["fecha_nac"];  $fecha_nacf6=formato_ddmmaaaa($sfecha); }
}
?>
<form name="form2" method="post" action="/sia/nomina/rpt/Datos_forma_1402.php">
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
	 <td width="5"><input name="txtnombref1" type="hidden" id="txtnombref1" value="<?echo $nombref1?>" ></td>
     <td width="5"><input name="txtparentescof1" type="hidden" id="txtparentescof1" value="<?echo $parentescof1?>" ></td>
     <td width="5"><input name="txtsexof1" type="hidden" id="txtsexof1" value="<?echo $sexof1?>" ></td>
	 <td width="5"><input name="txtedadf1" type="hidden" id="txtedadf1" value="<?echo $edadf1?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf1" type="hidden" id="txtfecha_nacf1" value="<?echo $fecha_nacf1?>" ></td>	
	 <td width="5"><input name="txtcedulaf1" type="hidden" id="txtcedulaf1" value="<?echo $cedulaf1?>" ></td>
	 
	 <td width="5"><input name="txtnombref2" type="hidden" id="txtnombref2" value="<?echo $nombref2?>" ></td>
     <td width="5"><input name="txtparentescof2" type="hidden" id="txtparentescof2" value="<?echo $parentescof2?>" ></td>
     <td width="5"><input name="txtsexof2" type="hidden" id="txtsexof2" value="<?echo $sexof2?>" ></td>
	 <td width="5"><input name="txtedadf2" type="hidden" id="txtedadf2" value="<?echo $edadf2?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf2" type="hidden" id="txtfecha_nacf2" value="<?echo $fecha_nacf2?>" ></td>	
	 <td width="5"><input name="txtcedulaf2" type="hidden" id="txtcedulaf2" value="<?echo $cedulaf2?>" ></td>	
     <td width="5"><input name="txtnombref3" type="hidden" id="txtnombref3" value="<?echo $nombref3?>" ></td>
     <td width="5"><input name="txtparentescof3" type="hidden" id="txtparentescof3" value="<?echo $parentescof3?>" ></td>
     <td width="5"><input name="txtsexof3" type="hidden" id="txtsexof3" value="<?echo $sexof3?>" ></td>
	 <td width="5"><input name="txtedadf3" type="hidden" id="txtedadf3" value="<?echo $edadf3?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf3" type="hidden" id="txtfecha_nacf3" value="<?echo $fecha_nacf3?>" ></td>	
	 <td width="5"><input name="txtcedulaf3" type="hidden" id="txtcedulaf3" value="<?echo $cedulaf3?>" ></td>	
     <td width="5"><input name="txtnombref4" type="hidden" id="txtnombref4" value="<?echo $nombref4?>" ></td>
     <td width="5"><input name="txtparentescof4" type="hidden" id="txtparentescof4" value="<?echo $parentescof4?>" ></td>
     <td width="5"><input name="txtsexof4" type="hidden" id="txtsexof4" value="<?echo $sexof4?>" ></td>
	 <td width="5"><input name="txtedadf4" type="hidden" id="txtedadf4" value="<?echo $edadf4?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf4" type="hidden" id="txtfecha_nacf4" value="<?echo $fecha_nacf4?>" ></td>	
	 <td width="5"><input name="txtcedulaf4" type="hidden" id="txtcedulaf4" value="<?echo $cedulaf4?>" ></td>	
     <td width="5"><input name="txtnombref5" type="hidden" id="txtnombref5" value="<?echo $nombref5?>" ></td>
     <td width="5"><input name="txtparentescof5" type="hidden" id="txtparentescof5" value="<?echo $parentescof5?>" ></td>
     <td width="5"><input name="txtsexof5" type="hidden" id="txtsexof5" value="<?echo $sexof5?>" ></td>
	 <td width="5"><input name="txtedadf5" type="hidden" id="txtedadf5" value="<?echo $edadf5?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf5" type="hidden" id="txtfecha_nacf5" value="<?echo $fecha_nacf5?>" ></td>	
	 <td width="5"><input name="txtcedulaf5" type="hidden" id="txtcedulaf5" value="<?echo $cedulaf5?>" ></td>	
     <td width="5"><input name="txtnombref6" type="hidden" id="txtnombref6" value="<?echo $nombref6?>" ></td>
     <td width="5"><input name="txtparentescof6" type="hidden" id="txtparentescof6" value="<?echo $parentescof6?>" ></td>
     <td width="5"><input name="txtsexof6" type="hidden" id="txtsexof6" value="<?echo $sexof6?>" ></td>
	 <td width="5"><input name="txtedadf6" type="hidden" id="txtedadf6" value="<?echo $edadf6?>" ></td>	 
	 <td width="5"><input name="txtfecha_nacf6" type="hidden" id="txtfecha_nacf6" value="<?echo $fecha_nacf6?>" ></td>	
	 <td width="5"><input name="txtcedulaf6" type="hidden" id="txtcedulaf6" value="<?echo $cedulaf6?>" ></td>
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