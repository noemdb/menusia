<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$tipo_pago=$_GET["txttipo_pago"];$referencia_pago=$_GET["txtreferencia_pago"];$cod_banco=$_GET["txtcod_banco"];
$referencia_caus=$_GET["txtreferencia_caus"];$tipo_causado=$_GET["txttipo_causado"];
$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"];
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $Nom_Emp=busca_conf(); $periodom=$SIA_Periodo;  $error=0; if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?} 
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
  }  $SIA_Periodoc=$SIA_Periodo;
  $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodoc=$registro["campo503"];}} $valida_c=substr($campo502,2,1);
  if($error==0){
    $sSQL="Select * from pre008 WHERE tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_banco='$cod_banco'" ;
    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE PAGO NO EXISTE');</script><?}
     else{   $registro=pg_fetch_array($resultado);    $fecha_pago=$registro["fecha_pago"];    $adescripcion=$registro["descripcion_pago"]; $genera_comprobante=$registro["genera_comprobante"];
        if($genera_comprobante=="S"){ if ($SIA_Periodo<$SIA_Periodoc){$SIA_Periodo=$SIA_Periodoc;}
		  if(($error==0)and($valida_c=="S")){ $tipo_comp='G'.$tipo_pago;
	        $sql="SELECT referencia,status from con002 Where referencia='$referencia_pago' And fecha='$fecha_pago' And tipo_comp='$tipo_comp'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
            if ($filas>0){ $reg=pg_fetch_array($resultado); $mstatusc=$reg["status"]; if($mstatusc=="A"){$error=1;?><script language="JavaScript">muestra('Comprobante Contable del Pago esta Actualizado, debe cambiar a Diferido');</script><?} }
	      }
		}
	  }
  }	  
  $periodom=$SIA_Periodo;
  if($error==0){$nmes=substr($fecha_pago,5, 2);if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}
   if($periodom>$nmes){echo $periodom.' '.$nmes.' '.$fecha_pago;$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
    
  if($error==0){ 
	 $sql="SELECT * FROM codigos_pagos where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_banco='$cod_banco' order by cod_presup";
     $res=pg_query($sql);  $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){   $total=$total+$registro["monto"];  $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];   }
     $sfecha=$fecha_pago;
     $resultado=pg_exec($conn,"SELECT ELIMINA_PRE008('$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$cod_banco','S')");
     $error=pg_errormessage($conn);   $error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $desc_doc="MOV.PAGO: DOCUMENTO PAGO:".$tipo_pago.", REFERENCIA PAGO:".$referencia_pago.", DOCUMENTO CAUSADO:".$tipo_causado.", REFERENCIA CAUSADO:".$referencia_caus.", DOCUMENTO COMPROMISO:".$tipo_compromiso.", REFERENCIA COMPROMISO:".$referencia_comp.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;
         $desc_doc=$desc_doc.$desc_cod; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);$error=substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>