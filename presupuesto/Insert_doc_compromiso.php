<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_Compromiso=$_POST["txtdoc_compromiso"];$Nombre_doc_compromiso=$_POST["txtnombre_doc_compromiso"];
$Nombre_Abrev=$_POST["txtnombre_abrev"];$Doc_CompromisoA="";$Nombre_doc_compromisoA="";
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from pre002 WHERE tipo_compromiso='$Doc_Compromiso'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('DOCUMENTO COMPROMISO YA EXISTE');  </script> <? }
   else{     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(1,'$Doc_Compromiso','$Nombre_doc_compromiso','$Nombre_Abrev','N','','','','',0,0,'$MInf_Usuario')");
     $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){  ?>  <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{        $Doc_CompromisoA="A".substr($Doc_Compromiso,1,3);        $Nombre_doc_compromisoA = $Nombre_doc_compromiso." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(1,'$Doc_CompromisoA','$Nombre_doc_compromisoA','ANU','N','','','','',0,0,'$MInf_Usuario')");
        $error=pg_errormessage($conn);       $error=substr($error, 0, 61);
        if (!$resultado){?> <script language="JavaScript">  muestra('<? echo $error; ?>');  </script> <? }
         else{$error=0; ?> <script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');  </script> <? }
        }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_doc_compromiso.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>