<?include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502=""; $campo503=$_POST["txtperiodo"]; $campo504=$_POST["txtformato"]; $campo522=$_POST["txttitulo"]; $campo549=strlen($campo504);
$campo521=$_POST["txtcta_ing_dep"]; $campo523=$_POST["txtcta_dep_noiden"]; $campo524=$_POST["txtcta_imp_ret"]; $campo526=$_POST["txtcta_dep_ingade"];  $campo525=$_POST["txtcta_imp_iva"];
$campo527=$_POST["txtcta_fond_gar"];  $campo528=$_POST["txtcta_fond_res"];
 
$campo=$_POST["txtreg_mov"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtgen_comp"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo505=$_POST["txtnomb1"];$campo506=$_POST["txtabrev1"]; $campo507=$_POST["txtnomb2"];$campo508=$_POST["txtabrev2"];
$campo509=$_POST["txtnomb3"];$campo510=$_POST["txtabrev3"]; $campo511=$_POST["txtnomb4"];$campo512=$_POST["txtabrev4"];
$campo513=$_POST["txtnomb5"];$campo514=$_POST["txtabrev5"]; $campo515=$_POST["txtnomb6"];$campo516=$_POST["txtabrev6"];
$campo517=$_POST["txtnomb7"];$campo518=$_POST["txtabrev7"]; $campo519=$_POST["txtnomb8"];$campo520=$_POST["txtabrev8"];
$campo522=$campo506; if(strlen($campo508)>0){$campo522=$campo522.'-'.$campo508;}  if(strlen($campo510)>0){$campo522=$campo522.'-'.$campo510;} if(strlen($campo512)>0){$campo522=$campo522.'-'.$campo512;} if(strlen($campo514)>0){$campo522=$campo522.'-'.$campo514;} if(strlen($campo516)>0){$campo522=$campo522.'-'.$campo516;} if(strlen($campo518)>0){$campo522=$campo522.'-'.$campo518;} if(strlen($campo520)>0){$campo522=$campo522.'-'.$campo520;}
$url="Act_Conf_Ingresos.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACIÓN NO EXISTE');</script> <? }
   else{$sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','$campo511','$campo512','$campo513','$campo514','$campo515','$campo516','$campo517','$campo518','$campo519','$campo520','$campo521','$campo522','$campo523','$campo524','$campo525','$campo526','$campo527','$campo528','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,$campo549,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>