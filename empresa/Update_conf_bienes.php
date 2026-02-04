<?php include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502=""; $campo503=$_POST["txtperiodo"]; $campo504=$_POST["txtformato_bien"]; $campo549=$_POST["txtlong_num_bien"]; 
$campo="N";$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo="N";$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtgencaus_p"]; $campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtnumbien_unico"]; $campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtvalida_des"]; $campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo="N";$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtmod_dep"]; $campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo509=$_POST["txtdoc_caus_inm"]; $campo510=$_POST["txtdoc_caus_mue"]; $campo511=$_POST["txtdoc_caus_sem"];   $campo512=$_POST["txtcod_fuente"];
$campo513=$_POST["txtdoc_comp"];   $campo514=$_POST["txtref_comp"];
if(is_numeric($campo549)){$campo549=$campo549;} else{$campo549=0;}  
$url="Act_Conf_Bienes.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2011-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?php }
 else{ $error=0;
  if($error==0){$sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACIÓN NO EXISTE');</script> <?php }
   else{$error=0;
     $sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','','','','','$campo509','$campo510','$campo511','$campo512','$campo513','$campo514','','','','','','','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,$campo549,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<?php echo $error; ?>'); </script> <?php } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><?php $error=0; }
  }}
}pg_close();?> <script language="JavaScript"> LlamarURL('<?php echo $url;?>'); </script>
