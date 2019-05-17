<?include ("../class/conect.php");  require ("../class/fun_num_otros.php"); require ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0; 
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"];   $tipo_calculo=$_POST["txttipo_calculo"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $concepto_t=$_POST["txtconcepto_t"];
$tipo_formato=$_POST["txttipo_formato"];$tipo_nom=$_POST["txttipo_nom"];  $agrupado=$_POST["txtagrupado"]; $agrupado=substr($agrupado,0,1);
$cod_conceptod=$_POST["txtcod_concepto_d"]; $cod_conceptoh=$_POST["txtcod_concepto_h"]; $cod_departd=$_POST["txtcodigo_departamento_d"];  $cod_departh=$_POST["txtcodigo_departamento_h"];
$cod_empleado_d=$_POST["txtcod_empleado_d"]; $cod_empleado_h=$_POST["txtcod_empleado_h"];  $codigo_cargo_d=$_POST["txtcodigo_cargo_d"]; $codigo_cargo_h=$_POST["txtcodigo_cargo_h"];
$mformula=""; $cformula=""; $fechah=formato_aaaammdd($fecha_hasta);  $fechad=formato_aaaammdd($fecha_desde); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$tipo_nom=substr($tipo_nom,0,1); $tipo_calculo=substr($tipo_calculo,0,1);
$sSQL="Select * from nom045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if($filas>=1){  $registro=pg_fetch_array($resultado,0); $den_arch_banco=$registro["den_arch_banco"];
$sSQL="SELECT ACTUALIZA_nom045(2,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','','','$tipo_nom','$agrupado','$cod_conceptod','$cod_conceptoh','','','','','$minf_usuario')"; $resultado=pg_exec($conn,$sSQL);}
else{  $error=1;?> <script language="JavaScript">muestra('CODIGO DE ARCHIVO NO DEFINIDO');</script><? }
$sql="SELECT NOM046.tipo_nomina,NOM001.descripcion FROM NOM046,NOM001 Where (NOM046.tipo_nomina=NOM001.tipo_nomina) And (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}

$tcod_arch_banco=$tipo_arch_banco.substr($cod_arch_banco,2,4);
$sql="SELECT * from nom061 Where (cod_arch_banco='$tcod_arch_banco')"; $res=pg_query($sql); //echo $sql;
while($registro=pg_fetch_array($res)){ $cod_concepto=$registro["cod_concepto"]; if($cformula!=""){$cformula=$cformula." or ";}  $cformula=$cformula."(cod_concepto='$cod_concepto')";}

if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
if($error==0){ $mformula="(".$mformula.")";
$tipo_salida=$tipo_formato;$salto_linea="\n"; if($tipo_salida=="TXT"){ $tipo_formato="LINEAL";  } if($tipo_salida=="EXCEL"){ $tipo_formato="TABULADO"; }
if($concepto_t=="NOMINA"){$mformula=$mformula." and (concepto_vac='N')";}
if($concepto_t=="VACACIONES"){$mformula=$mformula." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}
if($tipo_calculo=="T"){ $mformula=$mformula." and ((tp_calculo='N')or(tp_calculo='E')) "; } else { $mformula=$mformula." and (tp_calculo='".$tipo_calculo."')"; }
$mformula=$mformula." and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."')  and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."')"; 

if($cformula!=""){  $mformula=$mformula." and(".$cformula.")";  }
else{ $mformula=$mformula." and (cod_concepto>='".$cod_conceptod."' and cod_concepto<='".$cod_conceptoh."') "; }

If ($tipo_nom=="H"){$sql="SELECT * FROM NOM019 Where  (NOM019.fecha_p_desde>='$fechad') And (NOM019.fecha_p_hasta<='$fechah') And ". $mformula ." Order by  NOM019.cod_empleado,cod_concepto,fecha_p_hasta";}
 else{$sql="SELECT * FROM NOM017 Where  ". $mformula ." Order by  NOM017.cod_empleado,cod_concepto,fecha_p_hasta";}
$monto_tot=0; $monto_toty=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_codigo=""; $nombre_banco=""; $cta_empresa=""; $fecha_p_desde=""; $fecha_p_hasta="";
//echo $sql,"<br>";
$res=pg_query($sql);
while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; 
  if($prev_codigo!=$cod_empleado){ $prev_codigo=$cod_empleado; $monto_tot=$monto_tot+$monto_emp; $monto_toty=$monto_toty+$monto_emp; if($monto_emp<>0){$monto_emp=0; $leidos=$leidos+1;} }
  $nombre_banco=$reg["nombre_banco"]; $cta_empresa=$reg["cta_empresa"]; $fecha_p_desde=$reg["fecha_p_desde"]; $fecha_p_hasta=$reg["fecha_p_hasta"];
  //if($reg["oculto"]=="NO"){$monto_emp=$monto_emp+($reg["monto_asignacion"]-$reg["monto_deduccion"]);}   
  //$monto_concepto=$reg["monto_asignacion"]-$reg["monto_deduccion"]; if($monto_concepto==0){$monto_concepto=$reg["monto"];}
  $num_linea=$num_linea+1; $monto_concepto=$reg["monto"]; //if($reg["cod_concepto"]="910"){$monto_concepto=$reg["valory"];}else{$monto_concepto=$reg["monto"];}  
  $monto_emp=$monto_emp+$monto_concepto;  
  //echo $prev_codigo." ".$monto_emp,"<br>";
  } 
  $monto_tot=$monto_tot+$monto_emp; if($monto_emp<>0){$monto_emp=0;$leidos=$leidos+1;}
  if($monto_tot<0){$monto_tot=$monto_tot*-1;}
if($leidos==0){ echo $leidos; $error=1;?> <script language="JavaScript">muestra('INFORMACION DE NOMINAS NO LOCALIZADA');</script><? }
else{ $encabezado=""; $detalle="";  $pie_pagina=""; if($tipo_formato=="TABULADO"){$encabezado="<tr>";}

  $StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='E') Order by Pos_Campo";  $res=pg_query($StrSQL);
  while($registro=pg_fetch_array($res)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    $status3_campo=$registro["status3_campo"];
	switch($cod_campo){
      Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
	  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
	  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
      Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	  
      Case "58":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "59":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
    }if($l<0){$l=0;} If(($tipo_campo=="C") And ($l>0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
    $str_campo=substr($str_campo,$pos_c-1,$pos_f);
	if($status1_campo=="S"){	
	  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
	  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
        if($condicion_evaluar=="1"){
          if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }	
        if($condicion_evaluar=="2"){
          if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
		if($condicion_evaluar=="3"){
          if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
        if($condicion_evaluar=="4"){
          if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }  		
	  }
	}
    if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);}if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);} $l=strlen($str_campo);
    if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
    if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
    if($rellena_espacios_i=="S"){$str_campo=inserta_espacio($e).$str_campo;} if($rellena_espacios_d=="S"){$str_campo=$str_campo.inserta_espacio($e);}
    if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
    if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
    if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$encabezado=$encabezado."</tr><tr>";}else{$encabezado=$encabezado."<td>".$str_campo."</td>"; }}else{if($cod_campo=="998"){$str_campo="<br>";}$encabezado=$encabezado.$str_campo;}
  } if($tipo_formato=="TABULADO"){$encabezado=$encabezado."</tr><tr>";}else{$encabezado=$encabezado."<br>";}
  
  
  $StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='P') Order by Pos_Campo";  $res=pg_query($StrSQL);
  while($registro=pg_fetch_array($res)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    $status3_campo=$registro["status3_campo"];
	switch($cod_campo){
      Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
	  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
	  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
      Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	  
      Case "58":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "59":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
    }if($l<0){$l=0;} If(($tipo_campo=="C") And ($l>0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
    $str_campo=substr($str_campo,$pos_c-1,$pos_f);
	if($status1_campo=="S"){	
	  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
	  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
        if($condicion_evaluar=="1"){
          if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }	
        if($condicion_evaluar=="2"){
          if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
		if($condicion_evaluar=="3"){
          if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
        if($condicion_evaluar=="4"){
          if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }  		
	  }
	}
    if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);}if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);} $l=strlen($str_campo);
    if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
    if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
    if($rellena_espacios_i=="S"){$str_campo=inserta_espacio($e).$str_campo;} if($rellena_espacios_d=="S"){$str_campo=$str_campo.inserta_espacio($e);}
    if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
    if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
    if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$pie_pagina=$pie_pagina."</tr><tr>";}else{$pie_pagina=$pie_pagina."<td>".$str_campo."</td>"; }}else{if($cod_campo=="998"){$str_campo="<br>";}$pie_pagina=$pie_pagina.$str_campo;}
  } if($tipo_formato=="TABULADO"){$pie_pagina=$pie_pagina."</tr><tr>";}else{$pie_pagina=$pie_pagina."<br>";}
  
  $cat_trab=$leidos; $monto_c=0; $monto_y=0; $monto_asignacion=0; $monto_deduccion=0; $monto_aporte=0; $cantidad=0;
  $monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_codigo="";  $prev_conc=""; $res=pg_query($sql);
  //echo $sql." ".$agrupado,"<br>";
  if($agrupado=='S'){
  while($reg=pg_fetch_array($res)){  if($prev_conc==""){ $prev_conc=$reg["cod_concepto"]; $prev_codigo=$reg["cod_empleado"]; $cod_empleado=$reg["cod_empleado"]; $leidos=$leidos+1;}
    if(($prev_conc<>$reg["cod_concepto"])or($prev_codigo<>$reg["cod_empleado"])){	$num_linea=$num_linea+1; $prev_conc=$reg["cod_concepto"];
		$fecha_nac=formato_aaaammdd($fecha_hoy); $cod_cta_lph=""; $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $edad=0; $paso=""; $grado=""; $fecha_ing_adm=$fecha_ingreso;
		$StrSQL="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado') and (cedula='$cedula')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){ $fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }
		else{$StrSQL="SELECT * From TRABAJADORES Where ( (cedula='$cedula')";$result=pg_query($StrSQL);
		 if($registro=pg_fetch_array($result,0)){$fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }}
		$fecha_ini=$fecha_p_desde; $fecha_exp=$fecha_p_hasta;
		$StrSQL="SELECT * FROM nom011 WHERE (tipo_nomina='$tipo_nomina') and  (cod_empleado='$cod_empleado') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"];  }
		
		$cod_orden=$cod_concepto;		
		$StrSQL="SELECT * FROM nom002 WHERE (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$cod_orden=$registro["cod_orden"]; }
		
		$monto_tot=$monto_tot+$monto_c;  
		if($prev_codigo<>$reg["cod_empleado"]){$prev_codigo=$reg["cod_empleado"]; $leidos=$leidos+1; } 
		$StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
		while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
		  $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
		  $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
		  $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
		  $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
		  $status3_campo=$registro["status3_campo"];
		  switch($cod_campo){
		  Case "01":$str_campo=$cod_empleado; $l=$long_campo-strlen($cod_empleado); break;
		  Case "02":$str_campo=$nombre; $l=$long_campo-strlen($nombre); break;
		  Case "03":$str_campo=$cedula; $l=$long_campo-strlen($cedula); break;
		  Case "04":$str_campo=formato_ddmmaaaa($fecha_ingreso); $l=10; break;	  
		  Case "05":$str_campo=$tipo_nomina; $l=$long_campo-strlen($tipo_nomina); break;
		  Case "06":$str_campo=$des_nomina; $l=$long_campo-strlen($des_nomina); break;
		  Case "07":$str_campo=$tipo_pago; $l=$long_campo-strlen($tipo_pago); break;	  
		  Case "08":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); break;
		  Case "09":$str_campo=$tipo_cuenta; $l=$long_campo-strlen($tipo_cuenta); break;	  
		  Case "10":$str_campo=$cod_cargo; $l=$long_campo-strlen($cod_cargo); break;
		  Case "11":$str_campo=$des_cargo; $l=$long_campo-strlen($des_cargo); break;	  
		  Case "12":$str_campo=$cod_departam; $l=$long_campo-strlen($cod_departam); break;
		  Case "13":$str_campo=$des_departam; $l=$long_campo-strlen($des_departam); break;	  
		  Case "14":$str_campo=$cod_tipo_personal; $l=$long_campo-strlen($cod_tipo_personal); break;
		  Case "15":$str_campo=$des_tipo_personal; $l=$long_campo-strlen($des_tipo_personal); break;	  
		  Case "16":$str_campo=$paso; $l=$long_campo-strlen($paso); break;
		  Case "17":$str_campo=$grado; $l=$long_campo-strlen($grado); break;  
		  Case "18":$ssueldo_cargo=elimina_puntos(formato_monto($sueldo_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_cargo),14); $l=0; break;
		  Case "19":$sprima_cargo=elimina_puntos(formato_monto($prima_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sprima_cargo),14); $l=0; break;	  
		  Case "20":$scompensa_cargo=elimina_puntos(formato_monto($compensa_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scompensa_cargo),14); $l=0; break;	  
		  Case "21":$ssueldo_comp=elimina_puntos(formato_monto($sueldo_comp)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_comp),14); $l=0; break;		  
		  Case "22":$scantidad=elimina_puntos(formato_monto($cantidad)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scantidad),14); $l=0; break;
		  Case "23":$smonto_c=formato_monto($monto_c);  $smonto_c=elimina_puntos($smonto_c); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_c),14); $l=0; break;
		  Case "24":$sacumulado=elimina_puntos(formato_monto($acumulado)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sacumulado),14); $l=0; break;
		  Case "25":$ssaldo=elimina_puntos(formato_monto($saldo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssaldo),14); $l=0; break;
		  Case "26":$smonto_orig=elimina_puntos(formato_monto($monto_orig)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_orig),14); $l=0; break;		  
		  Case "27":$svalore=elimina_puntos(formato_monto($valore)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalore),14); $l=0; break;
		  Case "28":$svalorq=elimina_puntos(formato_monto($valorq)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorq),14); $l=0; break;
		  Case "29":$svalorw=elimina_puntos(formato_monto($valorw)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorw),14); $l=0; break;
		  Case "30":$svalorx=elimina_puntos(formato_monto($valorx)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorx),14); $l=0; break;
		  Case "31":$svalory=elimina_puntos(formato_monto($monto_y)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalory),14); $l=0; break;
		  Case "32":$svalorz=elimina_puntos(formato_monto($valorz)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorz),14); $l=0; break;		  
		  Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
		  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
		  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
		  Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	 
		  Case "37":$str_campo=$cod_concepto; $l=$long_campo-strlen($cod_concepto); break;
		  Case "38":$str_campo=$denominacion; $l=$long_campo-strlen($denominacion); break;	  
		  Case "39":$str_campo=$asignacion; $l=$long_campo-strlen($asignacion); break;
		  Case "40":$str_campo=$tipo_asigna; $l=$long_campo-strlen($tipo_asigna); break;
		  Case "41":$str_campo=$prestamo; $l=$long_campo-strlen($prestamo); break;
		  Case "42":$str_campo=$concepto_vac; $l=$long_campo-strlen($concepto_vac); break;
		  Case "43":$str_campo=$oculto; $l=$long_campo-strlen($oculto); break;		  
		  Case "44":$str_campo=$cod_presup; $l=$long_campo-strlen($cod_presup); break;
		  Case "45":$str_campo=$cod_retencion; $l=$long_campo-strlen($cod_retencion); break;
		  Case "46":$str_campo=$codigo_ubicacion; $l=$long_campo-strlen($codigo_ubicacion); break;
		  Case "47":$str_campo=$descripcion_ubi; $l=$long_campo-strlen($descripcion_ubi); break;
		  Case "48":$str_campo=$nacionalidad; $l=$long_campo-strlen($nacionalidad); break;
		  Case "49":$str_campo=$sexo; $l=$long_campo-strlen($sexo); break;	  
		  Case "50":$str_campo=$edo_civil; $l=$long_campo-strlen($edo_civil); break;
		  Case "51":$str_campo=formato_ddmmaaaa($fecha_nac); $l=10; break;	  
		  Case "52":$str_campo=formato_ddmmaaaa($fecha_ini); $l=10; break;
		  Case "53":$str_campo=formato_ddmmaaaa($fecha_exp); $l=10; break;      
		  Case "54":$str_campo=$nombre1; $l=$long_campo-strlen($nombre1); break;
		  Case "55":$str_campo=$nombre2; $l=$long_campo-strlen($nombre2); break;
		  Case "56":$str_campo=$apellido1; $l=$long_campo-strlen($apellido1); break;
		  Case "57":$str_campo=$apellido2; $l=$long_campo-strlen($apellido2); break;
		  Case "58":$str_campo=Rellenarcerosizq($cat_trab,4); $l=0; break;
		  Case "60":$str_campo=$cod_orden; $l=$long_campo-strlen($cod_orden); break;
		  Case "61":$str_campo=$cod_cta_lph; $l=$long_campo-strlen($cod_cta_lph); break;
		  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
		  Case "998":$str_campo="<br>"; $l=0; break;
		  Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
		  } if($l<0){$l=0;} If(($tipo_campo=="C") And ($l> 0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
		  $str_campo=substr($str_campo,$pos_c-1,$pos_f);
		  if($status1_campo=="S"){	
			  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
			  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
				if($condicion_evaluar=="1"){
				  if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}	
				if($condicion_evaluar=="2"){
				  if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}
				if($condicion_evaluar=="3"){
				  if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}
				if($condicion_evaluar=="4"){
				  if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}  		
			  }
		  }
		  if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);} if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);}$l=strlen($str_campo);
		  if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
		  if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
		  if($rellena_espacios_i=="S"){$str_campo=trim($str_campo); $k=strlen($str_campo); if($k>$l){$ei=0;}else{$ei=$l-$k;} $str_campo=inserta_espacio($ei).$str_campo;} 
		  if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
		  if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
		  if($status3_campo=="S"){$str_campo=cambia_punto_comas($str_campo);}
		  if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<td>".$str_campo."</td>"; }} else{if($cod_campo=="998"){$str_campo="<br>";}$detalle=$detalle.$str_campo;}
		} if($tipo_formato=="TABULADO"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<br>";} 
		$monto_c=0; $monto_y=0; $monto_asignacion=0; $monto_deduccion=0; $monto_aporte=0; $cantidad=0;	
	}
	$monto_c=$monto_c+$reg["monto"]; $monto_y=$monto_y+$reg["valory"]; $cantidad=$cantidad+$reg["cantidad"]; 
	$monto_asignacion=$monto_asignacion+$reg["monto_asignacion"];$monto_deduccion=$monto_deduccion+$reg["monto_deduccion"];$monto_aporte=$monto_aporte+$reg["monto_aporte"];
	
	$cedula=$reg["cedula"];   $tipo_nomina=$reg["tipo_nomina"]; 
    $cod_empleado=$reg["cod_empleado"];  $nombre=$reg["nombre"]; $cta_empleado=$reg["cta_empleado"];   $fecha_ingreso=$reg["fecha_ingreso"]; $status_calculo=$reg["status_calculo"];$tipo_cuenta=""; $edo_civil="";
    $tipo_nomina=$reg["tipo_nomina"];  $des_nomina=$reg["des_nomina"]; $tipo_pago=$reg["tipo_pago"];  $nombre_banco=$reg["nombre_banco"]; $cta_empresa=$reg["cta_empresa"]; $fecha_p_desde=$reg["fecha_p_desde"]; $fecha_p_hasta=$reg["fecha_p_hasta"];
    $cod_cargo=$reg["cod_cargo"];$des_cargo=$reg["des_cargo"]; $cod_departam=$reg["cod_departam"];$des_departam=$reg["des_departam"];
	$sueldo_cargo=$reg["sueldo_cargo"];$prima_cargo=$reg["prima_cargo"];$compensa_cargo=$reg["compensa_cargo"];$sueldo_integral=$reg["sueldo_integral"];$otros=$reg["otros"];
	$sueldo_comp=$sueldo_cargo+$compensa_cargo;
	$cod_tipo_personal=$reg["cod_tipo_personal"]; $des_tipo_personal=$reg["des_tipo_personal"];$cod_presup=$reg["cod_presup"];$cod_contable=$reg["cod_contable"];
	$cod_retencion=$reg["cod_retencion"]; $codigo_ubicacion=$reg["codigo_ubicacion"]; $descripcion_ubi=$reg["descripcion_ubi"];
    $cod_concepto=$reg["cod_concepto"];$denominacion=$reg["denominacion"]; $asignacion=$reg["asignacion"]; $oculto=$reg["oculto"];$tipo_asigna=$reg["tipo_asigna"];$asig_ded_apo=$reg["asig_ded_apo"];$prestamo=$reg["prestamo"];$concepto_vac=$reg["concepto_vac"];
    $monto_orig=$reg["monto_orig"];$monto=$reg["monto"];$acumulado=$reg["acumulado"];
	$saldo=$reg["saldo"];$valore=$reg["valore"];$valoru=$reg["valoru"];$valorq=$reg["valorq"];$valorw=$reg["valorw"];$valorx=$reg["valorx"];$valory=$reg["valory"];$valorz=$reg["valorz"];
    if(substr($status_calculo,1,1)=="E"){$nacionalidad="EXTRANJERO";}else{$nacionalidad="VENEZOLANO";} if(substr($status_calculo,3,1)=="M"){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
    switch(substr($status_calculo,2,1)){Case "A":$tipo_cuenta="AHORROS"; break; Case "C":$tipo_cuenta="CORRIENTE"; break;Case "F":$tipo_cuenta="FAL"; break;}
    switch(substr($status_calculo,4,1)){Case "C":$edo_civil="CASADO"; break; Case "V":$edo_civil="VIUDO"; break; Case "D":$edo_civil="DIVORCIADO"; break; Case "U":$edo_civil="CONCUBINO"; break; Case "S":$edo_civil="SOLTERO"; break;}
  }
        $num_linea=$num_linea+1; $fecha_nac=formato_aaaammdd($fecha_hoy); $nombre1=""; $cod_cta_lph=""; $nombre2=""; $apellido1=""; $apellido2=""; $edad=0; $paso=""; $grado=""; $fecha_ing_adm=$fecha_ingreso;
		$StrSQL="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado') and (cedula='$cedula')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){ $fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }
		else{$StrSQL="SELECT * From TRABAJADORES Where ( (cedula='$cedula')";$result=pg_query($StrSQL);
		 if($registro=pg_fetch_array($result,0)){$fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }}
		$fecha_ini=$fecha_p_desde; $fecha_exp=$fecha_p_hasta;
		$StrSQL="SELECT * FROM nom011 WHERE (tipo_nomina='$tipo_nomina') and  (cod_empleado='$cod_empleado') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"];  }
		$cod_orden=$cod_concepto;		
		$StrSQL="SELECT * FROM nom002 WHERE (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$cod_orden=$registro["cod_orden"]; }
		$monto_tot=$monto_tot+$monto_c; 
		//if($prev_codigo<>$cod_empleado){
		   $prev_codigo=$cod_empleado; $leidos=$leidos+1; 		
		   $StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
			while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
			  $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
			  $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
			  $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
			  $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
			  $status3_campo=$registro["status3_campo"];
			  switch($cod_campo){
			  Case "01":$str_campo=$cod_empleado; $l=$long_campo-strlen($cod_empleado); break;
			  Case "02":$str_campo=$nombre; $l=$long_campo-strlen($nombre); break;
			  Case "03":$str_campo=$cedula; $l=$long_campo-strlen($cedula); break;
			  Case "04":$str_campo=formato_ddmmaaaa($fecha_ingreso); $l=10; break;	  
			  Case "05":$str_campo=$tipo_nomina; $l=$long_campo-strlen($tipo_nomina); break;
			  Case "06":$str_campo=$des_nomina; $l=$long_campo-strlen($des_nomina); break;
			  Case "07":$str_campo=$tipo_pago; $l=$long_campo-strlen($tipo_pago); break;	  
			  Case "08":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); break;
			  Case "09":$str_campo=$tipo_cuenta; $l=$long_campo-strlen($tipo_cuenta); break;	  
			  Case "10":$str_campo=$cod_cargo; $l=$long_campo-strlen($cod_cargo); break;
			  Case "11":$str_campo=$des_cargo; $l=$long_campo-strlen($des_cargo); break;	  
			  Case "12":$str_campo=$cod_departam; $l=$long_campo-strlen($cod_departam); break;
			  Case "13":$str_campo=$des_departam; $l=$long_campo-strlen($des_departam); break;	  
			  Case "14":$str_campo=$cod_tipo_personal; $l=$long_campo-strlen($cod_tipo_personal); break;
			  Case "15":$str_campo=$des_tipo_personal; $l=$long_campo-strlen($des_tipo_personal); break;	  
			  Case "16":$str_campo=$paso; $l=$long_campo-strlen($paso); break;
			  Case "17":$str_campo=$grado; $l=$long_campo-strlen($grado); break;  
			  Case "18":$ssueldo_cargo=elimina_puntos(formato_monto($sueldo_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_cargo),14); $l=0; break;
			  Case "19":$sprima_cargo=elimina_puntos(formato_monto($prima_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sprima_cargo),14); $l=0; break;	  
			  Case "20":$scompensa_cargo=elimina_puntos(formato_monto($compensa_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scompensa_cargo),14); $l=0; break;	  
			  Case "21":$ssueldo_comp=elimina_puntos(formato_monto($sueldo_comp)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_comp),14); $l=0; break;		  
			  Case "22":$scantidad=elimina_puntos(formato_monto($cantidad)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scantidad),14); $l=0; break;
			  Case "23":$smonto_c=formato_monto($monto_c);  $smonto_c=elimina_puntos($smonto_c); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_c),14); $l=0; break;
			  Case "24":$sacumulado=elimina_puntos(formato_monto($acumulado)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sacumulado),14); $l=0; break;
			  Case "25":$ssaldo=elimina_puntos(formato_monto($saldo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssaldo),14); $l=0; break;
			  Case "26":$smonto_orig=elimina_puntos(formato_monto($monto_orig)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_orig),14); $l=0; break;		  
			  Case "27":$svalore=elimina_puntos(formato_monto($valore)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalore),14); $l=0; break;
			  Case "28":$svalorq=elimina_puntos(formato_monto($valorq)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorq),14); $l=0; break;
			  Case "29":$svalorw=elimina_puntos(formato_monto($valorw)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorw),14); $l=0; break;
			  Case "30":$svalorx=elimina_puntos(formato_monto($valorx)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorx),14); $l=0; break;
			  Case "31":$svalory=elimina_puntos(formato_monto($monto_y)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalory),14); $l=0; break;
			  Case "32":$svalorz=elimina_puntos(formato_monto($valorz)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorz),14); $l=0; break;		  
			  Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
			  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
			  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
			  Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	 
			  Case "37":$str_campo=$cod_concepto; $l=$long_campo-strlen($cod_concepto); break;
			  Case "38":$str_campo=$denominacion; $l=$long_campo-strlen($denominacion); break;	  
			  Case "39":$str_campo=$asignacion; $l=$long_campo-strlen($asignacion); break;
			  Case "40":$str_campo=$tipo_asigna; $l=$long_campo-strlen($tipo_asigna); break;
			  Case "41":$str_campo=$prestamo; $l=$long_campo-strlen($prestamo); break;
			  Case "42":$str_campo=$concepto_vac; $l=$long_campo-strlen($concepto_vac); break;
			  Case "43":$str_campo=$oculto; $l=$long_campo-strlen($oculto); break;		  
			  Case "44":$str_campo=$cod_presup; $l=$long_campo-strlen($cod_presup); break;
			  Case "45":$str_campo=$cod_retencion; $l=$long_campo-strlen($cod_retencion); break;
			  Case "46":$str_campo=$codigo_ubicacion; $l=$long_campo-strlen($codigo_ubicacion); break;
			  Case "47":$str_campo=$descripcion_ubi; $l=$long_campo-strlen($descripcion_ubi); break;
			  Case "48":$str_campo=$nacionalidad; $l=$long_campo-strlen($nacionalidad); break;
			  Case "49":$str_campo=$sexo; $l=$long_campo-strlen($sexo); break;	  
			  Case "50":$str_campo=$edo_civil; $l=$long_campo-strlen($edo_civil); break;
			  Case "51":$str_campo=formato_ddmmaaaa($fecha_nac); $l=10; break;	  
			  Case "52":$str_campo=formato_ddmmaaaa($fecha_ini); $l=10; break;
			  Case "53":$str_campo=formato_ddmmaaaa($fecha_exp); $l=10; break;      
			  Case "54":$str_campo=$nombre1; $l=$long_campo-strlen($nombre1); break;
			  Case "55":$str_campo=$nombre2; $l=$long_campo-strlen($nombre2); break;
			  Case "56":$str_campo=$apellido1; $l=$long_campo-strlen($apellido1); break;
			  Case "57":$str_campo=$apellido2; $l=$long_campo-strlen($apellido2); break;
			  Case "58":$str_campo=Rellenarcerosizq($cat_trab,4); $l=0; break;
			  Case "60":$str_campo=$cod_orden; $l=$long_campo-strlen($cod_orden); break;
			  Case "61":$str_campo=$cod_cta_lph; $l=$long_campo-strlen($cod_cta_lph); break;
			  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
			  Case "998":$str_campo="<br>"; $l=0; break;
			  Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
			  } if($l<0){$l=0;} If(($tipo_campo=="C") And ($l> 0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
			  $str_campo=substr($str_campo,$pos_c-1,$pos_f);
			  if($status1_campo=="S"){	
				  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
				  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
					if($condicion_evaluar=="1"){
					  if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
					}	
					if($condicion_evaluar=="2"){
					  if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
					}
					if($condicion_evaluar=="3"){
					  if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
					}
					if($condicion_evaluar=="4"){
					  if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
					}  		
				  }
			  }
			  if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);} if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);}$l=strlen($str_campo);
			  if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
			  if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
			  if($rellena_espacios_i=="S"){$str_campo=trim($str_campo); $k=strlen($str_campo); if($k>$l){$ei=0;}else{$ei=$l-$k;} $str_campo=inserta_espacio($ei).$str_campo;} 
			  if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
			  if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
			  if($status3_campo=="S"){$str_campo=cambia_punto_comas($str_campo);}
			  if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<td>".$str_campo."</td>"; }} else{if($cod_campo=="998"){$str_campo="<br>";} $detalle=$detalle.$str_campo; }			
			}  if($tipo_formato=="TABULADO"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<br>";} 
		//}
  }else{
	while($reg=pg_fetch_array($res)){  	$num_linea=$num_linea+1;
		$cedula=$reg["cedula"]; $monto_c=$monto_c+$reg["monto"];  $tipo_nomina=$reg["tipo_nomina"]; 
		$cod_empleado=$reg["cod_empleado"];  $nombre=$reg["nombre"]; $cta_empleado=$reg["cta_empleado"];  $fecha_ingreso=$reg["fecha_ingreso"]; $status_calculo=$reg["status_calculo"];$tipo_cuenta=""; $edo_civil="";
		$tipo_nomina=$reg["tipo_nomina"];  $des_nomina=$reg["des_nomina"]; $tipo_pago=$reg["tipo_pago"];  $nombre_banco=$reg["nombre_banco"]; $cta_empresa=$reg["cta_empresa"]; $fecha_p_desde=$reg["fecha_p_desde"]; $fecha_p_hasta=$reg["fecha_p_hasta"];
		$cod_cargo=$reg["cod_cargo"];$des_cargo=$reg["des_cargo"]; $cod_departam=$reg["cod_departam"];$des_departam=$reg["des_departam"];
		$sueldo_cargo=$reg["sueldo_cargo"];$prima_cargo=$reg["prima_cargo"];$compensa_cargo=$reg["compensa_cargo"];$sueldo_integral=$reg["sueldo_integral"];$otros=$reg["otros"];
		$sueldo_comp=$sueldo_cargo+$compensa_cargo;
		$cod_tipo_personal=$reg["cod_tipo_personal"]; $des_tipo_personal=$reg["des_tipo_personal"];$cod_presup=$reg["cod_presup"];$cod_contable=$reg["cod_contable"];
		$cod_retencion=$reg["cod_retencion"]; $codigo_ubicacion=$reg["codigo_ubicacion"]; $descripcion_ubi=$reg["descripcion_ubi"];
		$cod_concepto=$reg["cod_concepto"];$denominacion=$reg["denominacion"]; $asignacion=$reg["asignacion"]; $oculto=$reg["oculto"];$tipo_asigna=$reg["tipo_asigna"];$asig_ded_apo=$reg["asig_ded_apo"];$prestamo=$reg["prestamo"];$concepto_vac=$reg["concepto_vac"];
		$cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"];$monto=$reg["monto"];$monto_asignacion=$reg["monto_asignacion"];$monto_deduccion=$reg["monto_deduccion"];$monto_aporte=$reg["monto_aporte"];$acumulado=$reg["acumulado"];
		$saldo=$reg["saldo"];$valore=$reg["valore"];$valoru=$reg["valoru"];$valorq=$reg["valorq"];$valorw=$reg["valorw"];$valorx=$reg["valorx"];$valory=$reg["valory"];$valorz=$reg["valorz"];
		if(substr($status_calculo,1,1)=="E"){$nacionalidad="EXTRANJERO";}else{$nacionalidad="VENEZOLANO";} if(substr($status_calculo,3,1)=="M"){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
		switch(substr($status_calculo,2,1)){Case "A":$tipo_cuenta="AHORROS"; break; Case "C":$tipo_cuenta="CORRIENTE"; break;Case "F":$tipo_cuenta="FAL"; break;}
		switch(substr($status_calculo,4,1)){Case "C":$edo_civil="CASADO"; break; Case "V":$edo_civil="VIUDO"; break; Case "D":$edo_civil="DIVORCIADO"; break; Case "U":$edo_civil="CONCUBINO"; break; Case "S":$edo_civil="SOLTERO"; break;}
	 
		$fecha_nac=formato_aaaammdd($fecha_hoy); $cod_cta_lph=""; $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $edad=0; $paso=""; $grado=""; $fecha_ing_adm=$fecha_ingreso;
		$StrSQL="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado') and (cedula='$cedula')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){ $fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"];$nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }
		else{$StrSQL="SELECT * From TRABAJADORES Where ( (cedula='$cedula')";$result=pg_query($StrSQL);
		 if($registro=pg_fetch_array($result,0)){$fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
		 $cod_cta_lph=$registro["cta_lph"];$nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; $paso=$registro["paso"]; $grado=$registro["grado"]; }}
		$fecha_ini=$fecha_p_desde; $fecha_exp=$fecha_p_hasta;
		$StrSQL="SELECT * FROM nom011 WHERE (tipo_nomina='$tipo_nomina') and  (cod_empleado='$cod_empleado') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$fecha_ini=$registro["fecha_ini"]; $fecha_exp=$registro["fecha_exp"];  }
		$cod_orden=$cod_concepto;		
		$StrSQL="SELECT * FROM nom002 WHERE (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_concepto')";$result=pg_query($StrSQL);
		if($registro=pg_fetch_array($result,0)){$cod_orden=$registro["cod_orden"]; }
		$monto_tot=$monto_tot+$monto_c;  
		if($prev_codigo!=$cod_empleado){$prev_codigo=$cod_empleado; $leidos=$leidos+1; } 
		$StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
		while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
		  $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
		  $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
		  $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
		  $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
		  $status3_campo=$registro["status3_campo"];
		  switch($cod_campo){
		  Case "01":$str_campo=$cod_empleado; $l=$long_campo-strlen($cod_empleado); break;
		  Case "02":$str_campo=$nombre; $l=$long_campo-strlen($nombre); break;
		  Case "03":$str_campo=$cedula; $l=$long_campo-strlen($cedula); break;
		  Case "04":$str_campo=formato_ddmmaaaa($fecha_ingreso); $l=10; break;	  
		  Case "05":$str_campo=$tipo_nomina; $l=$long_campo-strlen($tipo_nomina); break;
		  Case "06":$str_campo=$des_nomina; $l=$long_campo-strlen($des_nomina); break;
		  Case "07":$str_campo=$tipo_pago; $l=$long_campo-strlen($tipo_pago); break;	  
		  Case "08":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); break;
		  Case "09":$str_campo=$tipo_cuenta; $l=$long_campo-strlen($tipo_cuenta); break;	  
		  Case "10":$str_campo=$cod_cargo; $l=$long_campo-strlen($cod_cargo); break;
		  Case "11":$str_campo=$des_cargo; $l=$long_campo-strlen($des_cargo); break;	  
		  Case "12":$str_campo=$cod_departam; $l=$long_campo-strlen($cod_departam); break;
		  Case "13":$str_campo=$des_departam; $l=$long_campo-strlen($des_departam); break;	  
		  Case "14":$str_campo=$cod_tipo_personal; $l=$long_campo-strlen($cod_tipo_personal); break;
		  Case "15":$str_campo=$des_tipo_personal; $l=$long_campo-strlen($des_tipo_personal); break;	  
		  Case "16":$str_campo=$paso; $l=$long_campo-strlen($paso); break;
		  Case "17":$str_campo=$grado; $l=$long_campo-strlen($grado); break;  
		  Case "18":$ssueldo_cargo=elimina_puntos(formato_monto($sueldo_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_cargo),14); $l=0; break;
		  Case "19":$sprima_cargo=elimina_puntos(formato_monto($prima_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sprima_cargo),14); $l=0; break;	  
		  Case "20":$scompensa_cargo=elimina_puntos(formato_monto($compensa_cargo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scompensa_cargo),14); $l=0; break;	  
		  Case "21":$ssueldo_comp=elimina_puntos(formato_monto($sueldo_comp)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_comp),14); $l=0; break;		  
		  Case "22":$scantidad=elimina_puntos(formato_monto($cantidad)); $str_campo=Rellenarcerosizq(cambia_coma_numero($scantidad),14); $l=0; break;
		
		  Case "23":$smonto_c=formato_monto($monto_c);  $smonto_c=elimina_puntos($smonto_c); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_c),14); $l=0; break;
		  Case "24":$sacumulado=elimina_puntos(formato_monto($acumulado)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sacumulado),14); $l=0; break;
		  Case "25":$ssaldo=elimina_puntos(formato_monto($saldo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssaldo),14); $l=0; break;
		  Case "26":$smonto_orig=elimina_puntos(formato_monto($monto_orig)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_orig),14); $l=0; break;		  
		  Case "27":$svalore=elimina_puntos(formato_monto($valore)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalore),14); $l=0; break;
		  Case "28":$svalorq=elimina_puntos(formato_monto($valorq)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorq),14); $l=0; break;
		  Case "29":$svalorw=elimina_puntos(formato_monto($valorw)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorw),14); $l=0; break;
		  Case "30":$svalorx=elimina_puntos(formato_monto($valorx)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorx),14); $l=0; break;
		  Case "31":$svalory=elimina_puntos(formato_monto($valory)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalory),14); $l=0; break;
		  Case "32":$svalorz=elimina_puntos(formato_monto($valorz)); $str_campo=Rellenarcerosizq(cambia_coma_numero($svalorz),14); $l=0; break;
		  Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
		  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
		  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
		  Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	 
		  Case "37":$str_campo=$cod_concepto; $l=$long_campo-strlen($cod_concepto); break;
		  Case "38":$str_campo=$denominacion; $l=$long_campo-strlen($denominacion); break;	  
		  Case "39":$str_campo=$asignacion; $l=$long_campo-strlen($asignacion); break;
		  Case "40":$str_campo=$tipo_asigna; $l=$long_campo-strlen($tipo_asigna); break;
		  Case "41":$str_campo=$prestamo; $l=$long_campo-strlen($prestamo); break;
		  Case "42":$str_campo=$concepto_vac; $l=$long_campo-strlen($concepto_vac); break;
		  Case "43":$str_campo=$oculto; $l=$long_campo-strlen($oculto); break;		  
		  Case "44":$str_campo=$cod_presup; $l=$long_campo-strlen($cod_presup); break;
		  Case "45":$str_campo=$cod_retencion; $l=$long_campo-strlen($cod_retencion); break;
		  Case "46":$str_campo=$codigo_ubicacion; $l=$long_campo-strlen($codigo_ubicacion); break;
		  Case "47":$str_campo=$descripcion_ubi; $l=$long_campo-strlen($descripcion_ubi); break;
		  Case "48":$str_campo=$nacionalidad; $l=$long_campo-strlen($nacionalidad); break;
		  Case "49":$str_campo=$sexo; $l=$long_campo-strlen($sexo); break;	  
		  Case "50":$str_campo=$edo_civil; $l=$long_campo-strlen($edo_civil); break;
		  Case "51":$str_campo=formato_ddmmaaaa($fecha_nac); $l=10; break;	  
		  Case "52":$str_campo=formato_ddmmaaaa($fecha_ini); $l=10; break;
		  Case "53":$str_campo=formato_ddmmaaaa($fecha_exp); $l=10; break;      
		  Case "54":$str_campo=$nombre1; $l=$long_campo-strlen($nombre1); break;
		  Case "55":$str_campo=$nombre2; $l=$long_campo-strlen($nombre2); break;
		  Case "56":$str_campo=$apellido1; $l=$long_campo-strlen($apellido1); break;
		  Case "57":$str_campo=$apellido2; $l=$long_campo-strlen($apellido2); break;
		  Case "58":$str_campo=Rellenarcerosizq($cat_trab,4); $l=0; break;
		  Case "60":$str_campo=$cod_orden; $l=$long_campo-strlen($cod_orden); break;
		  Case "61":$str_campo=$cod_cta_lph; $l=$long_campo-strlen($cod_cta_lph); break;
		  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
		  Case "998":$str_campo="<br>"; $l=0; break;
		  Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
		  } if($l<0){$l=0;} If(($tipo_campo=="C") And ($l> 0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
		  $str_campo=substr($str_campo,$pos_c-1,$pos_f);
		  if($status1_campo=="S"){	
			  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
			  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
				if($condicion_evaluar=="1"){
				  if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}	
				if($condicion_evaluar=="2"){
				  if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}
				if($condicion_evaluar=="3"){
				  if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}
				if($condicion_evaluar=="4"){
				  if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
				}  		
			  }
		  }
		  if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);} if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);}$l=strlen($str_campo);
		  if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
		  if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
		  
		  if($rellena_espacios_i=="S"){$str_campo=trim($str_campo); $k=strlen($str_campo); if($k>$l){$ei=0;}else{$ei=$l-$k;} $str_campo=inserta_espacio($ei).$str_campo;} 
		  if($rellena_espacios_d=="S"){$str_campo=$str_campo.inserta_espacio($e);}
		  if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
		  
		  if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}
		  if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
		  if($status3_campo=="S"){$str_campo=cambia_punto_comas($str_campo);}
		  
		  if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<td>".$str_campo."</td>"; }} else{if($cod_campo=="998"){$str_campo="<br>";}$detalle=$detalle.$str_campo;}
		} if($tipo_formato=="TABULADO"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<br>";} $monto_c=0;
	}  
  }

  $StrSQL="SELECT * FROM NOM052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='P') Order by Pos_Campo";  $res=pg_query($StrSQL);
  while($registro=pg_fetch_array($res)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    $status3_campo=$registro["status3_campo"];
	switch($cod_campo){
      Case "33":$str_campo=$cta_empresa; $l=$long_campo-strlen($cta_empresa); break;
	  Case "34":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;	  
	  Case "35":$str_campo=formato_ddmmaaaa($fecha_p_desde); $l=10; break;
      Case "36":$str_campo=formato_ddmmaaaa($fecha_p_hasta); $l=10; break;	  
      Case "58":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "59":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
    }if($l<0){$l=0;} If(($tipo_campo=="C") And ($l>0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
    $str_campo=substr($str_campo,$pos_c-1,$pos_f);
	if($status1_campo=="S"){	
	  $sql7= "SELECT nom057.cod_arch_banco,nom057.pos_campo,nom057.cod_condicion,nom057.tipo_campo,nom057.condicion_evaluar,nom057.svalor_evaluar,nom057.svalor_retornar,nom057.nvalor_evaluar,nom057.nvalor_retornar FROM nom057 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (nom057.pos_campo='$pos_campo') Order by cod_condicion"; $res7=pg_query($sql7);
	  while($registro=pg_fetch_array($res7)){ $cod_condicion=$registro["cod_condicion"]; $condicion_evaluar=$registro["condicion_evaluar"]; $svalor_evaluar=$registro["svalor_evaluar"]; $svalor_retornar=$registro["svalor_retornar"]; 
        if($condicion_evaluar=="1"){
          if($str_campo==$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }	
        if($condicion_evaluar=="2"){
          if($str_campo<>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
		if($condicion_evaluar=="3"){
          if($str_campo>$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }
        if($condicion_evaluar=="4"){
          if($str_campo<$svalor_evaluar){  $str_campo=$svalor_retornar; }
        }  		
	  }
	}
    if($elimina_comas=="S"){$str_campo=elimina_comas($str_campo);}if($elimina_puntos=="S"){$str_campo=elimina_puntos($str_campo);} $l=strlen($str_campo);
    if($rellena_ceros_izq=="S"){$str_campo=Rellenarcerosizq(trim($str_campo),$pos_f);} if($rellena_ceros_der=="S"){$str_campo=Rellenarcerosder(trim($str_campo),$pos_f);}
    if($pos_f>$l){$e=$pos_f-$l;}else{$e=0;}
    if($rellena_espacios_i=="S"){$str_campo=inserta_espacio($e).$str_campo;} if($rellena_espacios_d=="S"){$str_campo=$str_campo.inserta_espacio($e);}
    if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
    if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);}if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
    if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$pie_pagina=$pie_pagina."</tr><tr>";}else{$pie_pagina=$pie_pagina."<td>".$str_campo."</td>"; }}else{if($cod_campo=="998"){$str_campo="<br>";}$pie_pagina=$pie_pagina.$str_campo;}
  } if($tipo_formato=="TABULADO"){$pie_pagina=$pie_pagina."</tr><tr>";}else{$pie_pagina=$pie_pagina."<br>";}
    
if($tipo_formato=="TABULADO"){$encabezado="<table>".$encabezado; $pie_pagina.="<tr></table>";  if($tipo_salida=="EXCEL"){ header("Content-type: application/vnd.ms-excel");   header("Content-Disposition: attachment; filename=arch_nom.xls"); } }
else{ if($tipo_salida=="TXT"){$encabezado=str_replace("<br>","\r\n",$encabezado);$detalle=str_replace("<br>","\r\n",$detalle);
$pie_pagina=str_replace("<br>","\r\n",$pie_pagina); header("Content-type: application/txt");   header("Content-Disposition: attachment; filename=arch_nomina.txt");
} else{$encabezado="<pre>".$encabezado; $pie_pagina.="</pre>";} }
echo $encabezado.$detalle.$pie_pagina;
} }
pg_close();
if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 
?>