<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];
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
	
	$criterio ="(BIEN015.cod_bien_mue>='$cod_bien_mued' AND BIEN015.cod_bien_mue<='$cod_bien_mueh') AND 
(BIEN015.cod_empresa>='$cod_empresad' AND BIEN015.cod_empresa<='$cod_empresah') AND 
(BIEN015.Cod_Dependencia>='$cod_dependenciad' AND BIEN015.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN015.cod_direccion>='$cod_direcciond' AND BIEN015.cod_direccion<='$cod_direccionh') AND
(BIEN015.cod_departamento>='$cod_departamentod' AND BIEN015.cod_departamento<='$cod_departamentoh') AND
(BIEN015.Fecha_Incorporacion>='$fecha_desde' AND BIEN015.Fecha_Incorporacion<='$fecha_hasta')";


   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN015.Cod_Bien_Mue, BIEN015.Cod_Clasificacion, substr(BIEN015.Cod_Clasificacion,1,1) as grupo, substr(BIEN015.Cod_Clasificacion,3,2) as subgrupo, substr(BIEN015.Cod_Clasificacion,6,1) as seccion, BIEN015.Num_Bien, BIEN015.Denominacion, BIEN015.Cod_Dependencia,BIEN015.Cod_Direccion,BIEN015.Cod_Departamento,BIEN001.Denominacion_Dep, BIEN001.Direccion_Dep, BIEN015.Valor_Incorporacion, BIEN015.Monto_Depreciado, BIEN015.Fecha_Incorporacion, BIEN015.Caracteristicas, BIEN015.Marca, BIEN015.Modelo, BIEN015.Color, BIEN015.Matricula, BIEN015.Serial1, BIEN015.Tipo_Clase, BIEN015.Dimension_Tam, BIEN015.Accesorios, BIEN015.Serial2, BIEN015.Material, BIEN005.Denominacion_Dir, BIEN006.Denominacion_Dep as Den_Departamento  
FROM BIEN001 BIEN001,((BIEN015 BIEN015  LEFT JOIN BIEN005 ON (BIEN005.Cod_Dependencia=BIEN015.Cod_Dependencia And BIEN005.Cod_Direccion=BIEN015.Cod_Direccion)) LEFT JOIN BIEN006 ON (BIEN006.Cod_Departamento=BIEN015.Cod_Departamento And BIEN006.Cod_Dependencia=BIEN015.Cod_Dependencia And BIEN006.Cod_Direccion=BIEN015.Cod_Direccion)) 
WHERE BIEN001.Cod_Dependencia = BIEN015.Cod_Dependencia AND ".$criterio."
ORDER BY BIEN015.Cod_Bien_Mue";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_fi_bie_mue_depre_repor_bie_mue.xml");
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
