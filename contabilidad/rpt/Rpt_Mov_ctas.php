<?include ("../../class/phpreports/PHPReportMaker.php"); include ("../../class/conect.php"); include ("../../class/fun_fechas.php"); error_reporting(E_ALL ^ E_NOTICE);
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $ced_rif_d=$_GET["ced_rif_d"]; $ced_rif_h=$_GET["ced_rif_h"];
$tipo_asiento_d="O/P";$tipo_asiento_h="O/P"; $cod_cuenta_h=$_GET["cod_cuenta_h"]; $cod_cuenta_d=$_GET["cod_cuenta_d"]; $vstatus=$_GET["vstatus"];
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; $criterio2="";  $date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','2')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);  $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_MOV_CON013_RIF('".$usuario_sia."','2','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ced_rif_d."','".$ced_rif_h."','".$cod_cuenta_d."','".$cod_cuenta_h."','".$vstatus."')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
       else{ 
	        
			$Sql= "SELECT CON013.fecha,to_char(CON013.fecha,'DD/MM/YYYY') as fechaf, CON013.referencia, CON013.tipo_asiento, CON013.tipo_comp, CON013.aoperacion, CON013.descripcion, CON013.cod_cuenta, CON013.debito_credito, CON013.columna1, CON013.columna2, 
			       CON013.descripcion_a, CON013.nombre_cuenta, CON013.Nombre_Usuario, CON013.Tipo_Registro, text(con013.referencia)||text(con013.tipo_comp) as clave_comp, CON013.codigo_cuenta2, pre099.nombre FROM CON013 left join pre099 on (CON013.codigo_cuenta2=pre099.ced_rif)
         		   WHERE (columna1<>0 or columna2<>0) and nombre_usuario='".$usuario_sia."' AND tipo_registro='2' ORDER BY fecha, referencia, aoperacion";
            $Sql= "SELECT CON013.fecha,to_char(CON013.fecha,'DD/MM/YYYY') as fechaf, CON013.referencia, CON013.tipo_asiento, CON013.tipo_comp, CON013.aoperacion, CON013.descripcion, CON013.cod_cuenta, CON013.debito_credito, CON013.columna1, CON013.columna2,
			       CON013.descripcion_a, CON013.nombre_cuenta, CON013.Nombre_Usuario, CON013.Tipo_Registro, text(con013.referencia)||text(con013.tipo_comp) as clave_comp, CON013.codigo_cuenta2, pre099.nombre, ban002.nombre_banco, ban002.nro_cuenta,
				   pag001.status,pag001.cod_banco,pag001.nro_cheque,pag001.fecha_cheque,pag001.tipo_pago,pre007.referencia_comp,pre007.tipo_compromiso,pre002.nombre_abrev_comp,pre002.nombre_tipo_comp,pre006.unidad_sol,pre019.Denominacion_Cat	FROM CON013 left join pre099 on (CON013.codigo_cuenta2=pre099.ced_rif), pag001 left join ban002 on (pag001.cod_banco=ban002.cod_banco),pre007,pre002,pre006,pre019  
				   WHERE (CON013.nombre_usuario='".$usuario_sia."') AND (CON013.tipo_registro='2') and (con013.referencia=pag001.nro_orden) and (pag001.tipo_causado=substring(con013.tipo_comp,2,4)) and (pag001.anulado='N') and (pre007.referencia_caus=pag001.nro_orden) and (pag001.tipo_causado=pre007.tipo_causado) and (pre002.tipo_compromiso=pre007.tipo_compromiso) and (pre006.tipo_compromiso=pre007.tipo_compromiso) and (pre006.referencia_comp=pre007.referencia_comp) and (pre006.unidad_sol=pre019.Cod_Presup_Cat) and (CON013.columna1<>0 or CON013.columna2<>0) ORDER BY fecha, referencia, aoperacion";
			 $sSQL = $Sql;
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Movimientos_Cuentas.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>"$criterio1","criterio2"=>"$criterio2"));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec = $aBench["report_end"]-$aBench["report_start"];
           }
}
?>