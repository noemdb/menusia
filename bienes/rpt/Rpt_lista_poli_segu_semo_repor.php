<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_bien_semd=$_GET["cod_bien_semd"];$cod_bien_semh=$_GET["cod_bien_semh"];
$cedulad=$_GET["cedulad"];$cedulah=$_GET["cedulah"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
//print_r($cedulad);print_r($cedulah);
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
        //cambiar formato a la fecha
       if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
      $fecha_desde=$ano1.$mes1.$dia1;
        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
      $fecha_hasta=$ano1.$mes1.$dia1;

	$criterio ="(BIEN023.cod_bien_sem>='$cod_bien_semd' AND BIEN023.cod_bien_sem<='$cod_bien_semh') AND 
                    (BIEN023.Ced_Rif_Proveedor>='$cedulad' AND BIEN023.Ced_Rif_Proveedor<='$cedulah') AND
	            (BIEN023.Fecha_Poliza>='$fecha_desde' AND BIEN023.Fecha_Poliza<='$fecha_hasta')";
   //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT BIEN023.Cod_Bien_Sem, BIEN016.Denominacion, BIEN016.Direccion, BIEN023.Numero_Poliza, BIEN023.Ced_Rif_Proveedor, PRE099.Nombre, to_char(BIEN023.Fecha_Poliza,'DD/MM/YYYY') as fechap, to_char(BIEN023.Fecha_Desde,'DD/MM/YYYY') as fechad , to_char(BIEN023.Fecha_Hasta,'DD/MM/YYYY') as fechah, BIEN023.Monto_Poliza, BIEN023.Tasa_Cobertura, BIEN023.Monto_Cobertura  FROM BIEN016 BIEN016, BIEN023 BIEN023, PRE099 PRE099  
WHERE BIEN016.Cod_Bien_Sem = BIEN023.Cod_Bien_Sem AND BIEN023.Ced_Rif_Proveedor = PRE099.Ced_Rif AND ".$criterio."
ORDER BY BIEN023.Cod_Bien_Sem";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_poli_segu_semo_repor_semo.xml");
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
