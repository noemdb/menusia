<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); 
$referencia_comp = $_POST["txtreferencia_comp"]; $tipo_compromiso = $_POST["txttipo_compromiso"];
$cod_comp = $_POST["txtcod_comp"];$fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR DEVOLVIENDO....","<br>"; $error=0; $descrip_dev=$descrip_anu;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp'";
  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_compromiso=$registro["fecha_compromiso"]; $adescripcion=$registro["descripcion_comp"]; $anulado=$registro["anulado"]; $descrip_dev=$adescripcion.'(DEVUELTO POR: '.$descrip_anu.')';
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('COMPROMISO YA ESTA ANULADO');</script><?}
     if($error==0){$sfecha=$fecha_compromiso; if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);}
       else{$error=1; ?> <script language="JavaScript">muestra('FECHA DEVOLUCION NO ES VALIDA');</script><? }      }
     if($error==0){if ($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA DEVOLUCION NO PUEDE SER MENOR A FECHA DEL COMPROMISO');</script><? }}
	 echo "SELECT DEVUELVE_PRE006('$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$afecha','$usuario_sia','$descrip_dev')";
	 if($error==0){$resultado=pg_exec($conn,"SELECT DEVUELVE_PRE006('$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$afecha','$usuario_sia','$descrip_dev')");
       $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        else{?><script language="JavaScript">muestra('DEVOLVIO EXITOSAMENTE');</script><?
           $desc_doc="MOV.COMPROMISO: DOCUMENTO:".$tipo_compromiso.", REFERENCIA:".$referencia_comp.", DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Devolvio','$sfecha','$desc_doc')");
           $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); ?>


