<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$tipo_mov_h=$_GET["tipo_mov_h"];$periodod=$_GET["periodod"];$periodoh=$_GET["periodoh"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
    if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
    if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;

      if ($periodod==01){$periodod='2008-01-01';}
      if ($periodoh==01){$periodoh='2008-01-31';}
      if ($periodod==02){$periodod='2008-02-01';}
      if ($periodoh==02){$periodoh='2008-02-28';}
      if ($periodod==03){$periodod='2008-03-01';}
      if ($periodoh==03){$periodoh='2008-03-31';}
      if ($periodod==04){$periodod='2008-04-01';}
      if ($periodoh==04){$periodoh='2008-04-30';}
      if ($periodod==05){$periodod='2008-05-01';}
      if ($periodoh==05){$periodoh='2008-05-31';}
      if ($periodod==06){$periodod='2008-06-01';}
      if ($periodoh==06){$periodoh='2008-06-30';}
      if ($periodod==07){$periodod='2008-07-01';}
      if ($periodoh==07){$periodoh='2008-07-31';}
      if ($periodod==08){$periodod='2008-08-01';}
      if ($periodoh==08){$periodoh='2008-08-31';}
      if ($periodod==09){$periodod='2008-09-01';}
      if ($periodoh==09){$periodoh='2008-09-30';}
      if ($periodod==10){$periodod='2008-10-01';}
      if ($periodoh==10){$periodoh='2008-10-31';}
      if ($periodod==11){$periodod='2008-11-01';}
      if ($periodoh==11){$periodoh='2008-11-30';}
      if ($periodod==12){$periodod='2008-12-01';}
      if ($periodoh==12){$periodoh='2008-12-31';}
       $criterio1 = $periodod;
    //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";

   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
     $sSQL = "SELECT BAN005.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN005.Tipo_Mov_Banco,
                BAN003.Descrip_Tipo_Mov, BAN005.Fecha_Mov_Banco, BAN005.Monto_Mov_Banco, BAN005.Anulado,
                BAN005.Fecha_Anulado, BAN003.Tipo, BAN003.Operacion
                FROM BAN002, BAN003, BAN005
                WHERE BAN002.Cod_Banco = BAN005.Cod_Banco AND BAN005.Tipo_Mov_Banco = BAN003.Tipo_Movimiento AND
                BAN005.Cod_Banco>='".$cod_banco_d."' AND BAN005.Cod_Banco<='".$cod_banco_h."' AND
                BAN005.Tipo_Mov_Banco>='".$tipo_mov_d."' AND BAN005.Tipo_Mov_Banco<='".$tipo_mov_h."' AND
                BAN005.Fecha_Mov_Banco>='".$periodod."' AND BAN005.Fecha_Mov_Banco<='".$periodoh."'
                ORDER BY BAN005.Cod_Banco, BAN005.Tipo_Mov_Banco";

             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Resumen_Movimientos_Bancos.xml");
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

