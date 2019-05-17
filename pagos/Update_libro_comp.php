<?include ("../class/conect.php");  include ("../class/funciones.php");    error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];  $mes_libro=$_POST["txtmes_fiscal"];
if (($mes_libro=="")or(strlen($mes_libro)<2)){$error=1; ?> <script language="JavaScript">muestra('MES LIBRO NO VALIDO');</script><? }
$equipo = getenv("COMPUTERNAME");$minf_usuario=$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Act_libro_compras.php?Gmes_libro=C".$mes_libro;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0;
    if($error==0){ $sql="Select mes_libro from PAG032 where mes_libro='$mes_libro'";  $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('MES LIBRO DE COMPAS NO EXISTE');</script><? }
       else{$sSQL="SELECT BORRAR_PAG032('$mes_libro')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
    }
    if($error==0){ $sSQL="SELECT GRABAR_PAG032('$codigo_mov','$minf_usuario')"; ECHO $sSQL;  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('GRABO EXITOSAMENTE');</script><?} }
}pg_close(); error_reporting(E_ALL ^ E_WARNING);  if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }
 ?>