<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$codigo_mov=$_POST["txtcodigo_mov"]; $nro_aut=$_POST["txtnro_aut"]; $ced_rif=$_POST["txtced_rif"]; $statusc="D";
$referencia_transf=$_POST["txtreferencia"];$fecha_transf=$_POST["txtfecha"]; $tipo_transferencia=$_POST["txttipo_transferencia"];
$descripcion=$_POST["txtdescripcion"];$cod_empresa_e="000";  $cod_empresa_r="000";  
$cod_dependencia_e=$_POST["txtcod_dependencia"];$cod_direccion_e=$_POST["txtcod_direccion"];$cod_departamento_e=$_POST["txtcod_departamento"];
$cod_dependencia_r=$_POST["txtcod_dependencia_r"];$cod_direccion_r=$_POST["txtcod_direccion_r"]; $cod_departamento_r=$_POST["txtcod_departamento_r"];
$ced_responsable=$_POST["txtced_responsable"]; $ced_res_uso=$_POST["txtced_responsable_uso"];
$departamento_e=$_POST["txtdenominacion_depart"]; $departamento_r=$_POST["txtdenominacion_depart_r"];
$nombre_e=$_POST["txtnombre_e"]; $nombre_r=$_POST["txtnombre_r"]; $nombre1=""; $departamento1="";   
IF($tipo_transferencia=="CAMBIO DE ESTADO"){ $tipo_transferencia="T";} $tipo_transferencia=substr($tipo_transferencia,0,1);
$equipo = getenv("COMPUTERNAME");$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_transf)=='1'){$error=0; $fecha=$fecha_transf;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
$url="Act_bienes_muebles_pro_trasn_bie.php?Greferencia_transf=".$referencia_transf;
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
  if($error==0){     
	$sSQL="Select * from bien036 WHERE referencia_transf='$referencia_transf'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE TRANSFERENCIA YA EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_transf);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE TRANSFERENCIA INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha,3, 2);
	If ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA TRANSFERENCIA MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }  
  if($error==0){ $sql="SELECT * FROM BIEN050 where codigo_mov='$codigo_mov' order by cod_bien";  $res=pg_query($sql); $total=0; $c=0;
    while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"]; $c=$c+1; $tipo_id=$registro["tipo_id"];   $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"];
       if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
			$cod_empresa_e=$reg["cod_empresa"];   $cod_empresa_r=$reg["cod_empresa"];
			
		    if($cod_depb<>$cod_dependencia_e) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPENDECIA DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if($cod_dirb<>$cod_direccion_e) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if($cod_departb<>$cod_departamento_e) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			
			if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
	    }
	}
    /*if(($total==0)or($c==0)){$error=1;?><script language="JavaScript">muestra('MONTO TRANSFERENCIA INVALIDO');</script><?}*/
	if(($c==0)){$error=1;?><script language="JavaScript">muestra('CANTIDAD DE BIENES EN TRANSFERENCIA INVALIDA');</script><?}
  }  
  if($error==0){     
    if(($tipo_transferencia=="E")and($cod_dependencia_e==$cod_dependencia_r)){$error=1;?><script language="JavaScript">muestra('TIPO DE TRANSFERENCIA INVALIDA');</script><?}
  }
  if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependencia_r'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependencia_r; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><? }
   }
   if($error==0){$sql="SELECT cod_direccion,denominacion_dir FROM bien005 where cod_dependencia='$cod_dependencia_r' and cod_direccion='$cod_direccion_r'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_direccion_r; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }
   }
   if($error==0){$sql="Select denominacion_dep from BIEN006 WHERE cod_dependencia='$cod_dependencia_r' and cod_direccion='$cod_direccion_r' and cod_departamento='$cod_departamento_r'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_departamento_r; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO NO EXISTE');</script><? }
   }
   if($error==0){$sSQL="Select ced_responsable from BIEN002 WHERE ced_responsable='$ced_responsable'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE NO EXISTE');</script> <? }
   }      
   if($error==0){$sSQL="Select ced_res_uso from BIEN031 WHERE ced_res_uso='$ced_res_uso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE DE USO NO EXISTE');</script> <? }
   }   
  if($error==0){ $sfecha=formato_aaaammdd($fecha_transf); $tipo_mov_r="002"; $tipo_mov_e="051";
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN036(1,'$codigo_mov','$referencia_transf','$sfecha','$tipo_transferencia','$cod_dependencia_r','$cod_empresa_r','$cod_direccion_r','$cod_departamento_r','$tipo_mov_r','$cod_dependencia_e','$cod_empresa_e','$cod_direccion_e','$cod_departamento_e','$tipo_mov_e','$ced_responsable','$ced_res_uso','','','$departamento_r','$nombre_r','$departamento_e','$nombre_e','','$departamento1','$nombre1','00000000','00000000','','','','$usuario_sia','$minf_usuario','$descripcion','$statusc','$ced_rif')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 91);   if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>
