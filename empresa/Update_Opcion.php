<?php include ("../class/conect.php"); include ("../class/funciones.php");
$opcion=$_GET["opcion"]; $criterio=$_GET["modulo"];$derecho=$_GET["derecho"];
$modulo=substr($criterio, 0, 2);$musuario=substr($criterio, 2, 15);$inicio=1;$fin=20;
$der1=substr($derecho, 0, 1);$der2=substr($derecho, 1, 1);$der3=substr($derecho, 2, 1);$der4=substr($derecho, 3, 1);$der5=substr($derecho, 4, 1);$der6=substr($derecho, 5, 1);
$der7=substr($derecho, 6, 1);$der8=substr($derecho, 7, 1);$der9=substr($derecho, 8, 1);$der10=substr($derecho, 9, 1);$der11=substr($derecho, 10, 1);
$der12=substr($derecho, 11, 1);$der13=substr($derecho, 12, 1);$der14=substr($derecho, 13, 1);$der15=substr($derecho, 14, 1);$der16=substr($derecho, 15, 1);$der17=substr($derecho, 16, 1);$der18=substr($derecho, 17, 1);$der19=substr($derecho, 18, 1);$der20=substr($derecho, 19, 1);
echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?php }
 else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_SIA006('$musuario','$modulo','$opcion',$inicio,$fin,'$der1','$der2','$der3','$der4','$der5','$der6','$der7','$der8','$der9','$der10','$der11','$der12','$der13','$der14','$der15','$der16','$der17','$der18','$der19','$der20')");
  $error=pg_errormessage($conn);$error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript"> muestra('<?php echo $error; ?>'); </script> <?php }
}pg_close();
?><script language="JavaScript" type="text/JavaScript">
function Llama_Acceso(modu){var url; url="Det_acceso.php?modulo="+modu; document.location = url; }</script><script language="JavaScript">Llama_Acceso('<?php echo $criterio; ?>'); </script>
