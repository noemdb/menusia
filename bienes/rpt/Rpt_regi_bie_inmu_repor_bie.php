<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];
$cod_empresad=$_GET["cod_empresad"];$cod_empresah=$_GET["cod_empresah"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"];
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
(BIEN014.cod_empresa>='$cod_empresad' AND BIEN014.cod_empresa<='$cod_empresah') AND 
(BIEN014.Cod_Dependencia>='$cod_dependenciad' AND BIEN014.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN014.cod_direccion>='$cod_direcciond' AND BIEN014.cod_direccion<='$cod_direccionh') AND
(BIEN014.cod_departamento>='$cod_departamentod' AND BIEN014.cod_departamento<='$cod_departamentoh')";

   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT *
FROM BIEN001, BIEN002, BIEN004, BIEN009, BIEN010, BIEN014, BIEN030, PRE091, PRE092, PRE093, PRE094, PRE099  
WHERE BIEN001.Cod_Dependencia = BIEN014.Cod_Dependencia AND BIEN002.Ced_Responsable = BIEN014.Ced_Responsable AND 
BIEN014.Cod_Region = PRE092.Cod_Region AND BIEN014.Cod_Municipio = PRE093.Cod_Municipio AND BIEN014.Cod_Ciudad = PRE094.Cod_Ciudad AND 
BIEN014.Edo_Conservacion = BIEN004.Codigo AND BIEN014.Sit_Legal = BIEN009.Codigo AND BIEN014.Sit_Contable = BIEN010.Codigo AND
BIEN014.Cod_Entidad = PRE091.Cod_Estado AND BIEN014.Ced_Rif_Proveedor = PRE099.Ced_Rif AND 
BIEN014.Ced_Verificador = BIEN030.Ced_Res_Verificador AND ".$criterio."";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_regi_bie_inmu_repor_bie_inmu.xml");
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
