<?include ("../class/conect.php");  include ("../class/funciones.php"); $nro_linea=1; $error=0;
$codigo_mov=$_POST["txtcodigo_mov"]; $debito_credito="C"; $tipo="ING";  $referencia=$_POST["txtreferencia"]; 
$cod_presup=$_POST["txtcod_presup"]; $denominacion=$_POST["txtdenominacion"];  $cod_ramo="00";  $codigo_cuenta="";
$descripcion_a=$_POST["txtDes_A"]; $monto=formato_numero($_POST["txtmonto"]); if(is_numeric($monto)){ $monto_asiento=$monto;} else{$monto_asiento=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_mov_comp.php?codigo_mov=".$codigo_mov;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{  $sql="Select * from SIA005 where campo501='07'";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$formato_ingre=$registro["campo504"];}else{$formato_ingre="XXX-XX-XX-XX";}$len_cod=strlen($formato_ingre); $long_cod=strlen($cod_presup);
    if($len_cod==$long_cod){$error=0; }else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DEL CODIGO INVALIDA');</script><?}
    if ($error==0){
      $sSQL="Select codigo_contable, nombre from ingre001 WHERE codigo_presup='$cod_presup'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE INGRESOS NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); $codigo_cuenta=$registro["codigo_contable"]; $denominacion=$registro["nombre"]; }
    }
   if ($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}}
	   
	}   
   if(($error==0)and($monto_asiento==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }

	 if ($error==0){  $sSQL="Select * from CON017 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_presup' and debito_credito='$debito_credito'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
		    else{ $StrSQL="Select max(nro_linea) as max_linea from CON017 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
                 if($filas>0){$registro=pg_fetch_array($resultado); $nro_linea=$registro["max_linea"]; $nro_linea=$nro_linea+1; }  }
      }
      if ($error==0){ $sSQL="SELECT INCLUYE_CON017('$codigo_mov','$referencia','$debito_credito','$cod_presup','00000','$tipo',$monto_asiento,'D','I','S','00','0',$nro_linea,'$denominacion','$descripcion_a')";
	  $resultado=pg_exec($conn,$sSQL); echo $sSQL;
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
      }
} pg_close(); 
if($error==0){?><script language="JavaScript">document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>