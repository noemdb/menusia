<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $fecha=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_inc_bienes_mue_depreciacion.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR CARGANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else { $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");   $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  
	$tipo_dep="M"; $tipo_causado="0004"; $cod_fuente="00"; $fecha_d=$fecha;
    $sSQL="Select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if ($filas>0){ $registro=pg_fetch_array($resultado); $cod_fuente=$registro["tipo_orden"]; $tipo_causado=$registro["tipo_causado"]; $fecha_d=$registro["cod_contable_o"]; $tipo_dep=$registro["pasivo_comp"];   }
    //else{ echo $sSQL;}
	if (checkData($fecha_d)=='1'){ $error=$error;} else{ echo $fecha_d; $fecha_d=$fecha; $error=1; ?><script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><?}	
	$sSQL="Select BIEN015.cod_bien_mue,BIEN015.cod_clasificacion,BIEN015.denominacion,BIEN015.valor_incorporacion,BIEN015.valor_residual,BIEN015.vida_util,BIEN015.cod_contablea,BIEN015.cod_contabled,BIEN015.monto_depreciado,BIEN015.cod_presup_dep,BIEN015.tipo_depreciacion,BIEN015.fecha_incorporacion,PRE001.cod_contable FROM BIEN015 LEFT JOIN PRE001 ON ((cod_presup_dep=PRE001.cod_presup) and (cod_fuente='$cod_fuente')) Where (BIEN015.tipo_depreciacion='LINEA RECTA') and (BIEN015.vida_util>0) and (BIEN015.cod_contabled<>'') And (BIEN015.desincorporado<>'S') Order by BIEN015.cod_bien_mue";
	$res=pg_query($sSQL);	
	while($registro=pg_fetch_array($res)){ $cod_bien_mue=$registro["cod_bien_mue"];  $cod_contablea=$registro["cod_contablea"]; $cod_contabled=$registro["cod_contabled"]; $codigo_cuenta=$registro["cod_contable"]; 
		$cod_presup=$registro["cod_presup_dep"]; $monto=$registro["valor_incorporacion"]; $valor_residual=$registro["valor_residual"]; $saldo_dep=$registro["valor_incorporacion"]-$registro["monto_depreciado"]; 
		$monto_depreciado=$registro["monto_depreciado"]; $tipo_depreciacion=$registro["tipo_depreciacion"]; $fecha_incorporacion=$registro["fecha_incorporacion"]; $vida_util=$registro["vida_util"]; 
	    $cod_clasificacion=$registro["cod_clasificacion"]; $fechai=$registro["fecha_incorporacion"]; $fechai=formato_ddmmaaaa($fechai);	$dif_mes=diferencia_meses($fechai,$fecha_d);		
	    if(($tipo_depreciacion=="LINEA RECTA")and($vida_util>0)and($dif_mes>=1)){  
		   $monto_dep=($registro["valor_incorporacion"]-$registro["valor_residual"])/$vida_util; 
		   if($tipo_dep=="M"){ $monto_dep=$monto_dep/12; $monto_dep=round($monto_dep,2); }				   
		   if($monto_dep>$saldo_dep){ $monto_dep=$saldo_dep; }   if($monto_dep<0){$monto_dep=0;}
		   if($monto_dep>0){ $sfecha=formato_aaaammdd($fecha_d);
		     if($codigo_cuenta==""){
				$sqlb="Select * from BIEN008 where codigo_c='$cod_clasificacion'"; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
				if($filasb>=1){  $regb=pg_fetch_array($resb,0); $cod_presup=$regb["cod_presup"];
				  $sqlb="Select * from con001 where codigo_cuenta='$cod_presup'";  $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
				  if($filasb>=1){  $regb=pg_fetch_array($resb,0); $codigo_cuenta=$regb["codigo_cuenta"]; }
				}
			 }
			 if($codigo_cuenta==""){$codigo_cuenta=$cod_contablea;}
		     $sql="SELECT ACTUALIZA_BIEN050(1,'$codigo_mov','','$sfecha','$cod_bien_mue','00','$tipo_dep','',$saldo_dep,$monto_dep,'$cod_contabled','$codigo_cuenta',$monto,$monto_depreciado)";
             $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn);			
		   }
		}
		//else{echo $tipo_depreciacion." ".$vida_util." ".$dif_mes." ".$fechai." ".$fecha_d; }	
	}	
 }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } 
?>