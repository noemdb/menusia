<?include ("../class/conect.php");  include ("../class/funciones.php");
$Tipo_Asiento=$_POST["txtTipo_Asiento"];$Des_Asiento=$_POST["txtDes_Tipo_Asi"];$url="Mod_tipo_asiento.php?GTipo_Asiento=".$Tipo_Asiento;
echo "ESPERE POR FAVOR MODIFICANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn))  { ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{$sSQL="Select * from con009 WHERE tipo_asiento='$Tipo_Asiento'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){?>  <script language="JavaScript">  muestra('TIPO DE ASIENTO NO EXISTE');  </script>  <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_CON009(2,'$Tipo_Asiento','$Des_Asiento','','',0,0,'EDUARDO-PORTATIL')");
     $error=pg_errormessage($conn);     $error=substr($error,0,91);     if (!$resultado){     ?>  <script language="JavaScript">  muestra('<? echo $error; ?>');   </script>   <? }
      else{?> <script language="JavaScript">   muestra('MODIFICO EXITOSAMENTE');   </script>  <? }
  }
}
pg_close();
?>
<script language="JavaScript">LlamarURL('<?echo $url;?>');</script>