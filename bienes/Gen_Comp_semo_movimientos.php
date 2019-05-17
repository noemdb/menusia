<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $url="Det_inc_bienes_semo_movimientos.php?codigo_mov=".$codigo_mov;
echo "GENERANDO COMPROBANTE....","<br>"; $error=0; $cod_contable=""; $pasivo_comp="NO"; $tipo_ord="0000";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
 
  $sql="Select * from bien050 where codigo_mov='$codigo_mov' and monto>0 order by cod_bien"; $res=pg_query($sql);
  while(($registro=pg_fetch_array($res))){ $monto_asiento=$registro["monto"]; $cod_bien=$registro["cod_bien"];
        $sSQL="Select * from BIEN016 WHERE cod_bien_sem='$cod_bien'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); 
        if ($filas>0){ $reg=pg_fetch_array($resultado); $codigo_cuenta=$reg["cod_contablea"];
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
     
  }

   
}
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>
