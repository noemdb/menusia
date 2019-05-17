<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_partida=$_GET["Gpartida"];$den_partida="";$func_inv="";$aplicacion="";$cod_contable="";$ord_cord="O";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from PRE098 WHERE cod_partida='$cod_partida'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PARTIDA NO EXISTE');  </script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE098(3,'$cod_partida','$den_partida','$aplicacion','$ord_cord','$func_inv','$cod_contable')");
     $error=pg_errormessage($conn);   $error=substr($error,0,91);   if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }      else{$error= "ELIMINO EXITOSAMENTE"; ?><script language="JavaScript"> muestra('<? echo $error; ?>'); </script>         <? }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_clasificador.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>