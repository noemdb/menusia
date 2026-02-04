<?php include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502=""; $campo503=$_POST["txtperiodo"]; $campo504=$_POST["txtformato"];
$campo=$_POST["txtnro_aut"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtcomp_dif"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtrevisa_dif"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo505=$_POST["txtactivo"]; $campo506=$_POST["txtpasivo"]; $campo507=$_POST["txtingreso"]; $campo508=$_POST["txtegreso"]; $campo509=$_POST["txtresultado"]; $campo510=$_POST["txtcapital"]; $campo511=$_POST["txtorden"]; $campo512=$_POST["txtresultadoe"]; $campo513=$_POST["txtresul_ant"]; $campo514=$_POST["txtcaja"];  $campo516=$_POST["txtanticipo"]; $campo517=$_POST["txtcosto"];
$url="Act_Conf_Contab_Finac.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?php }
 else{ $error=0;
  if($error==0){$sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACIÓN NO EXISTE');</script> <?php }
   else{$error=0;
     $sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','$campo511','$campo512','$campo513','$campo514','','$campo516','$campo517','','','','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<?php echo $error; ?>'); </script> <?php } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><?php $error=0; }
  }}
}pg_close();?> <script language="JavaScript"> LlamarURL('<?php echo $url;?>'); </script>
