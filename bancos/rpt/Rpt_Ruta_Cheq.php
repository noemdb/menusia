<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cheque_d=$_GET["cheque_d"];$cheque_h=$_GET["cheque_h"];$detallado=$_GET["detallado"];$imprimir=$_GET["imprimir"];$ordenado=$_GET["ordenado"];$Sql="";$date = date("d-m-Y");$hora = date("h:i:s a");
      //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;
//echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
        $Anulado_Monto_Cero = "S";
            //print_r ($detallado);
if  ($detallado == 'S' && $imprimir=='S')
{
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha,
                BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado,
                BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque
                FROM BAN002, BAN006, PRE099
                WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."'
                ORDER BY ".$ordenado."";

                $res=pg_query($sSQL);
                while($registro=pg_fetch_array($res))
                {
                 $anulado=$registro["anulado"];
                 $fecha_anulado=$registro["fecha_anulado"];
                 $monto_cheque=$registro["monto_cheque"];
                 //print_r ($criterio2);


                if ($anulado = "S" && $Anulado_Monto_Cero = "S" && fecha_anulado <= $fecha_hasta)
                {
                   $criterio2=0;
                }
                else
                   $criterio2=$monto_cheque;
                    //print_r ($criterio2);
               }


             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Ruta_Cheques.xml");
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
}
else
if  ($detallado == 'N' && $imprimir=='S')
{
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha,
                BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado,
                BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque
                FROM BAN002, BAN006, PRE099
                WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."'
                ORDER BY ".$ordenado."";

                $res=pg_query($sSQL);
                while($registro=pg_fetch_array($res))
                {
                 $anulado=$registro["anulado"];
                 $fecha_anulado=$registro["fecha_anulado"];
                 $monto_cheque=$registro["monto_cheque"];
                 //print_r ($criterio2);


                if ($anulado = "S" && $Anulado_Monto_Cero = "S" && fecha_anulado <= $fecha_hasta)
                {
                   $criterio2=0;
                }
                else
                   $criterio2=$monto_cheque;
                    //print_r ($criterio2);
               }


             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Ruta_Cheques_Detalle.xml");
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
}
else
if  ($detallado == 'N' && $imprimir=='N')
{
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha,
                BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado,
                BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque
                FROM BAN002, BAN006, PRE099
                WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."'
                ORDER BY ".$ordenado."";

                $res=pg_query($sSQL);
                while($registro=pg_fetch_array($res))
                {
                 $anulado=$registro["anulado"];
                 $fecha_anulado=$registro["fecha_anulado"];
                 $monto_cheque=$registro["monto_cheque"];
                 //print_r ($criterio2);


                if ($anulado = "S" && $Anulado_Monto_Cero = "S" && fecha_anulado <= $fecha_hasta)
                {
                   $criterio2=0;
                }
                else
                   $criterio2=$monto_cheque;
                    //print_r ($criterio2);
               }


             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Ruta_Cheques_Detalle1.xml");
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
}
else
if  ($detallado == 'S' && $imprimir=='N')
{
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else
   {
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha,
                BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado,
                BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque
                FROM BAN002, BAN006, PRE099
                WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."'
                ORDER BY ".$ordenado."";

                $res=pg_query($sSQL);
                while($registro=pg_fetch_array($res))
                {
                 $anulado=$registro["anulado"];
                 $fecha_anulado=$registro["fecha_anulado"];
                 $monto_cheque=$registro["monto_cheque"];
                 //print_r ($criterio2);


                if ($anulado = "S" && $Anulado_Monto_Cero = "S" && fecha_anulado <= $fecha_hasta)
                {
                   $criterio2=0;
                }
                else
                   $criterio2=$monto_cheque;
                    //print_r ($criterio2);
               }


             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Ruta_Cheques_Detalle2.xml");
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
}
?>

