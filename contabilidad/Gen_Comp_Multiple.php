<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"]; 
$url="Det_inc_comp_mult.php?codigo_mov=".$codigo_mov;echo "GENERANDO COMPROBANTE....","<br>";
$error=0; $t_debe=0; $t_haber=0;$balance=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{ $res=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 

$sql="SELECT * FROM CON017  where codigo_mov='$codigo_mov' order by nro_linea";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $codigo_cuenta=$registro["cod_cuenta"]; $debito_credito=$registro["debito_credito"];
  if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
  if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}  $tipo=$registro["tipo_asiento"]; $descripcion_a=$registro["descripcion_a"];
  $modulo=$registro["modulo"]; $cod_banco=$codigo_cuenta; $cod_presup=$codigo_cuenta; $cod_fuente=$registro["aoperacion"];
  
  if($registro["modulo"]=="C"){$tipo=$registro["debito_credito"]; $des_modulo="CONTAB";}
  if($registro["modulo"]=="B"){$des_modulo="BANCOS";} 
  if($registro["modulo"]=="E"){$des_modulo="EGRESO";} 
  if($registro["modulo"]=="I"){$des_modulo="INGRESO";}
  echo $registro["modulo"]." ".$codigo_cuenta,"<br>";
  
  if($modulo=="C"){
   if($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; echo $codigo_cuenta; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; echo $codigo_cuenta; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }
    
   if ($error==0){  $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);  
      if ($filas>0){ $error=1; echo $codigo_cuenta; ?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? } 
	   else{ $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','B','S','01','0','$descripcion_a')");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
    } 
  }
  if($modulo=="B"){ $sSQL="SELECT cod_banco,nombre_banco,cod_contable,activa,fecha_activa,fecha_desactiva FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado,0);  $nombre_banco=$registro["nombre_banco"]; $codigo_cuenta=$registro["cod_contable"]; $activoA=$registro["activa"]; if($activoA=="N"){$error=1; ?> <script language="JavaScript"> muestra('BANCO NO ESTA ACTIVO');</script><? }} 
    if($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }
    if($error==0){$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);  
      if ($filas>0){ $error=1; echo $codigo_cuenta; ?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? } 
	   else{ $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','B','S','01','0','$descripcion_a')");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
	}
  }
  if($modulo=="E"){$sSQL="SELECT cod_presup,cod_fuente,cod_contable,denominacion FROM pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script><? }
     else{$registro=pg_fetch_array($resultado,0);  $nombre_cod=$registro["denominacion"]; $codigo_cuenta=$registro["cod_contable"]; }
     
	if($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }
    if($error==0){$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);  
      if ($filas>0){ $error=1; echo $codigo_cuenta; ?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? } 
	   else{ $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','B','S','01','0','$descripcion_a')");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
	} 
  }
  if($modulo=="I"){ $sSQL="Select codigo_contable, nombre from ingre001 WHERE codigo_presup='$cod_presup'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE INGRESOS NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); $codigo_cuenta=$registro["codigo_contable"]; $denominacion=$registro["nombre"]; }
    if ($error==0){$sSQL="Select cargable,nombre_cuenta from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"]; if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?}} }   
    if($error==0){$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito' and monto_asiento=$monto_asiento"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);  
      if ($filas>0){ $error=1; echo $codigo_cuenta; ?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? } 
	   else{ $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','B','S','01','0','$descripcion_a')");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
	}      
  }
 }
} 
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>  
                                                                
 