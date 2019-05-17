<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $sfecha=formato_aaaammdd($fecha_hoy);
$cod_articulo=$_POST["txtcod_articulo"]; $denominacion=$_POST["txtdes_articulo"]; $ramo=$_POST["txtcod_ramo"];  $partida=$_POST["txtpartida"]; $cod_contable=""; $observacion=""; $lote=""; $fecha_vence=$sfecha; $refrigerado="N";
$tipo_articulo=$_POST["txttipo_articulo"]; $tipo_articulo=substr($tipo_articulo,0,1); $unidad_medida=$_POST["txtunidad_medida"]; $unidad_alterna=$_POST["txtunidad_alterna"];
$marca=$_POST["txtmarca"]; $modelo=$_POST["txtmodelo"]; $medida=$_POST["txtmedida"]; $grupo=$_POST["txtgrupo"];  $tipo_costo=$_POST["txttipo_costo"];  $tipo_costo=substr($tipo_costo,0,1);
$relacion=$_POST["txtrelacion"];  $relacion=formato_numero($relacion); if(is_numeric($relacion)){$relacion=$relacion;}else{$relacion=1;} $existencia=0; $pto_reorden=0;
$existencia_min=$_POST["txtexistencia_min"]; $existencia_min=formato_numero($existencia_min); if(is_numeric($existencia_min)){$existencia_min=$existencia_min;}else{$existencia_min=0;}
$existencia_max=$_POST["txtexistencia_max"]; $existencia_max=formato_numero($existencia_max); if(is_numeric($existencia_max)){$existencia_max=$existencia_max;}else{$existencia_max=0;}
$pedido_minimo=$_POST["txtpedido_minimo"]; $pedido_minimo=formato_numero($pedido_minimo); if(is_numeric($pedido_minimo)){$pedido_minimo=$pedido_minimo;}else{$pedido_minimo=0;}
$ultimo_costo=$_POST["txtultimo_costo"];   $ultimo_costo=formato_numero($ultimo_costo); if(is_numeric($ultimo_costo)){$ultimo_costo=$ultimo_costo;}else{$ultimo_costo=0;}
$fecha_u_costo=$_POST["txtfecha_u_costo"]; if(checkData($fecha_u_costo)=='1'){$fecha_u_costo=$sfecha;}else{$fecha_u_costo=$sfecha;}
$impuesto=$_POST["txtimpuesto"]; $impuesto=formato_numero($impuesto);  if(is_numeric($impuesto)){$impuesto=$impuesto;}else{$impuesto=0;}
$pedido_maximo=$_POST["txtpedido_maximo"];  $pedido_maximo=formato_numero($pedido_maximo); if(is_numeric($pedido_maximo)){$pedido_maximo=$pedido_maximo;}else{$pedido_maximo=0;}
$fecha_creado=$_POST["txtfecha_creado"]; if(checkData($fecha_creado)=='1'){$fecha_creado=$sfecha;}else{$fecha_creado=$sfecha;}
$cod_aux1=$_POST["txtcod_aux1"]; $fecha_aprobada=$_POST["txtfecha_aprobada"]; $error=0;
if (checkData($fecha_aprobada)=='1'){ $afecha=formato_aaaammdd($fecha_aprobada);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA APROBACION NO ES VALIDA');</script><? }
$usuario_aprueba=$usuario_sia;$aprobado="S";$fecha_aprobada=$afecha;
$cod_aux2="";$campo_str1="";$campo_str2="";$campo_num1=0;$campo_num2=0;$costo1 =0;$fecha_costo1=$sfecha;$costo2=0;$fecha_costo2=$sfecha;$costo3=0;$fecha_costo3=$sfecha; $cod_barra=""; $status=""; 

$equipo = getenv("COMPUTERNAME"); $inf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR APROBANDO....","<br>"; $url="Act_Def_Art.php?Gcod_articulo=C".$cod_articulo;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ 
  $sSQL="Select * from COMP072 WHERE cod_articulo='$cod_articulo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARTICULO NO EXISTE');</script><? }
   else{  $registro=pg_fetch_array($resultado,0);  $prev_apro=$registro["aprobado"];
     if($prev_apro=="S"){$error=1; ?> <script language="JavaScript"> muestra('ARTICULO YA APROBADO');</script><? } 
	 else{$part="000001";
     $StrSQL="Select max(cod_articulo) As cod_articulo FROM COMP002 where substring(cod_articulo,1,3)='$ramo'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
     if($filas>0){$registro=pg_fetch_array($resultado); $part=$registro["cod_articulo"];  $part=substr($part,4,6); if(is_numeric($part)){$part=$part+1;}else{$part="000001";} $part=Rellenarcerosizq($part,6); } $cod_aux2=$ramo.'-'.$part; }
   } 
  if($error==0){if(strlen($cod_aux2)==10){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE ARTICULO INVALIDA');</script><?} }
  if($error==0){if(strlen($denominacion)==0){$error=1; ?> <script language="JavaScript"> muestra('DESCRIPCION INVALIDA');</script><?} }
  if($error==0){$sSQL="Select cod_articulo,des_articulo from COMP002 WHERE cod_articulo='$cod_aux2'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARTICULO YA EXISTE');</script><? }}
  
  if($error==0){$sSQL="Select cod_par_ramo from COMP001 WHERE cod_ramo='$ramo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO RAMO DE ARTICULO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $cod_par_ramo=$registro["cod_par_ramo"];}}
  if($error==0){if($ramo==substr($cod_aux2,0,3)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARTICULO INVALIDO');</script><?}}
  if($error==0){$l=strlen($cod_par_ramo); if($cod_par_ramo==substr($partida,0,$l)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PARTIDA INVALIDO');</script><?} }
  if($error==0){$sSQL="Select cod_grupo from COMP053 WHERE cod_grupo='$grupo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO GRUPO DE ARTICULO NO EXISTE');</script><?}}
  if($error==0){$sSQL="Select cod_articulo,des_articulo from COMP002 WHERE des_articulo='$denominacion' and cod_articulo<>'$cod_aux2'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('ARTICULO YA EXISTE CON LA MISMA DESCRIPCION');</script><? }}
  
  if($error==0){$sSQL="SELECT ACTUALIZA_COMP072(4,'$cod_articulo','$denominacion','$ramo','$tipo_articulo','$partida','$cod_contable','$unidad_medida','$unidad_alterna','$observacion','$marca','$modelo','$medida','$grupo','$lote','$fecha_vence','$tipo_costo','$refrigerado',$relacion,$existencia_min,$existencia_max,$existencia,$pto_reorden,$pedido_minimo,$ultimo_costo,'$fecha_u_costo',$impuesto,$pedido_maximo,'$cod_barra','$status','$cod_aux1','$cod_aux2','$campo_str1','$campo_str2',$campo_num1,$campo_num2,'$fecha_creado','$aprobado','$fecha_aprobada','$usuario_aprueba','$inf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('APROBO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>