<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];
$cedulad=$_GET["cedulad"];$cedulah=$_GET["cedulah"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
$numero_contratod=$_GET["numero_contratod"];$numero_contratoh=$_GET["numero_contratoh"];
//print_r($cedulad);print_r($cedulah);
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
        //cambiar formato a la fecha
       if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;

	$criterio ="(BIEN019.Cod_Bien_Mue>='$cod_bien_mued' AND BIEN019.Cod_Bien_Mue<='$cod_bien_mueh') AND 
                    (BIEN019.Ced_Rif_Proveedor>='$cedulad' AND BIEN019.Ced_Rif_Proveedor<='$cedulah') AND
                    (BIEN019.Numero_Contrato>='$numero_contratod' AND BIEN019.Numero_Contrato<='$numero_contratoh') AND
	            (BIEN019.Fecha_Contrato>='$fecha_desde' AND BIEN019.Fecha_Contrato<='$fecha_hasta')";
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN019.Cod_Bien_Mue, BIEN015.Denominacion, BIEN015.Direccion, BIEN019.Numero_Contrato, BIEN019.Ced_Rif_Proveedor, PRE099.Nombre, to_char(BIEN019.Fecha_Contrato,'DD/MM/YYYY') as fechac, to_char(BIEN019.Fecha_Desde,'DD/MM/YYYY') as fechad, to_char(BIEN019.Fecha_Hasta,'DD/MM/YYYY') as fechah, BIEN019.Monto_Contrato  
FROM BIEN015 BIEN015, BIEN019 BIEN019, PRE099 PRE099  
WHERE BIEN015.Cod_Bien_Mue = BIEN019.Cod_Bien_Mue AND BIEN019.Ced_Rif_Proveedor = PRE099.Ced_Rif  AND ".$criterio."
ORDER BY BIEN019.Cod_Bien_Mue";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_conta_man_mue_repor_bie_mue.xml");
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
