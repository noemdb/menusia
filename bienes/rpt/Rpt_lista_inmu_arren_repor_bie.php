<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];
$cedulad=$_GET["cedulad"];$cedulah=$_GET["cedulah"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
        //cambiar formato a la fecha
       if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;

	$criterio ="(BIEN017.cod_bien_inm>='$cod_bien_inmd' AND BIEN017.cod_bien_inm<='$cod_bien_inmh') AND 
	(BIEN017.Fecha_Contrato>='$fecha_desde' AND BIEN017.Fecha_Contrato<='$fecha_hasta')";
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN017.Cod_Bien_Inm, BIEN014.Denominacion, BIEN014.Direccion, BIEN017.Numero_Contrato, BIEN017.Ced_Arrendatario, BIEN011.Nombre_Ocupante, to_char(BIEN017.Fecha_Contrato,'DD/MM/YYYY') as fechac , to_char(BIEN017.Fecha_Desde,'DD/MM/YYYY') as fechad , to_char(BIEN017.Fecha_Hasta,'DD/MM/YYYY') as fechah, BIEN017.Canon_Arr, BIEN017.Garantia_Fianza, BIEN017.Observacion  
FROM BIEN011 BIEN011, BIEN014 BIEN014, BIEN017 BIEN017 
WHERE BIEN014.Cod_Bien_Inm = BIEN017.Cod_Bien_Inm AND BIEN017.Ced_Arrendatario = BIEN011.Ced_Rif AND ".$criterio."";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_inmu_arren_repor_bie_inmu.xml");
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
