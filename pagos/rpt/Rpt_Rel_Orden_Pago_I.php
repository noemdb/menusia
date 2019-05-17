<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo=$_GET["tipo"];$criterio1="403-17-01-00";$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;

    //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT PAG018.NRO_ORDEN, PAG001.FECHA, PAG001.CONCEPTO, PAG018.COD_CONTABLE_A,
                PAG018.COD_PRESUP, PAG018.MONTO_CONTABLE
                FROM PAG018, PAG001
                WHERE PAG018.NRO_ORDEN = PAG001.NRO_ORDEN AND
                PAG001.FECHA>='".$fecha_desde."' AND PAG001.FECHA<='".$fecha_hasta."'";

       $oRpt = new PHPReportMaker();
       $oRpt->setXML("Rpt_Rel_Orden_Pago_IVA.xml");
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
?>

