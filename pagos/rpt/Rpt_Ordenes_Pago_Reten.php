<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$tipo_retencion_d=$_GET["tipo_retencion_d"];$tipo_retencion_h=$_GET["tipo_retencion_h"];$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
    $clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];$informacion_beneficiario=$_GET["informacion_beneficiario"];$imprimir_monto=$_GET["imprimir_monto"];
    $imprimir_orden=$_GET["imprimir_orden"];$fecha_cancelada_d=$_GET["fecha_cancelada_d"];$fecha_cancelada_h=$_GET["fecha_cancelada_h"];$status_orden=$_GET["status_orden"];$informacion_cancelada=$_GET["informacion_cancelada"];
    $criterio1="Desde ".$fecha_d." Al ".$fecha_h;
    $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;

if ($informacion_beneficiario=='N'&& $imprimir_monto=='N')
{
           $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
           if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
           else
           {
           // LLAMAR A PHP_REPORT
              $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto,
                       PAG004.Monto_Retencion, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status,
                       PAG001.Anulado, PAG001.Fecha_Anulado, PAG004.Tipo_Retencion,
                       PAG004.Nro_Orden_Ret, PAG001.Fecha_Cheque, PAG004.Monto_Objeto_Ret,
                       PAG004.Tasa_Retencion, PAG004.Status_R, PAG004.Cod_Banco_R,
                       PAG004.Nro_Cheque_R, PAG004.Fecha_Cheque_R, PAG004.Tipo_Pago_R
                       FROM PAG001, PAG004, PRE099
                       WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                       PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                       PAG004.Aux_Orden>='".$nro_orden_d."' AND PAG004.Aux_Orden<='".$nro_orden_h."' AND
                       PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                       PRE099.CLASIFICACION>='".$clasificacion_d."' AND PRE099.CLASIFICACION<='".$clasificacion_h."'
                       ORDER BY PAG004.Aux_Orden";

                       $oRpt = new PHPReportMaker();
                       $oRpt->setXML("Rpt_Orden_Pago_Retencion.xml");
                       $oRpt->setUser("$user");
                       $oRpt->setPassword("$password");
                       $oRpt->setConnection("localhost");
                       $oRpt->setDatabaseInterface("postgresql");
                       $oRpt->setSQL($sSQL);
                       $oRpt->setDatabase("$dbname");
                       $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
                       $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
                       $oRpt->run();
                       $aBench = $oRpt->getBenchmark();
                       $iSec   = $aBench["report_end"]-$aBench["report_start"];
           }
}
elseif ($informacion_beneficiario=='N'&& $imprimir_monto=='S')
{

           $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
           if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
           else
           {
           // LLAMAR A PHP_REPORT
              $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto,
                       PAG004.Monto_Retencion, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status,
                       PAG001.Anulado, PAG001.Fecha_Anulado, PAG004.Tipo_Retencion,
                       PAG004.Nro_Orden_Ret, PAG001.Fecha_Cheque, PAG004.Monto_Objeto_Ret,
                       PAG004.Tasa_Retencion, PAG004.Status_R, PAG004.Cod_Banco_R,
                       PAG004.Nro_Cheque_R, PAG004.Fecha_Cheque_R, PAG004.Tipo_Pago_R
                       FROM PAG001, PAG004, PRE099
                       WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                       PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                       PAG004.Aux_Orden>='".$nro_orden_d."' AND PAG004.Aux_Orden<='".$nro_orden_h."' AND
                       PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                       PRE099.CLASIFICACION>='".$clasificacion_d."' AND PRE099.CLASIFICACION<='".$clasificacion_h."'
                       ORDER BY PAG004.Aux_Orden";

                       $oRpt = new PHPReportMaker();
                       $oRpt->setXML("Rpt_Orden_Pago_Retencion_Monto_Objeto.xml");
                       $oRpt->setUser("$user");
                       $oRpt->setPassword("$password");
                       $oRpt->setConnection("localhost");
                       $oRpt->setDatabaseInterface("postgresql");
                       $oRpt->setSQL($sSQL);
                       $oRpt->setDatabase("$dbname");
                       $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
                       $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
                       $oRpt->run();
                       $aBench = $oRpt->getBenchmark();
                       $iSec   = $aBench["report_end"]-$aBench["report_start"];
           }
}
elseif ($informacion_beneficiario=='S' && $imprimir_monto=='N')
{
           $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
           if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
           else
           {
           // LLAMAR A PHP_REPORT
              $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto,
                       PAG004.Monto_Retencion, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status,
                       PAG001.Anulado, PAG001.Fecha_Anulado, PAG004.Tipo_Retencion,
                       PAG004.Nro_Orden_Ret, PAG001.Fecha_Cheque, PAG004.Monto_Objeto_Ret,
                       PAG004.Tasa_Retencion, PAG004.Status_R, PAG004.Cod_Banco_R,
                       PAG004.Nro_Cheque_R, PAG004.Fecha_Cheque_R, PAG004.Tipo_Pago_R
                       FROM PAG001, PAG004, PRE099
                       WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                       PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                       PAG004.Aux_Orden>='".$nro_orden_d."' AND PAG004.Aux_Orden<='".$nro_orden_h."' AND
                       PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                       PRE099.CLASIFICACION>='".$clasificacion_d."' AND PRE099.CLASIFICACION<='".$clasificacion_h."'
                       ORDER BY PAG004.Aux_Orden";

                       $oRpt = new PHPReportMaker();
                       $oRpt->setXML("Rpt_Orden_Pago_Retencion_Detallado.xml");
                       $oRpt->setUser("$user");
                       $oRpt->setPassword("$password");
                       $oRpt->setConnection("localhost");
                       $oRpt->setDatabaseInterface("postgresql");
                       $oRpt->setSQL($sSQL);
                       $oRpt->setDatabase("$dbname");
                       $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
                       $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
                       $oRpt->run();
                       $aBench = $oRpt->getBenchmark();
                       $iSec   = $aBench["report_end"]-$aBench["report_start"];
           }
}
elseif ($informacion_beneficiario=='S' && $imprimir_monto=='S')
{
           $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
           if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
           else
           {
           // LLAMAR A PHP_REPORT
              $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto,
                       PAG004.Monto_Retencion, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status,
                       PAG001.Anulado, PAG001.Fecha_Anulado, PAG004.Tipo_Retencion,
                       PAG004.Nro_Orden_Ret, PAG001.Fecha_Cheque, PAG004.Monto_Objeto_Ret,
                       PAG004.Tasa_Retencion, PAG004.Status_R, PAG004.Cod_Banco_R,
                       PAG004.Nro_Cheque_R, PAG004.Fecha_Cheque_R, PAG004.Tipo_Pago_R, PRE099.Campo_str2
                       FROM PAG001, PAG004, PRE099
                       WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                       PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                       PAG004.Aux_Orden>='".$nro_orden_d."' AND PAG004.Aux_Orden<='".$nro_orden_h."' AND
                       PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                       PRE099.CLASIFICACION>='".$clasificacion_d."' AND PRE099.CLASIFICACION<='".$clasificacion_h."'
                       ORDER BY PAG004.Aux_Orden";

                       $oRpt = new PHPReportMaker();
                       $oRpt->setXML("Rpt_Orden_Pago_Retencion_Detallado_Monto_Objeto.xml");
                       $oRpt->setUser("$user");
                       $oRpt->setPassword("$password");
                       $oRpt->setConnection("localhost");
                       $oRpt->setDatabaseInterface("postgresql");
                       $oRpt->setSQL($sSQL);
                       $oRpt->setDatabase("$dbname");
                       $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
                       $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
                       $oRpt->run();
                       $aBench = $oRpt->getBenchmark();
                       $iSec   = $aBench["report_end"]-$aBench["report_start"];
           }
}
?>
