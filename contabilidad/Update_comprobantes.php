<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha=$_POST["txtFecha"];$referencia=$_POST["txtReferencia"];
$tipo_Comp=$_POST["txttipo_comp"];$tipo_asiento=$_POST["txttipo_asiento"];$codigo_mov=$_POST["txtcodigo_mov"];$descripcion=$_POST["txtDescripcion"];
$ced_rif = $_POST["txtcodigo_mov"];$status = $_POST["txtstatus"];$nro_comprobante = $_POST["txtnro_comprobante"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO COMPROBANTE....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
  $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_Comp'";  $resultado=pg_query($sSql); $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO EXISTE');</script><? }
   else{   $registro=pg_fetch_array($resultado);   $adescripcion=$registro["descripcion"];
     if ($registro["modulo"]=="C"||$registro["modulo"]=="I"||$registro["modulo"]=="O"){$error=0;}else{$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE NO PUEDE SER MODIFICADO');</script><?}
     if ($error==0){ $sqlg="SELECT MODIFICA_CON002('$codigo_mov','$referencia','$sfecha','$tipo_asiento','$tipo_Comp','$status','$nro_comprobante','$ced_rif','$descripcion')";
      $resultado=pg_exec($conn,$sqlg);   $error=pg_errormessage($conn); $error=substr($error,0,91); echo $sqlg;
      if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       else{ $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);
         if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }     ?> <script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script> <?
         $desc_doc="COMPROBANTE: FECHA:".$sfecha.", REFERENCIA:".$referencia.", TIPO ASIENTO:".$tipo_asiento.", DESCRIPCION:".$adescripcion;     $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);  $error=substr($error,0,91);  if (!$resultado){?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       }
     }
  }
}
pg_close();?><script language="JavaScript">//history.back();</script>