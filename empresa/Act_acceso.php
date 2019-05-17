<?include ("../class/conect.php");include ("../class/funciones.php");$opcion=$_GET["opcion"];$criterio=$_GET["modulo"];$modulo=substr($criterio, 0, 2); $usuario=substr($criterio, 2, 15);
echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{   $resultado=pg_exec($conn,"SELECT ACT_SIA006_LOTE($opcion,'$usuario','$modulo')");   $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
}
pg_close();
?> <script language="JavaScript" type="text/JavaScript">function Llama_Acceso(user,modu){var url; url="Acc_usuario.php?GUsuario="+user+"&Gmodulo="+modu;  document.location = url;} </script>
<script language="JavaScript">Llama_Acceso('<? echo $usuario; ?>','<? echo $modulo; ?>');</script>
