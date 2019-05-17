<?php include ("../class/conect.php"); include ("../class/funciones.php");  include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy();  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR REVISANDO....","<br>";
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $Nom_Emp=busca_conf(); //echo $Cod_Emp;
	$sql="SELECT * FROM NOM040  order by cod_tipo_personal,paso,grado"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_aprobacion"]; $cod_tipo_personal=$registro["cod_tipo_personal"];
	  $grado=$registro["grado"]; $paso=$registro["paso"]; $act=0; $ngrado=$grado; $npaso=$paso;
	  $leng=strlen($grado); if($leng<3){ $ngrado=Rellenarcerosizq($grado,3); $act=1; }
	  $leng=strlen($paso); if($leng<3){ $npaso=Rellenarcerosizq($paso,3); $act=1; }
	  if($act==1){
		$sqlg="Update  nom040 set grado='$ngrado',  paso='$npaso' where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and paso='$paso'";  
		$resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}  
		  
	  }	  
	}
	
	$act=0; $prev_codigo=""; $ngrado=""; $npaso="";
	$sql="SELECT cod_empleado, fecha_asigna, cod_cargo, cod_departamento, des_cargo,des_departamento, cod_tipo_personal, paso, grado, observacion,sueldo, prima, compensacion, otros, sueldo_integral  FROM nom008 order by cod_empleado,fecha_asigna"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){
	
      if(($prev_codigo<>$registro["cod_empleado"])and($prev_codigo<>"")and($act==1)){
        $sqlg="Update nom006 set grado='$ngrado',  paso='$npaso' where cod_empleado='$cod_empleado'";  
		$resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}  
		
      }	  
	  $cod_empleado=$registro["cod_empleado"]; $fecha_asigna=$registro["fecha_asigna"]; $act=0;
	  $cod_tipo_personal=$registro["cod_tipo_personal"];  $grado=$registro["grado"]; $paso=$registro["paso"];
	
	  $leng=strlen($grado); if($leng<3){ $ngrado=Rellenarcerosizq($grado,3); $act=1; }
	  $leng=strlen($paso); if($leng<3){ $npaso=Rellenarcerosizq($paso,3); $act=1; }
	  if($act==1){
		$sqlg="Update  nom008 set grado='$ngrado',  paso='$npaso' where cod_empleado='$cod_empleado' and fecha_asigna='$fecha_asigna'";  
		$resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}  
		  
	  }	
	  $prev_codigo=$registro["cod_empleado"];
	  
	}
	if(($prev_codigo<>"")and($act==1)){
        $sqlg="Update nom006 set grado='$ngrado',  paso='$npaso' where cod_empleado='$cod_empleado'";  
		$resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}  
	}

    ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?	
	
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>