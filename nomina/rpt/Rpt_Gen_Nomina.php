<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$tipo_nomina_d=$_GET["tipo_nomina_d"];
$tipo_nomina_h=$_GET["tipo_nomina_h"];
//$tipo_asiento_d=$_GET["tipo_asiento_d"];
//$tipo_asiento_h=$_GET["tipo_asiento_h"];
$Sql="";
//if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
//if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
//echo "ESPERE GENERANDO REPORTE DIARIO GENERAL....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
    $Sql="SELECT ELIMINA_nom006('".$usuario_sia."','1')";
    $resultado=pg_exec($conn,$Sql);
    $error=pg_errormessage($conn);
    $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_NOMINA_nom006('".$usuario_sia."','1','".$stipo_nomina_d."','".$stipo_nomina_h."','"')";
    $resultado=pg_exec($conn,$Sql);
    $error=pg_errormessage($conn);
    $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
       else{
          // LLAMAR A PHP_REPORT
          //   $oRpt->setPageSize(30);                        // 30 lines page
             $Sql= "select * from RPT_NOMINA WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='1' ORDER BY tipo_nomina";
             $sSQL = $Sql;
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("nomina.xml");
             $oRpt->setUser("$user");                                                                                                    º
             $oRpt->setPassword("$password");
             $oRpt->setConnection("localhost");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();

           //  $aBench = $oRpt->getBenchmark();
           //     foreach($aBench as $k=>$v)
           //     print "$k on $v<br/>";

              $aBench = $oRpt->getBenchmark();
              $iSec   = $aBench["report_end"]-$aBench["report_start"];
              print "Your report was created on $iSec seconds.";
           }
}
// pg_close();
?>
