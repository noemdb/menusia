<?include ("../class/conect.php"); include ("../class/funciones.php");
$tipo_nomina=$_GET["txttipo_nomina"]; $cod_concepto=$_GET["txtcod_concepto"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ASIGNANDO CONCEPTO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["denominacion"]; $tipo_grupo=$registro["tipo_grupo"]; $cod_partida=$registro["cod_partida"]; $cod_cat_alter=$registro["cod_cat_alter"]; $frec=$registro["frecuencia"];  $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"];  $prestamo=$registro["prestamo"]; $sfecha=date("y/m/d");}
  if($error==0){
    $sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.status,NOM006.calculo_grupos,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where (NOM006.status='ACTIVO' or NOM006.status='VACACIONES' or NOM006.status='REPOSO') And (NOM006.tipo_nomina='$tipo_nomina') And (NOM006.cod_empleado not in (select NOM011.cod_empleado from NOM011 Where NOM011.tipo_nomina='$tipo_nomina' and NOM011.cod_concepto='$cod_concepto')) ORDER BY NOM006.cod_empleado";   $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){$grupo_valido=0; $calculo_grupos=$registro["calculo_grupos"]; $cod_empleado=$registro["cod_empleado"]; $fecha_ini=$registro["fecha_ingreso"]; $cod_categoria=$registro["cod_categoria"];
       if(ereg($tipo_grupo, $calculo_grupos)){    if($cod_cat_alter==""){$cod_presup=$cod_categoria."-".$cod_partida;}else{$cod_presup=$cod_cat_alter."-".$cod_partida;} $fecha_exp="2999-12-31";
         $sSQL="SELECT ACTUALIZA_NOM011(1,'$tipo_nomina','$cod_empleado','$cod_concepto',0,0,'$fecha_ini','$fecha_exp','SI','SI',0,0,'$cod_presup','$frec','$afecta_presup','$cod_retencion','','N',0,0,0,'NN','$minf_usuario')";
         $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;}
       }
    }
    if($error==0){ ?><script language="JavaScript"> muestra('ASIGNACION DE CONCEPTO FINALIZADA');</script><? }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>