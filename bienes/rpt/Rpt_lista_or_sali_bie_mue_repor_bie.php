<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];
$referenciad=$_GET["referenciad"];$referenciad=$_GET["referenciad"];
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
	
	$criterio ="(BIEN043.Referencia>='$referenciad' AND BIEN043.Referencia<='$referenciah') AND 
(BIEN044.Cod_Bien_Mue>='$cod_bien_mued' AND BIEN044.Cod_Bien_Mue<='$cod_bien_mueh') AND 
(BIEN043.Fecha>='$fecha_desde' AND BIEN043.Fecha<='$fecha_hasta')";


   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN043.Referencia, BIEN043.Tipo_Salida, to_char(BIEN043.Fecha,'DD/MM/YYYY') as fecha, BIEN044.Cod_Bien_Mue, BIEN015.Denominacion, BIEN015.Caracteristicas, BIEN015.Marca, BIEN015.Modelo, BIEN015.Color, BIEN015.Matricula, BIEN015.Serial1, BIEN015.Serial2, BIEN015.Tipo_Clase, BIEN015.Uso, BIEN015.Dimension_Tam, BIEN015.Antiguedad, BIEN015.Accesorios, BIEN015.Valor_Incorporacion, BIEN043.Cod_Dependencia, BIEN043.Cargo1, BIEN043.Departamento1, BIEN043.Nombre1, BIEN043.Cargo2, BIEN043.Departamento2, BIEN043.Nombre2, BIEN044.Monto, BIEN043.Descripcion  
FROM BIEN001, BIEN015, BIEN043, BIEN044 
WHERE BIEN015.Cod_Bien_Mue = BIEN044.Cod_Bien_Mue AND BIEN043.Referencia = BIEN044.Referencia AND BIEN001.Cod_Dependencia = BIEN015.Cod_Dependencia
";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_or_sali_bie_mue_repor_bie_mue.xml");
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
