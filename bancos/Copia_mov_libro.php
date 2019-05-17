<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
$cod_banco=$_GET["cod_banco"]; $referencia=$_GET["referencia"]; $tipo_mov=$_GET["tipo_mov"]; $equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $tipo_pago="0001";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{$Nom_Emp=busca_conf();  $error=0; $sSQL="SELECT * FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN LIBRO NO EXISTE');  </script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_mov=$registro["fecha_mov_libro"]; $error=0; 
     $cod_busca="BAN004".$usuario_sia;  $sfecha=$fecha_mov; 
     $resultado=pg_exec($conn,"SELECT COPIA_BAN004('$cod_busca','$cod_banco','$referencia','$tipo_mov','$fecha_mov')"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><?}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>

