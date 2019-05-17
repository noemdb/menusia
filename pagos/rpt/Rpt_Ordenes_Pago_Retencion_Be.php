<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cedula_d=$_GET["cedula_d"];
   $cedula_h=$_GET["cedula_h"];
   $tipo_retencion_d=$_GET["tipo_retencion_d"];
   $tipo_retencion_h=$_GET["tipo_retencion_h"];
   $numero_orden_d=$_GET["numero_orden_d"];
   $numero_orden_h=$_GET["numero_orden_h"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $status_orden=$_GET["status_orden"];
   $criterio1="Desde ".$fecha_d." Al ".$fecha_h;
   $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;
           //print_r($status_orden);
           //print_r($criterio1);
if ($status_orden=='I')
{
    $criterio2="CANCELADA";
     //print_r($criterio2);
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto, PAG004.Monto_Retencion,
                PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status, PAG001.Anulado, PAG001.Fecha_Anulado,
                PAG004.Tipo_Retencion, PAG001.Fecha_Cheque, PRE099.Campo_str2
                FROM PAG001, PAG004, PRE099
                WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                PAG001.Ced_Rif>='".$cedula_d."' AND PAG001.Ced_Rif<='".$cedula_h."' AND
                PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                PAG004.Aux_Orden>='".$numero_orden_d."' AND PAG004.Aux_Orden<='".$numero_orden_h."' AND
                PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                PAG001.STATUS = '".$status_orden."' AND
                PAG001.FECHA_CHEQUE<='".$fecha_hasta."'
                ORDER BY PRE099.Nombre";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Ordenes_Pago_Retencion_Benef.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
   }
}

else
{
    if ($status_orden=='S')
    {
        $criterio2="ANULADA";
        //print_r($criterio2);
        //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
            // LLAMAR A PHP_REPORT
            $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto, PAG004.Monto_Retencion,
                PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status, PAG001.Anulado, PAG001.Fecha_Anulado,
                PAG004.Tipo_Retencion, PAG001.Fecha_Cheque, PRE099.Campo_str2
                FROM PAG001, PAG004, PRE099
                WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                PAG001.Ced_Rif>='".$cedula_d."' AND PAG001.Ced_Rif<='".$cedula_h."' AND
                PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                PAG004.Aux_Orden>='".$numero_orden_d."' AND PAG004.Aux_Orden<='".$numero_orden_h."' AND
                PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                PAG001.STATUS = '".$status_orden."' AND
                PAG001.FECHA_ANULADA<='".$fecha_hasta."'
                ORDER BY PRE099.Nombre";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Ordenes_Pago_Retencion_Benef.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
        }
    }

else
{
    if ($status_orden=='N')
    {
        $criterio2="PENDIENTE";
        //print_r($criterio2);
        //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
            // LLAMAR A PHP_REPORT
            $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto, PAG004.Monto_Retencion,
                PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status, PAG001.Anulado, PAG001.Fecha_Anulado,
                PAG004.Tipo_Retencion, PAG001.Fecha_Cheque, PRE099.Campo_str2
                FROM PAG001, PAG004, PRE099
                WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                PAG001.Ced_Rif>='".$cedula_d."' AND PAG001.Ced_Rif<='".$cedula_h."' AND
                PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                PAG004.Aux_Orden>='".$numero_orden_d."' AND PAG004.Aux_Orden<='".$numero_orden_h."' AND
                PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                PAG001.STATUS = '".$status_orden."'
                ORDER BY PRE099.Nombre";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Ordenes_Pago_Retencion_Benef.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
        }
    }

else
{
    if ($status_orden=='L')
    {
        $criterio2="LIBERADA";
        //print_r($criterio2);
        //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
            // LLAMAR A PHP_REPORT
            $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto, PAG004.Monto_Retencion,
                PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status, PAG001.Anulado, PAG001.Fecha_Anulado,
                PAG004.Tipo_Retencion, PAG001.Fecha_Cheque, PRE099.Campo_str2
                FROM PAG001, PAG004, PRE099
                WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                PAG001.Ced_Rif>='".$cedula_d."' AND PAG001.Ced_Rif<='".$cedula_h."' AND
                PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                PAG004.Aux_Orden>='".$numero_orden_d."' AND PAG004.Aux_Orden<='".$numero_orden_h."' AND
                PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
                PAG001.STATUS = '".$status_orden."' AND
                PAG001.FECHA_CHEQUE<='".$fecha_hasta."'
                ORDER BY PRE099.Nombre";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Ordenes_Pago_Retencion_Benef.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
        }
    }
else
    {
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
            // LLAMAR A PHP_REPORT
            $sSQL = "SELECT PAG004.Aux_Orden, PAG001.Fecha, PAG001.Concepto, PAG004.Monto_Retencion,
                PAG001.Ced_Rif, PRE099.Nombre, PAG001.Status, PAG001.Anulado, PAG001.Fecha_Anulado,
                PAG004.Tipo_Retencion, PAG001.Fecha_Cheque, PRE099.Campo_str2
                FROM PAG001, PAG004, PRE099
                WHERE PAG001.Ced_Rif = PRE099.Ced_Rif AND PAG001.Nro_Orden = PAG004.Aux_Orden AND
                PAG001.Ced_Rif>='".$cedula_d."' AND PAG001.Ced_Rif<='".$cedula_h."' AND
                PAG004.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG004.Tipo_Retencion<='".$tipo_retencion_h."' AND
                PAG004.Aux_Orden>='".$numero_orden_d."' AND PAG004.Aux_Orden<='".$numero_orden_h."' AND
                PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."'
                ORDER BY PRE099.Nombre";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Ordenes_Pago_Retencion_Benef.xml");
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
}
}
}
?>
