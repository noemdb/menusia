<?include ("../class/conect.php");  include ("../class/funciones.php"); $nro_linea=1; $error=0;
$codigo_mov=$_POST["txtcodigo_mov"]; $cod_banco=$_POST["txtcod_banco"]; $nombre_banco=$_POST["txtnombre_banco"];
$referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"]; 
$descripcion_a=$_POST["txtDes_A"]; $monto=formato_numero($_POST["txtmonto"]); if(is_numeric($monto)){ $monto_asiento=$monto;} else{$monto_asiento=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_mov_comp.php?codigo_mov=".$codigo_mov;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{ $sSQL="SELECT cod_banco,nombre_banco,cod_contable,activa,fecha_activa,fecha_desactiva FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO EXISTE');</script><? }
 else{$registro=pg_fetch_array($resultado,0);  $nombre_banco=$registro["nombre_banco"]; $codigo_cuenta=$registro["cod_contable"]; $activoA=$registro["activa"]; if($activoA=="N"){$error=1; ?> <script language="JavaScript"> muestra('BANCO NO ESTA ACTIVO');</script><? }} 
      if($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }
      if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $debito_credito=$registro["tipo"];}}
      if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN LIBRO YA EXISTE');</script><? }}
      if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
      if($error==0){if(($tipo_mov=="CHQ") Or ($tipo_mov=="REV") Or ($tipo_mov=="ANU") Or ($tipo_mov=="TRD") Or ($tipo_mov=="ANC") Or ($tipo_mov=="AND")Or($tipo_mov=="IDB")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO INVALIDO');</script><? } }
     
	 if ($error==0){  $sSQL="Select * from CON017 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_banco' and debito_credito='$debito_credito' and referencia='$referencia'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
		    else{ $StrSQL="Select max(nro_linea) as max_linea from CON017 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
                 if($filas>0){$registro=pg_fetch_array($resultado); $nro_linea=$registro["max_linea"]; $nro_linea=$nro_linea+1; }  }
      }  if($debito_credito=="C"){$AOperacion="03";}else{$AOperacion="01";}
      if ($error==0){ $sSQL="SELECT INCLUYE_CON017('$codigo_mov','$referencia','$debito_credito','$cod_banco','00000','$tipo_mov',$monto_asiento,'D','B','S','$AOperacion','0',$nro_linea,'$nombre_banco','$descripcion_a')";
	  $resultado=pg_exec($conn,$sSQL); echo $sSQL;
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
      }
} pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}

?>