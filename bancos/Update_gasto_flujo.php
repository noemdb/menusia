<?include ("../class/conect.php");  include ("../class/funciones.php");  $periodo=$_POST["txtperiodo"];
$cod_banco=$_POST["txtcod_banco"];$referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"]; 
$cod_presup=$_POST["txtcod_presup"]; $fuente=$_POST["txttfuente_financ"]; $cod_contable=$_POST["txtcod_contable"];  $cod_partida=$_POST["txtcod_partida"];
$descripcion=$_POST["txtcod_presup"]; $ced_rif=$_POST["txtced_rif"]; $fecha=$_POST["txtfecha"];
$monto=formato_numero($_POST["txtmonto_codigo"]); if(is_numeric($monto)){ $monto=$monto;} else{$monto=0;}
$monto_mov_libro=formato_numero($_POST["txtmonto_mov_libro"]); if(is_numeric($monto_mov_libro)){ $monto_mov_libro=$monto_mov_libro;} else{$monto_mov_libro=0;}
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Det_inc_gasto_flujo.php?criterio=".$periodo;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{ $sSQL="SELECT * FROM BAN021 where referencia='$referencia' and cod_banco='$cod_banco' and tipo_mov_libro='$tipo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('MOVIMIENTO NO EXISTE'); </script>  <? }
   else{ $registro=pg_fetch_array($resultado);
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BAN021(2,'$periodo','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente','$cod_partida','$cod_contable',$monto,'','',0,0,'$descripcion')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  }
pg_close();?> <script language="JavaScript">document.location ='<? echo $url; ?>'; </script>
 