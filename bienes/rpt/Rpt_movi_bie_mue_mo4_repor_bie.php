<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"];
$referenciad=$_GET["referenciad"]; $referenciah=$_GET["referenciah"]; $fecha_d=$_GET["fecha_d"];print_r($fecha_d);
//print_r($cedulad);print_r($cedulah);
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
        //cambiar formato a la fecha
       if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;

$criterio ="(BIEN015.Cod_Bien_Mue>='$cod_bien_mued' AND BIEN015.Cod_Bien_Mue<='$cod_bien_mueh') AND 
(BIEN025.Cod_Dependencia>='$cod_dependenciad' AND BIEN025.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN025.Referencia>='$referenciad' AND BIEN025.Referencia<='$referenciah') AND 
(to_char(BIEN025.Fecha,'MM/YYYY')='$fecha_d')";

   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN025.Referencia, BIEN025.Fecha, BIEN015.Cod_Bien_Mue, BIEN015.Cod_Clasificacion, substr(BIEN015.Cod_Clasificacion,1,1) as grupo, substr(BIEN015.Cod_Clasificacion,3,2) as subgrupo, substr(BIEN015.Cod_Clasificacion,6,1) as seccion, BIEN015.Num_Bien, BIEN015.Denominacion,
BIEN025.Cod_Dependencia, BIEN001.Denominacion_Dep, BIEN001.Direccion_Dep, BIEN040.Tipo_Movimiento, BIEN003.Denomina_Tipo, BIEN040.Tipo_ID, BIEN025.Descripcion, BIEN025.Anulado, BIEN040.Cantidad, 
BIEN040.Monto, BIEN015.Direccion, BIEN015.Valor_Incorporacion, BIEN025.Saldo_Anterior  
FROM BIEN001, BIEN003, BIEN015, BIEN025, BIEN040 
WHERE BIEN001.Cod_Dependencia = BIEN025.Cod_Dependencia AND (BIEN025.Fecha=BIEN040.Fecha) AND
BIEN015.Cod_Bien_Mue = BIEN040.Cod_Bien_Mue AND  BIEN025.Referencia = BIEN040.Referencia AND
BIEN040.Tipo_Movimiento = BIEN003.Codigo AND ((BIEN025.Anulado='N')) AND ".$criterio."";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_movi_bie_mue_mo4_repor_bie_mue.xml");
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
