<?include ("../class/conect.php");  include ("../class/funciones.php"); $MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0,0);
function BUSCAR_ACTUAL($Clave,$Formato){  global $MControl;  $j=0;
  for ($i=0; $i<strlen($Formato); $i++) { if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;} }
  $Ultimo=$j;  $k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];} }
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) {if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;}}
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><? }
  return $actual;
}
echo "ESPERE ACTUALIZANDO MAESTRO....","<br>";$Formato_Cuenta="X-X-X-XX-XX-XX-XX";
$Cta_Activo="1";$Cta_Pasivo="2";$Cta_Ingreso="5";$Cta_Egreso="6"; $Cta_Resultado="7";$Cta_Capital="3"; $Cta_Orden="4";
$Cta_Result_Eje="3-1-5-02";$Cta_Result_Ant="3-1-5-01"; $Cta_Costo_Venta="";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sql="Select * from SIA005 where campo501='06'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"];
     $Cta_Ingreso=$registro["campo507"];  $Cta_Egreso=$registro["campo508"];  $Cta_Resultado=$registro["campo509"];$Cta_Capital=$registro["campo510"]; $Cta_Orden=$registro["campo511"];
     $Cta_Result_Eje=$registro["campo512"]; $Cta_Result_Ant=$registro["campo513"];$Cta_Costo_Venta=$registro["campo517"];
  }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAES_CONTAB('$Cta_Result_Eje')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO SALDOS....","<br>"; $r=0; $a=BUSCAR_ACTUAL($Formato_Cuenta,$Formato_Cuenta);
  if($a>0){
    for ($i=$a-1; $i>=0; $i--) {
        $str_C = $MControl[$i]; $str_L = $MControl[$i+1];if (strlen($Cta_Result_Eje)==$MControl[$i]){$r = $i;}
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_SALDO_CONTAB($str_C,$str_L)"); 
		$error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
  }
  echo "ESPERE ACTUALIZANDO CUENTA DE RESULTADOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_RESULTADO('$Cta_Ingreso','$Cta_Egreso','$Cta_Costo_Venta','$Cta_Result_Eje')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  //$r=0;
  if($r>0){ $str_C = $MControl[$r-1];  $str_L = $MControl[$r]; $cuenta=substr($Cta_Result_Eje,0,$str_L);
    for ($i=$r-1; $i>=0; $i--) { $str_C = $MControl[$i];  $str_L = $MControl[$i+1]; 
        //echo $cuenta." ".$r." "."SELECT ACTUALIZA_SALDO_RESULT('$cuenta',$str_C,$str_L)","<br>";
        $resultado=pg_exec($conn,"SELECT ACTUALIZA_SALDO_RESULT('$cuenta',$str_C,$str_L)");   $error=pg_errormessage($conn); $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
  }
  ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?
}
pg_close(); ?><script language="JavaScript">cerrar_ventana();</script>