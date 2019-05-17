<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$fecha=$_GET["txtFecha"]; $error=0;
$equipo = getenv("COMPUTERNAME");echo "ESPERE POR FAVOR ELIMINANDO INTERFAZ CONTABLE....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf(); $periodom=$SIA_Periodo; if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
 $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}   
  $sSql="Select * from con012 where text(fecha_mov)='$sfecha'";  $resultado=pg_query($sSql); $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INTERFAZ CONTABLE NO EXISTE');</script><? }
   else{    $nmes=substr($fecha,3, 2);if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}
     if($periodom>$nmes){echo $periodom.' '.$nmes.' '.$fecha_mov;$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?} 
	 if ($error==0){    
      $resultado=pg_exec($conn,"select ELIMINA_CON012('$sfecha')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
      if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       else{ ?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script> <?
         $desc_doc="INTERFAZ CONTABLE, FECHA:".$sfecha;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);$error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       }
     }
   }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>                                  