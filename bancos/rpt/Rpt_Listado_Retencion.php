<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$num_comprobante_d=$_GET["num_comprobante_d"];$num_comprobante_h=$_GET["num_comprobante_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$Sql="";$date = date("d-m-Y");$hora = date("h:i:s a");
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
       $sSQL = "SELECT BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion, BAN027.Ced_Rif, BAN027.Fecha_Emision,
                BAN027.Tipo_Operacion, BAN027.Tipo_Documento, BAN027.Fecha_Documento, BAN027.Nro_Documento, BAN027.Nro_Con_Documento, BAN027.Nro_Doc_Afectado,
                BAN027.Tipo_Transaccion, BAN027.Monto_Documento, BAN027.Monto_Exento_IVA, BAN027.Base_Imponible, BAN027.Tasa_IVA, BAN027.Monto_IVA,
                BAN027.Monto_IVA_Retenido, BAN027.Cod_Banco, BAN027.Tipo_Mov, BAN027.Referencia, BAN027.Inf_Usuario, PRE099.Nombre
                FROM BAN027,PRE099
                WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND
                BAN027.Fecha_Emision>='".$fecha_desde."' AND BAN027.Fecha_Emision<='".$fecha_hasta."' AND
                BAN027.Nro_Comprobante>='".$num_comprobante_d."' AND BAN027.Nro_Comprobante<='".$num_comprobante_h."'  AND
                BAN027.Ced_Rif>='".$cedula_d."' AND BAN027.Ced_Rif<='".$cedula_h."'
                ORDER BY BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante";

             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Listado_Retencion_IVA.xml");
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

