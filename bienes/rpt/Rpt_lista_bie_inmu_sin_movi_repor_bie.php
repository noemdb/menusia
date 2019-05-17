<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
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
(BIEN014.Fecha_Incorporacion>='$fecha_desde' AND BIEN014.Fecha_Incorporacion<='$fecha_hasta')";


   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN014.Cod_Bien_Inm, BIEN014.Codigo_Tipo_Incorp, BIEN014.Denominacion, BIEN014.Cod_ContableA, BIEN014.Valor_Incorporacion, BIEN003.Denomina_Tipo, 
BIEN003.Tipo, BIEN003.Gen_Comprobante, BIEN014.Cod_Dependencia, BIEN001.Denominacion_Dep, to_char(BIEN014.Fecha_Incorporacion,'DD/MM/YYYY') as fechai 
FROM BIEN014, BIEN003, BIEN001 
WHERE (BIEN001.Cod_Dependencia = BIEN014.Cod_Dependencia) AND (BIEN014.Codigo_Tipo_Incorp=BIEN003.Codigo) And
(BIEN014.Cod_Bien_Inm not in (Select BIEN041.Cod_Bien_Inm From BIEN041)) And ".$criterio." Order by BIEN014.Cod_Bien_Inm";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_bie_inmu_sin_movi_repor_bie_inmu.xml");
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
