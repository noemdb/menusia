<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_ajuste=$_GET["txtreferencia_ajuste"];$tipo_ajuste=$_GET["txttipo_ajuste"];$tipo_pago=$_GET["txttipo_pago"];$referencia_pago=$_GET["txtreferencia_pago"];
$referencia_caus=$_GET["txtreferencia_caus"];$tipo_causado=$_GET["txttipo_causado"];$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$tipo_ajuste_p="0003";$tipo_ajuste_a="0002";$tipo_ajuste_c="0001";echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0; $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; 
 if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
    if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
     if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
    }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 }
 if($error==0){$sSQL="Select * from pre011 WHERE referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'" ;
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE AJUSTE  NO EXISTE');</script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_pago=$registro["fecha_ajuste"];  $adescripcion=$registro["descripcion"];    $error=0;
    $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='CAUSADO'";    $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A CAUSADO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_a=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='PAGO'";    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A PAGO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_p=$registro["tipo_ajuste"]; }
   }
  if($error==0){$sql="SELECT * FROM codigos_ajustes where referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' order by cod_presup";
     $res=pg_query($sql); $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"];
       $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];
     }
     $sfecha=$fecha_pago; $sql="SELECT ELIMINA_PRE011('$referencia_ajuste','$tipo_ajuste','$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$tipo_ajuste_p','$tipo_ajuste_a','$tipo_ajuste_c','S')";
     $resultado=pg_exec($conn,$sql); echo $sql;
     $error=pg_errormessage($conn);$error=substr($error, 0, 90);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $desc_doc="MOV.AJUSTE: DOCUMENTO AJUSTE:".$tipo_ajuste.", REFERENCIA AJUSTE:".$referencia_ajuste.", DOCUMENTO PAGO:".$tipo_pago.", REFERENCIA PAGO:".$referencia_pago.", DOCUMENTO CAUSADO:".$tipo_causado.", REFERENCIA CAUSADO:".$referencia_caus.", DOCUMENTO COMPROMISO:".$tipo_compromiso.", REFERENCIA COMPROMISO:".$referencia_comp.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;
         $desc_doc=$desc_doc.$desc_cod; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);  if (!$resultado){ echo $error,"<br>";  $error=substr($error, 0, 90);?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> //window.close(); window.opener.location.reload(); </script>