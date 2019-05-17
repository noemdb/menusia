<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"]; $fecha_hoy=asigna_fecha_hoy();
$desde="01".substr($fecha_hoy,2,8); $hasta=colocar_udiames($fecha_hoy);
$fecha_d=formato_aaaammdd($desde); $fecha_h=formato_aaaammdd($hasta);
$url="Det_inc_facret_orden.php?codigo_mov=".$codigo_mov;  echo "CARGANDO FACTURAS....","<br>"; $error=0; $ced_rif="";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";    $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA RIF NO VALIDO');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $ced_rif=$registro["ced_rif"];  $tipo_ret_d=$registro["tipo_causado"];  $tipo_ret_h=$registro["cod_contable_o"];  echo $ced_rif;
      $res=pg_exec($conn,"SELECT BORRAR_PAG039('$codigo_mov')");  $error=pg_errormessage($conn); 
	  $resultado=pg_exec($conn,"SELECT CARGA_pag039 ('$codigo_mov','$ced_rif','$fecha_d','$fecha_h')");  echo "SELECT CARGA_pag039 ('$codigo_mov','$ced_rif','$fecha_d','$fecha_h')";
	  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
      if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
?> <script language="JavaScript">  document.location ='<? echo $url; ?>' </script>
