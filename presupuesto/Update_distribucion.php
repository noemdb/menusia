<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_presup=$_POST["txtcod_presup"]; $cod_fuente=$_POST["txtcod_fuente"]; $distribucion=$_POST["txtdistribucion"]; $status_dist="1";
$asignado01=$_POST["txtasignado01"]; $asignado02=$_POST["txtasignado02"]; $asignado03=$_POST["txtasignado03"]; $asignado04=$_POST["txtasignado04"];
$asignado05=$_POST["txtasignado05"]; $asignado06=$_POST["txtasignado06"]; $asignado07=$_POST["txtasignado07"]; $asignado08=$_POST["txtasignado08"];
$asignado09=$_POST["txtasignado09"]; $asignado10=$_POST["txtasignado10"]; $asignado11=$_POST["txtasignado11"]; $asignado12=$_POST["txtasignado12"];
$asignado=0; $monto=$_POST["txtasignado"];$monto=formato_numero($monto); if(is_numeric($monto)){$asignado=$monto;} 
if($distribucion=="MENSUAL POR MONTO"){ $status_dist="2";} if($distribucion=="TRIMESTRAL (%)"){ $status_dist="4";}
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
if($status_dist=="1"){ If($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}
$disponible=0;$diferido=0;$disp_diferida=0; $asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f; $asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
$monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
if($monto!=$asignado){ $f=round($f,2); $p=$asignado-$monto; $p=round($p,2); $f=$f+$p; $asignado12=$f; }  $monto=$asignado; }
else{ $asignado01=formato_numero($asignado01); if(is_numeric($asignado01)){$asignado01=$asignado01;}else{$asignado01=0;} 
$asignado02=formato_numero($asignado02); if(is_numeric($asignado02)){$asignado02=$asignado02;}else{$asignado02=0;} 
$asignado03=formato_numero($asignado03); if(is_numeric($asignado03)){$asignado03=$asignado03;}else{$asignado03=0;} 
$asignado04=formato_numero($asignado04); if(is_numeric($asignado04)){$asignado04=$asignado04;}else{$asignado04=0;} 
$asignado05=formato_numero($asignado05); if(is_numeric($asignado05)){$asignado05=$asignado05;}else{$asignado05=0;}
$asignado06=formato_numero($asignado06); if(is_numeric($asignado06)){$asignado06=$asignado06;}else{$asignado06=0;}
$asignado07=formato_numero($asignado07); if(is_numeric($asignado07)){$asignado07=$asignado07;}else{$asignado07=0;}
$asignado08=formato_numero($asignado08); if(is_numeric($asignado08)){$asignado08=$asignado08;}else{$asignado08=0;} 
$asignado09=formato_numero($asignado09); if(is_numeric($asignado09)){$asignado09=$asignado09;}else{$asignado09=0;}
$asignado10=formato_numero($asignado10); if(is_numeric($asignado10)){$asignado10=$asignado10;}else{$asignado10=0;}  
$asignado11=formato_numero($asignado11); if(is_numeric($asignado11)){$asignado11=$asignado11;}else{$asignado11=0;} 
$asignado12=formato_numero($asignado12); if(is_numeric($asignado12)){$asignado12=$asignado12;}else{$asignado12=0;}      
$monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
}
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$equipo=getenv("COMPUTERNAME");$url="Act_codigos.php?Gcodigo=C".$cod_fuente.$cod_presup;$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}
  $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');  </script> <? }
   else{ $registro=pg_fetch_array($resultado); $disponible=$registro["disponible"]; $diferido=$registro["diferido"]; $disp_diferida=$registro["disp_diferida"]; 
     $func_inv=$registro["func_inv"]; $aplicacion=$registro["aplicacion"]; $des_ant=$registro["denominacion"]; $asignado=$registro["asignado"];  $cod_cont_ant=$registro["cod_contable"]; $sfecha=$registro["fecha_creado"];}  
  if(strlen($cod_presup)==strlen($formato_presup)){ 
    if ($monto>$asignado){$balance=$monto-$asignado;}else{$balance=$monto-$asignado;}
    if ($balance>0.001){$error=1;  echo $monto.' '.$asignado.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO DISTRIBUCION DIFERENTE A ASIGNACION');</script><? }  }
  else {$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO VALIDO');</script><?}
  if($error==0){  $fecha=asigna_fecha_hoy();
     if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE001(2,'$cod_presup','$cod_fuente','$des_ant','$cod_cont_ant','$status_dist',$asignado,$disponible,$diferido,$disp_diferida,'$func_inv','O','$aplicacion','','$sfecha',$asignado01,$asignado02,$asignado03,$asignado04,$asignado05,$asignado06,$asignado07,$asignado08,$asignado09,$asignado10,$asignado11,$asignado12)");
     $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{ ?> <script language="JavaScript"> muestra('MODIFICO DISTRIBUCION EXITOSAMENTE'); </script><? $error=0;
        $desc_doc="DISTRIBUCION CODIGO PRESUPUETARIO:".$cod_presup.", FUENTE:".$cod_fuente.",  ASIGNACION:".$asignado;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
  }
}pg_close();if ($error==0){?><script language="JavaScript">LlamarURL('<?echo $url;?>'); </script> <? } else { ?> <script language="JavaScript">history.back();</script>  <? } ?>