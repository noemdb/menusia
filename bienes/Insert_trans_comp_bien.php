<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$codigo_mov=$_POST["txtcodigo_mov"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtdescripcion"];
$referencia_transf=$_POST["txtreferencia"];$fecha_transf=$_POST["txtfecha"]; $tipo_transferencia=$_POST["txttipo_transferencia"];
IF($tipo_transferencia=="CAMBIO DE ESTADO"){ $tipo_transferencia="T";} $tipo_transferencia=substr($tipo_transferencia,0,1);
$nombre_e=$_POST["txtnombre_e"]; $nombre_r=$_POST["txtnombre_r"]; $departamento_e=""; $departamento_r=""; $nombre1=""; $departamento1="";
$equipo = getenv("COMPUTERNAME");$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_transf)=='1'){$error=0; $fecha=$fecha_transf;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
$url="Act_trans_comp_bien.php?Greferencia_transf_c=".$referencia_transf;
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
  if($error==0){     
	$sSQL="Select * from bien054 WHERE referencia_transf_c='$referencia_transf'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
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
    while($registro=pg_fetch_array($res)){ $c=$c+1; $tipo_id=$registro["tipo_id"];   $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"]; $campo_str2=$registro["campo_str2"];
       if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
		    if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN EMISOR <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
	    }
		if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$campo_str2'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
		  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
		    if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN RECEPTOR <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
		}
	}	
	if(($c==0)){$error=1;?><script language="JavaScript">muestra('TRANSFERENCIA NO TIENE MOVIMIENTOS');</script><?}
  }  
  if($error==0){ $sfecha=formato_aaaammdd($fecha_transf); $tipo_mov_r="002"; $tipo_mov_e="051";
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN054(1,'$codigo_mov','$referencia_transf','$sfecha','$tipo_transferencia','$departamento_r','$nombre_r','$departamento_e','$nombre_e','','$departamento1','$nombre1','','','$usuario_sia','$minf_usuario','$descripcion')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?    $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); }  
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>
