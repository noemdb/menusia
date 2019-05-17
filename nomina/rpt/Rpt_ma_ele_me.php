<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$sexo=$_GET["sexo"];$estado_civil=$_GET["estado_civil"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$edad_d=$_GET["edad_d"];$edad_h=$_GET["edad_h"];$profesion=$_GET["profesion"];$Sql="";$date = date("d-m-Y");$hora = date("h:i:s a");
$date = date("d-m-Y");
$hora = date("H:i:s a");
        //cambiar formato a la fecha
        if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}
        else{$fecha_d='';}
        $fecha_desde=$ano1.$mes1.$dia1;

        if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}
        else{$fecha_h='';}
        $fecha_hasta=$ano1.$mes1.$dia1;
      //echo "ESPERE GENERANDO REPORTE MAYOR GENERAL....","<br>";
if ($sexo<>'TODOS' &&  $estado_civil<>'TODOS' &&  $profesion<>'TODAS')
{
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM053.Nacionalidad_E, NOM053.Sexo_E, NOM053.Edo_Civil_E, NOM053.Fecha_Nacimiento_E,
                  NOM053.Edad_E, NOM053.Lugar_Nacimiento_E, NOM053.Direccion_E, NOM053.Cod_Postal_E, NOM053.Telefono_E, NOM053.Tlf_Movil_E,
                  NOM053.Correo_E, NOM053.Profesion_E, NOM053.Grado_Inst_E, NOM053.Estado_E, NOM053.Ciudad_E, NOM053.Municipio_E, NOM053.Parroquia_E,
                  NOM053.Observacion_E, NOM053.Talla_Camisa_E, NOM053.Talla_Pantalon_E, NOM053.Talla_Calzado_E, NOM053.Peso_E, NOM053.Estatura_E, NOM053.Aptdo_Postal_E
                  FROM NOM053
                  WHERE  NOM053.Cedula>='".$cedula_d."' AND NOM053.Cedula<='".$cedula_h."' AND
                  NOM053.Sexo_E ='".$sexo."' AND
                  NOM053.Edo_Civil_E ='".$estado_civil."' AND
                  NOM053.Profesion_E ILIKE '".$profesion."%' AND
                  NOM053.Fecha_Nacimiento_E>= '".$fecha_desde."' AND NOM053.Fecha_Nacimiento_E<= '".$fecha_hasta."'  AND
                  NOM053.Edad_E>= '".$edad_d."' AND NOM053.Edad_E<= '".$edad_h."'
                  ORDER BY NOM053.Cedula";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ma_ele_me_re.xml");
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
if ($sexo<>'TODOS')
{
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM053.Nacionalidad_E, NOM053.Sexo_E, NOM053.Edo_Civil_E, NOM053.Fecha_Nacimiento_E,
                  NOM053.Edad_E, NOM053.Lugar_Nacimiento_E, NOM053.Direccion_E, NOM053.Cod_Postal_E, NOM053.Telefono_E, NOM053.Tlf_Movil_E,
                  NOM053.Correo_E, NOM053.Profesion_E, NOM053.Grado_Inst_E, NOM053.Estado_E, NOM053.Ciudad_E, NOM053.Municipio_E, NOM053.Parroquia_E,
                  NOM053.Observacion_E, NOM053.Talla_Camisa_E, NOM053.Talla_Pantalon_E, NOM053.Talla_Calzado_E, NOM053.Peso_E, NOM053.Estatura_E, NOM053.Aptdo_Postal_E
                  FROM NOM053
                  WHERE  NOM053.Cedula>='".$cedula_d."' AND NOM053.Cedula<='".$cedula_h."' AND
                  NOM053.Sexo_E ='".$sexo."' AND
                  NOM053.Fecha_Nacimiento_E>= '".$fecha_desde."' AND NOM053.Fecha_Nacimiento_E<= '".$fecha_hasta."'  AND
                  NOM053.Edad_E>= '".$edad_d."' AND NOM053.Edad_E<= '".$edad_h."'
                  ORDER BY NOM053.Cedula";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ma_ele_me_re.xml");
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
if ($estado_civil<>'TODOS')
{
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM053.Nacionalidad_E, NOM053.Sexo_E, NOM053.Edo_Civil_E, NOM053.Fecha_Nacimiento_E,
                  NOM053.Edad_E, NOM053.Lugar_Nacimiento_E, NOM053.Direccion_E, NOM053.Cod_Postal_E, NOM053.Telefono_E, NOM053.Tlf_Movil_E,
                  NOM053.Correo_E, NOM053.Profesion_E, NOM053.Grado_Inst_E, NOM053.Estado_E, NOM053.Ciudad_E, NOM053.Municipio_E, NOM053.Parroquia_E,
                  NOM053.Observacion_E, NOM053.Talla_Camisa_E, NOM053.Talla_Pantalon_E, NOM053.Talla_Calzado_E, NOM053.Peso_E, NOM053.Estatura_E, NOM053.Aptdo_Postal_E
                  FROM NOM053
                  WHERE  NOM053.Cedula>='".$cedula_d."' AND NOM053.Cedula<='".$cedula_h."' AND
                  NOM053.Edo_Civil_E ='".$estado_civil."' AND
                  NOM053.Fecha_Nacimiento_E>= '".$fecha_desde."' AND NOM053.Fecha_Nacimiento_E<= '".$fecha_hasta."'  AND
                  NOM053.Edad_E>= '".$edad_d."' AND NOM053.Edad_E<= '".$edad_h."'
                  ORDER BY NOM053.Cedula";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ma_ele_me_re.xml");
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
if ($profesion<>'TODAS')
{
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM053.Nacionalidad_E, NOM053.Sexo_E, NOM053.Edo_Civil_E, NOM053.Fecha_Nacimiento_E,
                  NOM053.Edad_E, NOM053.Lugar_Nacimiento_E, NOM053.Direccion_E, NOM053.Cod_Postal_E, NOM053.Telefono_E, NOM053.Tlf_Movil_E,
                  NOM053.Correo_E, NOM053.Profesion_E, NOM053.Grado_Inst_E, NOM053.Estado_E, NOM053.Ciudad_E, NOM053.Municipio_E, NOM053.Parroquia_E,
                  NOM053.Observacion_E, NOM053.Talla_Camisa_E, NOM053.Talla_Pantalon_E, NOM053.Talla_Calzado_E, NOM053.Peso_E, NOM053.Estatura_E, NOM053.Aptdo_Postal_E
                  FROM NOM053
                  WHERE  NOM053.Cedula>='".$cedula_d."' AND NOM053.Cedula<='".$cedula_h."' AND
                  NOM053.Profesion_E ILIKE '".$profesion."%' AND
                  NOM053.Fecha_Nacimiento_E>= '".$fecha_desde."' AND NOM053.Fecha_Nacimiento_E<= '".$fecha_hasta."'  AND
                  NOM053.Edad_E>= '".$edad_d."' AND NOM053.Edad_E<= '".$edad_h."'
                  ORDER BY NOM053.Cedula";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ma_ele_me_re.xml");
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
if ($sexo=='TODOS' OR $estado_civil=='TODOS' OR $profesion=='TODAS')
{
        $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
        if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
        else
        {
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT NOM053.Cedula, NOM053.Nombre_E, NOM053.Nacionalidad_E, NOM053.Sexo_E, NOM053.Edo_Civil_E, NOM053.Fecha_Nacimiento_E,
                  NOM053.Edad_E, NOM053.Lugar_Nacimiento_E, NOM053.Direccion_E, NOM053.Cod_Postal_E, NOM053.Telefono_E, NOM053.Tlf_Movil_E,
                  NOM053.Correo_E, NOM053.Profesion_E, NOM053.Grado_Inst_E, NOM053.Estado_E, NOM053.Ciudad_E, NOM053.Municipio_E, NOM053.Parroquia_E,
                  NOM053.Observacion_E, NOM053.Talla_Camisa_E, NOM053.Talla_Pantalon_E, NOM053.Talla_Calzado_E, NOM053.Peso_E, NOM053.Estatura_E, NOM053.Aptdo_Postal_E
                  FROM NOM053
                  WHERE  NOM053.Cedula>='".$cedula_d."' AND NOM053.Cedula<='".$cedula_h."' AND
                  NOM053.Fecha_Nacimiento_E>= '".$fecha_desde."' AND NOM053.Fecha_Nacimiento_E<= '".$fecha_hasta."'    AND
                  NOM053.Edad_E>= '".$edad_d."' AND NOM053.Edad_E<= '".$edad_h."'
                  ORDER BY NOM053.Cedula";

         $oRpt = new PHPReportMaker();
         $oRpt->setXML("Rpt_ma_ele_me_re.xml");
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
