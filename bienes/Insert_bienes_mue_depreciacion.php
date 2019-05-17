<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];$cod_bien_mue=$_POST["txtcod_bien_mue"];$monto_c=$_POST["txtmonto"];  $saldo_dep=$_POST["txtmonto_depreciado"]; 
$fecha=asigna_fecha_hoy();$monto_c=formato_numero($monto_c);if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;}
$saldo_dep=formato_numero($saldo_dep);if(is_numeric($saldo_dep)){$saldo_dep=$saldo_dep;} else{$saldo_dep=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_inc_bienes_mue_depreciacion.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else { $tipo_dep="M"; $tipo_causado="0004"; $cod_fuente="00"; 
  $sSQL="Select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){ $registro=pg_fetch_array($resultado); $cod_fuente=$registro["tipo_orden"]; $tipo_causado=$registro["tipo_causado"]; $fecha_d=$registro["cod_contable_o"]; $tipo_dep=$registro["pasivo_comp"];   }
  
  $sSQL="Select * from BIEN050 WHERE codigo_mov='$codigo_mov' and cod_bien='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN YA EXISTE EN EL MOVIMIENTO');</script><? }
  if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN NO EXISTE');</script><? }  
	else{  $registro=pg_fetch_array($resultado); $desincorporado=$registro["desincorporado"];  $codigo_cuenta=$registro["cod_contablea"]; $cod_contabled=$registro["cod_contabled"];
		$cod_presup=$registro["cod_presup_dep"]; $monto=$registro["valor_incorporacion"]; $valor_residual=$registro["valor_residual"]; $saldo_dep=$registro["valor_incorporacion"]-$registro["monto_depreciado"]; 
		$monto_depreciado=$registro["monto_depreciado"];
		if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN ESTA DESINCORPORADO');</script><?} 
		if($monto_c>$saldo_dep){$error=1; ?> <script language="JavaScript"> muestra('MONTO MAYOR QUE SALDO DE DEPRECIACION');</script><?} 
	}			
  }
  
  if($error==0){ 
    $sSQL="Select cod_presup,cod_contable from pre001 WHERE cod_presup='$cod_presup' ";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>=1){  $registro=pg_fetch_array($resultado); $codigo_cuenta=$registro["cod_contable"]; }
  }
  
  if($error==0){ $sfecha=formato_aaaammdd($fecha); $sql="SELECT ACTUALIZA_BIEN050(1,'$codigo_mov','','$sfecha','$cod_bien_mue','00','$tipo_dep','',$saldo_dep,$monto_c,'$cod_contabled','$codigo_cuenta',$monto,$monto_depreciado)";
    $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    //echo $sql;
  }
  
 }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 
?>


