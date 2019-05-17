<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_semd=$_GET["cod_bien_semd"];$cod_bien_semh=$_GET["cod_bien_semh"];
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

   $criterio ="(BIEN016.cod_bien_sem>='$cod_bien_semd' AND BIEN016.cod_bien_sem<='$cod_bien_semh') AND 
(BIEN016.Cod_Dependencia>='$cod_dependenciad' AND BIEN016.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN029.Referencia_Dep>='$referencia_depd' AND BIEN029.Referencia_Dep<='$referencia_deph') AND
(BIEN029.Fecha_Dep>='$fecha_desde' AND BIEN029.Fecha_Dep<='$fecha_hasta')";

if ($calculo=='T'){$criterio=$criterio; }
if ($calculo=='M'){$criterio=$criterio." AND BIEN029.Met_Calculo='M'";}
if ($calculo=='A'){$criterio=$criterio." AND BIEN029.Met_Calculo='A'";}


if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else
{
     // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN016.Cod_Bien_Sem, BIEN016.Denominacion, BIEN029.Referencia_Dep, BIEN029.Fecha_Dep, BIEN029.Descripcion, BIEN029.Met_Calculo, 
BIEN029.Status, BIEN029.Anulado, BIEN016.Valor_Incorporacion, BIEN049.Monto_Dep, BIEN016.Valor_Residual, BIEN049.Saldo_Dep, BIEN016.Cod_Dependencia, BIEN001.Denominacion_Dep, to_char(BIEN029.Fecha_Dep,'DD/MM/YYYY') as fechad   
FROM BIEN001, BIEN016, BIEN029,  BIEN049
WHERE BIEN016.Cod_Bien_Sem = BIEN049.Cod_Bien_Sem  AND BIEN016.Cod_Dependencia = BIEN001.Cod_Dependencia AND BIEN029.Referencia_Dep=BIEN049.Referencia_Dep AND ".$criterio."
ORDER BY BIEN049.Cod_Bien_Sem, BIEN029.Referencia_Dep, BIEN029.Fecha_Dep";


            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_depre_bie_semo_repor_semo.xml");
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
