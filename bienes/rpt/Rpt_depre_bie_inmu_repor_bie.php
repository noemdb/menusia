<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$referencia_depd=$_GET["referencia_depd"]; $referencia_deph=$_GET["referencia_deph"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$calculo=$_GET["calculo"];print_r($calculo);
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
        //cambiar formato a la fecha
       if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");

   $criterio ="(BIEN014.cod_bien_inm>='$cod_bien_inmd' AND BIEN014.cod_bien_inm<='$cod_bien_inmh') AND 
(BIEN014.Cod_Dependencia>='$cod_dependenciad' AND BIEN014.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN027.Referencia_Dep>='$referencia_depd' AND BIEN027.Referencia_Dep<='$referencia_deph') AND
(BIEN027.Fecha_Dep>='$fecha_desde' AND BIEN027.Fecha_Dep<='$fecha_hasta')";

if ($calculo=='T'){$criterio=$criterio; }
if ($calculo=='M'){$criterio=$criterio." AND BIEN027.Met_Calculo='M'";}
if ($calculo=='A'){$criterio=$criterio." AND BIEN027.Met_Calculo='A'";}


if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else
{

         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN014.Cod_Bien_Inm, BIEN014.Denominacion, BIEN027.Referencia_Dep, BIEN014.Denominacion, BIEN027.Referencia_Dep, BIEN027.Fecha_Dep, BIEN027.Descripcion, BIEN027.Met_Calculo, BIEN027.Status, BIEN027.Anulado, BIEN014.Valor_Incorporacion, BIEN027.Monto_Dep, BIEN014.Valor_Residual, BIEN027.Saldo_Dep, BIEN014.Cod_Dependencia, BIEN001.Denominacion_Dep, to_char(BIEN027.Fecha_Dep,'DD/MM/YYYY') as fechad  
FROM BIEN001, BIEN014, BIEN027, BIEN048
WHERE BIEN014.Cod_Bien_Inm = BIEN048.Cod_Bien_Inm AND BIEN014.Cod_Dependencia = BIEN001.Cod_Dependencia AND BIEN027.Referencia_Dep=BIEN048.Referencia_Dep AND ".$criterio."
ORDER BY BIEN048.Cod_Bien_Inm, BIEN027.Referencia_Dep,  BIEN027.Fecha_Dep";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_depre_bie_inmu_repor_bie_inmu.xml");
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
