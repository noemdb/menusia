<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");error_reporting(E_ALL);
$referencia_aju=$_POST["txtreferencia_aju"];  $tipo_ajuste=$_POST["txttipo_ajuste"];$fecha_anu=$_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$equipo = getenv("COMPUTERNAME");  $tipo_ajuste_c="0001";$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ANULANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){ 
    $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
    $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1);  $fecha_aut=substr($campo502,5,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
    $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){  $formato_presup=$registro["campo504"];  $formato_cat=$registro["campo526"];   $l_cat=strlen($formato_cat);
    if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
  $sql="Select * from PAG019 WHERE referencia_aju_ord='$referencia_aju'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA AJUSTE DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $fecha_ajuste=$reg["fecha_aju_ord"];  $adescripcion=$reg["descripcion"]; $total_ajuste=$reg["monto_aju_ord"]; $tipo_causado=$reg["tipo_causado"];  $referencia_caus=$reg["nro_orden"]; $anulado=$reg["anulado_aju"];
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('AJUSTE YA ESTA ANULADO');</script><?}
     
	 if($error==0){
       $sql="SELECT * FROM codigos_ajustes where tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_aju' and  tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' order by cod_presup";  $res=pg_query($sql);
       if (($error==0)and(substr($tipo_ajuste,0,1)=="A")){$error=1;?><script language="JavaScript">muestra('AJUSTE A ORDEN NO PUEDE SER ANULADO');</script><?}
       if ($error==0){ $nmes=substr($fecha_anu,3,2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?}    }
	 }
	 if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if(($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
     }
     if($error==0){ $sfecha=$fecha_ajuste;
       if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);}
       else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }
     }
     if($error==0){  $sSQL="SELECT ced_rif,fecha FROM PAG001 where nro_orden='$referencia_caus'";
       $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas==0){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO A AJUSTAR NO EXISTE');</script><?}
        else{ $reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_orden=$reg["fecha"]; }
     }
     if($error==0){ if ($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DEL AJUSTE');</script><? } }
     if($error==0){
       $sfecha=$fecha_ajuste;
       $resultado=pg_exec($conn,"SELECT ANULA_PAG019('$referencia_aju','$tipo_ajuste','$tipo_ajuste_c','$afecha','$usuario_sia','$minf_usuario','$ced_rif','$descrip_anu')");
       $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
         $desc_doc="AJUSTE ORDEN DE PAGO:  REFERENCIA:".$referencia_aju.", DOCUMENTO AJUSTE:".$tipo_ajuste.", FECHA:".$fecha.", DESCRIPCION:".$adescripcion;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);   $error=substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
    }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">cerrar_ventana();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>