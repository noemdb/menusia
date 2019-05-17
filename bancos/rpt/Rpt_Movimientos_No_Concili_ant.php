<?include ("../../class/conect.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"]; $tipo_mov_h=$_GET["tipo_mov_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$mcod_m="BAN07L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else {

    $Sql="delete from ban037 where codigo_mov='".$codigo_mov."'";   $resultado=pg_exec($conn,$Sql);
	
	$Sql="insert into ban037 select '".$codigo_mov."',ban007.cod_banco,ban007.referencia,ban007.tipo_trans_libro,ban007.fecha_trans_libro,ban007.monto_trans_libro,ban007.beneficiario,ban007.mes_conciliacion,ban007.inf_usuario,ban007.monto_trans_libro,0,0,0,0,'','',ban007.desc_trans_libro FROM ban007,ban003 where ban007.tipo_trans_libro=ban003.tipo_movimiento AND ban003.Tipo='D' and ban007.cod_banco>='".$cod_banco_d."' AND ban007.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'";   $resultado=pg_exec($conn,$Sql);
    $Sql="insert into ban037 select '".$codigo_mov."',ban007.cod_banco,ban007.referencia,ban007.tipo_trans_libro,ban007.fecha_trans_libro,ban007.monto_trans_libro,ban007.beneficiario,ban007.mes_conciliacion,ban007.inf_usuario,0,ban007.monto_trans_libro,0,0,0,'','',ban007.desc_trans_libro FROM ban007,ban003 where ban007.tipo_trans_libro=ban003.tipo_movimiento AND ban003.Tipo='C' and ban007.cod_banco>='".$cod_banco_d."' AND ban007.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'";   $resultado=pg_exec($conn,$Sql);
    $sSQL = "SELECT ban037.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, ban037.Tipo_Trans_Libro,
                ban037.Referencia, ban037.Fecha_Trans_Libro, ban037.Beneficiario, ban037.Monto_Trans_Libro, ban037.columna1, ban037.columna2,
                ban037.Desc_Trans_Libro, ban037.Desc_Trans_Libro, BAN003.Tipo, to_char(ban037.Fecha_Trans_Libro,'DD/MM/YYYY') as fecham
                FROM BAN002 BAN002, BAN003 BAN003, ban037 ban037 WHERE ban037.codigo_mov='".$codigo_mov."' AND 
				BAN002.Cod_Banco = ban037.Cod_Banco AND ban037.Tipo_Trans_Libro = BAN003.Tipo_Movimiento AND
				BAN002.Cod_Banco>='".$cod_banco_d."' AND BAN002.Cod_Banco<='".$cod_banco_h."' AND
                ban037.Tipo_Trans_Libro>='".$tipo_mov_d."' AND ban037.Tipo_Trans_Libro<='".$tipo_mov_h."' AND
                ban037.Referencia>='".$referencia_d."' AND ban037.Referencia<='".$referencia_h."' AND
                ban037.Fecha_Trans_Libro>='".$fecha_d."' AND ban037.Fecha_Trans_Libro<='".$fecha_h."'
                ORDER BY BAN002.Cod_Banco,ban037.Fecha_Trans_Libro,ban037.Referencia";
     
	 
	
        $sql1 = "SELECT B.Cod_Banco,B.Fecha_Mov_Libro as Fecha,B.Referencia,A.Nombre_Banco,A.Nro_Cuenta,B.Tipo_Mov_Libro as Tipo_Mov,B.Ced_Rif,B.Monto_Mov_Libro as Monto,B.Anulado,B.Fecha_Anulado,B.Inf_Usuario,to_char(B.Fecha_Mov_Libro,'DD/MM/YYYY') as fecham  
		          FROM BAN004 B LEFT JOIN BAN002 A ON (A.Cod_Banco=B.Cod_Banco)where text(B.referencia)||text(B.Cod_Banco)||text(B.Tipo_Mov_Libro) not in (SELECT text(C.referencia)||text(C.Cod_Banco)||text(C.Tipo_Mov_Banco) FROM BAN005 C) AND 
				  (Tipo_Mov_Libro <> 'ANU' AND Tipo_Mov_Libro <> 'DAN' AND Tipo_Mov_Libro <> 'CAN') AND 
				  B.Cod_Banco>='".$cod_banco_d."' AND B.Cod_Banco<='".$cod_banco_h."' AND
                  B.Tipo_Mov_Libro>='".$tipo_mov_d."' AND B.Tipo_Mov_Libro<='".$tipo_mov_h."' AND
				  B.Referencia>='".$referencia_d."' AND B.Referencia<='".$referencia_h."' AND
                  B.Fecha_Mov_Libro>='".$sfecha_d."' AND B.Fecha_Mov_Libro<='".$sfecha_h."' ";
				  
		$sql2 = "Union All SELECT C.Cod_Banco,C.Fecha_Trans_Libro as Fecha,C.Referencia,D.Nombre_Banco,D.Nro_Cuenta,C.Tipo_Trans_Libro as Tipo_Mov,'' as Ced_Rif,C.Monto_Trans_Libro as Monto,'N' as Anulado,C.Fecha_Trans_Libro as Fecha_Anulado,C.Inf_Usuario,to_char(C.Fecha_Trans_Libro,'DD/MM/YYYY') as fecham 
                  FROM BAN007 C LEFT JOIN BAN002 D ON (D.Cod_Banco=C.Cod_Banco) where (C.referencia)||text(C.Cod_Banco)||text(C.Tipo_Trans_Libro) not in (SELECT text(BAN005.referencia)||text(BAN005.Cod_Banco)||text(BAN005.Tipo_Mov_Banco) FROM BAN005) and 
				  text(C.referencia)||text(C.Cod_Banco)||text(C.Monto_Trans_Libro) not in (SELECT text(BAN004.referencia)||text(BAN004.Cod_Banco)||text(BAN004.Monto_Mov_Libro) FROM BAN004) and
                  C.Cod_Banco>='".$cod_banco_d."' AND C.Cod_Banco<='".$cod_banco_h."' AND
                  C.Tipo_Trans_Libro>='".$tipo_mov_d."' AND C.Tipo_Trans_Libro<='".$tipo_mov_h."' AND
				  C.Referencia>='".$referencia_d."' AND C.Referencia<='".$referencia_h."' AND
                  C.Fecha_Trans_Libro>='".$sfecha_d."' AND C.Fecha_Trans_Libro<='".$sfecha_h."'";				  
				  
		$sSQL = $sql1.$sql2." order by 1,2,3";
          
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Movimientos_No_Conciliados.xml");
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

