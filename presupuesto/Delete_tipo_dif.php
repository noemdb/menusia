<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_diferido=$_GET["txttipo_diferido"];$nombre_tipo_dife="";
$nombre_abrev="";$tipo_diferidooA="";$nombre_tipo_difeA="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre024 WHERE tipo_diferido='$tipo_diferido'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE DIFERIDO NO EXISTE'); </script> <? }
   else{$error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE024(3,'$tipo_diferido','$nombre_tipo_dife','$nombre_abrev')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{ $tipo_diferidoA="A".substr($tipo_diferido,1,3);
        $nombre_tipo_difeA = $nombre_tipo_dife." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE024(3,'$tipo_diferidoA','$nombre_tipo_difeA','ANU')");
        $error=pg_errormessage($conn); $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script>      <? }
       }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_tipo_diferido.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>