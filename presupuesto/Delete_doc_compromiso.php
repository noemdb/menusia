<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_compromiso=$_GET["txtdoc_compromiso"];$Nombre_doc_compromiso="";$Nombre_Abrev="";$Doc_compromisoA="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre002 WHERE tipo_compromiso='$Doc_compromiso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">    muestra('DOCUMENTO COMPROMISO NO EXISTE');  </script> <? }
   else{     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(3,'$Doc_compromiso','','','','','','','',0,0,'')");
     $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{        $Doc_compromisoA="A".substr($Doc_compromiso,1,3);
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE002(3,'$Doc_compromisoA','','','','','','','',0,0,'')");
        $error=pg_errormessage($conn);        $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }         else{?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script>      <? }
        }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_doc_compromiso.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>