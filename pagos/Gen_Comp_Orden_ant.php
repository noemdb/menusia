<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $url="Det_inc_comp_ord_ant.php?codigo_mov=".$codigo_mov;
echo "GENERANDO COMPROBANTE....","<br>"; $error=0; $cod_contable=""; $pasivo_comp="NO"; $tipo_ord="0000";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $campo502="NNNNNNNNNNNNNNNNNNNN"; $monto_t=0;
  $sql="Select * from SIA005 where campo501='01'";
  $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];}
  $Genera_Orden_Retencion=substr($campo502,0,1); $Genera_Comp_Retencion=substr($campo502,1,1); $Genera_Presup_Retencion=substr($campo502,2,1); $Anticipo_Presup=substr($campo502,14,1);
  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $tipo_ord=$registro["tipo_orden"]; $monto_t=$registro["total_causado"];  $cod_cont_ant=$registro["campo_str1"];
    $StrSQL="select * from pag008 where tipo_orden='$tipo_ord'";  $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
    if($filas>0){$registro=pg_fetch_array($resultado); $cod_contable=$registro["cod_contable_t"];}
     else {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
    if($error==0){
      $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
      $codigo_cuenta=$cod_cont_ant; $monto_asiento=$monto_t;  $error=0;
      $sSQL="Select * from con001 WHERE codigo_cuenta='$codigo_cuenta'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE CUENTA ANTICIPO NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE CUENTA ANTICIPO NO ES CARGABLE');</script><?}}
      if ($error==0){$resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
      if (($Genera_Comp_Retencion=="S") and ($Genera_Orden_Retencion=="N")) {
      $sql="Select * from cod_ret where codigo_mov='$codigo_mov' order by tipo_retencion";
      $res=pg_query($sql);
      while(($registro=pg_fetch_array($res))){
        $monto_asiento=$registro["monto_retencion"]; $codigo_cuenta=$registro["cod_contable_ret"];
        if($registro["cargable"]=="C"){
          $monto_t=$monto_t-$monto_asiento;
          $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'";
          $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if ($filas>0){ $reg=pg_fetch_array($resultado);
             $monto_c=$monto_asiento+$reg["monto_asiento"];   $monto_c=formato_numero($monto_c);
             if ($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
           else{
            $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
            $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
        }
      }}
      $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$cod_contable','00000','',$monto_t,'D','C','N','01','0','')");
      $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
   }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>