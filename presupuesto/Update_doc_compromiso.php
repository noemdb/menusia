<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_compromiso=$_POST["txtdoc_compromiso"]; $Nombre_doc_compromiso=$_POST["txtnombre_doc_compromiso"];
$Nombre_Abrev=$_POST["txtnombre_abrev"];$Doc_compromisoA="";$Nombre_doc_compromisoA="";
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
$url="Mod_doc_compromiso.php?GDoc_compromiso=".$Doc_compromiso;echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre002 WHERE tipo_compromiso='$Doc_compromiso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('DOCUMENTO COMPROMISO NO EXISTE');</script> <? }
   else{
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(2,'$Doc_compromiso','$Nombre_doc_compromiso','$Nombre_Abrev','N','','','','',0,0,'$MInf_Usuario')");
     $error=pg_errormessage($conn);     $error=substr($error, 0, 61);     if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{        $Doc_compromisoA="A".substr($Doc_compromiso,1,3);        $Nombre_doc_compromisoA = $Nombre_doc_compromiso." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(2,'$Doc_compromisoA','$Nombre_doc_compromisoA','ANU','N','','','','',0,0,'$MInf_Usuario')");
        $error=pg_errormessage($conn);        $error=substr($error, 0, 61);        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script>      <? }
       }
  }
}
pg_close();
?>
<script language="JavaScript">history.back();</script>