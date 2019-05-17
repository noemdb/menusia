<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$Sql="";$date = date("d-m-Y");$hora = date("h:i:s a");
$criterio1="DEL:$fecha_d  Al:$fecha_h";
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
       $sSQL  = "SELECT PRE008.Referencia_Pago, PRE008.Tipo_Pago, PRE008.Referencia_Comp, PRE008.Tipo_Compromiso, PRE008.Referencia_Caus, PRE008.Tipo_Causado,
                 PRE008.Fecha_Pago, PRE008.Cod_Banco, PRE008.Tipo_Pago_B, BAN004.Cod_Banco,BAN004.Descrip_Mov_Libro,  PRE099.Nombre, PRE008.Descripcion_Pago,
                 BAN002.Nombre_Banco, BAN002.Cod_Contable, BAN002.Nro_Cuenta, BAN004.Monto_Mov_Libro
                 FROM BAN002, BAN004, PRE008, PRE099
                 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Cod_Banco = PRE008.Cod_Banco  AND PRE008.Ced_Rif = PRE099.Ced_Rif
                 AND BAN004.Referencia = PRE008.Referencia_Pago AND BAN004.Tipo_Mov_Libro = PRE008.Tipo_Pago_B  AND
                 PRE008.Cod_Banco>='".$cod_banco_d."' AND PRE008.Cod_Banco<='".$cod_banco_h."'   AND
                 PRE008.Fecha_Pago>='".$fecha_desde."' AND PRE008.Fecha_Pago<='".$fecha_hasta."'
                 ORDER BY PRE008.Cod_Banco, PRE008.Fecha_Pago, PRE008.Referencia_Pago";

             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Relacion_Gastos_Presupuestarios.xml");
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

