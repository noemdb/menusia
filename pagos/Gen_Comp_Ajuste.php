<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"];
$url="Det_inc_comp_ajuste.php?codigo_mov=".$codigo_mov;echo "GENERANDO COMPROBANTE....","<br>";
$error=0;$cod_contable=""; $pasivo_comp="NO"; $tipo_ord="0000";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' And monto>0";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTEN CODIGOS AJUSTADOS');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"];  $cod_cont_pas="";
    $sql="Select * from PAG001 where nro_orden='$referencia_caus' and tipo_causado='$tipo_causado'";
    $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('NÚMERO DE ORDEN NO EXISTE');</script><?}
     else { $reg=pg_fetch_array($resultado); $cod_contable=$reg["cod_contable_o"];
    }
  }
  if ($error==0){ $monto_t=0;
   $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");
   $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
   $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' and monto>0 order by cod_presup";$res=pg_query($sql);
   while(($registro=pg_fetch_array($res))){
     $monto_asiento=$registro["monto"];  $codigo_cuenta=$registro["cod_con_g_pagar"];
     if($registro["cargable"]=="C"){ $monto_t=$monto_t+$monto_asiento;
       $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'";
       $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas>0){
          $reg=pg_fetch_array($resultado);  $monto_c=$monto_asiento+$reg["monto_asiento"]; 
          $resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
          $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
        else{
         $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','CAUSADO PRESUPUESTARIO')");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
     }
   }
  }
  if ($error==0){ 
     $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$cod_contable','00000','',$monto_t,'D','C','N','01','0','')");
     $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>