<?include ("../../class/phpreports/PHPReportMaker.php");?>
<?include ("../../class/conect.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{
 }
   $partida_d=$_GET["partida_d"];
   $partida_h=$_GET["partida_h"];
   $fuente_d=$_GET["fuente_d"];
   $fuente_h=$_GET["fuente_h"];
   $sSQL1="(traslados01+traslados02+traslados03+traslados04+traslados05+traslados06+traslados07+traslados08+traslados09+traslados10+traslados11+traslados12)";
   $sSQL2="(trasladon01+trasladon02+trasladon03+trasladon04+trasladon05+trasladon06+trasladon07+trasladon08+trasladon09+trasladon10+trasladon11+trasladon12)";
   $sSQL3="(adicion01+adicion02+adicion03+adicion04+adicion05+adicion06+adicion07+adicion08+adicion09+adicion10+adicion11+adicion12)";
   $sSQL4="(disminucion01+disminucion02+disminucion03+disminucion04+disminucion05+disminucion06+disminucion07+disminucion08+disminucion09+disminucion10+disminucion11+disminucion12)";

   $sSQL = "select cod_presup, cod_fuente, denominacion, asignado01 as enero, asignado02 as febrero, asignado03 as marzo, asignado04 as abril, asignado05 as mayo, asignado06 as junio, asignado07 as julio, asignado08 as agosto, asignado09 as septiembre, asignado10 as octubre, asignado11 as noviembre, asignado12 as diciembre from pre001 where cod_presup>='".$partida_d."' and  cod_presup<='".$partida_h."' and cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."' order by cod_presup";
  // echo $sSQL;
   $oRpt = new PHPReportMaker();
   $oRpt->setXML("asignacion_presup_distri.xml");
   $oRpt->setUser("$user");
   $oRpt->setPassword("$password");
   $oRpt->setConnection("localhost");
   $oRpt->setDatabaseInterface("postgresql");
   $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
   $oRpt->setSQL($sSQL);
   $oRpt->setDatabase("$dbname");
   $oRpt->run();
?>

