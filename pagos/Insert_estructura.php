<?include ("../class/conect.php");  include ("../class/funciones.php");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $cod_estructura=$_POST["txtcod_estructura"];
$descripcion_est=$_POST["txtdescripcion_est"]; $ced_rif=$_POST["txtced_rif"]; $fecha_desde_est=$_POST["txtfecha_desde_est"];
$fecha_hasta_est=$_POST["txtfecha_hasta_est"]; $tipo_documento=$_POST["txttipo_documento"];$nro_documento=$_POST["txtnro_documento"];
$cod_tipo_ord=$_POST["txttipo_orden"];$concepto_est=$_POST["txtconcepto_est"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;  $url="Act_estructura_orden.php?Gcod_estructura=".$cod_estructura;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sSQL="Select * from PAG006 WHERE cod_estructura='$cod_estructura'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">muestra('CÓDIGO DE ESTRUCTURA YA EXISTE'); </script><?}
   else{if($error==0){$sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'";$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF DE BENEFICIARIO NO EXISTE');</script><? }  }
     if($error==0){ $sSQL="Select * from PAG008 WHERE tipo_orden='$cod_tipo_ord'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE ORDEN NO EXISTE');</script><?} }
     if($error==0){  $sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);$total=0;
       while($registro=pg_fetch_array($res)){ $total=$total+1;}if($total==0){$error=1;?><script language="JavaScript">muestra('NO HAY CÓDIGOS EN LA ESTRUCTURA');</script><?}}
     if($error==0){ $dfecha=formato_aaaammdd($fecha_desde_est); $hfecha=formato_aaaammdd($fecha_hasta_est);
       $sSQL="SELECT INCLUYE_PAG006('$codigo_mov','$cod_estructura','$descripcion_est','$ced_rif','$dfecha','$hfecha','N','O','$tipo_documento','$nro_documento','$cod_tipo_ord','','$minf_usuario','$concepto_est')";
       $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
        else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?
             $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91);
             if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
             $resultado=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error,0,91);
             if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }}
    }
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script> <? }?>