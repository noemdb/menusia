<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_dependencia=$_POST["txtcod_dependencia"]; $denominacion_dep=$_POST["txtdenominacion_dep"]; $cod_region=$_POST["txtcod_region"]; $cod_entidad=$_POST["txtcod_entidad"]; $cod_municipio=$_POST["txtcod_municipio"]; $cod_ciudad=$_POST["txtcod_ciudad"]; $cod_parroquia=$_POST["txtcod_parroquia"]; $direccion_dep=$_POST["txt_direccion_dep"]; 
$cod_postal_dep=$_POST["txtcod_postal_dep"]; $telefonos_dep=$_POST["txttelefonos_dep"]; $ci_contacto=$_POST["txtced_responsable"]; $nombre_contacto=$_POST["txtnombre_respp"]; $distrito=$_POST["txtdistrito"]; $cod_alterno=$_POST["txtcod_alterno"];  
$saldo_inicial=$_POST["txtsaldo_inicial"]; $saldo_inicial=formato_numero($saldo_inicial);  if(is_numeric($saldo_inicial)){$saldo_inicial=$saldo_inicial;}else{$saldo_inicial=0;}
$url="Act_dependencias_ar.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN001 WHERE cod_dependencia='$cod_dependencia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPENDENCIA NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN001(2,'$cod_dependencia','$denominacion_dep','$cod_region','$cod_entidad','$cod_municipio','$cod_ciudad','$cod_parroquia','$direccion_dep','$cod_postal_dep','$telefonos_dep','$ci_contacto','$nombre_contacto','$distrito','$cod_alterno',$saldo_inicial,'','','','',0.00,0.00,'')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
