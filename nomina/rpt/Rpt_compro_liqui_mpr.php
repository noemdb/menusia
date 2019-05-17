<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $cod_empleado_d=$_GET["cod_empleado_d"];
   $cod_empleado_h=$_GET["cod_empleado_h"];
   $date = date("d-m-Y");
   $hora = date("H:i:s a");
   $Sql="";
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
         $sSQL = "SELECT NOM035.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM035.Cod_Cargo, NOM035.Des_Cargo, NOM035.Cod_Departamento, NOM035.Des_Departamento, NOM006.Fecha_Ingreso,
                  NOM035.Fecha_Liquidacion, NOM035.Ant_Ano, NOM035.Ant_Mes, NOM035.Ant_Dia, NOM035.Sueldo_Basico, NOM035.Tipo_Liquidacion, NOM035.Sueldo_Liquidacion, NOM035.Sueldo_Vacaciones,
                  NOM035.Dias_Preaviso, NOM035.Monto_Preaviso, NOM035.Dias_Art125, NOM035.Monto_Art125, NOM035.Dias_Art108, NOM035.Monto_Art108, NOM035.Dias_Ant_Depositada, NOM035.Monto_Ant_Depositada,
                  NOM035.Total_Adelantos, NOM035.Total_Prestamos, NOM035.Total_Intereses, NOM035.Int_Fraccionados, NOM035.Dias_Vacaciones_F, NOM035.Monto_Vacaciones_F, NOM035.Dias_Bono_Vac_F,
                  NOM035.Monto_Bono_Vac_F, NOM035.Total_Vacaciones_P, NOM035.Total_Bono_Vac_P, NOM036.Cod_Concepto, NOM036.Den_Concepto, NOM036.Asignacion, NOM036.Monto_Base, NOM036.Cantidad, NOM036.Monto
                  FROM NOM006, NOM035, NOM036
                  WHERE NOM006.Cod_Empleado = NOM035.Cod_Empleado AND NOM006.Cod_Empleado = NOM036.Cod_Empleado AND NOM035.Cod_Empleado = NOM036.Cod_Empleado
                  ORDER BY NOM035.Cod_Empleado, NOM036.Cod_Concepto";

            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_compro_liqui_mpr_re.xml");
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
