<?include ("../class/conect.php");  include ("../class/funciones.php");
$Doc_pago=$_POST["txtdoc_pago"];$Nombre_doc_pago=$_POST["txtnombre_doc_pago"];$Nombre_Abrev=$_POST["txtnombre_abrev"];
$Refiera_a=$_POST["txtRefierea"];$Afecta_Presup=$_POST["TxtAfecta"];$Doc_pagoA="";$Nombre_doc_pagoA="";
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sSQL="Select * from pre004 WHERE tipo_pago='$Doc_pago'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('DOCUMENTO COMPROMISO YA EXISTE');  </script> <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE004(1,'$Doc_pago','$Nombre_doc_pago','$Nombre_Abrev','$Refiera_a','$Afecta_Presup','$MInf_Usuario')");
     $error=pg_errormessage($conn);    $error=substr($error, 0, 61);
     if (!$resultado){  ?>  <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{ $Doc_pagoA="A".substr($Doc_pago,1,3);       $Nombre_doc_pagoA = $Nombre_doc_pago." (ANULADO)";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE004(1,'$Doc_pagoA','$Nombre_doc_pagoA','ANU','$Refiera_a','$Afecta_Presup','$MInf_Usuario')");
        $error=pg_errormessage($conn);      $error=substr($error, 0, 61);
        if (!$resultado){?> <script language="JavaScript">  muestra('<? echo $error; ?>');  </script> <? }
         else{$error=0; ?> <script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');  </script> <? }
        }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_doc_pago.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>