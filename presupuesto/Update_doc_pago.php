<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_pago=$_POST["txtdoc_pago"]; $Nombre_doc_pago=$_POST["txtnombre_doc_pago"];
$Nombre_Abrev=$_POST["txtnombre_abrev"];$Refiera_a=$_POST["txtRefierea"];
$Afecta_Presup=$_POST["TxtAfecta"];$Doc_pagoA="";$Nombre_doc_pagoA="";
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
$url="Mod_doc_pago.php?GDoc_pago=".$Doc_pago;echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre004 WHERE tipo_pago='$Doc_pago'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('DOCUMENTO COMPROMISO NO EXISTE');</script> <? } 
   else{  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE004(2,'$Doc_pago','$Nombre_doc_pago','$Nombre_Abrev','$Refiera_a','$Afecta_Presup','$MInf_Usuario')");
     $error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?>  <script language="JavaScript">  muestra('<? echo $error; ?>');  </script>  <? }
      else{    $Doc_pagoA="A".substr($Doc_pago,1,3);        $Nombre_doc_pagoA = $Nombre_doc_pago." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE004(2,'$Doc_pagoA','$Nombre_doc_pagoA','ANU','$Refiera_a','$Afecta_Presup','$MInf_Usuario')");
        $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
         else{?> <script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script>      <? }
       }
  }
}
pg_close();
?>
<script language="JavaScript">history.back();</script>