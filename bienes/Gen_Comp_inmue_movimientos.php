<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);  $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN025".$usuario_sia.$equipo; 
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];} $cod_contable="";
$url="Det_inc_comp_inmue_movimientos.php?codigo_mov=".$codigo_mov; echo "GENERANDO COMPROBANTE....","<br>"; $error=0; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  
  $t_mov=0; $monto_asiento=0;
  $sql="Select * from bien050 where codigo_mov='$codigo_mov' and monto<>0 order by cod_bien"; $res=pg_query($sql);
  while(($registro=pg_fetch_array($res))){ $monto_asiento=$registro["monto"]; $cod_bien=$registro["cod_bien"];  $tipo_id=$registro["tipo_id"]; $t_mov=$t_mov+$monto_asiento;
	$sSQL="Select * from BIEN014 WHERE cod_bien_inm='$cod_bien'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); 
	if ($filas>0){ $reg=pg_fetch_array($resultado); $codigo_cuenta=$reg["cod_contablea"]; $error=0;	
	  $sSQL="Select * from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA <? echo $codigo_cuenta; ?> NO EXISTE');</script><? }
       else{ $registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA <? echo $codigo_cuenta; ?> NO ES CARGABLE');</script><?}}
	   
	} else { $error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN <? echo $cod_bien; ?> NO EXISTE');</script><?}
    if($error==0){	if($tipo_id=="I"){$dc="D";}else{$dc="C";}
	  $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$dc'";
	  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
	  if ($filas>0){ $reg=pg_fetch_array($resultado);    $monto_c=$monto_asiento+$reg["monto_asiento"];   //$monto_c=formato_numero($monto_c);
		 if ($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','$dc','$codigo_cuenta',$monto_c,'')");
		 $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
	   else{  $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$dc','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
		$error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
	}     
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>
