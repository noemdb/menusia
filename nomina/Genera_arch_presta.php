<?include ("../class/conect.php"); require ("../class/fun_num_otros.php"); require ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0; 
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"];  
$mes=$_POST["txtperiodo_h"]; $ano=$_POST["txtperiodo_d"];$tipo_formato=$_POST["txttipo_formato"];
$tipo_nominad=$_POST["txttipo_nomina_d"]; $tipo_nominah=$_POST["txttipo_nomina_h"]; $cod_departd=$_POST["txtcodigo_departamento_d"];  $cod_departh=$_POST["txtcodigo_departamento_h"];
$cod_empleado_d=$_POST["txtcod_empleado_d"]; $cod_empleado_h=$_POST["txtcod_empleado_h"];  $codigo_cargo_d=$_POST["txtcodigo_cargo_d"]; $codigo_cargo_h=$_POST["txtcodigo_cargo_h"];
$fecha_d="01/".$mes."/".$ano;  $fecha_h=colocar_udiames($fecha_d);
$ordenar=" ORDER BY nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";
$mformula=""; $fechah=formato_aaaammdd($fecha_h);  $fechad=formato_aaaammdd($fecha_d); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
$sSQL="Select * from nom045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if($filas>=1){  $registro=pg_fetch_array($resultado,0); $den_arch_banco=$registro["den_arch_banco"];}
else{  $error=1;?> <script language="JavaScript">muestra('CODIGO DE ARCHIVO NO DEFINIDO');</script><? }
$criterio="  and (nom030.tipo_calculo='P') and (nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."') 
	   and (nom030.fecha_calculo>='".$fechad."' and nom030.fecha_calculo<='".$fechah."')  ";
$mformula=$criterio." and (nom030.cod_empleado>='".$cod_empleado_d."' and nom030.cod_empleado<='".$cod_empleado_h."') and (nom006.cod_departam>='".$cod_departd."' and nom006.cod_departam<='".$cod_departh."') and (nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."')"; 
$tipo_rpt=$tipo_formato; if($tipo_rpt=="EXCEL"){ $tipo_formato="TABULADO"; }
$sSQL="SELECT nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo,nom030.tipo_calculo,nom030.sueldo_calculo,nom030.dias_prestaciones,nom030.c_prestaciones,nom030.sueldo_calculo_adic,nom030.dias_adicionales,nom030.c_presta_adic,nom030.monto_prestaciones,nom030.total_prestaciones,nom030.monto_adelanto,nom030.total_adelanto,
	    nom030.monto_prestamo,nom030.total_prestamo,nom030.saldo_prestaciones,nom030.interes_devengado,nom030.interes_noacum,nom030.interes_acum,nom030.interes_pagado,nom030.total_interes,nom030.tasa_interes,nom030.tiempo_variacion,nom030.acumulado_total,to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac,nom006.cod_departam,nom006.cod_categoria,pre019.denominacion_cat 
		FROM nom030,nom006 left join pre019 on (nom006.cod_categoria=pre019.cod_presup_cat) WHERE ".$mformula.$ordenar;		
$ordenar=" ORDER BY nom006.fecha_ingreso,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";
$sSQL="SELECT nom030.cod_empleado,nom006.nombre,nom006.cedula,nom006.nacionalidad,nom006.tipo_Nomina,nom006.status,nom006.fecha_ingreso,nom006.fecha_ing_adm,nom006.cod_Categoria,nom006.tipo_pago,nom006.tipo_cuenta,nom006.cta_empleado,nom006.cod_cargo,nom006.cod_departam,
      nom006.cod_tipo_personal,nom006.paso,nom006.Grado, nom006.Sueldo,nom006.Prima,nom006.compensacion,to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac,
      nom007.nombre1,nom007.nombre2,nom007.apellido1,nom007.apellido2,nom007.sexo,nom007.edo_civil,nom007.fecha_nacimiento,nom007.edad,nom007.lugar_nacimiento,
	  nom030.fecha_calculo,nom030.num_calculo,nom030.tipo_calculo,nom030.sueldo_calculo,nom030.dias_prestaciones,nom030.c_prestaciones,nom030.sueldo_calculo_adic,nom030.dias_adicionales,nom030.c_presta_adic,nom030.monto_prestaciones,nom030.total_prestaciones,
      nom030.monto_adelanto,nom030.total_adelanto, nom030.monto_prestamo, nom030.total_prestamo,nom030.saldo_prestaciones,nom030.interes_devengado,nom030.interes_noacum,nom030.interes_acum,
      nom030.interes_pagado,nom030.total_interes,nom030.tasa_interes,nom030.tiempo_variacion,nom030.acumulado_total 
      FROM nom006,nom007,nom030 WHERE (nom006.cod_empleado=nom030.cod_empleado) AND nom006.cod_empleado=nom007.cod_empleado ".$mformula.$ordenar;	
$sql=$sSQL; $monto_tot=0; $monto_toty=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_codigo=""; $nombre_banco=""; $cta_empresa=""; $fecha_p_desde=""; $fecha_p_hasta="";
//echo $sql,"<br>";
$res=pg_query($sql);
while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; 
  if($prev_codigo!=$cod_empleado){ $prev_codigo=$cod_empleado; $monto_tot=$monto_tot+$monto_emp; $monto_toty=$monto_toty+$monto_emp; if($monto_emp<>0){$monto_emp=0; $leidos=$leidos+1;} }
    $monto_prestaciones=$reg["monto_prestaciones"]; $monto_emp=$monto_emp+$monto_prestaciones;  
  } 
  $monto_tot=$monto_tot+$monto_emp; if($monto_emp<>0){$monto_emp=0;$leidos=$leidos+1;}
  if($monto_tot<0){$monto_tot=$monto_tot*-1;}
if($leidos==0){ echo $leidos; $error=1;?> <script language="JavaScript">muestra('INFORMACION DE PRESTACIONES NO LOCALIZADA');</script><? }
else{ $encabezado=""; $detalle="";  $pie_pagina=""; if($tipo_formato=="TABULADO"){$encabezado="<tr>";}
  $StrSQL="SELECT * FROM nom052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='E') Order by Pos_Campo";  $res=pg_query($StrSQL);
  while($registro=pg_fetch_array($res)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    $status3_campo=$registro["status3_campo"];
	switch($cod_campo){       
      Case "23":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	  Case "24":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
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
  
  
  $StrSQL="SELECT * FROM nom052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='P') Order by Pos_Campo";  $res=pg_query($StrSQL);
  while($registro=pg_fetch_array($res)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    $status3_campo=$registro["status3_campo"];
	switch($cod_campo){
      Case "23":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	  Case "24":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
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
  //echo $sql;  
	while($reg=pg_fetch_array($res)){  	$num_linea=$num_linea+1;	$leidos=$leidos+1;
	    $cod_empleado=$reg["cod_empleado"]; $nombre=$reg["nombre"]; $cedula=$reg["cedula"]; $nombre=substr($nombre,0,75);
	    $fecha_ingreso=$reg["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); 
	    $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $mes=substr($reg["fechac"],3,2); $fecha_calculo=$reg["fecha_calculo"];
	    $fechac=$reg["fechac"]; $num_calculo=$reg["num_calculo"];  $sueldo_calculo=$reg["sueldo_calculo"];  $sueldo_dia=($reg["sueldo_calculo"]/30);
	    $dias_prestaciones=$reg["dias_prestaciones"]; $c_prestaciones=$reg["c_prestaciones"]; $sueldo_calculo_adic=$reg["sueldo_calculo_adic"];  $sueldo_dia_adic=($reg["sueldo_calculo_adic"]/30);
		$dias_adicionales=$reg["dias_adicionales"]; $c_presta_adic=$reg["c_presta_adic"]; $monto_prestaciones=$reg["monto_prestaciones"]; 
		$total_prestaciones=$reg["total_prestaciones"]; $monto_adelanto=$reg["monto_adelanto"]; $total_adelanto=$reg["total_adelanto"];
		$interes_devengado=$reg["interes_devengado"]; $interes_noacum=$reg["interes_noacum"]; $interes_acum=$reg["interes_acum"]; 
		$interes_pagado=$reg["interes_pagado"];  $total_interes=$reg["total_interes"]; $tasa_interes=$reg["tasa_interes"]; 
		$tiempo_variacion=$reg["tiempo_variacion"]; $acumulado_total=$reg["acumulado_total"]; $tipo_calculo=$reg["tipo_calculo"];
		$saldo_prestaciones=$reg["saldo_prestaciones"]; $t_prestaciones=$total_prestaciones-$c_presta_adic; $t_dias=$dias_prestaciones+$dias_adicionales;
		$fecha_nac=$reg["fecha_nacimiento"]; $nacionalidad=$reg["nacionalidad"]; $sexo=$reg["sexo"]; $tipo_cuenta=$reg["tipo_cuenta"]; $edo_civil=$reg["edo_civil"];
        $nombre1=$reg["nombre1"]; $nombre2=$reg["nombre2"]; $apellido1=$reg["apellido1"]; $apellido2=$reg["apellido2"]; $edad=$reg["edad"];  $fecha_ing_adm=$reg["fecha_ing_adm"];
	    $cta_empleado=$reg["cta_empleado"]; $tipo_nomina=$reg["tipo_nomina"]; 
		IF($monto_prestaciones>0){ $monto_tot=$monto_tot+$monto_prestaciones; 
		$StrSQL="SELECT * FROM nom052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
		while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
		  $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
		  $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
		  $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
		  $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
		  $status3_campo=$registro["status3_campo"];
		  switch($cod_campo){
		  Case "01":$str_campo=$cod_empleado; $l=$long_campo-strlen($cod_empleado); break;
		  Case "02":$str_campo=$nombre1; $l=$long_campo-strlen($nombre1); break;
		  Case "03":$str_campo=$nombre2; $l=$long_campo-strlen($nombre2); break;
		  Case "04":$str_campo=$apellido1; $l=$long_campo-strlen($apellido1); break;
		  Case "05":$str_campo=$apellido2; $l=$long_campo-strlen($apellido2); break;
		  Case "06":$str_campo=$nombre; $l=$long_campo-strlen($nombre); break;
		  Case "07":$str_campo=$cedula; $l=$long_campo-strlen($cedula); break;
		  Case "08":$str_campo=$nacionalidad; $l=$long_campo-strlen($nacionalidad); break;
		  Case "09":$str_campo=$sexo; $l=$long_campo-strlen($sexo); break;
		  Case "10":$str_campo=formato_ddmmaaaa($fecha_nac); $l=10; break;
		  Case "11":$str_campo=Rellenarcerosizq($edad,4); $l=0; break;
		  Case "12":$str_campo=formato_ddmmaaaa($fecha_ingreso); $l=10; break;
		  Case "13":$str_campo=formato_ddmmaaaa($fecha_ing_adm); $l=10; break;
		  Case "14":$str_campo=formato_ddmmaaaa($fecha_calculo); $l=10; break;	
          Case "15":$ssueldo_calculo=elimina_puntos(formato_monto($sueldo_calculo)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_calculo),14); $l=0; break;
		  Case "16":$sdias=elimina_puntos(formato_monto($dias_prestaciones)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sdias),4); $l=0; break;
		  Case "17":$ssueldo_calculo=elimina_puntos(formato_monto($sueldo_calculo_adic)); $str_campo=Rellenarcerosizq(cambia_coma_numero($ssueldo_calculo),14); $l=0; break;
		  Case "18":$sdias=elimina_puntos(formato_monto($dias_adicionales)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sdias),4); $l=0; break;
		  Case "19":$sdias=elimina_puntos(formato_monto($t_dias)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sdias),4); $l=0; break;
		  Case "20":$sc_prestaciones=elimina_puntos(formato_monto($c_prestaciones)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sc_prestaciones),14); $l=0; break;	  
		  Case "21":$sc_presta_adic=elimina_puntos(formato_monto($c_presta_adic)); $str_campo=Rellenarcerosizq(cambia_coma_numero($sc_presta_adic),14); $l=0; break;		  
		  Case "22":$smonto_prestaciones=elimina_puntos(formato_monto($monto_prestaciones)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_prestaciones),14); $l=0; break;
		  Case "23":$smonto_tot=elimina_puntos(formato_monto($monto_tot)); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
	      Case "24":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
		  Case "25":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); break;
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
   
if($tipo_formato=="TABULADO"){$encabezado="<table>".$encabezado; $pie_pagina.="<tr></table>"; }
else{$encabezado="<pre>".$encabezado; $pie_pagina.="</pre>"; }
if($tipo_rpt=="EXCEL"){	 header("Content-type: application/vnd.ms-excel");   header("Content-Disposition: attachment; filename=prestaciones.xls");	}	  
echo $encabezado.$detalle.$pie_pagina;	  
} 
pg_close();
if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 
?>