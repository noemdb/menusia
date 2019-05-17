<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_semd=$_GET["cod_bien_semd"];$cod_bien_semh=$_GET["cod_bien_semh"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$referenciad=$_GET["referenciad"]; $referenciah=$_GET["referenciah"];$fecha_d=$_GET["fecha_d"];print_r($fecha_d);
$date = date("d-m-Y");
$mes = date("m");
$ano = date("Y");$hora = date("H:i:s a");$Sql="";
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
(BIEN026.Referencia>='$referenciad' AND BIEN026.Referencia<='$referenciah') AND 
(to_char(BIEN026.Fecha,'MM/YYYY')='$fecha_d')";


   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN026.Referencia, BIEN026.Fecha, BIEN016.Cod_Bien_Sem, BIEN016.Cod_Clasificacion, substr(BIEN016.Cod_Clasificacion,1,1) as grupo, substr(BIEN016.Cod_Clasificacion,3,2) as subgrupo, substr(BIEN016.Cod_Clasificacion,6,1) as seccion, BIEN016.Num_Bien, BIEN016.Denominacion,
BIEN026.Cod_Dependencia, BIEN001.Denominacion_Dep, BIEN001.Direccion_Dep, BIEN042.Tipo_Movimiento, BIEN003.Denomina_Tipo, BIEN042.Tipo_ID, BIEN026.Descripcion, BIEN026.Anulado, BIEN042.Cantidad, 
BIEN042.Monto, BIEN016.Direccion, BIEN016.Valor_Incorporacion, BIEN026.Saldo_Anterior  
FROM BIEN001, BIEN003, BIEN016, BIEN026, BIEN042 
WHERE BIEN001.Cod_Dependencia = BIEN026.Cod_Dependencia AND (BIEN026.Fecha=BIEN042.Fecha) AND
BIEN016.Cod_Bien_Sem = BIEN042.Cod_Bien_Sem AND  BIEN026.Referencia = BIEN042.Referencia AND
BIEN042.Tipo_Movimiento = BIEN003.Codigo AND ((BIEN026.Anulado='N')) AND ".$criterio."";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_movi_bie_semo_repor_semo.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora,"mes"=>$mes,"ano"=>$ano));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
   }
?>
