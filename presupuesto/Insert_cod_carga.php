<?include ("../class/conect.php");  include ("../class/funciones.php"); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo=$_GET["codigo"];$cod_partida=$_GET["partida"];$error=0;
$SIA_Definicion=substr($codigo,0,1);$cod_fuente=substr($codigo,1,2);$cod_categoria=substr($codigo,3,20);
$divi="-";$cod_presup=$cod_categoria.$divi.$cod_partida;
$url="Det_carga_codigos.php?Gcodigo=".$codigo;echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='05'";
  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}  
  if ($error==0){    $sSQL="Select * from PRE098 WHERE cod_partida='$cod_partida'";
    $resultado=pg_query($sSQL);    $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PARTIDA NO EXISTE EN EL CLASIFICADOR');</script><? }
    else{      $registro=pg_fetch_array($resultado);      $aplicacion=$registro["aplicacion"];
      $cod_contable=$registro["cod_contable"];}
    if($error==0){ $sSQL="Select * from pre032 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";
      $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);  if ($filas>0){$error=1;?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO YA CARGADO');</script> <? }
    }
    if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuente'";      $resultado=pg_query($sSQL);      $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? }
    }
    if($error==0){  $sSQL="Select * from PRE025 WHERE cod_aplicacion='$aplicacion'";      $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE APLICACION NO EXISTE');</script><? }
    }	
    if(strlen($cod_presup)==strlen($formato_presup)){  
	/*
  	  $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";     $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO  CONTABLE DE GASTO NO ES CARGABLE');</script><?} }
	 */ 
    }else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CODIGO PRESUPUESTARIO NO VALIDA');</script><?}
    if($error==0){  $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";
      $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
      if ($filas>0){?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO YA EXISTE');</script> <? }
       else{ $resultado=pg_exec($conn,"SELECT INCLUYE_PRE032('$cod_fuente','$cod_partida','$cod_categoria','$divi')");    $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
    }
  }
}
pg_close();?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>