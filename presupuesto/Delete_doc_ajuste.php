<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_ajuste=$_GET["txtdoc_ajuste"];$Nombre_doc_ajuste="";$Nombre_Abrev="";$Doc_ajusteA="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $sSQL="Select * from pre005 WHERE tipo_ajuste='$Doc_ajuste'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('DOCUMENTO AJUSTE NO EXISTE'); </script> <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE005(3,'$Doc_ajuste','','','','')");     $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){ ?>  <script language="JavaScript">   muestra('<? echo $error; ?>');   </script>  <? }
      else{ $Doc_ajusteA="A".substr($Doc_ajuste,1,3);     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE005(3,'$Doc_ajusteA','','','','')");
        $error=pg_errormessage($conn);       $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script>      <? }
        }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_doc_ajuste.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>