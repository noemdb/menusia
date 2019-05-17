<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php"); include ("../class/configura.inc");
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $nro_linea=1; $error=0; $fecha=asigna_fecha_hoy();
$codigo_mov=$_POST["txtcodigo_mov"]; $debito_credito="D"; $tipo="PAG"; $tipo_comp=$_POST["txttipo_pago"];
$cod_presup=$_POST["txtcod_presup"]; $cod_fuente=$_POST["txtcod_fuente"]; $debito_credito=$_POST["txtDeb_Cre"];
$referencia=$_POST["txtreferencia_pago"];  $nombre_cod=$_POST["txtdenominacion"];
$descripcion_a=$_POST["txtDes_A"]; $monto=formato_numero($_POST["txtmonto"]); if(is_numeric($monto)){ $monto_asiento=$monto;} else{$monto_asiento=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_mov_comp.php?codigo_mov=".$codigo_mov;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{    
   $sfecha=formato_aaaammdd($fecha);  $Nom_Emp=busca_conf(); if($sfecha>$Fec_Fin_Ejer){ $fecha=formato_ddmmaaaa($Fec_Fin_Ejer); }    
	$sql="Select * from SIA005 where campo501='05'";$resultado=pg_query($sql);
     if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}   $error=0; $monto_c=$monto_asiento;
     if(strlen($cod_presup)==strlen($formato_presup)){  
	   if($debito_credito=="D"){if(verifica_disponibilidad($conn,$cod_presup,$cod_fuente,$fecha,$monto_c)==0){$error=0;}else{$error=1;}}}
       else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CODIGO PRESUPUESTARIO INVALIDA');</script><? }
     if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuente'";       $resultado=pg_query($sSQL);      $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? } }
	 if($error==0){$sSQL="SELECT cod_presup,cod_fuente,cod_contable,denominacion FROM pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script><? }
     else{$registro=pg_fetch_array($resultado,0);  $nombre_cod=$registro["denominacion"]; $codigo_cuenta=$registro["cod_contable"]; } }
      
	  if($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }
      if($error==0){$sSQL="SELECT referencia_pago FROM PRE008 WHERE referencia_pago='$referencia' and tipo_pago='$tipo_comp'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('REFERENCIA DE YA EXISTE');</script><? }}
      if(($error==0)and($monto_asiento==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
      
	 if ($error==0){  $sSQL="Select * from CON017 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_presup' and debito_credito='$debito_credito' and referencia='$referencia' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
		    else{ $StrSQL="Select max(nro_linea) as max_linea from CON017 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
                 if($filas>0){$registro=pg_fetch_array($resultado); $nro_linea=$registro["max_linea"]; $nro_linea=$nro_linea+1; }  }
      }
	  if ($error==0){  $sSQL="Select * from CON017 WHERE codigo_mov='$codigo_mov' and modulo='E'  and  referencia='$referencia' "; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('REEFERENCIA DE MOVIMIENTO EGRESO YA EXISTE');</script> <? }
		   
      }
      if ($error==0){ $sSQL="SELECT INCLUYE_CON017('$codigo_mov','$referencia','$debito_credito','$cod_presup','$tipo_comp','$tipo',$monto_asiento,'D','E','S','$cod_fuente','P',$nro_linea,'$nombre_cod','$descripcion_a')";
	  $resultado=pg_exec($conn,$sSQL); echo $sSQL;
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
      }
} pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>