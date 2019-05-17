<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
   $tipo_nominad=$_GET["tipo_nominad"];
   $tipo_nominah=$_GET["tipo_nominah"];
   $cod_empleado_d=$_GET["cod_empleado_d"];
   $cod_empleado_h=$_GET["cod_empleado_h"];
   $cedula_d=$_GET["cedula_d"];
   $cedula_h=$_GET["cedula_h"];
   $sexo=$_GET["sexo"];
   $estado_civil=$_GET["estado_civil"];
   $fecha_d=$_GET["fecha_d"];
   $fecha_h=$_GET["fecha_h"];
   $edad_d=$_GET["edad_d"];
   $edad_h=$_GET["edad_h"];
   $fecha_ingreso_d=$_GET["fecha_ingreso_d"];
   $fecha_ingreso_h=$_GET["fecha_ingreso_h"];
   $estatus=$_GET["estatus"];
   $codigo_cargo_d=$_GET["codigo_cargo_d"];
   $codigo_cargo_h=$_GET["codigo_cargo_h"];
   $codigo_departamentod=$_GET["codigo_departamentod"];
   $codigo_departamentoh=$_GET["codigo_departamentoh"];
   $inf_per=$_GET["inf_per"];
   $inf_car=$_GET["inf_car"];
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
      //cambiar formato a la fecha ingreso
        if (!(empty($fecha_ingreso_d))){$ano1=substr($fecha_ingreso_d,6,9);$mes1=substr($fecha_ingreso_d,3,2);$dia1=substr($fecha_ingreso_d,0,2);}
        else{$fecha_ingreso_d='';}
        $fecha_desde_ing=$ano1.$mes1.$dia1;
        if (!(empty($fecha_ingreso_h))){$ano1=substr($fecha_ingreso_h,6,9);$mes1=substr($fecha_ingreso_h,3,2);$dia1=substr($fecha_ingreso_h,0,2);}
        else{$fecha_ingreso_h='';}
        $fecha_hasta_ing=$ano1.$mes1.$dia1;

        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM006.Cod_Empleado, NOM006.Nombre, NOM006.Cedula, NOM006.Nacionalidad, NOM006.Fecha_Ingreso, NOM006.Status, NOM006.Tipo_Nomina, NOM001.Descripcion,
                  NOM006.Cod_Categoria, NOM006.Tipo_Pago, NOM006.Cta_Empleado, NOM006.Cod_Banco, NOM006.Nombre_Banco, NOM006.Cta_Empresa, NOM007.Sexo, NOM007.Edo_Civil,
                  NOM007.Fecha_Nacimiento, NOM007.Edad, NOM007.Lugar_Nacimiento, NOM007.Direccion, NOM007.Cod_Postal, NOM007.Telefono, NOM007.Correo, NOM007.Estado, NOM007.Ciudad,
                  NOM008.Cod_Cargo, NOM008.Des_Cargo, NOM008.Cod_Departamento, NOM008.Des_Departamento, NOM008.Fecha_Asigna, NOM008.Sueldo
                  FROM NOM001 NOM001, NOM006 NOM006, NOM007 NOM007, NOM008 NOM008
                  WHERE NOM006.Cod_Empleado = NOM007.Cod_Empleado AND NOM006.Tipo_Nomina = NOM001.Tipo_Nomina AND NOM008.Cod_Empleado = NOM006.Cod_Empleado ORDER BY NOM006.Cod_Empleado";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ho_vida_mp_re.xml");
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
