<?php $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $pasivo_comp=$_GET["pasivo_comp"];$codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="06";
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";  $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','00000000','0000','','0000','','$pasivo_comp')"); }
else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(4,'$codigo_mov','00000000','0000','','0000','','$pasivo_comp')"); }

$formato=""; $periodo="01"; $campo502="";  $activo="";  $pasivo="";  $ingreso=""; $egreso=""; $resultado=""; $capital=""; 
$sit_finan="";  $sit_fiscal=""; $hacienda="";$ejec_presup="";  $superavit=""; $caja=""; $anticipo=""; $fondo_avance="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $formato=$registro["campo504"];
$activot=$registro["campo505"]; $pasivot=$registro["campo506"]; $activoh=$registro["campo507"]; $pasivoh=$registro["campo508"];
$ingreso=$registro["campo510"]; $egreso=$registro["campo509"]; $resultado=$registro["campo511"]; $capital=$registro["campo512"]; 
$sit_finan=$registro["campo513"]; $sit_fiscal=$registro["campo514"]; $ejec_presup=$registro["campo515"]; $hacienda=$registro["campo516"]; 
$superavit=$registro["campo517"]; $caja=$registro["campo518"]; $anticipo=$registro["campo520"]; $fondo_avance=$registro["campo519"];
}
$url="Det_inc_pas_orden.php?codigo_mov=".$codigo_mov;
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 
$total=0;
$sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' and monto>0 order by cod_presup";  $res=pg_query($sql);
//echo $sql,"<br>";
while(($registro=pg_fetch_array($res))){
   $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $monto_asiento=$registro["monto"]; $monto_a=$registro["monto"];
   
   $sSQL="Select * from con019 WHERE cod_presup='$cod_presup'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
   //echo $sSQL,"<br>";
   if ($filas>0){  $reg=pg_fetch_array($resultado);      $cod_contable=$reg["cod_contab_asoc"];
      echo $cod_contable." ".$monto_asiento,"<br>";
      $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);  $error=0;
      if ($filas==0){echo "Codigo Presupuestario:".$cod_presup." Cuenta Asociada:".$cod_contable; $error=1; ?> <script language="JavaScript"> muestra('CUENTA ASOCIADA NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){ echo "Codigo Presupuestario:".$cod_presup." Cuenta Asociada:".$cod_contable; $error=1; ?> <script language="JavaScript"> muestra('CUENTA ASOCIADA NO ES CARGABLE');</script><?} }
      $mexiste=0;
	  if ($error==0){ $sSQL="Select * from PAG030 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_contable' and debito_credito='$debito_credito'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
         if ($filas>0){  $mexiste=1;  $reg=pg_fetch_array($resultado);      $monto_a=$reg["monto_pasivo"]; }
      }
	  if($error==0){ $total=$total+$monto_asiento; $debito_credito="D";	  
	    if($mexiste==0){
	      $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('1','$codigo_mov','$cod_contable','$debito_credito','$monto_asiento')");
          $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
		} else{ $monto_a=$monto_a+$monto_asiento;
          $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('2','$codigo_mov','$cod_contable','$debito_credito','$monto_a')");
          $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
	  
        }		
	  }   
   }
}
if(($total>0)and($error==0)){ $cod_contable=$hacienda; $monto_asiento=$total;
   $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);  $error=0;
   if ($filas==0){echo " Cuenta Hacienda:".$cod_contable; $error=1; ?> <script language="JavaScript"> muestra('CUENTA HACIENDA NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){ echo "Cuenta Hacienda:".$cod_contable; $error=1; ?> <script language="JavaScript"> muestra('CUENTA HACIENDA NO ES CARGABLE');</script><?} }
   if($error==0){ $debito_credito="C";
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('1','$codigo_mov','$cod_contable','$debito_credito','$monto_asiento')");
          $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
   }   
}
pg_close(); 


if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 


?>