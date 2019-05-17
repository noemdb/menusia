<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_planilla_d=$_GET["tipo_planilla_d"];$tipo_planilla_h=$_GET["tipo_planilla_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];$tipo_bene_d=$_GET["tipo_bene_d"];$tipo_bene_h=$_GET["tipo_bene_h"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;
      print_r ($tipo_bene_d);
    //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";

   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT BAN012.Nro_Planilla, BAN012.Fecha_Emision, BAN012.Tipo_Planilla, BAN011.Descripcion,
                BAN012.Cod_Banco, BAN012.Tipo_Mov, BAN012.Referencia, BAN012.Nro_Documento, BAN012.Ced_Rif,
                PRE099.Tipo_Benef, PRE099.Nombre, BAN012.Tasa, BAN012.Monto_Retencion,BAN012.Nro_Orden
                FROM BAN011, BAN012, PRE099
                WHERE BAN012.Ced_Rif = PRE099.Ced_Rif AND BAN012.Tipo_Planilla = BAN011.Codigo AND
                BAN012.Ced_Rif>='".$cedula_d."' AND  BAN012.Ced_Rif<='".$cedula_h."' AND
                BAN012.Tipo_Planilla>='".$tipo_planilla_d."' AND  BAN012.Tipo_Planilla<='".$tipo_planilla_h."' AND
                BAN012.Fecha_Emision>='".$fecha_desde."' AND  BAN012.Fecha_Emision<='".$fecha_hasta."' AND
                PRE099.Tipo_Benef>='".$tipo_bene_d."' AND PRE099.Tipo_Benef<='".$tipo_bene_h."'
                ORDER BY BAN012.Nro_Planilla, BAN012.Fecha_Emision";

             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Listado_Planillas_Retencion_Beneficiario.xml");
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

