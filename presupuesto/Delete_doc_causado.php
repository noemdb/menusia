<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_causado=$_GET["txtdoc_causado"];$Nombre_doc_causado="";$Nombre_Abrev="";$Doc_causadoA="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre003 WHERE tipo_causado='$Doc_causado'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">      muestra('DOCUMENTO CAUSADO NO EXISTE');  </script>  <? }
   else{   $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(3,'$Doc_causado','','','','','')");   $error=pg_errormessage($conn);    $error=substr($error, 0, 61);
     if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{  $Doc_causadoA="A".substr($Doc_causado,1,3);
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(3,'$Doc_causadoA','','','','','')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script>      <? }
        }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_doc_causado.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>