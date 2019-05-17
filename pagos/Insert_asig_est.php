<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$cod_estructura=$_POST["txtcod_estructura"]; $ced_rif_est=$_POST["txtcedula"]; $monto=0; $referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Det_asig_comp_est.php?cod_estructura=".$cod_estructura;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from pag037 where cod_estructura='$cod_estructura' and ced_rif_est='$ced_rif_est'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA YA EXISTE EN LA ESTRUCTURA');</script><? }
   else{  $sSQL="Select ced_rif from PRE006 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' "; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){echo $sSQL;$error=1; ?> <script language="JavaScript"> muestra('REFERENCIA COMPROMISO NO EXISTE');</script><? }
    }  
    if($error==0){ $sSQL="select sum(monto_cod) as monto from pag034 where cod_estructura='$cod_estructura' and ced_rif_est='$ced_rif_est'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
	    if($filas>=1){$reg=pg_fetch_array($res);$monto=$reg["monto"];} 
    }	
	if($tipo_compromiso=="0000"){ $error=1; ?> <script language="JavaScript"> muestra('DOCUMENTO COMPROMISO INVALIDO'); </script><?  }
    if($error==0){  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG037(1,'$cod_estructura','$ced_rif_est','$referencia_comp','$tipo_compromiso',$monto,'','','','',0,0)");
      $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>


