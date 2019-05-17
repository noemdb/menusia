<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$nom_usuario=$_GET["nom_usuario"];$fecha_d=$_GET["fecha_d"];$num_expediente_d=$_GET["num_expediente_d"];$num_expediente_h=$_GET["num_expediente_h"];$Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;

    //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else
{
    // LLAMAR A PHP_REPORT
$sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha,
        BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado,
        BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque,
        BAN006.Nro_Informe, BAN006.Usuario_SIA  FROM BAN002 BAN002, BAN006 BAN006, PRE099 PRE099
        WHERE BAN006.Anulado = 'N' AND BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif
        Order by BAN006.Cod_Banco, BAN006.Num_Cheque";

             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Cheques_Emitidos_Usuario.xml");
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

