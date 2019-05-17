<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); 
//cod_movimiento,linea,descripcion,cod_grupo,operacion,tipo_operacion,activo,modulo,signo,cod_contab,cod_contable,tipo_mov,monto,acumulado,cod_titulo,cargable,inf_usuario) VALUES (Pcod_movimiento,Plinea,Pdescripcion,Pcod_grupo,Poperacion,Ptipo_operacion,Pactivo,Pmodulo,Psigno,Pcod_contab,Pcod_contable,Ptipo_mov,Pmonto,Pacumulado,Pcod_titulo,Pcargable,Pinf_usuario
$cod_movimiento=$_POST["txtcod_movimiento"]; $descripcion=$_POST["txtdescripcion"];$linea=$_POST["txtcod_movimiento"]; 
$cod_titulo=$_POST["txtcod_titulo"];$cod_grupo=$_POST["txtcod_grupo"];$operacion=$_POST["txtoperacion"];
$tipo_operacion=$_POST["txttipo_operacion"];$activo=$_POST["txtactivo"];$modulo=$_POST["txtmodulo"]; $cargable="S";
$signo=$_POST["txtsigno"];$cod_contab=$_POST["txtcod_contab"];$cod_contable=$_POST["txtCodigo_Cuenta"]; $tipo_mov=$_POST["txttipo_mov"];
$monto=$_POST["txtmonto"]; $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;} 
$acumulado=$_POST["txtacumulado"]; $acumulado=formato_numero($acumulado); if(is_numeric($acumulado)){$acumulado=$acumulado;} else{$acumulado=0;} 
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban015 WHERE cod_movimiento='$cod_movimiento'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE MOVIMIENTO YA EXISTE');  </script> <? }
   else{$error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_ban015(1,'$cod_movimiento','$linea','$descripcion','$cod_grupo','$operacion','$tipo_operacion','$activo','$modulo','$signo','$cod_contab','$cod_contable','$tipo_mov',$monto,$acumulado,'$cod_titulo','$cargable','$minf_usuario')";  echo $sSQL,"<br>";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location='Act_Flujo_Caja.php?Gcod_movimiento=C<? echo $cod_movimiento; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
