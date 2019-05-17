<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_causado=$_POST["txtdoc_causado"];
$Nombre_doc_causado=$_POST["txtnombre_doc_causado"];
$Nombre_Abrev=$_POST["txtnombre_abrev"];
$Refiera_a_Comp=$_POST["txtRefiereComp"];
$Afecta_Presup=$_POST["TxtAfecta"];
$Doc_causadoA="";
$Nombre_doc_causadoA="";
$equipo = getenv("COMPUTERNAME");
$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
$url="Mod_doc_causado.php?GDoc_causado=".$Doc_causado;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $sSQL="Select * from pre003 WHERE tipo_causado='$Doc_causado'";
  $resultado=pg_exec($conn,$sSQL);
  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('DOCUMENTO COMPROMISO NO EXISTE');</script> <? } 
   else{
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(2,'$Doc_causado','$Nombre_doc_causado','$Nombre_Abrev','$Refiera_a_Comp','$Afecta_Presup','$MInf_Usuario')");
     $error=pg_errormessage($conn);
     $error=substr($error, 0, 61);
    if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{
        $Doc_causadoA="A".substr($Doc_causado,1,3);
        $Nombre_doc_causadoA = $Nombre_doc_causado." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(2,'$Doc_causadoA','$Nombre_doc_causadoA','ANU','$Refiera_a_Comp','$Afecta_Presup','$MInf_Usuario')");
        $error=pg_errormessage($conn);
        $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script>      <? }
       }
  }
}
pg_close();
?>
<script language="JavaScript">history.back();</script>