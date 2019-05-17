<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$codigo_mov=$_POST["txtcodigo_mov"]; $nro_aut=$_POST["txtnro_aut"]; $ced_rif=""; $statusc="D";
$referencia=$_POST["txtreferencia"];$fecha_transf=$_POST["txtfecha"];
$tipo_salida=$_POST["txttipo_salida"];$cod_dependencia=$_POST["txtcod_dependencia"];$descripcion=$_POST["txtdescripcion"];
$cargo1=""; $nombre1="";$departamento1=""; $cargo2=""; $nombre2="";$departamento2=""; $num_tipo_salida="1"; $des_tipo_salida="";

if($tipo_salida=="ORDEN POR REPARACION"){ $des_tipo_salida="ORDEN POR REPARACION";   $num_tipo_salida="1"; }
if($tipo_salida=="DONACION"){ $des_tipo_salida="DONACION"; $num_tipo_salida="2";}
if($tipo_salida=="RETORNO A PROVEEDOR"){ $des_tipo_salida="RETORNO A PROVEEDOR"; $num_tipo_salida="3";}
if($tipo_salida=="TRASLADO POR REPARACION"){ $des_tipo_salida="TRASLADO POR REPARACION"; $num_tipo_salida="4";}
if($tipo_salida=="PUNTO CUENTA DONACION"){ $des_tipo_salida="PUNTO CUENTA DONACION"; $num_tipo_salida="5";}
if($tipo_salida=="COMODATO"){ $des_tipo_salida="COMODATO"; $num_tipo_salida="6";}
if($tipo_salida=="PARA USO DE LA DEPENDENCIA"){ $des_tipo_salida="PARA USO DE LA DEPENDENCIA"; $num_tipo_salida="7";}

$equipo = getenv("COMPUTERNAME");$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_transf)=='1'){$error=0; $fecha=$fecha_transf;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
$url="Act_orden_salida_bienes_muebles_pro.php?Greferencia=".$referencia;
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
 
  if($error==0){     
	$sSQL="Select * from bien043 WHERE referencia='$referencia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA ORDEN DE SALIDA YA EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_transf);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA ORDEN DE SALIDA  INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha,3, 2);
	If ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA ORDEN DE SALIDA  MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }
  if($error==0){ $sql="SELECT * FROM BIEN050 where codigo_mov='$codigo_mov' order by cod_bien";  $res=pg_query($sql); $total=0; $c=0;
    while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"]; $c=$c+1; $tipo_id=$registro["tipo_id"];   $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"];
       if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
		    if($cod_depb<>$cod_dependencia) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPENDECIA DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
	    }
	}
    if(($total==0)or($c==0)){$error=1;?><script language="JavaScript">muestra('MONTO ORDEN DE SALIDA  INVALIDO');</script><?}
  }
  if($error==0){  $sfecha=formato_aaaammdd($fecha);
     $sSQL="SELECT ACTUALIZA_BIEN043(1,'$codigo_mov','$referencia','$sfecha','$cod_dependencia','$num_tipo_salida','N','N','$sfecha','$cargo1','$departamento1','$nombre1','$cargo2','$departamento2','$nombre2','','','','$usuario_sia','$minf_usuario','$descripcion')";
     $resultado=pg_exec($conn,$sSQL);   $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
	 echo $sSQL;
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);

if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }

?>
