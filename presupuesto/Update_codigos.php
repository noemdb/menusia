<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_presup=$_POST["txtcod_presup"];$cod_fuente=$_POST["txtcod_fuente"];$denominacion=$_POST["txtdenominacion"];$cod_contable=$_POST["txtCodigo_Cuenta"];
$func_inv=$_POST["txtTipo_Gasto"]; $func_inv=substr($func_inv,0,1); $aplicacion=$_POST["txtAplicacion"]; $status_dist="1";
$asignado=0; $monto=$_POST["txtasignado"];$monto=formato_numero($monto); $denominacion=str_replace("\r\n","",$denominacion); $denominacion=str_replace("\n","",$denominacion);
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; if(is_numeric($monto)){$asignado=$monto;} If($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}
$disponible=0;$diferido=0;$disp_diferida=0; $asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f; $asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
$monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
if($monto!=$asignado){ $f=round($f,2); $p=$asignado-$monto; $p=round($p,2); $f=$f+$p; $asignado12=$f; }
$monto=cambia_coma_numero($monto);$asignado01=cambia_coma_numero($asignado01);$asignado02=cambia_coma_numero($asignado02);$asignado03=cambia_coma_numero($asignado03);$asignado04=cambia_coma_numero($asignado04);$asignado05=cambia_coma_numero($asignado05);$asignado06=cambia_coma_numero($asignado06);
$asignado07=cambia_coma_numero($asignado07);$asignado08=cambia_coma_numero($asignado08);$asignado09=cambia_coma_numero($asignado09);$asignado10=cambia_coma_numero($asignado10);$asignado11=cambia_coma_numero($asignado11);$asignado12=cambia_coma_numero($asignado12);
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $formato_cat="XX-XX-XX"; $equipo=getenv("COMPUTERNAME");$url="Mod_codigos.php?Gcodigo=".$cod_fuente.$cod_presup;
$url="Act_codigos.php?Gcodigo=".$cod_fuente.$cod_presup; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}
  $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');  </script> <? }
   else{ $registro=pg_fetch_array($resultado); $sal_ant=$registro["disponible"]; $des_ant=$registro["denominacion"]; $asig_ant=$registro["asignado"];  $cod_cont_ant=$registro["cod_contable"]; $sfecha=$registro["fecha_creado"];}
  if($error==0){ $sSQL="Select * from PRE025 WHERE cod_aplicacion='$aplicacion'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE APLICACION NO EXISTE');</script><? }
  }
  if(strlen($cod_presup)==strlen($formato_presup)){  $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$error=0; ?> <script language="JavaScript"> muestra('CODIGO  CONTABLE DE GASTO NO ES CARGABLE');</script><?} }
  }else{$cod_contable="";}
  if($error==0){ $montoc = 0;
    $sSQL = "SELECT SUM(monto) As montoc FROM PRE036 WHERE (cod_presup='$cod_presup') And (fuente_financ='$cod_fuente')";   $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$registro=pg_fetch_array($resultado); $montoc = $montoc + $registro["montoc"];}
    $sSQL = "SELECT SUM(monto) As montoc FROM PRE039 WHERE (operacion='+') And (cod_presup='$cod_presup') And (fuente_financ='$cod_fuente')"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$registro=pg_fetch_array($resultado); $montoc = $montoc - $registro["montoc"];}
    If ($montoc>$asignado) {$error=1; ?> <script language="JavaScript"> muestra('MONTO DE ASIGNACION ES MENOR AL COMPROMETIDO');</script><? }
  }
  if($error==0){  $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $sqlg="SELECT ACTUALIZA_PRE001(2,'$cod_presup','$cod_fuente','$denominacion','$cod_contable','$status_dist',$asignado,$disponible,$diferido,$disp_diferida,'$func_inv','O','$aplicacion','','$sfecha',$asignado01,$asignado02,$asignado03,$asignado04,$asignado05,$asignado06,$asignado07,$asignado08,$asignado09,$asignado10,$asignado11,$asignado12)";
     $resultado=pg_exec($conn,$sqlg); //echo $sqlg;	 
     $error=pg_errormessage($conn);$error=substr($error, 0, 91); if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0;
        $desc_doc="CODIGO PRESUPUETARIO:".$cod_presup.", FUENTE:".$cod_fuente.", DENOMINACION:".$des_ant.", ASIGNACION:".$asig_ant.", COD.CONTABLE:".$cod_cont_ant;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
  }
}pg_close();
/* */
if ($error==0){?><script language="JavaScript">LlamarURL('<?echo $url;?>'); </script> <? } else { ?> <script language="JavaScript">history.back();</script>  <? } 

?>