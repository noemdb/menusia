<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_semd=$_GET["cod_bien_semd"];$cod_bien_semh=$_GET["cod_bien_semh"];
$cod_empresad=$_GET["cod_empresad"];$cod_empresah=$_GET["cod_empresah"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"];
print_r($cod_departamentod);
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
(BIEN016.cod_empresa>='$cod_empresad' AND BIEN016.cod_empresa<='$cod_empresah') AND 
(BIEN016.Cod_Dependencia>='$cod_dependenciad' AND BIEN016.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN016.cod_direccion>='$cod_direcciond' AND BIEN016.cod_direccion<='$cod_direccionh') AND
(BIEN016.cod_departamento>='$cod_departamentod' AND BIEN016.cod_departamento<='$cod_departamentoh')";


   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN016.Cod_Bien_Sem, BIEN016.Denominacion, BIEN016.Cod_Dependencia, BIEN001.Denominacion_Dep, BIEN016.Valor_Incorporacion 
		  FROM BIEN001 BIEN001, BIEN016 BIEN016 
                  WHERE BIEN001.Cod_Dependencia = BIEN016.Cod_Dependencia AND ".$criterio."";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_bie_semo_repor_semo.xml");
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
