<?include ("../class/conect.php");  require ("../class/fun_num_otros.php"); require ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0;
header('Content-Type: text/html; charset=UTF-8');
$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"]; $cod_cta_emp=$_POST["txtcod_cta_emp"];  $tipo_calculo=$_POST["txttipo_calculo"]; $forma_pago=$_POST["txtforma_pago"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_dep=$_POST["txtfecha_dep"]; $hora_dep=$_POST["txthora_dep"]; $ordenar_por=$_POST["txtordenar"]; $mformula=""; $fechah=formato_aaaammdd($fecha_hasta);
$frac_nom=$_POST["txtfrac_nom"];$num_quinc=$_POST["txtnum_quinc"];$tipo_formato=$_POST["txttipo_formato"];$tipo_nom=$_POST["txttipo_nom"]; $concepto_t=$_POST["txtconcepto_t"]; $tipo_salida="HTML";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $tipo_nom=substr($tipo_nom,0,1); $tipo_calculo=substr($tipo_calculo,0,1); $num_periodos=$_POST["txtnum_periodos"];
$sql="SELECT nom046.tipo_nomina,nom001.descripcion FROM nom046,nom001 Where (nom046.tipo_nomina=nom001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}
if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
if($error==0){ $mformula="(".$mformula.")";
$tipo_salida=$tipo_formato;
$salto_linea="\n"; if($tipo_salida=="TXT"){ $tipo_formato="LINEAL";  } if($tipo_salida=="EXCEL"){ $tipo_formato="TABULADO"; }
if($concepto_t=="NOMINA"){$mformula=$mformula." and (concepto_vac='N')";}
if($concepto_t=="VACACIONES"){$mformula=$mformula." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}
$criterio_f="(tipo_pago='".$forma_pago."') ";
if($forma_pago=="DEPOSITO"){ If ($tipo_nom=="H"){ $criterio_f="(nom019.cta_empresa='$cod_cta_emp') And (nom019.tipo_pago='DEPOSITO')"; } else{ $criterio_f="(nom017.cta_empresa='$cod_cta_emp') And (nom017.tipo_pago='DEPOSITO')"; }   }

$ordenar=" order by to_number(nom017.cedula,'999999999999'),cod_empleado";
if($ordenar_por=="DEPARTAMENTO"){$ordenar="  order by tipo_nomina, cod_departam, cod_cargo, cod_empleado, cod_concepto";	  }

if($tipo_calculo=="E") { $mformula=$mformula." and (num_periodos='$num_periodos')";  }
 
If ($tipo_nom=="H"){$sql="SELECT * FROM nom019 Where (nom019.oculto='NO') and (nom019.tp_calculo='$tipo_calculo') And ". $criterio_f ." And (nom019.fecha_p_hasta='$fechah') And ". $mformula ." order by to_number(nom019.cedula,'999999999999'),cod_empleado";}
 else{$sql="SELECT * FROM nom017 Where (nom017.oculto='NO') and (nom017.tp_calculo='$tipo_calculo') And ". $criterio_f ." And ". $mformula .$ordenar;}


 
$monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_cedula=""; $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cedula=$reg["cedula"]; $grupo=$reg["cedula"].$reg["cod_empleado"]; if($prev_cedula!=$grupo){ $prev_cedula=$grupo; $monto_tot=$monto_tot+$monto_emp; if($monto_emp>0){$monto_emp=0;$leidos=$leidos+1;} }
  //if($reg["oculto"]=="NO"){$monto_emp=$monto_emp+($reg["monto_asignacion"]-$reg["monto_deduccion"]);} 
  if($reg["oculto"]=="NO"){ $monto_c=$reg["monto"]; $monto_ant=$reg["valorz"]; if($frac_nom=="SI"){ if($num_quinc=="1"){$monto_c=$monto_ant;}else{$monto_c=$monto_c-$monto_ant;} }
    if($reg["asignacion"]=="SI"){$monto_emp=$monto_emp+$monto_c;}else{$monto_emp=$monto_emp-$monto_c;}}    
  $num_linea=$num_linea+1;
  } $monto_tot=$monto_tot+$monto_emp; if($monto_emp>0){$monto_emp=0;$leidos=$leidos+1;}
if($leidos==0){ $error=1;?> <script language="JavaScript">muestra('INFORMACION DE NOMINAS NO LOCALIZADA');</script><? }
else{ $encabezado=""; $detalle="";  $pie_pagina=""; if($tipo_formato=="TABULADO"){$encabezado="<tr>";}
  $StrSQL="SELECT * FROM nom052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='E') Order by pos_campo";  $resc=pg_query($StrSQL);
  while($registro=pg_fetch_array($resc)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    switch($cod_campo){
      Case "17":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;
      Case "18":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "19":$smonto_tot=formato_monto($monto_tot); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
      Case "20":$str_campo=$fecha_dep; $l=0; break;
      Case "21":$str_campo=$hora_dep; $l=0; break;
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
  $monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_cedula=""; $res=pg_query($sql);
  while($reg=pg_fetch_array($res)){  if($prev_cedula==""){$prev_cedula=$reg["cedula"].$reg["cod_empleado"];} $grupo=$reg["cedula"].$reg["cod_empleado"];
    if($prev_cedula!=$grupo){$prev_cedula=$grupo;$monto_tot=$monto_tot+$monto_emp;
    if($monto_emp>0){$leidos=$leidos+1;  $num_linea=$num_linea+1;
    $fecha_nac=formato_aaaammdd($fecha_hoy); $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $nombre_c1=""; $edad=0; $fecha_ing_adm=$fecha_ingreso;
    $StrSQL="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado') and (cedula='$cedula')";$result=pg_query($StrSQL);
    if($registro=pg_fetch_array($result,0)){ $fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
     $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; }
    else{$StrSQL="SELECT * From TRABAJADORES Where ( (cedula='$cedula')";$result=pg_query($StrSQL);
     if($registro=pg_fetch_array($result,0)){$fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
     $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"];}}
    $nombre_c1=$apellido1." ".$nombre1; $rcedula=Rellenarcerosizq($cedula,8); $nac_ced=substr($nacionalidad,0,1).$rcedula;
	$StrSQL="SELECT * FROM nom052 Where (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
    while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
      $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
      $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
      $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
      $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
      $inic_celda="<td>";
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
      Case "14":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); $inic_celda='<td style="mso-number-format:'; $inic_celda=$inic_celda."'@'";  $inic_celda=$inic_celda.' ;" >'; break;
      Case "15":$str_campo=$tipo_cuenta; $l=$long_campo-strlen($tipo_cuenta); break;
      Case "16":$smonto_emp=formato_monto($monto_emp);  $str_campo=Rellenarcerosizq($smonto_emp,14); 
	  //echo $str_campo." ".$long_campo,"<br>";
	  $l=0; break; //$str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_emp),14);
      Case "17":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;
      Case "18":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "19":$smonto_tot=formato_monto($monto_tot); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
      Case "20":$str_campo=$fecha_dep; $l=0; break;
      Case "21":$str_campo=$hora_dep; $l=0; break;
	  Case "22":$str_campo=$nombre_c1; $l=$long_campo-strlen($nombre_c1); break;
	  Case "23":$str_campo=$nac_ced; $l=$long_campo-strlen($nac_ced); break;
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      //Case "999":$l=$long_campo; $str_campo=$car_especial; break;
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
      
	  if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle.$inic_celda.$str_campo."</td>"; }} else{if($cod_campo=="998"){$str_campo="<br>";}$detalle=$detalle.$str_campo;}
    } if($tipo_formato=="TABULADO"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<br>";} $monto_emp=0;
    } }
    if($reg["oculto"]=="NO"){ $monto_c=$reg["monto"]; $monto_ant=$reg["valorz"]; if($frac_nom=="SI"){ if($num_quinc=="1"){$monto_c=$monto_ant;}else{$monto_c=$monto_c-$monto_ant;} }
    if($reg["asignacion"]=="SI"){$monto_emp=$monto_emp+$monto_c;}else{$monto_emp=$monto_emp-$monto_c;}}
    $cedula=$reg["cedula"]; $cod_empleado=$reg["cod_empleado"];  $nombre=$reg["nombre"]; $cta_empleado=$reg["cta_empleado"]; $fecha_ingreso=$reg["fecha_ingreso"]; $status_calculo=$reg["status_calculo"];$tipo_cuenta=""; $edo_civil="";
    if(substr($status_calculo,1,1)=="E"){$nacionalidad="EXTRANJERO";}else{$nacionalidad="VENEZOLANO";} if(substr($status_calculo,3,1)=="M"){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
    switch(substr($status_calculo,2,1)){Case "A":$tipo_cuenta="AHORROS"; break; Case "C":$tipo_cuenta="CORRIENTE"; break;Case "F":$tipo_cuenta="FAL"; break;}
    switch(substr($status_calculo,4,1)){Case "C":$edo_civil="CASADO"; break; Case "V":$edo_civil="VIUDO"; break; Case "D":$edo_civil="DIVORCIADO"; break; Case "U":$edo_civil="CONCUBINO"; break; Case "S":$edo_civil="SOLTERO"; break;}
    $nombre=str_replace("Ñ","N",$nombre); $nombre=conv_cadenas($nombre,1);
  } $monto_tot=$monto_tot+$monto_emp;
  if($monto_emp>0){$leidos=$leidos+1;  $num_linea=$num_linea+1;
    $fecha_nac=formato_aaaammdd($fecha_hoy); $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $edad=0; $fecha_ing_adm=$fecha_ingreso;
    $StrSQL="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado') and (cedula='$cedula')";$result=pg_query($StrSQL);
    if($registro=pg_fetch_array($result,0)){ $fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
     $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"]; }
    else{$StrSQL="SELECT * From TRABAJADORES Where (cedula='$cedula')";$result=pg_query($StrSQL);
     if($registro=pg_fetch_array($result,0)){$fecha_nac=$registro["fecha_nacimiento"]; $nacionalidad=$registro["nacionalidad"]; $sexo=$registro["sexo"]; $tipo_cuenta=$registro["tipo_cuenta"]; $edo_civil=$registro["edo_civil"];
     $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"]; $apellido2=$registro["apellido2"]; $edad=$registro["edad"];  $fecha_ing_adm=$registro["fecha_ing_adm"];}}
    $StrSQL="SELECT * FROM nom052 Where (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='D') Order by Pos_Campo";  $result=pg_query($StrSQL);
    while($registro=pg_fetch_array($result)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
      $long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
      $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
      $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
      $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
      $inic_celda="<td>";
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
      Case "14":$str_campo=$cta_empleado; $l=$long_campo-strlen($cta_empleado); $inic_celda='<td style="mso-number-format:'; $inic_celda=$inic_celda."'@'";  $inic_celda=$inic_celda.' ;" >'; break;
      Case "15":$str_campo=$tipo_cuenta; $l=$long_campo-strlen($tipo_cuenta); break;
      Case "16":$smonto_emp=formato_monto($monto_emp);  
	  $str_campo=Rellenarcerosizq($smonto_emp,14); 
	  //echo $str_campo." ".$long_campo,"<br>";
	  $l=0; break; //$str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_emp),14);
      Case "17":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;
      Case "18":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "19":$smonto_tot=formato_monto($monto_tot); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
      Case "20":$str_campo=$fecha_dep; $l=0; break;
      Case "21":$str_campo=$hora_dep; $l=0; break;
	  Case "22":$str_campo=$nombre_c1; $l=$long_campo-strlen($nombre_c1); break;
	  Case "23":$str_campo=$nac_ced; $l=$long_campo-strlen($nac_ced); break;	  
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      //Case "999":$l=$long_campo; $str_campo=$car_especial; break;
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
      if($rellena_espacios_i=="S"){$str_campo=inserta_espacio($e).$str_campo;} if($rellena_espacios_d=="S"){$str_campo=$str_campo.inserta_espacio($e);}
      if($elimina_espacios_i=="S"){$str_campo=elimina_esp_izq($str_campo);}if($elimina_espacios_d=="S"){$str_campo=elimina_esp_der($str_campo);}
      if($elimina_ceros_izq=="S"){$str_campo=elimina_cero_izq($str_campo);} if($elimina_ceros_der=="S"){$str_campo=elimina_cero_der($str_campo);}
      if($tipo_formato=="TABULADO"){if($cod_campo=="998"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle.$inic_celda.$str_campo."</td>"; }} else{if($cod_campo=="998"){$str_campo="<br>";}$detalle=$detalle.$str_campo;}
    } 
	$monto_emp=0;
  }
  $existe_pie=0;
  $StrSQL="SELECT * FROM nom052 Where (cod_arch_banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco') And (status2_campo='P') Order by pos_campo";  $resc=pg_query($StrSQL);
  while($registro=pg_fetch_array($resc)){ $str_campo=""; $l=0; $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
    $existe_pie=1;
	$long_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_c=$registro["pos_comienza"]; $pos_f=$registro["pos_finaliza"];
    $rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
    $elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
    $elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"];
    switch($cod_campo){
      Case "17":$str_campo=$cod_cta_emp; $l=$long_campo-strlen($cod_cta_emp); break;
      Case "18":$str_campo=Rellenarcerosizq($leidos,4); $l=0; break;
      Case "19":$smonto_tot=formato_monto($monto_tot); $str_campo=Rellenarcerosizq(cambia_coma_numero($smonto_tot),14);$l=0; break;
      Case "20":$str_campo=$fecha_dep; $l=0; break;
      Case "21":$str_campo=$hora_dep; $l=0; break;
	  Case "997":$str_campo=Rellenarcerosizq($num_linea,4); $l=0; break;
      Case "998":$str_campo="<br>"; $l=0; break;
      Case "999":$l=$long_campo; $str_campo=$car_especial; if(strlen(trim($car_especial))==0){$l=$l+1;} break;
    }if($l<0){$l=0;} If(($tipo_campo=="C") And ($l>0)){$e=$l; $str_campo=$str_campo.inserta_espacio($e);}
    $str_campo= substr($str_campo,$pos_c-1,$pos_f);
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
   }
    IF($existe_pie==1){ if($tipo_formato=="TABULADO"){$detalle=$detalle."</tr><tr>";}else{$detalle=$detalle."<br>";}  }   
  //if($tipo_formato=="TABULADO"){$pie_pagina=$pie_pagina."</tr><tr>";}else{$pie_pagina=$pie_pagina."<br>";}
  
if($tipo_formato=="TABULADO"){$encabezado="<table>".$encabezado; $pie_pagina.="<tr></table>"; 
  if($tipo_salida=="EXCEL"){ header("Content-type: application/vnd.ms-excel");   header("Content-Disposition: attachment; filename=arch_banco.xls"); }
}else{ if($tipo_salida=="TXT"){$encabezado=str_replace("<br>","\r\n",$encabezado);$detalle=str_replace("<br>","\r\n",$detalle);
$pie_pagina=str_replace("<br>","\r\n",$pie_pagina); header("Content-type: application/txt");   header("Content-Disposition: attachment; filename=arch_bancos.txt");
} else{$encabezado="<pre>".$encabezado; $pie_pagina.="</pre>";} }
echo $encabezado.$detalle.$pie_pagina; 
} }
pg_close();
if($error==0){$error=0;}else{
?><script language="JavaScript">window.close(); </script><?
} 
?>