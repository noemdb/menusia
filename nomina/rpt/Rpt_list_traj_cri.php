<? error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");$php_os=PHP_OS; 
   $tipo_nominad=$_GET["tipo_nominad"];   $tipo_nominah=$_GET["tipo_nominah"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $tipo_rpt=$_GET["tipo_rpt"];   $cod_empleado_h=$_GET["cod_empleado_h"];   $cedula_d=$_GET["cedula_d"];   $cedula_h=$_GET["cedula_h"];
   $sexo=$_GET["sexo"];   $estado_civil=$_GET["estado_civil"];   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"];   $edad_d=$_GET["edad_d"];   $edad_h=$_GET["edad_h"];  $mesnac_d=$_GET["mesnac_d"];   $mesnac_h=$_GET["mesnac_h"]; 
   $fecha_ingreso_d=$_GET["fecha_ingreso_d"];   $fecha_ingreso_h=$_GET["fecha_ingreso_h"];   $fecha_egreso_d=$_GET["fecha_egreso_d"];   $fecha_egreso_h=$_GET["fecha_egreso_h"];
   $estatus=$_GET["estatus"];   $codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"];    $codigo_departamentod=$_GET["codigo_departamentod"];   $codigo_departamentoh=$_GET["codigo_departamentoh"];  
   $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"];   $fecha_egreso_d=$_GET["fecha_egreso_d"];   $fecha_egreso_h=$_GET["fecha_egreso_h"];
   $ordenado=$_GET["ordenado"];  $columna1=$_GET["columna1"]; $columna2=$_GET["columna2"];  $columna3=$_GET["columna3"];  $columna4=$_GET["columna4"]; 
   $columna5=$_GET["columna5"]; $columna6=$_GET["columna6"];  $columna7=$_GET["columna7"];  $columna8=$_GET["columna8"];    
   $date = date("d-m-Y");   $hora = date("H:i:s a");   $Sql=""; $criterio1="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_d))){$ano1=substr($fecha_ingreso_d,6,9);$mes1=substr($fecha_ingreso_d,3,2);$dia1=substr($fecha_ingreso_d,0,2);}else{$fecha_ingreso_d='';}$fecha_desde_ing=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_h))){$ano1=substr($fecha_ingreso_h,6,9);$mes1=substr($fecha_ingreso_h,3,2);$dia1=substr($fecha_ingreso_h,0,2);} else{$fecha_ingreso_h='';} $fecha_hasta_ing=$ano1.$mes1.$dia1;

   if (!(empty($fecha_egreso_d))){$ano1=substr($fecha_egreso_d,6,9);$mes1=substr($fecha_egreso_d,3,2);$dia1=substr($fecha_egreso_d,0,2);}else{$fecha_egreso_d='';}$fecha_desde_egreso=$ano1.$mes1.$dia1;
   if (!(empty($fecha_egreso_h))){$ano1=substr($fecha_egreso_h,6,9);$mes1=substr($fecha_egreso_h,3,2);$dia1=substr($fecha_egreso_h,0,2);} else{$fecha_egreso_h='';} $fecha_hasta_egreso=$ano1.$mes1.$dia1;

   $crit_st="and nom007.sexo ='".$sexo."' and nom007.edo_civil='".$estado_civil."' and  nom006.status ='".$estatus."'"; $crit_st="";
   if($sexo<>"TODOS"){$crit_st=$crit_st."and nom007.sexo ='".$sexo."' ";}
   if($estado_civil<>"TODOS"){$crit_st=$crit_st."and nom007.edo_civil='".$estado_civil."' ";}
   if($estatus<>"TODOS"){
     if($estatus=="ACTIVO/VACACIONES/PERMISO"){ $crit_st=$crit_st."and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='PERMISO')";}	 
       else{ if($estatus=="ACTIVO/VACACIONES/REPOSO"){ $crit_st=$crit_st."and (nom006.Status='ACTIVO' or nom006.Status='VACACIONES' or nom006.Status='REPOSO')";}	 
       else{ $crit_st=$crit_st."and nom006.status='".$estatus."'";}   }
   
   }
   $str_campo5=""; $str_campo6=""; $str_campo7=""; $str_campo8="";
   $lc1=60; $lc2=60; $lc3=60; $lc4=60; $ac1="L"; $ac2="L"; $ac3="L"; $ac4="L";
   if($columna1=="00"){ $str_campo1=""; $c1="N"; $enc1=""; if($ordenado=="col1"){$ordenado="nom006.cod_empleado";} }else{  $c1="S";   
	if($columna1=="01"){ $str_campo1=",nom006.cedula as col1"; $enc1="CEDULA"; $lc1=20;  }
	if($columna1=="02"){ $str_campo1=",nom006.nacionalidad as col1"; $enc1="NACIONALIDAD"; $lc1=20;  }
	if($columna1=="03"){ $str_campo1=",nom007.rif_empleado as col1"; $enc1="RIF EMPLEADO"; $lc1=20; }
	if($columna1=="04"){ $str_campo1=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col1"; $enc1="FECHA INGRESO"; $lc1=20; if($ordenado=="col1"){$ordenado="nom006.fecha_ingreso";} }
	if($columna1=="05"){ $str_campo1=",nom006.status as col1"; $enc1="ESTATUS"; $lc1=20; }	
	if($columna1=="06"){ $str_campo1=",nom006.tipo_nomina as col1"; $enc1="NOMINA"; $lc1=20; }
	if($columna1=="07"){ $str_campo1=",nom006.cod_categoria as col1"; $enc1="COD.CATEGORIA"; $lc1=20; }	
	if($columna1=="08"){ $str_campo1=",nom006.tipo_pago as col1"; $enc1="TIPO DE PAGO"; $lc1=20; }
	if($columna1=="09"){ $str_campo1=",nom006.cta_empleado as col1"; $enc1="CTA. TRABAJADOR"; $lc1=30; }
	if($columna1=="10"){ $str_campo1=",nom006.cta_empresa as col1"; $enc1="CTA. EMPRESA"; $lc1=30; }	
	if($columna1=="11"){ $str_campo1=",nom007.sexo as col1"; $enc1="SEXO"; $lc1=20; }
	if($columna1=="12"){ $str_campo1=",nom007.edo_civil as col1"; $enc1="EDO.CIVIL"; $lc1=20; }
	if($columna1=="13"){ $str_campo1=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col1"; $enc1="FECHA NACIMIENTO"; $lc1=20; if($ordenado=="col1"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna1=="14"){ $str_campo1=",nom007.edad as col1"; $enc1="EDAD"; $lc1=20; }
	if($columna1=="15"){ $str_campo1=",nom007.direccion as col1"; $enc1="DIRECCION"; }
	if($columna1=="16"){ $str_campo1=",nom007.telefono as col1"; $enc1="TELEFONO"; $lc1=20; }
	if($columna1=="17"){ $str_campo1=",nom007.correo as col1"; $enc1="E-MAIL"; }
	if($columna1=="18"){ $str_campo1=",nom007.profesion as col1"; $enc1="PROFESION"; }
	if($columna1=="19"){ $str_campo1=",nom007.grado_inst as col1"; $enc1="GRADO INST."; }
	if($columna1=="20"){ $str_campo1=",nom006.cod_cargo as col1"; $enc1="COD.CARGO"; $lc1=20; }	
	if($columna1=="21"){ $str_campo1=",nom004.denominacion as col1"; $enc1="DENOMINACION CARGO"; }
	if($columna1=="22"){ $str_campo1=",nom006.cod_departam as col1"; $enc1="COD.DEPARTAMENTO"; $lc1=20; }
	if($columna1=="23"){ $str_campo1=",nom005.descripcion_dep as col1"; $enc1="DES.DEPARTAMENTO"; }
	if($columna1=="24"){ $str_campo1=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col1"; $enc1="FEC.ASIG.CARGO"; }
	if($columna1=="25"){ $str_campo1=",nom006.sueldo as col1"; $enc1="SUELDO"; $lc1=20; $ac1="R"; }
	if($columna1=="26"){ $str_campo1=",nom006.compensacion as col1"; $enc1="COMPENSACION"; $lc1=20; $ac1="R"; }
	if($columna1=="27"){ $str_campo1=",(nom006.sueldo+nom006.compensacion) as col1"; $enc1="SUELDO+COMP."; $lc1=20; $ac1="R"; }
	if($columna1=="28"){ $str_campo1=",nom006.grado as col1"; $enc1="GRADO"; $lc1=20; }
	if($columna1=="29"){ $str_campo1=",nom006.paso as col1"; $enc1="PASO"; $lc1=20; }
	if($columna1=="30"){ $str_campo1=",nom006.cod_tipo_personal as col1"; $enc1="COD. TIPO PRES."; $lc1=20; }	
	if($columna1=="31"){ $str_campo1=",nom015.Des_tipo_personal as col1"; $enc1="DES. TIPO PRES."; }
	if($columna1=="32"){ $str_campo1=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col1"; $enc1="FECHA EGRESO"; $lc1=20; }
	if($columna1=="33"){ $str_campo1=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col1"; $enc1="FECHA INGRESO ADM. PUBLICA"; $lc1=30; }
	if($columna1=="34"){ $str_campo1=",nom006.codigo_Ubicacion as col1"; $enc1="COD. UBICACION"; $lc1=20; }
	if($columna1=="35"){ $str_campo1=",nom058.Descripcion_Ubi as col1"; $enc1="DESCRIPCION UBICACION"; }	
	if($columna1=="36"){ $str_campo1=",nom007.tlf_movil as col1"; $enc1="TELEFONO MOVIL"; $lc1=20; }
	if($columna1=="37"){ $str_campo1=",extract(days from now()-NOM006.fecha_ingreso) as col1"; $enc1="DIAS TRABAJO"; $lc1=10; $ac1="C"; }
	if($columna1=="38"){ $str_campo1=",extract(day from nom007.fecha_nacimiento) as col1"; $enc1="DIA NACIMIENTO"; $lc1=15; $ac1="C"; }
	if($columna1=="39"){ $str_campo1=",extract(month from nom007.fecha_nacimiento) as col1"; $enc1="MES NACIMIENTO"; $lc1=15; $ac1="C"; }
	if($columna1=="40"){ $str_campo1=",nom006.prima as col1"; $enc1="PRIMAS"; $lc1=20; $ac1="R"; }
	if($columna1=="41"){ $str_campo1=",nom006.sueldo_integral as col1"; $enc1="SUELDO INTEGRAL"; $lc1=20; $ac1="R"; }
	if($columna1=="42"){ $str_campo1=",nom007.estado as col1"; $enc1="ESTADO"; $lc1=20; }
	if($columna1=="43"){ $str_campo1=",nom007.municipio as col1"; $enc1="MUNICIPIO"; $lc1=30; }
	if($columna1=="44"){ $str_campo1=",nom007.ciudad as col1"; $enc1="CIUDAD"; $lc1=30; }
	if($columna1=="45"){ $str_campo1=",nom007.parroquia as col1"; $enc1="PARROQUIA"; $lc1=30; }	
   }
   if($columna2=="00"){ $str_campo2=""; $c2="N"; $enc2=""; if($ordenado=="col2"){$ordenado="nom006.cod_empleado";}}else{ $str_campo2=",nom006.cedula as col2"; $c2="S";
    if($columna2=="01"){ $str_campo2=",nom006.cedula as col2"; $enc2="CEDULA"; $lc2=20;  }
	if($columna2=="02"){ $str_campo2=",nom006.nacionalidad as col2"; $enc2="NACIONALIDAD"; $lc2=20;  }
	if($columna2=="03"){ $str_campo2=",nom007.rif_empleado as col2"; $enc2="RIF EMPLEADO"; $lc2=20; }
	if($columna2=="04"){ $str_campo2=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col2"; $enc2="FECHA INGRESO"; $lc2=20; if($ordenado=="col2"){$ordenado="nom006.fecha_ingreso";} }
	if($columna2=="05"){ $str_campo2=",nom006.status as col2"; $enc2="ESTATUS"; $lc2=20; }	
	if($columna2=="06"){ $str_campo2=",nom006.tipo_nomina as col2"; $enc2="NOMINA"; $lc2=20; }
	if($columna2=="07"){ $str_campo2=",nom006.cod_categoria as col2"; $enc2="COD.CATEGORIA"; $lc2=20; }	
	if($columna2=="08"){ $str_campo2=",nom006.tipo_pago as col2"; $enc2="TIPO DE PAGO"; $lc2=20; }
	if($columna2=="09"){ $str_campo2=",nom006.cta_empleado as col2"; $enc2="CTA. TRABAJADOR"; $lc2=30; }
	if($columna2=="10"){ $str_campo2=",nom006.cta_empresa as col2"; $enc2="CTA. EMPRESA"; $lc2=30; }	
	if($columna2=="11"){ $str_campo2=",nom007.sexo as col2"; $enc2="SEXO"; $lc2=20; }
	if($columna2=="12"){ $str_campo2=",nom007.edo_civil as col2"; $enc2="EDO.CIVIL"; $lc2=20; }
	if($columna2=="13"){ $str_campo2=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col2"; $enc2="FECHA NACIMIENTO"; $lc2=20; if($ordenado=="col2"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna2=="14"){ $str_campo2=",nom007.edad as col2"; $enc2="EDAD"; $lc2=20; }
	if($columna2=="15"){ $str_campo2=",nom007.direccion as col2"; $enc2="DIRECCION"; }
	if($columna2=="16"){ $str_campo2=",nom007.telefono as col2"; $enc2="TELEFONO"; $lc2=20; }
	if($columna2=="17"){ $str_campo2=",nom007.correo as col2"; $enc2="E-MAIL"; }
	if($columna2=="18"){ $str_campo2=",nom007.profesion as col2"; $enc2="PROFESION"; }
	if($columna2=="19"){ $str_campo2=",nom007.grado_inst as col2"; $enc2="GRADO INST."; }
	if($columna2=="20"){ $str_campo2=",nom006.cod_cargo as col2"; $enc2="COD.CARGO"; $lc2=20; }	
	if($columna2=="21"){ $str_campo2=",nom004.denominacion as col2"; $enc2="DENOMINACION CARGO"; }
	if($columna2=="22"){ $str_campo2=",nom006.cod_departam as col2"; $enc2="COD.DEPARTAMENTO"; $lc2=20; }
	if($columna2=="23"){ $str_campo2=",nom005.descripcion_dep as col2"; $enc2="DES.DEPARTAMENTO"; }
	if($columna2=="24"){ $str_campo2=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col2"; $enc2="FEC.ASIG.CARGO"; }
	if($columna2=="25"){ $str_campo2=",nom006.sueldo as col2"; $enc2="SUELDO"; $lc2=20; $ac2="R"; }
	if($columna2=="26"){ $str_campo2=",nom006.compensacion as col2"; $enc2="COMPENSACION"; $lc2=20; $ac2="R"; }
	if($columna2=="27"){ $str_campo2=",(nom006.sueldo+nom006.compensacion) as col2"; $enc2="SUELDO+COMP."; $lc2=20; $ac2="R"; }
	if($columna2=="28"){ $str_campo2=",nom006.grado as col2"; $enc2="GRADO"; $lc2=20; }
	if($columna2=="29"){ $str_campo2=",nom006.paso as col2"; $enc2="PASO"; $lc2=20; }
	if($columna2=="30"){ $str_campo2=",nom006.cod_tipo_personal as col2"; $enc2="COD. TIPO PRES."; $lc2=20; }	
	if($columna2=="31"){ $str_campo2=",nom015.Des_tipo_personal as col2"; $enc2="DES. TIPO PRES."; }
	if($columna2=="32"){ $str_campo2=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col2"; $enc2="FECHA EGRESO"; $lc2=20; }
	if($columna2=="33"){ $str_campo2=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col2"; $enc2="FECHA INGRESO ADM. PUBLICA"; $lc2=30; }
	if($columna2=="34"){ $str_campo2=",nom006.codigo_Ubicacion as col2"; $enc2="COD. UBICACION"; $lc2=20; }
	if($columna2=="35"){ $str_campo2=",nom058.Descripcion_Ubi as col2"; $enc2="DESCRIPCION UBICACION"; }
    if($columna2=="36"){ $str_campo2=",nom007.tlf_movil as col2"; $enc2="TELEFONO MOVIL"; $lc2=20; }
    if($columna2=="37"){ $str_campo2=",extract(days from now()-NOM006.fecha_ingreso) as col2"; $enc2="DIAS TRABAJO"; $lc2=6; $ac2="C"; }
    if($columna2=="38"){ $str_campo2=",extract(day from nom007.fecha_nacimiento) as col2"; $enc2="DIA NACIMIENTO"; $lc2=15; $ac2="C"; }
	if($columna2=="39"){ $str_campo2=",extract(month from nom007.fecha_nacimiento) as col2"; $enc2="MES NACIMIENTO"; $lc2=15; $ac2="C"; }	
	if($columna2=="40"){ $str_campo2=",nom006.prima as col2"; $enc2="PRIMAS"; $lc2=20; $ac2="R"; }	
	if($columna2=="41"){ $str_campo2=",nom006.sueldo_integral as col2"; $enc2="SUELDO INTEGRAL"; $lc2=20; $ac2="R"; }
	if($columna2=="42"){ $str_campo2=",nom007.estado as col2"; $enc2="ESTADO"; $lc2=20; }
	if($columna2=="43"){ $str_campo2=",nom007.municipio as col2"; $enc2="MUNICIPIO"; $lc2=30; }
	if($columna2=="44"){ $str_campo2=",nom007.ciudad as col2"; $enc2="CIUDAD"; $lc2=30; }
	if($columna2=="45"){ $str_campo2=",nom007.parroquia as col2"; $enc2="PARROQUIA"; $lc2=30; }
   }
   if($columna3=="00"){ $str_campo3=""; $c3="N"; $enc3=""; if($ordenado=="col3"){$ordenado="nom006.cod_empleado";}}else{ $str_campo3=",nom006.cedula as col3"; $c3="S";
    if($columna3=="01"){ $str_campo3=",nom006.cedula as col3"; $enc3="CEDULA"; $lc3=20;  }
	if($columna3=="02"){ $str_campo3=",nom006.nacionalidad as col3"; $enc3="NACIONALIDAD"; $lc3=20;  }
	if($columna3=="03"){ $str_campo3=",nom007.rif_empleado as col3"; $enc3="RIF EMPLEADO"; $lc3=20; }
	if($columna3=="04"){ $str_campo3=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col3"; $enc3="FECHA INGRESO"; $lc3=20; if($ordenado=="col3"){$ordenado="nom006.fecha_ingreso";} }
	if($columna3=="05"){ $str_campo3=",nom006.status as col3"; $enc3="ESTATUS"; $lc3=20; }	
	if($columna3=="06"){ $str_campo3=",nom006.tipo_nomina as col3"; $enc3="NOMINA"; $lc3=20; }
	if($columna3=="07"){ $str_campo3=",nom006.cod_categoria as col3"; $enc3="COD.CATEGORIA"; $lc3=20; }	
	if($columna3=="08"){ $str_campo3=",nom006.tipo_pago as col3"; $enc3="TIPO DE PAGO"; $lc3=20; }
	if($columna3=="09"){ $str_campo3=",nom006.cta_empleado as col3"; $enc3="CTA. TRABAJADOR"; $lc3=30; }
	if($columna3=="10"){ $str_campo3=",nom006.cta_empresa as col3"; $enc3="CTA. EMPRESA"; $lc3=30; }	
	if($columna3=="11"){ $str_campo3=",nom007.sexo as col3"; $enc3="SEXO"; $lc3=20; }
	if($columna3=="12"){ $str_campo3=",nom007.edo_civil as col3"; $enc3="EDO.CIVIL"; $lc3=20; }
	if($columna3=="13"){ $str_campo3=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col3"; $enc3="FECHA NACIMIENTO"; $lc3=20; if($ordenado=="col3"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna3=="14"){ $str_campo3=",nom007.edad as col3"; $enc3="EDAD"; $lc3=20; }
	if($columna3=="15"){ $str_campo3=",nom007.direccion as col3"; $enc3="DIRECCION"; }
	if($columna3=="16"){ $str_campo3=",nom007.telefono as col3"; $enc3="TELEFONO"; $lc3=20; }
	if($columna3=="17"){ $str_campo3=",nom007.correo as col3"; $enc3="E-MAIL"; }
	if($columna3=="18"){ $str_campo3=",nom007.profesion as col3"; $enc3="PROFESION"; }
	if($columna3=="19"){ $str_campo3=",nom007.grado_inst as col3"; $enc3="GRADO INST."; }
	if($columna3=="20"){ $str_campo3=",nom006.cod_cargo as col3"; $enc3="COD.CARGO"; $lc3=20; }	
	if($columna3=="21"){ $str_campo3=",nom004.denominacion as col3"; $enc3="DENOMINACION CARGO"; }
	if($columna3=="22"){ $str_campo3=",nom006.cod_departam as col3"; $enc3="COD.DEPARTAMENTO"; $lc3=20; }
	if($columna3=="23"){ $str_campo3=",nom005.descripcion_dep as col3"; $enc3="DES.DEPARTAMENTO"; }
	if($columna3=="24"){ $str_campo3=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col3"; $enc3="FEC.ASIG.CARGO"; }
	if($columna3=="25"){ $str_campo3=",nom006.sueldo as col3"; $enc3="SUELDO"; $lc3=20; $ac3="R"; }
	if($columna3=="26"){ $str_campo3=",nom006.compensacion as col3"; $enc3="COMPENSACION"; $lc3=20; $ac3="R"; }
	if($columna3=="27"){ $str_campo3=",(nom006.sueldo+nom006.compensacion) as col3"; $enc3="SUELDO+COMP."; $lc3=20; $ac3="R"; }
	if($columna3=="28"){ $str_campo3=",nom006.grado as col3"; $enc3="GRADO"; $lc3=20; }
	if($columna3=="29"){ $str_campo3=",nom006.paso as col3"; $enc3="PASO"; $lc3=20; }
	if($columna3=="30"){ $str_campo3=",nom006.cod_tipo_personal as col3"; $enc3="COD. TIPO PRES."; $lc3=20; }	
	if($columna3=="31"){ $str_campo3=",nom015.Des_tipo_personal as col3"; $enc3="DES. TIPO PRES."; }
	if($columna3=="32"){ $str_campo3=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col3"; $enc3="FECHA EGRESO"; $lc3=20; }
	if($columna3=="33"){ $str_campo3=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col3"; $enc3="FECHA INGRESO ADM. PUBLICA"; $lc3=30; }
	if($columna3=="34"){ $str_campo3=",nom006.codigo_Ubicacion as col3"; $enc3="COD. UBICACION"; $lc3=20; }
	if($columna3=="35"){ $str_campo3=",nom058.Descripcion_Ubi as col3"; $enc3="DESCRIPCION UBICACION"; }
    if($columna3=="36"){ $str_campo3=",nom007.tlf_movil as col3"; $enc3="TELEFONO MOVIL"; $lc3=20; }
    if($columna3=="37"){ $str_campo3=",extract(days from now()-NOM006.fecha_ingreso) as col3"; $enc3="DIAS TRABAJO"; $lc3=6; $ac3="C"; }
    if($columna3=="38"){ $str_campo3=",extract(day from nom007.fecha_nacimiento) as col3"; $enc3="DIA NACIMIENTO"; $lc3=15; $ac3="C"; }
	if($columna3=="39"){ $str_campo3=",extract(month from nom007.fecha_nacimiento) as col3"; $enc3="MES NACIMIENTO"; $lc3=15; $ac3="C"; }	
	if($columna3=="40"){ $str_campo3=",nom006.prima as col3"; $enc3="PRIMAS"; $lc3=20; $ac3="R"; }	
	if($columna3=="41"){ $str_campo3=",nom006.sueldo_integral as col3"; $enc3="SUELDO INTEGRAL"; $lc3=20; $ac3="R"; }
	if($columna3=="42"){ $str_campo3=",nom007.estado as col3"; $enc3="ESTADO"; $lc3=20; }
	if($columna3=="43"){ $str_campo3=",nom007.municipio as col3"; $enc3="MUNICIPIO"; $lc3=30; }
	if($columna3=="44"){ $str_campo3=",nom007.ciudad as col3"; $enc3="CIUDAD"; $lc3=30; }
	if($columna3=="45"){ $str_campo3=",nom007.parroquia as col3"; $enc3="PARROQUIA"; $lc3=30; }	
	
   }
   if($columna4=="00"){ $str_campo4=""; $c4="N"; $enc4="";if($ordenado=="col4"){$ordenado="nom006.cod_empleado";}}else{ $str_campo4=",nom006.cedula as col4"; $c4="S";
    if($columna4=="01"){ $str_campo4=",nom006.cedula as col4"; $enc4="CEDULA"; $lc4=20;  }
	if($columna4=="02"){ $str_campo4=",nom006.nacionalidad as col4"; $enc4="NACIONALIDAD"; $lc4=20;  }
	if($columna4=="03"){ $str_campo4=",nom007.rif_empleado as col4"; $enc4="RIF EMPLEADO"; $lc4=20; }
	if($columna4=="04"){ $str_campo4=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col4"; $enc4="FECHA INGRESO"; $lc4=20; if($ordenado=="col4"){$ordenado="nom006.fecha_ingreso";} }
	if($columna4=="05"){ $str_campo4=",nom006.status as col4"; $enc4="ESTATUS"; $lc4=20; }	
	if($columna4=="06"){ $str_campo4=",nom006.tipo_nomina as col4"; $enc4="NOMINA"; $lc4=20; }
	if($columna4=="07"){ $str_campo4=",nom006.cod_categoria as col4"; $enc4="COD.CATEGORIA"; $lc4=20; }	
	if($columna4=="08"){ $str_campo4=",nom006.tipo_pago as col4"; $enc4="TIPO DE PAGO"; $lc4=20; }
	if($columna4=="09"){ $str_campo4=",nom006.cta_empleado as col4"; $enc4="CTA. TRABAJADOR"; $lc4=30; }
	if($columna4=="10"){ $str_campo4=",nom006.cta_empresa as col4"; $enc4="CTA. EMPRESA"; $lc4=30; }	
	if($columna4=="11"){ $str_campo4=",nom007.sexo as col4"; $enc4="SEXO"; $lc4=20; }
	if($columna4=="12"){ $str_campo4=",nom007.edo_civil as col4"; $enc4="EDO.CIVIL"; $lc4=20; }
	if($columna4=="13"){ $str_campo4=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col4"; $enc4="FECHA NACIMIENTO"; $lc4=20; if($ordenado=="col4"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna4=="14"){ $str_campo4=",nom007.edad as col4"; $enc4="EDAD"; $lc4=20; }
	if($columna4=="15"){ $str_campo4=",nom007.direccion as col4"; $enc4="DIRECCION"; }
	if($columna4=="16"){ $str_campo4=",nom007.telefono as col4"; $enc4="TELEFONO"; $lc4=20; }
	if($columna4=="17"){ $str_campo4=",nom007.correo as col4"; $enc4="E-MAIL"; }
	if($columna4=="18"){ $str_campo4=",nom007.profesion as col4"; $enc4="PROFESION"; }
	if($columna4=="19"){ $str_campo4=",nom007.grado_inst as col4"; $enc4="GRADO INST."; }
	if($columna4=="20"){ $str_campo4=",nom006.cod_cargo as col4"; $enc4="COD.CARGO"; $lc4=20; }	
	if($columna4=="21"){ $str_campo4=",nom004.denominacion as col4"; $enc4="DENOMINACION CARGO"; }
	if($columna4=="22"){ $str_campo4=",nom006.cod_departam as col4"; $enc4="COD.DEPARTAMENTO"; $lc4=20; }
	if($columna4=="23"){ $str_campo4=",nom005.descripcion_dep as col4"; $enc4="DES.DEPARTAMENTO"; }
	if($columna4=="24"){ $str_campo4=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col4"; $enc4="FEC.ASIG.CARGO"; }
	if($columna4=="25"){ $str_campo4=",nom006.sueldo as col4"; $enc4="SUELDO"; $lc4=20; $ac4="R"; }
	if($columna4=="26"){ $str_campo4=",nom006.compensacion as col4"; $enc4="COMPENSACION"; $lc4=20; $ac4="R"; }
	if($columna4=="27"){ $str_campo4=",(nom006.sueldo+nom006.compensacion) as col4"; $enc4="SUELDO+COMP."; $lc4=20; $ac4="R"; }
	if($columna4=="28"){ $str_campo4=",nom006.grado as col4"; $enc4="GRADO"; $lc4=20; }
	if($columna4=="29"){ $str_campo4=",nom006.paso as col4"; $enc4="PASO"; $lc4=20; }
	if($columna4=="30"){ $str_campo4=",nom006.cod_tipo_personal as col4"; $enc4="COD. TIPO PRES."; $lc4=20; }	
	if($columna4=="31"){ $str_campo4=",nom015.Des_tipo_personal as col4"; $enc4="DES. TIPO PRES."; }
	if($columna4=="32"){ $str_campo4=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col4"; $enc4="FECHA EGRESO"; $lc4=20; }
	if($columna4=="33"){ $str_campo4=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col4"; $enc4="FECHA INGRESO ADM. PUBLICA"; $lc4=30; }
	if($columna4=="34"){ $str_campo4=",nom006.codigo_Ubicacion as col4"; $enc4="COD. UBICACION"; $lc4=20; }
	if($columna4=="35"){ $str_campo4=",nom058.Descripcion_Ubi as col4"; $enc4="DESCRIPCION UBICACION"; }
    if($columna4=="36"){ $str_campo4=",nom007.tlf_movil as col4"; $enc4="TELEFONO MOVIL"; $lc2=20; }	
	if($columna4=="37"){ $str_campo4=",extract(days from now()-NOM006.fecha_ingreso) as col4"; $enc4="DIAS TRABAJO"; $lc4=6; $ac4="C"; }
	if($columna4=="38"){ $str_campo4=",extract(day from nom007.fecha_nacimiento) as col4"; $enc4="DIA NACIMIENTO"; $lc4=15; $ac4="C"; }
	if($columna4=="39"){ $str_campo4=",extract(month from nom007.fecha_nacimiento) as col4"; $enc4="MES NACIMIENTO"; $lc4=15; $ac4="C"; }
    if($columna4=="40"){ $str_campo4=",nom006.prima as col4"; $enc4="PRIMAS"; $lc4=20; $ac4="R"; }	
	if($columna4=="41"){ $str_campo4=",nom006.sueldo_integral as col4"; $enc4="SUELDO INTEGRAL"; $lc4=20; $ac4="R"; }
	if($columna4=="42"){ $str_campo4=",nom007.estado as col4"; $enc4="ESTADO"; $lc4=20; }
	if($columna4=="43"){ $str_campo4=",nom007.municipio as col4"; $enc4="MUNICIPIO"; $lc4=30; }
	if($columna4=="44"){ $str_campo4=",nom007.ciudad as col4"; $enc4="CIUDAD"; $lc4=30; }
	if($columna4=="45"){ $str_campo4=",nom007.parroquia as col4"; $enc4="PARROQUIA"; $lc4=30; }	
   }
   if($columna5=="00"){ $str_campo5=""; $c5="N"; $enc5="";if($ordenado=="col5"){$ordenado="nom006.cod_empleado";}}else{ $str_campo5=",nom006.cedula as col5"; $c5="S";
    if($columna5=="01"){ $str_campo5=",nom006.cedula as col5"; $enc5="CEDULA"; $lc5=20;  }
	if($columna5=="02"){ $str_campo5=",nom006.nacionalidad as col5"; $enc5="NACIONALIDAD"; $lc5=20;  }
	if($columna5=="03"){ $str_campo5=",nom007.rif_empleado as col5"; $enc5="RIF EMPLEADO"; $lc5=20; }
	if($columna5=="04"){ $str_campo5=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col5"; $enc5="FECHA INGRESO"; $lc5=20; if($ordenado=="col5"){$ordenado="nom006.fecha_ingreso";} }
	if($columna5=="05"){ $str_campo5=",nom006.status as col5"; $enc5="ESTATUS"; $lc5=20; }	
	if($columna5=="06"){ $str_campo5=",nom006.tipo_nomina as col5"; $enc5="NOMINA"; $lc5=20; }
	if($columna5=="07"){ $str_campo5=",nom006.cod_categoria as col5"; $enc5="COD.CATEGORIA"; $lc5=20; }	
	if($columna5=="08"){ $str_campo5=",nom006.tipo_pago as col5"; $enc5="TIPO DE PAGO"; $lc5=20; }
	if($columna5=="09"){ $str_campo5=",nom006.cta_empleado as col5"; $enc5="CTA. TRABAJADOR"; $lc5=30; }
	if($columna5=="10"){ $str_campo5=",nom006.cta_empresa as col5"; $enc5="CTA. EMPRESA"; $lc5=30; }	
	if($columna5=="11"){ $str_campo5=",nom007.sexo as col5"; $enc5="SEXO"; $lc5=20; }
	if($columna5=="12"){ $str_campo5=",nom007.edo_civil as col5"; $enc5="EDO.CIVIL"; $lc5=20; }
	if($columna5=="13"){ $str_campo5=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col5"; $enc5="FECHA NACIMIENTO"; $lc5=20; if($ordenado=="col5"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna5=="14"){ $str_campo5=",nom007.edad as col5"; $enc5="EDAD"; $lc5=20; }
	if($columna5=="15"){ $str_campo5=",nom007.direccion as col5"; $enc5="DIRECCION"; }
	if($columna5=="16"){ $str_campo5=",nom007.telefono as col5"; $enc5="TELEFONO"; $lc5=20; }
	if($columna5=="17"){ $str_campo5=",nom007.correo as col5"; $enc5="E-MAIL"; }
	if($columna5=="18"){ $str_campo5=",nom007.profesion as col5"; $enc5="PROFESION"; }
	if($columna5=="19"){ $str_campo5=",nom007.grado_inst as col5"; $enc5="GRADO INST."; }
	if($columna5=="20"){ $str_campo5=",nom006.cod_cargo as col5"; $enc5="COD.CARGO"; $lc5=20; }	
	if($columna5=="21"){ $str_campo5=",nom004.denominacion as col5"; $enc5="DENOMINACION CARGO"; }
	if($columna5=="22"){ $str_campo5=",nom006.cod_departam as col5"; $enc5="COD.DEPARTAMENTO"; $lc5=20; }
	if($columna5=="23"){ $str_campo5=",nom005.descripcion_dep as col5"; $enc5="DES.DEPARTAMENTO"; }
	if($columna5=="24"){ $str_campo5=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col5"; $enc5="FEC.ASIG.CARGO"; }
	if($columna5=="25"){ $str_campo5=",nom006.sueldo as col5"; $enc5="SUELDO"; $lc5=20; $ac5="R"; }
	if($columna5=="26"){ $str_campo5=",nom006.compensacion as col5"; $enc5="COMPENSACION"; $lc5=20; $ac5="R"; }
	if($columna5=="27"){ $str_campo5=",(nom006.sueldo+nom006.compensacion) as col5"; $enc5="SUELDO+COMP."; $lc5=20; $ac5="R"; }
	if($columna5=="28"){ $str_campo5=",nom006.grado as col5"; $enc5="GRADO"; $lc5=20; }
	if($columna5=="29"){ $str_campo5=",nom006.paso as col5"; $enc5="PASO"; $lc5=20; }
	if($columna5=="30"){ $str_campo5=",nom006.cod_tipo_personal as col5"; $enc5="COD. TIPO PRES."; $lc5=20; }	
	if($columna5=="31"){ $str_campo5=",nom015.Des_tipo_personal as col5"; $enc5="DES. TIPO PRES."; }
	if($columna5=="32"){ $str_campo5=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col5"; $enc5="FECHA EGRESO"; $lc5=20; }
	if($columna5=="33"){ $str_campo5=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col5"; $enc5="FECHA INGRESO ADM. PUBLICA"; $lc5=30; }
	if($columna5=="34"){ $str_campo5=",nom006.codigo_Ubicacion as col5"; $enc5="COD. UBICACION"; $lc5=20; }
	if($columna5=="35"){ $str_campo5=",nom058.Descripcion_Ubi as col5"; $enc5="DESCRIPCION UBICACION"; }
    if($columna5=="36"){ $str_campo5=",nom007.tlf_movil as col5"; $enc5="TELEFONO MOVIL"; $lc2=20; }	
	if($columna5=="37"){ $str_campo5=",extract(days from now()-NOM006.fecha_ingreso) as col5"; $enc5="DIAS TRABAJO"; $lc5=6; $ac5="C"; }
	if($columna5=="38"){ $str_campo5=",extract(day from nom007.fecha_nacimiento) as col5"; $enc5="DIA NACIMIENTO"; $lc5=15; $ac5="C"; }
	if($columna5=="39"){ $str_campo5=",extract(month from nom007.fecha_nacimiento) as col5"; $enc5="MES NACIMIENTO"; $lc5=15; $ac5="C"; }
	if($columna5=="40"){ $str_campo5=",nom006.prima as col5"; $enc5="PRIMAS"; $lc5=20; $ac5="R"; }	
	if($columna5=="41"){ $str_campo5=",nom006.sueldo_integral as col5"; $enc5="SUELDO INTEGRAL"; $lc5=20; $ac5="R"; }
	if($columna5=="42"){ $str_campo5=",nom007.estado as col5"; $enc5="ESTADO"; $lc5=20; }
	if($columna5=="43"){ $str_campo5=",nom007.municipio as col5"; $enc5="MUNICIPIO"; $lc5=30; }
	if($columna5=="44"){ $str_campo5=",nom007.ciudad as col5"; $enc5="CIUDAD"; $lc5=30; }
	if($columna5=="45"){ $str_campo5=",nom007.parroquia as col5"; $enc5="PARROQUIA"; $lc5=30; }	
   }
   if($columna6=="00"){ $str_campo6=""; $c6="N"; $enc6="";if($ordenado=="col6"){$ordenado="nom006.cod_empleado";}}else{ $str_campo6=",nom006.cedula as col6"; $c6="S";
    if($columna6=="01"){ $str_campo6=",nom006.cedula as col6"; $enc6="CEDULA"; $lc6=20;  }
	if($columna6=="02"){ $str_campo6=",nom006.nacionalidad as col6"; $enc6="NACIONALIDAD"; $lc6=20;  }
	if($columna6=="03"){ $str_campo6=",nom007.rif_empleado as col6"; $enc6="RIF EMPLEADO"; $lc6=20; }
	if($columna6=="04"){ $str_campo6=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col6"; $enc6="FECHA INGRESO"; $lc6=20; if($ordenado=="col6"){$ordenado="nom006.fecha_ingreso";} }
	if($columna6=="05"){ $str_campo6=",nom006.status as col6"; $enc6="ESTATUS"; $lc6=20; }	
	if($columna6=="06"){ $str_campo6=",nom006.tipo_nomina as col6"; $enc6="NOMINA"; $lc6=20; }
	if($columna6=="07"){ $str_campo6=",nom006.cod_categoria as col6"; $enc6="COD.CATEGORIA"; $lc6=20; }	
	if($columna6=="08"){ $str_campo6=",nom006.tipo_pago as col6"; $enc6="TIPO DE PAGO"; $lc6=20; }
	if($columna6=="09"){ $str_campo6=",nom006.cta_empleado as col6"; $enc6="CTA. TRABAJADOR"; $lc6=30; }
	if($columna6=="10"){ $str_campo6=",nom006.cta_empresa as col6"; $enc6="CTA. EMPRESA"; $lc6=30; }	
	if($columna6=="11"){ $str_campo6=",nom007.sexo as col6"; $enc6="SEXO"; $lc6=20; }
	if($columna6=="12"){ $str_campo6=",nom007.edo_civil as col6"; $enc6="EDO.CIVIL"; $lc6=20; }
	if($columna6=="13"){ $str_campo6=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col6"; $enc6="FECHA NACIMIENTO"; $lc6=20; if($ordenado=="col6"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna6=="14"){ $str_campo6=",nom007.edad as col6"; $enc6="EDAD"; $lc6=20; }
	if($columna6=="15"){ $str_campo6=",nom007.direccion as col6"; $enc6="DIRECCION"; }
	if($columna6=="16"){ $str_campo6=",nom007.telefono as col6"; $enc6="TELEFONO"; $lc6=20; }
	if($columna6=="17"){ $str_campo6=",nom007.correo as col6"; $enc6="E-MAIL"; }
	if($columna6=="18"){ $str_campo6=",nom007.profesion as col6"; $enc6="PROFESION"; }
	if($columna6=="19"){ $str_campo6=",nom007.grado_inst as col6"; $enc6="GRADO INST."; }
	if($columna6=="20"){ $str_campo6=",nom006.cod_cargo as col6"; $enc6="COD.CARGO"; $lc6=20; }	
	if($columna6=="21"){ $str_campo6=",nom004.denominacion as col6"; $enc6="DENOMINACION CARGO"; }
	if($columna6=="22"){ $str_campo6=",nom006.cod_departam as col6"; $enc6="COD.DEPARTAMENTO"; $lc6=20; }
	if($columna6=="23"){ $str_campo6=",nom005.descripcion_dep as col6"; $enc6="DES.DEPARTAMENTO"; }
	if($columna6=="24"){ $str_campo6=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col6"; $enc6="FEC.ASIG.CARGO"; }
	if($columna6=="25"){ $str_campo6=",nom006.sueldo as col6"; $enc6="SUELDO"; $lc6=20; $ac6="R"; }
	if($columna6=="26"){ $str_campo6=",nom006.compensacion as col6"; $enc6="COMPENSACION"; $lc6=20; $ac6="R"; }
	if($columna6=="27"){ $str_campo6=",(nom006.sueldo+nom006.compensacion) as col6"; $enc6="SUELDO+COMP."; $lc6=20; $ac6="R"; }
	if($columna6=="28"){ $str_campo6=",nom006.grado as col6"; $enc6="GRADO"; $lc6=20; }
	if($columna6=="29"){ $str_campo6=",nom006.paso as col6"; $enc6="PASO"; $lc6=20; }
	if($columna6=="30"){ $str_campo6=",nom006.cod_tipo_personal as col6"; $enc6="COD. TIPO PRES."; $lc6=20; }	
	if($columna6=="31"){ $str_campo6=",nom015.Des_tipo_personal as col6"; $enc6="DES. TIPO PRES."; }
	if($columna6=="32"){ $str_campo6=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col6"; $enc6="FECHA EGRESO"; $lc6=20; }
	if($columna6=="33"){ $str_campo6=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col6"; $enc6="FECHA INGRESO ADM. PUBLICA"; $lc6=30; }
	if($columna6=="34"){ $str_campo6=",nom006.codigo_Ubicacion as col6"; $enc6="COD. UBICACION"; $lc6=20; }
	if($columna6=="35"){ $str_campo6=",nom058.Descripcion_Ubi as col6"; $enc6="DESCRIPCION UBICACION"; }
    if($columna6=="36"){ $str_campo6=",nom007.tlf_movil as col6"; $enc6="TELEFONO MOVIL"; $lc2=20; }	
	if($columna6=="37"){ $str_campo6=",extract(days from now()-NOM006.fecha_ingreso) as col6"; $enc6="DIAS TRABAJO"; $lc6=6; $ac6="C"; }
	if($columna6=="38"){ $str_campo6=",extract(day from nom007.fecha_nacimiento) as col6"; $enc6="DIA NACIMIENTO"; $lc6=15; $ac6="C"; }
	if($columna6=="39"){ $str_campo6=",extract(month from nom007.fecha_nacimiento) as col6"; $enc6="MES NACIMIENTO"; $lc6=15; $ac6="C"; }
	if($columna6=="40"){ $str_campo6=",nom006.prima as col6"; $enc6="PRIMAS"; $lc6=20; $ac6="R"; }
	if($columna6=="41"){ $str_campo6=",nom006.sueldo_integral as col6"; $enc6="SUELDO INTEGRAL"; $lc6=20; $ac6="R"; }
	if($columna6=="42"){ $str_campo6=",nom007.estado as col6"; $enc6="ESTADO"; $lc6=20; }
	if($columna6=="43"){ $str_campo6=",nom007.municipio as col6"; $enc6="MUNICIPIO"; $lc6=30; }
	if($columna6=="44"){ $str_campo6=",nom007.ciudad as col6"; $enc6="CIUDAD"; $lc6=30; }
	if($columna6=="45"){ $str_campo6=",nom007.parroquia as col6"; $enc6="PARROQUIA"; $lc6=30; }	
   }
   if($columna7=="00"){ $str_campo7=""; $c7="N"; $enc7="";if($ordenado=="col7"){$ordenado="nom006.cod_empleado";}}else{ $str_campo7=",nom006.cedula as col7"; $c7="S";
    if($columna7=="01"){ $str_campo7=",nom006.cedula as col7"; $enc7="CEDULA"; $lc7=20;  }
	if($columna7=="02"){ $str_campo7=",nom006.nacionalidad as col7"; $enc7="NACIONALIDAD"; $lc7=20;  }
	if($columna7=="03"){ $str_campo7=",nom007.rif_empleado as col7"; $enc7="RIF EMPLEADO"; $lc7=20; }
	if($columna7=="04"){ $str_campo7=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col7"; $enc7="FECHA INGRESO"; $lc7=20; if($ordenado=="col7"){$ordenado="nom006.fecha_ingreso";} }
	if($columna7=="05"){ $str_campo7=",nom006.status as col7"; $enc7="ESTATUS"; $lc7=20; }	
	if($columna7=="06"){ $str_campo7=",nom006.tipo_nomina as col7"; $enc7="NOMINA"; $lc7=20; }
	if($columna7=="07"){ $str_campo7=",nom006.cod_categoria as col7"; $enc7="COD.CATEGORIA"; $lc7=20; }	
	if($columna7=="08"){ $str_campo7=",nom006.tipo_pago as col7"; $enc7="TIPO DE PAGO"; $lc7=20; }
	if($columna7=="09"){ $str_campo7=",nom006.cta_empleado as col7"; $enc7="CTA. TRABAJADOR"; $lc7=30; }
	if($columna7=="10"){ $str_campo7=",nom006.cta_empresa as col7"; $enc7="CTA. EMPRESA"; $lc7=30; }	
	if($columna7=="11"){ $str_campo7=",nom007.sexo as col7"; $enc7="SEXO"; $lc7=20; }
	if($columna7=="12"){ $str_campo7=",nom007.edo_civil as col7"; $enc7="EDO.CIVIL"; $lc7=20; }
	if($columna7=="13"){ $str_campo7=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col7"; $enc7="FECHA NACIMIENTO"; $lc7=20; if($ordenado=="col7"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna7=="14"){ $str_campo7=",nom007.edad as col7"; $enc7="EDAD"; $lc7=20; }
	if($columna7=="15"){ $str_campo7=",nom007.direccion as col7"; $enc7="DIRECCION"; }
	if($columna7=="16"){ $str_campo7=",nom007.telefono as col7"; $enc7="TELEFONO"; $lc7=20; }
	if($columna7=="17"){ $str_campo7=",nom007.correo as col7"; $enc7="E-MAIL"; }
	if($columna7=="18"){ $str_campo7=",nom007.profesion as col7"; $enc7="PROFESION"; }
	if($columna7=="19"){ $str_campo7=",nom007.grado_inst as col7"; $enc7="GRADO INST."; }
	if($columna7=="20"){ $str_campo7=",nom006.cod_cargo as col7"; $enc7="COD.CARGO"; $lc7=20; }	
	if($columna7=="21"){ $str_campo7=",nom004.denominacion as col7"; $enc7="DENOMINACION CARGO"; }
	if($columna7=="22"){ $str_campo7=",nom006.cod_departam as col7"; $enc7="COD.DEPARTAMENTO"; $lc7=20; }
	if($columna7=="23"){ $str_campo7=",nom005.descripcion_dep as col7"; $enc7="DES.DEPARTAMENTO"; }
	if($columna7=="24"){ $str_campo7=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col7"; $enc7="FEC.ASIG.CARGO"; }
	if($columna7=="25"){ $str_campo7=",nom006.sueldo as col7"; $enc7="SUELDO"; $lc7=20; $ac7="R"; }
	if($columna7=="26"){ $str_campo7=",nom006.compensacion as col7"; $enc7="COMPENSACION"; $lc7=20; $ac7="R"; }
	if($columna7=="27"){ $str_campo7=",(nom006.sueldo+nom006.compensacion) as col7"; $enc7="SUELDO+COMP."; $lc7=20; $ac7="R"; }
	if($columna7=="28"){ $str_campo7=",nom006.grado as col7"; $enc7="GRADO"; $lc7=20; }
	if($columna7=="29"){ $str_campo7=",nom006.paso as col7"; $enc7="PASO"; $lc7=20; }
	if($columna7=="30"){ $str_campo7=",nom006.cod_tipo_personal as col7"; $enc7="COD. TIPO PRES."; $lc7=20; }	
	if($columna7=="31"){ $str_campo7=",nom015.Des_tipo_personal as col7"; $enc7="DES. TIPO PRES."; }
	if($columna7=="32"){ $str_campo7=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col7"; $enc7="FECHA EGRESO"; $lc7=20; }
	if($columna7=="33"){ $str_campo7=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col7"; $enc7="FECHA INGRESO ADM. PUBLICA"; $lc7=30; }
	if($columna7=="34"){ $str_campo7=",nom006.codigo_Ubicacion as col7"; $enc7="COD. UBICACION"; $lc7=20; }
	if($columna7=="35"){ $str_campo7=",nom058.Descripcion_Ubi as col7"; $enc7="DESCRIPCION UBICACION"; }
    if($columna7=="36"){ $str_campo7=",nom007.tlf_movil as col7"; $enc7="TELEFONO MOVIL"; $lc2=20; }	
	if($columna7=="37"){ $str_campo7=",extract(days from now()-NOM006.fecha_ingreso) as col7"; $enc7="DIAS TRABAJO"; $lc7=6; $ac7="C"; }
	if($columna7=="38"){ $str_campo7=",extract(day from nom007.fecha_nacimiento) as col7"; $enc7="DIA NACIMIENTO"; $lc7=15; $ac7="C"; }
	if($columna7=="39"){ $str_campo7=",extract(month from nom007.fecha_nacimiento) as col7"; $enc7="MES NACIMIENTO"; $lc7=15; $ac7="C"; }	
	if($columna7=="40"){ $str_campo7=",nom006.prima as col7"; $enc7="PRIMAS"; $lc7=20; $ac7="R"; }	
	if($columna7=="41"){ $str_campo7=",nom006.sueldo_integral as col7"; $enc7="SUELDO INTEGRAL"; $lc7=20; $ac7="R"; }
	if($columna7=="42"){ $str_campo7=",nom007.estado as col7"; $enc7="ESTADO"; $lc7=20; }
	if($columna7=="43"){ $str_campo7=",nom007.municipio as col7"; $enc7="MUNICIPIO"; $lc7=30; }
	if($columna7=="44"){ $str_campo7=",nom007.ciudad as col7"; $enc7="CIUDAD"; $lc7=30; }
	if($columna7=="45"){ $str_campo7=",nom007.parroquia as col7"; $enc7="PARROQUIA"; $lc7=30; }	
   }
   if($columna8=="00"){ $str_campo8=""; $c8="N"; $enc8="";if($ordenado=="col8"){$ordenado="nom006.cod_empleado";}}else{ $str_campo8=",nom006.cedula as col8"; $c8="S";
    if($columna8=="01"){ $str_campo8=",nom006.cedula as col8"; $enc8="CEDULA"; $lc8=20;  }
	if($columna8=="02"){ $str_campo8=",nom006.nacionalidad as col8"; $enc8="NACIONALIDAD"; $lc8=20;  }
	if($columna8=="03"){ $str_campo8=",nom007.rif_empleado as col8"; $enc8="RIF EMPLEADO"; $lc8=20; }
	if($columna8=="04"){ $str_campo8=",to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as col8"; $enc8="FECHA INGRESO"; $lc8=20; if($ordenado=="col8"){$ordenado="nom006.fecha_ingreso";} }
	if($columna8=="05"){ $str_campo8=",nom006.status as col8"; $enc8="ESTATUS"; $lc8=20; }	
	if($columna8=="06"){ $str_campo8=",nom006.tipo_nomina as col8"; $enc8="NOMINA"; $lc8=20; }
	if($columna8=="07"){ $str_campo8=",nom006.cod_categoria as col8"; $enc8="COD.CATEGORIA"; $lc8=20; }	
	if($columna8=="08"){ $str_campo8=",nom006.tipo_pago as col8"; $enc8="TIPO DE PAGO"; $lc8=20; }
	if($columna8=="09"){ $str_campo8=",nom006.cta_empleado as col8"; $enc8="CTA. TRABAJADOR"; $lc8=30; }
	if($columna8=="10"){ $str_campo8=",nom006.cta_empresa as col8"; $enc8="CTA. EMPRESA"; $lc8=30; }	
	if($columna8=="11"){ $str_campo8=",nom007.sexo as col8"; $enc8="SEXO"; $lc8=20; }
	if($columna8=="12"){ $str_campo8=",nom007.edo_civil as col8"; $enc8="EDO.CIVIL"; $lc8=20; }
	if($columna8=="13"){ $str_campo8=",to_char(nom007.fecha_nacimiento,'DD/MM/YYYY') as col8"; $enc8="FECHA NACIMIENTO"; $lc8=20; if($ordenado=="col8"){$ordenado="nom006.fecha_nacimiento";} }
	if($columna8=="14"){ $str_campo8=",nom007.edad as col8"; $enc8="EDAD"; $lc8=20; }
	if($columna8=="15"){ $str_campo8=",nom007.direccion as col8"; $enc8="DIRECCION"; }
	if($columna8=="16"){ $str_campo8=",nom007.telefono as col8"; $enc8="TELEFONO"; $lc8=20; }
	if($columna8=="17"){ $str_campo8=",nom007.correo as col8"; $enc8="E-MAIL"; }
	if($columna8=="18"){ $str_campo8=",nom007.profesion as col8"; $enc8="PROFESION"; }
	if($columna8=="19"){ $str_campo8=",nom007.grado_inst as col8"; $enc8="GRADO INST."; }
	if($columna8=="20"){ $str_campo8=",nom006.cod_cargo as col8"; $enc8="COD.CARGO"; $lc8=20; }	
	if($columna8=="21"){ $str_campo8=",nom004.denominacion as col8"; $enc8="DENOMINACION CARGO"; }
	if($columna8=="22"){ $str_campo8=",nom006.cod_departam as col8"; $enc8="COD.DEPARTAMENTO"; $lc8=20; }
	if($columna8=="23"){ $str_campo8=",nom005.descripcion_dep as col8"; $enc8="DES.DEPARTAMENTO"; }
	if($columna8=="24"){ $str_campo8=",to_char(nom006.fecha_asigna_cargo,'DD/MM/YYYY') as col8"; $enc8="FEC.ASIG.CARGO"; }
	if($columna8=="25"){ $str_campo8=",nom006.sueldo as col8"; $enc8="SUELDO"; $lc8=20; $ac8="R"; }
	if($columna8=="26"){ $str_campo8=",nom006.compensacion as col8"; $enc8="COMPENSACION"; $lc8=20; $ac8="R"; }
	if($columna8=="27"){ $str_campo8=",(nom006.sueldo+nom006.compensacion) as col8"; $enc8="SUELDO+COMP."; $lc8=20; $ac8="R"; }
	if($columna8=="28"){ $str_campo8=",nom006.grado as col8"; $enc8="GRADO"; $lc8=20; }
	if($columna8=="29"){ $str_campo8=",nom006.paso as col8"; $enc8="PASO"; $lc8=20; }
	if($columna8=="30"){ $str_campo8=",nom006.cod_tipo_personal as col8"; $enc8="COD. TIPO PRES."; $lc8=20; }	
	if($columna8=="31"){ $str_campo8=",nom015.Des_tipo_personal as col8"; $enc8="DES. TIPO PRES."; }
	if($columna8=="32"){ $str_campo8=",to_char(nom006.fecha_egreso,'DD/MM/YYYY') as col8"; $enc8="FECHA EGRESO"; $lc8=20; }
	if($columna8=="33"){ $str_campo8=",to_char(nom006.fecha_ing_adm,'DD/MM/YYYY') as col8"; $enc8="FECHA INGRESO ADM. PUBLICA"; $lc8=30; }
	if($columna8=="34"){ $str_campo8=",nom006.codigo_Ubicacion as col8"; $enc8="COD. UBICACION"; $lc8=20; }
	if($columna8=="35"){ $str_campo8=",nom058.Descripcion_Ubi as col8"; $enc8="DESCRIPCION UBICACION"; }
    if($columna8=="36"){ $str_campo8=",nom007.tlf_movil as col8"; $enc8="TELEFONO MOVIL"; $lc2=20; }	
	if($columna8=="37"){ $str_campo8=",extract(days from now()-NOM006.fecha_ingreso) as col8"; $enc8="DIAS TRABAJO"; $lc8=6; $ac8="C"; }
	if($columna8=="38"){ $str_campo8=",extract(day from nom007.fecha_nacimiento) as col8"; $enc8="DIA NACIMIENTO"; $lc8=15; $ac8="C"; }
	if($columna8=="39"){ $str_campo8=",extract(month from nom007.fecha_nacimiento) as col8"; $enc8="MES NACIMIENTO"; $lc8=15; $ac8="C"; }	
	if($columna6=="40"){ $str_campo8=",nom006.prima as col8"; $enc8="PRIMAS"; $lc8=20; $ac8="R"; }	
	if($columna8=="41"){ $str_campo8=",nom006.sueldo_integral as col8"; $enc8="SUELDO INTEGRAL"; $lc8=20; $ac8="R"; }
	if($columna8=="42"){ $str_campo8=",nom007.estado as col8"; $enc8="ESTADO"; $lc8=20; }
	if($columna8=="43"){ $str_campo8=",nom007.municipio as col8"; $enc8="MUNICIPIO"; $lc8=30; }
	if($columna8=="44"){ $str_campo8=",nom007.ciudad as col8"; $enc8="CIUDAD"; $lc8=30; }
	if($columna8=="45"){ $str_campo8=",nom007.parroquia as col8"; $enc8="PARROQUIA"; $lc8=30; }	
   }
   $nomb_rpt="Rpt_list_trab_cri.xml"; $rpdf=1; if(($c3=="S")or($c4=="S")){$nomb_rpt="Rpt_list_trab_cri_col.xml"; $rpdf=2;}
   $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   
        $sSQL = "SELECT nom006.cod_empleado, nom006.nombre, nom006.cedula, nom006.Nacionalidad, nom006.fecha_ingreso, nom006.Status, nom006.tipo_nomina, nom001.Descripcion, nom006.cod_categoria, nom006.tipo_pago, nom006.cta_empleado, nom006.cod_banco, nom006.nombre_banco, nom006.cta_empresa, 
		         nom006.fecha_egreso, nom006.Cont_fijo, nom006.cedula_titular, nom006.campo_str1, nom006.campo_num1, nom007.nombre1, nom007.nombre2, nom007.apellido1, nom007.apellido2, nom007.Sexo,nom007.Edo_civil,nom007.fecha_nacimiento,nom007.edad, nom007.lugar_nacimiento,nom007.direccion,
				 nom007.cod_postal,nom007.Profesion, nom007.Telefono,nom007.tlf_movil,nom007.Correo,nom007.estado,nom007.ciudad,nom007.parroquia,nom007.municipio, nom006.cod_cargo,nom004.Denominacion, nom006.cedula,nom006.cod_departam,nom005.Descripcion_dep,nom006.fecha_asigna_cargo, nom006.sueldo, nom006.compensacion, nom006.nombre, nom006.tipo_nomina, 
				 nom006.cod_tipo_personal, nom015.Des_tipo_personal, nom006.codigo_Ubicacion, nom058.Descripcion_Ubi FROM (nom006 LEFT JOIN nom007 ON (nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion), nom001, nom005, nom004, nom015 
				 WHERE nom006.tipo_nomina=nom001.tipo_nomina and nom006.cod_cargo=nom004.codigo_cargo and nom005.codigo_departamento=nom006.cod_departam and nom015.cod_tipo_personal=nom006.cod_tipo_personal And";
		
        $sSQL = "SELECT nom006.cod_empleado, nom006.nombre, nom006.cedula, nom006.Nacionalidad, nom006.fecha_ingreso, nom006.Status, nom006.tipo_nomina, nom001.Descripcion, nom006.cod_categoria, nom006.tipo_pago, nom006.cta_empleado, nom006.cod_banco, nom006.nombre_banco, nom006.cta_empresa, 
		         nom006.fecha_egreso, nom006.Cont_fijo, nom006.cedula_titular, nom006.campo_str1, nom006.campo_num1, nom007.nombre1, nom007.nombre2, nom007.apellido1, nom007.apellido2, nom007.Sexo,nom007.Edo_civil,nom007.fecha_nacimiento,nom007.edad, nom007.lugar_nacimiento,nom007.direccion,
				 nom007.cod_postal,nom007.Profesion, nom007.Telefono,nom007.tlf_movil,nom007.Correo,nom007.estado,nom007.ciudad,nom007.parroquia,nom007.municipio, nom006.cod_cargo,nom004.Denominacion, nom006.cedula,nom006.cod_departam,nom005.Descripcion_dep,nom006.fecha_asigna_cargo, nom006.sueldo, nom006.compensacion, nom006.nombre, nom006.tipo_nomina, 
				 nom006.cod_tipo_personal, nom015.Des_tipo_personal, nom006.codigo_Ubicacion, nom058.Descripcion_Ubi 
				 FROM (nom006 LEFT JOIN nom007 ON ( ((nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion) LEFT JOIN nom005 ON (nom005.codigo_departamento=nom006.cod_departam)) LEFT JOIN nom004 ON (nom006.cod_cargo=nom004.codigo_cargo) ) left join on nom015 (nom015.cod_tipo_personal=nom006.cod_tipo_personal), nom001   
				 WHERE nom006.tipo_nomina=nom001.tipo_nomina ";
		
		
        $cant=0;
       $fsql = "SELECT count(distinct  nom006.cod_empleado) as cant_trab   FROM  ((((nom006 LEFT JOIN nom007 ON (nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion)) LEFT JOIN nom005 ON (nom005.codigo_departamento=nom006.cod_departam)) LEFT JOIN nom004 ON (nom006.cod_cargo=nom004.codigo_cargo) ) left join nom015 on (nom015.cod_tipo_personal=nom006.cod_tipo_personal), nom001   
				 WHERE nom006.tipo_nomina=nom001.tipo_nomina and
				  nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."' and
                  nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."' and
                  nom006.cedula>='".$cedula_d."' and nom006.cedula<='".$cedula_h."' and 
				  nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."' and
				  nom006.cod_departam>='".$codigo_departamentod."' and nom006.cod_departam<='".$codigo_departamentoh."' and
				  nom006.cod_tipo_personal>='".$tipo_personal_d."' and nom006.cod_tipo_personal<='".$tipo_personal_h."' and
                  nom007.fecha_nacimiento>='".$fecha_desde."' and nom007.fecha_nacimiento<='".$fecha_hasta."' and
                  nom007.edad>='".$edad_d."' and nom007.edad<='".$edad_h."' and
				  extract(month from nom007.fecha_nacimiento)>=".$mesnac_d." and extract(month from nom007.fecha_nacimiento)<=".$mesnac_h." and
				   nom006.fecha_ingreso>='".$fecha_desde_ing."' and nom006.fecha_ingreso<='".$fecha_hasta_ing."' and
                  nom006.fecha_egreso>='".$fecha_desde_egreso."' and nom006.fecha_egreso<='".$fecha_hasta_egreso."' ".$crit_st;
	     $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $cant=$freg["cant_trab"];} 
		 
        $sSQL = "SELECT nom006.cod_empleado, nom006.nombre, nom006.cedula ".$str_campo1.$str_campo2.$str_campo3.$str_campo4.$str_campo5.$str_campo6.$str_campo7.$str_campo8."
		         FROM (nom006 LEFT JOIN nom007 ON (nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion), nom001, nom005, nom004, nom015 
				 WHERE nom006.tipo_nomina=nom001.tipo_nomina and nom006.cod_cargo=nom004.codigo_cargo and nom005.codigo_departamento=nom006.cod_departam and nom015.cod_tipo_personal=nom006.cod_tipo_personal And
				  nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."' and
                  nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."' and
                  nom006.cedula>='".$cedula_d."' and nom006.cedula<='".$cedula_h."' and 
				  nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."' and
				  nom006.cod_departam>='".$codigo_departamentod."' and nom006.cod_departam<='".$codigo_departamentoh."' and
				  nom006.cod_tipo_personal>='".$tipo_personal_d."' and nom006.cod_tipo_personal<='".$tipo_personal_h."' and
                  nom007.fecha_nacimiento>='".$fecha_desde."' and nom007.fecha_nacimiento<='".$fecha_hasta."' and
                  nom007.edad>='".$edad_d."' and nom007.edad<='".$edad_h."' and
				  extract(month from nom007.fecha_nacimiento)>=".$mesnac_d." and extract(month from nom007.fecha_nacimiento)<=".$mesnac_h." and
				  nom006.fecha_egreso>='".$fecha_desde_egreso."' and nom006.fecha_egreso<='".$fecha_hasta_egreso."' and
                  nom006.fecha_ingreso>='".$fecha_desde_ing."' and nom006.fecha_ingreso<='".$fecha_hasta_ing."' ".$crit_st."  order by ".$ordenado;
		
        $sSQL = "SELECT nom006.cod_empleado, nom006.nombre, nom006.cedula ".$str_campo1.$str_campo2.$str_campo3.$str_campo4.$str_campo5.$str_campo6.$str_campo7.$str_campo8."		
		         FROM  ((((nom006 LEFT JOIN nom007 ON (nom006.cod_empleado=nom007.cod_empleado)) LEFT JOIN nom058 ON (nom006.codigo_Ubicacion=nom058.codigo_Ubicacion)) LEFT JOIN nom005 ON (nom005.codigo_departamento=nom006.cod_departam)) LEFT JOIN nom004 ON (nom006.cod_cargo=nom004.codigo_cargo) ) left join nom015 on (nom015.cod_tipo_personal=nom006.cod_tipo_personal), nom001   
				 WHERE nom006.tipo_nomina=nom001.tipo_nomina and
		          nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."' and
                  nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."' and
                  nom006.cedula>='".$cedula_d."' and nom006.cedula<='".$cedula_h."' and 
				  nom006.cod_cargo>='".$codigo_cargo_d."' and nom006.cod_cargo<='".$codigo_cargo_h."' and
				  nom006.cod_departam>='".$codigo_departamentod."' and nom006.cod_departam<='".$codigo_departamentoh."' and
				  nom006.cod_tipo_personal>='".$tipo_personal_d."' and nom006.cod_tipo_personal<='".$tipo_personal_h."' and
                  nom007.fecha_nacimiento>='".$fecha_desde."' and nom007.fecha_nacimiento<='".$fecha_hasta."' and
                  nom007.edad>='".$edad_d."' and nom007.edad<='".$edad_h."' and
				  extract(month from nom007.fecha_nacimiento)>=".$mesnac_d." and extract(month from nom007.fecha_nacimiento)<=".$mesnac_h." and
				  nom006.fecha_egreso>='".$fecha_desde_egreso."' and nom006.fecha_egreso<='".$fecha_hasta_egreso."' and
                  nom006.fecha_ingreso>='".$fecha_desde_ing."' and nom006.fecha_ingreso<='".$fecha_hasta_ing."' ".$crit_st."  order by ".$ordenado;
		
		
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");	echo $sSQL;	     
         $oRpt = new PHPReportMaker();
         $oRpt->setXML($nomb_rpt);
         $oRpt->setUser("$user");
         $oRpt->setPassword("$password");
         $oRpt->setConnection("localhost");
         $oRpt->setDatabaseInterface("postgresql");
         $oRpt->setSQL($sSQL);
         $oRpt->setDatabase("$dbname");
         $oRpt->setParameters(array("enc1"=>$enc1,"enc2"=>$enc2,"enc3"=>$enc3,"enc4"=>$enc4,"c1"=>$c1,"c2"=>$c2,"c3"=>$c3,"c4"=>$c4,"criterio1"=>$criterio1,"cant"=>$cant,"date"=>$date,"hora"=>$hora));
         $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
         $oRpt->run();
         $aBench = $oRpt->getBenchmark();
         $iSec   = $aBench["report_end"]-$aBench["report_start"];
    }	
	if(($tipo_rpt=="PDF")and($rpdf==1)){	 $m=65; $n=$lc1; $w=60+(60-$n);	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $enc1; global $enc2; global $m; global $n; global $w;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE TRABAJADORES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',6);
			$this->Cell(15,5,'CEDULA',1,0);
			$this->Cell($m,5,'NOMBRE TRABAJADOR',1,0);
			$this->Cell($n,5,$enc1,1,0,'C');
			$this->Cell($w,5,$enc2,1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total=0; 	  $res=pg_query($sSQL);
	  //$pdf->MultiCell(200,3,$sSQL,0);  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
	       $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nombre=$registro["nombre"]; 
		   if($php_os=="WINNT"){if($c1=="N"){$col1="";} else{ $col1=$registro["col1"]; }  if($c2=="N"){$col2="";} else{ $col2=$registro["col2"]; }}
		   else{  $nombre=utf8_decode($registro["nombre"]);  
		   if($c1=="N"){$col1="";} else{ $col1=utf8_decode($registro["col1"]); }
		   if($c2=="N"){$col2="";} else{ $col2=utf8_decode($registro["col2"]); } }
		   
		   $pdf->Cell(15,3,$cod_empleado,0,0);
		   //$pdf->Cell(15,3,$cedula,0,0);
           $x=$pdf->GetX();   $y=$pdf->GetY();
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($m,3,$nombre,0);  
		   $pdf->SetXY($x+$m,$y);	
		   $pdf->MultiCell($n,3,$col1,0,$ac1);
		   $pdf->SetXY($x+$m+$n,$y);	
		   $pdf->MultiCell($w,3,$col2,0,$ac2);
		} 
        $pdf->Ln(5);
        $pdf->Cell(15,3,"Cantidad de Trabajadores: ".$cant,0,1);	 		
		$pdf->Output();   
    }
	if(($tipo_rpt=="PDF")and($rpdf==2)){	 $m=65; if($lc1>=60){$lc1=30;} $n=$lc1; $w=60+(30-$n);	if($lc3>=60){$lc3=30;} $p=$lc3; $z=60+(30-$p);
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $enc1; global $enc2; global $enc3; global $enc4; global $m; global $n; global $w;; global $p; global $z;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE TRABAJADORES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',6);
			$this->Cell(15,5,'CEDULA',1,0);
			$this->Cell($m,5,'NOMBRE TRABAJADOR',1,0);
			$this->Cell($n,5,$enc1,1,0,'C');			
			$this->Cell($w,5,$enc2,1,0,'C');
			$this->Cell($p,5,$enc3,1,0,'C');
			$this->Cell($z,5,$enc4,1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total=0; 	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
	       $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nombre=$registro["nombre"];
           if($php_os=="WINNT"){if($c1=="N"){$col1="";} else{ $col1=$registro["col1"]; }  if($c2=="N"){$col2="";} else{ $col2=$registro["col2"]; }
		     if($c3=="N"){$col3="";} else{ $col3=$registro["col3"]; }  if($c4=="N"){$col4="";} else{ $col4=$registro["col4"]; }}
		   else{  $nombre=utf8_decode($registro["nombre"]);  
		   if($c1=="N"){$col1="";} else{ $col1=utf8_decode($registro["col1"]); }
		   if($c2=="N"){$col2="";} else{ $col2=utf8_decode($registro["col2"]); } 
		   if($c3=="N"){$col3="";} else{ $col3=utf8_decode($registro["col3"]); }
		   if($c4=="N"){$col4="";} else{ $col4=utf8_decode($registro["col4"]); }}
		   
		   $nombre=utf8_decode($registro["nombre"]);  
		   if($c1=="N"){$col1="";} else{ $col1=utf8_decode($registro["col1"]); }
		   if($c2=="N"){$col2="";} else{ $col2=utf8_decode($registro["col2"]); }		   
		   if($c3=="N"){$col3="";} else{ $col3=utf8_decode($registro["col3"]); }
		   if($c4=="N"){$col4="";} else{ $col4=utf8_decode($registro["col4"]); }
		   
		   //$pdf->Cell(15,3,$cod_empleado,0,0);
		   $pdf->Cell(15,3,$cedula,0,0);
           
           $x=$pdf->GetX();   $y=$pdf->GetY();
		   $pdf->SetXY($x,$y);
		   
		   $pdf->MultiCell($m,3,$nombre,0);  
		   $pdf->SetXY($x+$m,$y);
		   
		   $pdf->MultiCell($n,3,$col1,0,$ac1);		   
		   $pdf->SetXY($x+$m+$n,$y);	
		   $pdf->MultiCell($w,3,$col2,0,$ac2);
		   
		   $pdf->SetXY($x+$m+$n+$w,$y);	
		   $pdf->MultiCell($p,3,$col3,0,$ac3);
		   
		   $pdf->SetXY($x+$m+$n+$w+$p,$y);	
		   $pdf->MultiCell($z,3,$col4,0,$ac4);
		} 	
		$pdf->Ln(5);
        $pdf->Cell(15,3,"Cantidad de Trabajadores: ".$cant,0,1);		
		$pdf->Output();   
    }
	 if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Trabajadores.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE TRABAJADORES</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CEDULA</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong><? echo $enc1; ?></strong></td> 
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc2; ?></strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc3; ?></strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc4; ?> </strong></td>
		   <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc5; ?></strong></td> 
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc6; ?></strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc7; ?></strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong><? echo $enc8; ?> </strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $alin1="left"; $alin2="left"; $alin3="left"; $alin4="left"; $alin5="left"; $alin6="left"; $alin7="left"; $alin8="left";
		   
		   $stilo1="mso-number-format:'@';";
		   $stilo2="mso-number-format:'@';";
		   $stilo3="mso-number-format:'@';";
		   $stilo4="mso-number-format:'@';";
		   $stilo5="mso-number-format:'@';";
		   $stilo6="mso-number-format:'@';";
		   $stilo7="mso-number-format:'@';";
		   $stilo8="mso-number-format:'@';";
		   
		   $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nombre=conv_cadenas($registro["nombre"],0);
           if($c1=="N"){$col1="";} else{ if(($columna1=="25")or($columna1=="26")or($columna1=="27")or($columna1=="40")){$col1=formato_monto($registro["col1"]); $alin1="right"; $stilo1="mso-number-format:'###,###,##0.00';";}else{ $col1=conv_cadenas($registro["col1"],0);} }  
		   if($c2=="N"){$col2="";} else{ if(($columna2=="25")or($columna2=="26")or($columna2=="27")or($columna2=="40")){$col2=formato_monto($registro["col2"]); $alin2="right"; $stilo2="mso-number-format:'###,###,##0.00';";}else{ $col2=conv_cadenas($registro["col2"],0);} }
		   if($c3=="N"){$col3="";} else{ if(($columna3=="25")or($columna3=="26")or($columna3=="27")or($columna3=="40")){$col3=formato_monto($registro["col3"]); $alin3="right"; $stilo3="mso-number-format:'###,###,##0.00';";}else{ $col3=conv_cadenas($registro["col3"],0);} }  
		   if($c4=="N"){$col4="";} else{ if(($columna4=="25")or($columna4=="26")or($columna4=="27")or($columna4=="40")){$col4=formato_monto($registro["col4"]); $alin4="right"; $stilo4="mso-number-format:'###,###,##0.00';";}else{ $col4=conv_cadenas($registro["col4"],0);} }
		   
		   if($c5=="N"){$col5="";} else{ if(($columna5=="25")or($columna5=="26")or($columna5=="27")or($columna5=="40")){$col5=formato_monto($registro["col5"]); $alin5="right"; $stilo5="mso-number-format:'###,###,##0.00';";}else{ $col5=conv_cadenas($registro["col5"],0);} }
		   if($c6=="N"){$col6="";} else{ if(($columna6=="25")or($columna6=="26")or($columna6=="27")or($columna6=="40")){$col6=formato_monto($registro["col6"]); $alin6="right"; $stilo6="mso-number-format:'###,###,##0.00';";}else{ $col6=conv_cadenas($registro["col6"],0);} }
		   if($c7=="N"){$col7="";} else{ if(($columna7=="25")or($columna7=="26")or($columna7=="27")or($columna7=="40")){$col7=formato_monto($registro["col7"]); $alin7="right"; $stilo7="mso-number-format:'###,###,##0.00';";}else{ $col7=conv_cadenas($registro["col7"],0);} }
		   if($c8=="N"){$col8="";} else{ if(($columna8=="25")or($columna8=="26")or($columna8=="27")or($columna8=="40")){$col8=formato_monto($registro["col8"]); $alin8="right"; $stilo8="mso-number-format:'###,###,##0.00';";}else{ $col8=conv_cadenas($registro["col8"],0);} }
	
	       $stiloc="mso-number-format:'@';";
	
	?>	   
		   <tr>
           <td width="100" align="left" style="<? echo $stiloc; ?>"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cedula; ?></td>
           <td width="300" align="left"><? echo $nombre; ?></td>
           <td width="200" align="<? echo $alin1; ?>" style="<? echo $stilo1; ?>"><? echo $col1; ?></td>
           <td width="200" align="<? echo $alin2; ?>" style="<? echo $stilo2; ?>"><? echo $col2; ?></td>
           <td width="200" align="<? echo $alin3; ?>" style="<? echo $stilo3; ?>"><? echo $col3; ?></td>
           <td width="200" align="<? echo $alin4; ?>" style="<? echo $stilo4; ?>"><? echo $col4; ?></td>
		   
		   
		   <td width="200" align="<? echo $alin5; ?>" style="<? echo $stilo5; ?>"><? echo $col5; ?></td>
           <td width="200" align="<? echo $alin6; ?>" style="<? echo $stilo6; ?>"><? echo $col6; ?></td>
           <td width="200" align="<? echo $alin7; ?>" style="<? echo $stilo7; ?>"><? echo $col7; ?></td>
           <td width="200" align="<? echo $alin8; ?>" style="<? echo $stilo8; ?>"><? echo $col8; ?></td>
         </tr>
	<? }   ?>
	  <tr>
           <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"></td>
           <td width="300" align="left"><strong>CANTIDAD TRABAJADORES: <? echo $cant; ?></strong></td>
         </tr>
	  </table><?
	}
		
	}	
?>
