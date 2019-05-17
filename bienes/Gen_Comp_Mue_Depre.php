<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $url="Det_inc_comp_depreciacion.php?codigo_mov=".$codigo_mov;
echo "GENERANDO COMPROBANTE....","<br>"; $error=0; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
  $i=0;
  $sql="Select campo_str1,campo_str2,sum(monto) as monto from bien050 where codigo_mov='$codigo_mov' and monto>0 group by campo_str1,campo_str2 order by campo_str1,campo_str2"; $res=pg_query($sql);
  while(($registro=pg_fetch_array($res)) ){ $monto_asiento=$registro["monto"];    $cuentad=$registro["campo_str2"];  $cuentac=$registro["campo_str1"];  
      $codigo_cuenta=$cuentad; $i=$i+1;
	  $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'";
	  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
	  if ($filas>0){ $reg=pg_fetch_array($resultado); $monto_c=$reg["monto_asiento"];
		 $monto_c=$monto_asiento+$monto_c;  //$monto_c=formato_numero($monto_c);
		 if ($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$codigo_cuenta',$monto_c,'DEPRECIACION DE BIENES')");
		 $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
	   else{
		$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','D','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','DEPRECIACION DE BIENES')");
		$error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
	 
      $codigo_cuenta=$cuentac; $monto_asiento=$registro["monto"];
	  $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'";
	  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
	  if ($filas>0){ $reg=pg_fetch_array($resultado);
		 $monto_c=$monto_asiento+$reg["monto_asiento"];  //$monto_c=formato_numero($monto_c);
		 if ($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','C','$codigo_cuenta',$monto_c,'DEPRECIACION DE BIENES')");
		 $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
	   else{
		$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','DEPRECIACION DE BIENES')");
		$error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
            
  }  
  $resultado=pg_exec($conn,"update pag036 set status_1='S' where codigo_mov='$codigo_mov'"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>


