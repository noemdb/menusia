<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$codigo_mov=$_POST["txtcodigo_mov"];$tiene_anticipo=$_POST["txttiene_anticipo"];$monto_anticipo=$_POST["txtmonto_anticipo"];
$cod_cuenta=$_POST["txtCodigo_Cuenta"];$tiene_anticipo=substr($tiene_anticipo,0,1);$fecha=asigna_fecha_hoy();
$monto_anticipo=formato_numero($monto_anticipo);
if(is_numeric($monto_anticipo)){$monto_anticipo=$monto_anticipo;} else{$monto_anticipo=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_comp_orden.php?codigo_mov=".$codigo_mov;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0;
   if($tiene_anticipo=="S") { $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO CONTABLE DE AMORTIZACION NO EXISTE');</script><? }
     else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO CONTABLE DE AMORTIZACION NO ES CARGABLE');</script><?} }
   }
   else {$tiene_anticipo="N"; $cod_cuenta=""; $monto_anticipo=0;}  
   if($error==0){
       $sSQL="SELECT UPDATE_PAG036_ANT('$codigo_mov',$monto_anticipo,'$tiene_anticipo','$cod_cuenta')";
       $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} }
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>