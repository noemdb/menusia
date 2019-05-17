<?include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502=""; $campo503=$_POST["txtperiodo"]; $campo504=$_POST["txtformato"];
$campo="N";$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo="S";$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo505=$_POST["txtactivot"]; $campo506=$_POST["txtpasivot"]; $campo507=$_POST["txtactivoh"]; $campo508=$_POST["txtpasivoh"];
$campo510=$_POST["txtingreso"]; $campo509=$_POST["txtegreso"];$campo511=$_POST["txtresultado"]; $campo512=$_POST["txtcapital"]; 
$campo513=$_POST["txtsit_finan"]; $campo514=$_POST["txtsit_fiscal"]; $campo515=$_POST["txtejec_presup"]; $campo516=$_POST["txthacienda"];
$campo517=$_POST["txtsuperavit"]; $campo518=$_POST["txtcaja"];$campo519=$_POST["txtfondo_avance"]; $campo520=$_POST["txtanticipo"];
$url="Act_Conf_Contab_Fiscal.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;
  if($error==0){$sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACION NO EXISTE');</script> <? }
   else{$error=0;
     $sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','$campo511','$campo512','$campo513','$campo514','$campo515','$campo516','$campo517','$campo518','$campo519','$campo520','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
	 $sql="SELECT MODIFICA_SIA005('03','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','$campo511','$campo512','$campo513','$campo514','$campo515','$campo516','$campo517','$campo518','$campo519','$campo520','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     echo $sql;
  }}
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
