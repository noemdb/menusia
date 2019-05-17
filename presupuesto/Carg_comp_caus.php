<?include ("../class/conect.php"); include ("../class/funciones.php");$codigo_mov=$_GET["codigo_mov"];
echo "ESPERE POR FAVOR CARGANDO CODIGOS DEL CAUSADO AL COMPROBANTE....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{   $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
   if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
   $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
   while(($registro=pg_fetch_array($res))){   $monto_asiento=$registro["monto"]; $codigo_cuenta=$registro["cod_con_g_pagar"];
     if($registro["cargable"]=="C"){ $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'";
       $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
       echo $sSQL.' '.$filas;
       if ($filas>0){  $reg=pg_fetch_array($resultado);    $monto_c=$monto_asiento+$reg["monto_asiento"];
          $resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','D','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
          $error=pg_errormessage($conn);     $error="ERROR GRABANDO: ".substr($error, 0, 61);    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
        else{
         $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','CAUSADO PRESUPUESTARIO')");
         $error=pg_errormessage($conn);     $error="ERROR GRABANDO: ".substr($error, 0, 61);     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
     }
   }
 }
pg_close();
?><script language="JavaScript">document.location ='Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>';</script>