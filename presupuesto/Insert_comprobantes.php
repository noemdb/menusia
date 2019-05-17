<?include ("../class/conect.php");  include ("../class/funciones.php");
$fecha=$_POST["txtFecha"];
$referencia=$_POST["txtReferencia"];
$tipo_asiento=$_POST["txttipo_asiento"];
$codigo_mov=$_POST["txtcodigo_mov"];
$descripcion=$_POST["txtDescripcion"];
$equipo = getenv("COMPUTERNAME");
$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
$ced_rif = "";
echo "ESPERE POR FAVOR INCLUYENDO COMPROBANTE....","<br>";
if (checkData($fecha)=='1'){$error=0;}
else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
if($tipo_asiento=='ANU'||$tipo_asiento=='ANC'||$tipo_asiento=='AND'){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ASIENTO NO VALIDO');</script><? }
if ($error==0){
 $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
 if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{
    $sSQL="Select * from con009 WHERE tipo_asiento='$tipo_asiento'";
    $resultado=pg_exec($conn,$sSQL);
    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?>  <script language="JavaScript">  muestra('TIPO DE ASIENTO NO EXISTE');  </script>  <? }
    else{
      $error=0;
      if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
      $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='00000'";
      $resultado=pg_query($sSql);
      $filas=pg_num_rows($resultado);
      if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }
      if ($error==0){
         $sql="SELECT * FROM CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";
         $res=pg_query($sql);
         $t_debe=0; $t_haber=0;$balance=0;
         while($registro=pg_fetch_array($res))
         { if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
           if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
         }
         IF ($balance==0){$error=0;}else{$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
         IF ($t_debe==0){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
      }
      if ($error==0){
         $resultado=pg_exec($conn,"SELECT INCLUYE_CON002('$codigo_mov','$referencia','$sfecha','00000','$tipo_asiento','A','C','S','01','0','00000000','$ced_rif','','$MInf_Usuario','$descripcion')");
         $error=pg_errormessage($conn);
         $error="ERROR GRABANDO: ".substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
          else{
           $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");
           $error=pg_errormessage($conn); $error=substr($error, 0, 61);
           if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
           ?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
      }
    }
 }
 pg_close();
}
if ($error==0){?><script language="JavaScript">document.location ='Inc_comprobantes.php';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>