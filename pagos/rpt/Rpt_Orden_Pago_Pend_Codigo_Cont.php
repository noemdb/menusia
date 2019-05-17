<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cuenta_h=$_GET["cod_cuenta_h"];$criterio1="Desde ".$fecha_d." Al ".$fecha_h;$Sql="";
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;
$date = date("d-m-Y");$hora = date("H:i:s a");
         // print_r($status_orden);
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
    // LLAMAR A PHP_REPORT
   $sSQL = "SELECT PAG001.Nro_Orden, PAG001.Tipo_Causado, PAG001.Tipo_Orden, PAG008.Des_Tipo_Orden, PAG001.Fecha, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Concepto,
   PAG001.Cod_Contable_O, CON001.Nombre_Cuenta, PAG001.Status, SUM(PAG001.Total_Causado-PAG001.Monto_Am_Ant-PAG001.Total_Retencion-PAG001.Total_Ajuste) AS Neto_Orden
   FROM PAG001 LEFT JOIN PRE099 ON (PRE099.Ced_Rif=PAG001.Ced_Rif) LEFT JOIN
   PAG008 ON (PAG008.Tipo_Orden=PAG001.Tipo_Orden) LEFT JOIN
   CON001 ON (CON001.Codigo_Cuenta=PAG001.Cod_Contable_O)
   WHERE PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
   PAG001.Tipo_Orden>='".$tipo_orden_d."' AND PAG001.Tipo_Orden<='".$tipo_orden_h."' AND
   PAG001.Cod_Contable_O>='".$cod_cuenta_d."' AND PAG001.Cod_Contable_O<='".$cod_cuenta_h."'
   GROUP BY PAG001.Nro_Orden, PAG001.Tipo_Causado, PAG001.Tipo_Orden, PAG008.Des_Tipo_Orden, PAG001.Fecha, PAG001.Ced_Rif, PRE099.Nombre, PAG001.Concepto,
   PAG001.Cod_Contable_O, CON001.Nombre_Cuenta, PAG001.Status";

   $oRpt = new PHPReportMaker();
   $oRpt->setXML("Rpt_Orden_Pago_Pend_Codigo_Contable.xml");
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
?>
