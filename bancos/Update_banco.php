<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL);
$cod_banco=$_POST["txtcod_banco"]; $nombre_banco=$_POST["txtnombre_banco"]; $nro_cuenta=$_POST["txtnro_cuenta"];  $descripcion_banco=$_POST["txtdescripcion_banco"]; $tipo_cuenta=$_POST["txttipo_cuenta"]; $cod_contable=$_POST["txtCodigo_Cuenta"]; $tipo_bco=$_POST["txttipo_bco"]; $formato_cheque=$_POST["txtformato_cheque"];
$s_inic_libro=$_POST["txts_inic_libro"]; $s_inic_libro=formato_numero($s_inic_libro); if(is_numeric($s_inic_libro)){$s_inic_libro=$s_inic_libro;} else{$s_inic_libro=0;} $s_inic_banco=$_POST["txts_inic_banco"]; $s_inic_banco=formato_numero($s_inic_banco); if(is_numeric($s_inic_banco)){$s_inic_banco=$s_inic_banco;} else{$s_inic_banco=0;}
$campo_str1=$_POST["txtcod_contable_idb"];$campo_str2=$_POST["txtgrupo_banco"];$campo_num1=$_POST["txttasa_idb"];$campo_num2=0; $campo_num1=formato_numero($campo_num1); if(is_numeric($campo_num1)){$campo_num1=$campo_num1;} else{$campo_num1=0;}
$fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);} if($campo_num1==0){$campo_str1="";}
if($tipo_bco=="GASTOS CORRIENTES"){$tipo_bco="1";} if($tipo_bco=="RECAUDACION"){$tipo_bco="2";}   if($tipo_bco=="FONDOS DE TERCEROS"){$tipo_bco="3";} if($tipo_bco=="FIDEICOMISOS-FIDES"){$tipo_bco="4";} if($tipo_bco=="FIDEICOMISOS-LAEE"){$tipo_bco="5";} if($tipo_bco=="FIEM"){$tipo_bco="6";} 
if($tipo_bco=="OTROS FIDEICOMISOS"){$tipo_bco="7";} if($tipo_bco=="PENDIENTE POR CANCELAR"){$tipo_bco="8";} if($tipo_bco=="OTROS"){$tipo_bco="9";}
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban002 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE BANCO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $anombre=$registro["nombre_banco"]; $saldo_ant_libro=$registro["s_inic_libro"]; $saldo_ant_banco=$registro["s_inic_banco"]; $c_contable=$registro["cod_contable"]; $error=0;
     if(($cod_banco=="")||(strlen($cod_banco)!=4)){$error=1; ?><script language="JavaScript">  muestra('CODIGO DE BANCO INVALIDO');</script> <? }
     if($nombre_banco==""){$error=1; ?><script language="JavaScript">  muestra('NOMBRE DE BANCO INVALIDO');</script> <? }
     if($error==0){ $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE BANCO NO EXISTE');</script><? }
       else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE BANCO NO ES CARGABLE');</script><?}}
     }
     if($error==0){$sSQL="Select tipo_cuenta from ban001 WHERE tipo_cuenta='$tipo_cuenta'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE CUENTA NO EXISTE');</script><? } }
     if($error==0){$sSQL="Select nombre_grupob from ban022 WHERE cod_grupob='$campo_str2'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('GRUPO DE BANCO NO EXISTE');</script><? } }
     if(($error==0)&&($campo_num1>0)){ $sSQL="Select * from con001 WHERE codigo_cuenta='$campo_str1'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE IDB NO EXISTE');</script><? }
       else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE IDB NO ES CARGABLE');</script><?}}
     }
     if($error==0){$sSQL="SELECT ACTUALIZA_ban002(2,'$cod_banco','$nombre_banco','$nro_cuenta','$descripcion_banco','$tipo_cuenta','$cod_contable','$tipo_bco','00000000','00000000','N','','S','$formato_cheque','$sfecha','$sfecha',$s_inic_libro,$s_inic_banco,'$campo_str1','$campo_str2',$campo_num1,$campo_num2,'$minf_usuario')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       echo $sSQL;
	   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
	    $sSQL="Update con001 set saldo_anterior=$s_inic_libro where codigo_cuenta='$cod_contable'"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
		$desc_doc="DEFINICION DE BANCO, CODIGO:".$cod_banco.", NOMBRE:".$anombre.", CODIGO CONTABLE:".$c_contable.", SALDO ANT. LIBRO:".$saldo_ant_libro.", SALDO ANT. LIBRO:".$saldo_ant_banco;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_bancos.php?Gcod_banco=C<?echo $cod_banco?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>