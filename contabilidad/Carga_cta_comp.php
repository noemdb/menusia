<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"];$fecha=$_POST["txtfecha"]; $referencia=$_POST["txtreferencia"]; 
$tipo_asiento=$_POST["txttipo_asiento"]; $tp_carga=$_POST["txttp_carga"];
 echo "ESPERE POR FAVOR CARGANDO....","<br>"; if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{ $res=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $sSQL="Select * from COMPROBANTES where text(fecha)='$sfecha' and referencia='$referencia' and tipo_asiento='$tipo_asiento'";
  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('COMPROBANTE A CARGAR NO LOCALIZADO'); </script>    <? }
   else{ $registro=pg_fetch_array($resultado); $tipo_comp=$registro["tipo_comp"];	 
	 $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta"; $res=pg_query($sql);
     while($registro=pg_fetch_array($res)){  $debito_credito=$registro["debito_credito"]; if($tp_carga=="REVERSO"){ if($debito_credito=="D"){$debito_credito="C";}else{$debito_credito="D";} }
	   $codigo_cuenta=$registro["cod_cuenta"];  $monto_asiento=$registro["monto_asiento"]; $descripcion_a= $registro["descripcion_a"];
	   $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','C','S','01','0','$descripcion_a')");
	   $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       echo "SELECT INCLUYE_CON008('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','C','S','01','0','$descripcion_a')","<br>";
	 }
  }
}
pg_close();?>
<script language="JavaScript">document.location ='Det_inc_comprobantes.php?codigo_mov=<?echo $codigo_mov?>';</script>

