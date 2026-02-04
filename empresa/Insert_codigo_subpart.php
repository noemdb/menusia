<?php include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
$login=$_POST["txtusuario"];$cod_dependencia=$_POST["txtcod_dependencia"]; $cod_direccion=$_POST["txtcod_direccion"]; $cod_departamento=$_POST["txtcod_departamento"]; $cod_sub_departamento=$_POST["txtcod_sub_departamento"];
$cod_unidad=""; $cod_empresa=""; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Det_asig_ubic_bienes.php?usuario=".$login;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
 else{ $error=0; 
   $sSQL="Select * from SIA009 where (usuario='$login') and (cod_dependencia='$cod_dependencia') and (cod_direccion='$cod_direccion')  and (cod_departamento='$cod_departamento') and (cod_sub_departamento='$cod_sub_departamento')";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('UBICACION DEL BIEN YA EXISTE EN EL USUARIO');</script><?php }
   else{    
    if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependencia'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependen; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><?php }
	}
	if($error==0){$sql="SELECT cod_direccion,denominacion_dir FROM bien005 where cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
		if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><?php }
		else{ $registro=pg_fetch_array($resultado); $departamento1=$registro["denominacion_dir"];}
	}
	if($error==0){$sql="Select denominacion_dep from BIEN006 where cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion' and cod_departamento='$cod_departamento'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
		if($filas==0){$error=1; echo $cod_departamento; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO NO EXISTE');</script><?php }
		else{  $registro=pg_fetch_array($resultado); $departamento2=$registro["denominacion_dep"];}
	}
	if($error==0){$sSQL="Select denominacion_sub_dep from BIEN059 where cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion' and cod_departamento='$cod_departamento' and (cod_sub_departamento='$cod_sub_departamento') "; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
		 if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO SUB-DEPARTAMENTO NO EXISTE');</script><?php }
		 else{  $registro=pg_fetch_array($resultado); $departamento3=$registro["denominacion_sub_dep"];}
	}
    if($error==0){$sfecha=formato_aaaammdd($fecha);  $sql="SELECT ACTUALIZA_SIA009(1, '$login','$cod_dependencia','$cod_direccion','$cod_departamento','$cod_sub_departamento','$cod_unidad','$cod_empresa', '', '', '', '', '', 0, 0)";
	  $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 91);    if (!$resultado){?><script language="JavaScript">muestra('<?php echo $error; ?>');</script><?php }
    }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<?php echo $url; ?>';</script> <?php }else {?>  <script language="JavaScript">history.back();</script> <?php } 
?>