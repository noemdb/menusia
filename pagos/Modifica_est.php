<?include ("../class/conect.php");  include ("../class/funciones.php");
$equipo = getenv("COMPUTERNAME");$mcod_m= "PAG006".$usuario_sia.$equipo;; $codigo_mov=substr($mcod_m,0,49); $cod_estructura=$_GET["Gcod_estructura"];
$url="Mod_estructura.php?Gcod_estructura=".$cod_estructura."&bloqueada=N&codigo_mov=".$codigo_mov; echo "ESPERE POR FAVOR CARGANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $error=0;  $sSQL="Select * from PAG006 WHERE cod_estructura='$cod_estructura'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; $url="Act_estructura_orden.php?Gcod_estructura==".$cod_estructura; ?><script language="JavaScript">muestra('CODIGO DE ESTRUCTURA NO EXISTE');</script> <? }
   else{$registro=pg_fetch_array($resultado);     $bloqueada=$registro["bloqueada"];
     if($bloqueada=="S"){$url="Mod_estructura.php?Gcod_estructura=".$cod_estructura."&bloqueada=S&codigo_mov=".$codigo_mov;?><script language="JavaScript">muestra('ESTRUCTURA ESTA BLOQUEADA');</script> <? }
     $resultado=pg_exec($conn,"SELECT CARGA_PAG006_MOD('$codigo_mov','$cod_estructura')"); 
     $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
   }
} pg_close();?> <script language="JavaScript">LlamarURL('<?echo $url;?>'); </script>
