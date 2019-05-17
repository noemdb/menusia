<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$codigo_partida=$_GET["codigo_partida"];$codigo_contable=$_GET["codigo_contable"];$asociacion=$_GET["asociacion"];$criterio1="Partida Presupuestaria ";$Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
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
 else{
    // LLAMAR A PHP_REPORT
   $sSQL = "SELECT PAG001.Nro_Orden, PAG001.Tipo_Causado, PAG001.Fecha, PAG001.Ced_Rif,
            PAG001.Concepto, PAG001.Status, PAG001.Fecha_Cheque,
            PAG001.Anulado, PAG001.Fecha_Anulado, PAG018.Cod_Contable_A, PAG018.Cod_Presup, PAG018.Monto_Contable,
            PAG018.Monto_Presup, PRE007.Referencia_Caus, PRE007.Tipo_Causado, PRE007.Referencia_Comp,
            PRE007.Tipo_Compromiso
            FROM PAG001, PAG018, PRE007
            WHERE PAG001.Nro_Orden = PRE007.Referencia_Caus AND PAG001.Tipo_Causado = PRE007.Tipo_Causado AND
            PRE007.Referencia_Caus = PAG018.Nro_Orden AND PAG018.Tipo_Causado = PRE007.Tipo_Causado AND
            PRE007.Referencia_Comp = PAG018.Referencia_Comp AND PAG018.Tipo_Compromiso = PRE007.Tipo_Compromiso AND
            PAG001.Fecha>='".$fecha_desde."' AND PAG001.Fecha<='".$fecha_hasta."' AND
            PAG018.Cod_Presup='".$codigo_partida."'";
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_Rel_Orden_Pago_Aso_Contab.xml");
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
