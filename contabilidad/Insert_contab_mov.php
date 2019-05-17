<?include ("../class/conect.php");  include ("../class/funciones.php"); $nro_linea=1;
$codigo_cuenta=$_POST["txtCodigo_Cuenta"]; $nombre_cuenta=$_POST["txtNombre_Cuenta"];
$codigo_mov=$_POST["txtcodigo_mov"]; $debito_credito=$_POST["txtDeb_Cre"];
$descripcion_a=$_POST["txtDes_A"]; $monto=formato_numero($_POST["txtmonto"]); if(is_numeric($monto)){ $monto_asiento=$monto;} else{$monto_asiento=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_mov_comp.php?codigo_mov=".$codigo_mov;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{ $error=0; $sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}}
      if ($error==0){ $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,cod_contable FROM ban002 WHERE cod_contable='$codigo_cuenta'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
       if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA ASOCIADA A UN BANCO');</script> <? } }
     if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }

	 if ($error==0){  $sSQL="Select * from CON017 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
		    else{ $StrSQL="Select max(nro_linea) as max_linea from CON017 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
                 if($filas>0){$registro=pg_fetch_array($resultado); $nro_linea=$registro["max_linea"]; $nro_linea=$nro_linea+1; }  }
      }
      if ($error==0){ $sSQL="SELECT INCLUYE_CON017('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','C','S','01','0',$nro_linea,'$nombre_cuenta','$descripcion_a')";
	  $resultado=pg_exec($conn,$sSQL); echo $sSQL;
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
      }
} pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>