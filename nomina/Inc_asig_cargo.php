<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$mcod_m="TRAB".$usuario_sia.$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$cod_modulo="04"; $campo502=""; $campo573=""; $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; } $trab_grado_paso=substr($campo502,9,1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Asignaci&oacute;n de Cargo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var mtrab_grado_paso='<?php echo $trab_grado_paso ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
  
function llamar_anterior(){ document.location ='Det_inc_asig_cargo.php?codigo_mov=<?echo $codigo_mov?>'; }
function apaga_cargo(mthis){var mcod_cargo=mthis.value; apagar(mthis); 
 ajaxSenddoc('GET', 'cargasueldoc.php?cod_cargo='+mcod_cargo, 'dsueldo', 'innerHTML');
}
function apaga_grado(mthis){var f=document.form1; var mpaso; var mgrado; var mtipo_per;
  apagar(mthis); 
  if(mtrab_grado_paso=="S"){
     mpaso=f.txtpaso.value; mgrado=f.txtgrado.value; mtipo_per=f.txtcod_tipo_personal.value;	 
	 ajaxSenddoc('GET', 'cargasueldopg.php?cod_tipo_per='+mtipo_per+'&grado='+mgrado+'&paso='+mpaso, 'dsueldo', 'innerHTML');
	 ajaxSenddoc('GET', 'cargacomppg.php?cod_tipo_per='+mtipo_per+'&grado='+mgrado+'&paso='+mpaso, 'dcompen', 'innerHTML');
  
  }
}
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtfecha_asigna.value==""){alert("Fecha no puede estar Vacio");return false;}
   if(f.txtcodigo_cargo.value==""){alert("Cargo no puede estar Vacio");return false;} else{f.txtcodigo_cargo.value=f.txtcodigo_cargo.value.toUpperCase();}
   if(f.txtcodigo_departamento.value==""){alert("Departamento no puede estar Vacio");return false;} else{f.txtcodigo_departamento.value=f.txtcodigo_departamento.value.toUpperCase();}
   if(f.txtcod_tipo_personal.value==""){alert("Tipo de Personal no puede estar Vacio");return false;}
   if(f.txtsueldo.value==""){alert("Sueldo no puede estar Vacio"); alert(f.txtsueldo.value); return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$cod_empleado=""; $cod_cargo=""; $des_cargo="";  $cod_departamento="";  $des_departamento=""; $cod_tipo_personal=""; $des_tipo_personal="";  $grado="000";  $paso="000";  $sueldo=0; $compensacion=0; $prima=0;
$sql="SELECT codigo_mov,cod_empleado,fecha_asigna,cod_cargo,cod_departamento,des_cargo,des_departamento,nom068.cod_tipo_personal,paso,grado,observacion,sueldo,prima,compensacion,prima,otros,sueldo_integral,des_tipo_personal FROM nom068 left join nom015 ON (nom068.cod_tipo_personal=nom015.cod_tipo_personal) where codigo_mov='$codigo_mov' order by fecha_asigna desc"; $res=pg_query($sql); $filas=pg_num_rows($res);
//echo $sql." ".$filas;
if($filas>=1){ $registro=pg_fetch_array($res,0); $fecha=$registro["fecha_asigna"];   $cod_cargo=$registro["cod_cargo"]; $des_cargo=$registro["des_cargo"]; $grado=$registro["grado"]; $paso=$registro["paso"];  $sueldo=$registro["sueldo"];  $compensacion=$registro["compensacion"]; $prima=$registro["prima"];
  $cod_empleado=$registro["cod_empleado"]; $cod_departamento=$registro["cod_departamento"]; $des_departamento=$registro["des_departamento"]; $cod_tipo_personal=$registro["cod_tipo_personal"]; $des_tipo_personal=$registro["des_tipo_personal"];
}
$sqlc="Select * FROM NOM004 where codigo_cargo='$cod_cargo'"; $resc=pg_query($sqlc);$filasc=pg_num_rows($resc); $sueldo_cargo=0;
if($filasc>=1){ $registroc=pg_fetch_array($resc,0);   $sueldo_cargo=$registroc["sueldo_cargo"]; } 
if($sueldo_cargo>$sueldo){ $sueldo=$sueldo_cargo;}
if($trab_grado_paso=="S"){ $sueldo_paso=0; $sueldo_grado=0; $msuel=0; $mcompen=0;
  $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and  paso='$paso'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
  if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_paso=$registrog["monto"]; }   
  $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and  paso='000'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
  if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_grado=$registrog["monto"]; }
  if($sueldo_grado==0){ $msuel=$sueldo_paso; } else{ $msuel=$sueldo_grado;  $mcompen=$sueldo_paso-$sueldo_grado;  }
  if($msuel>$sueldo){ $sueldo=$msuel;} if($mcompen>$compensacion){ $compensacion=$mcompen;}
}
$sueldo=formato_monto($sueldo);  $compensacion=formato_monto($compensacion);  $prima=formato_monto($prima);
pg_close();    
?>
<body>
<form name="form1" method="post" action="Insert_asig_cargo.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR ASIGNACION DE CARGO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="210"><span class="Estilo5">FECHA ASIGNACION DEL CARGO :</span> </td>
                <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtfecha_asigna" type="text" id="txtfecha_asigna" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="65"><span class="Estilo5">CARGO : </span></td>
                <td width="105"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apaga_cargo(this)" value="<?echo $cod_cargo?>"></span></td>
                <td width="40"><input class="Estilo10" name="btcargos" type="button" id="btcargos" title="Abrir Catalogo de Cargos"  onClick="VentanaCentrada('Cat_cargo.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="80" readonly value="<?echo $des_cargo?>"></span></td>
               </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="120"><span class="Estilo5">DEPARTAMENTO :</span></td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento" type="text" id="txtcodigo_departamento" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_departamento?>"></span></td>
                <td width="40"><input class="Estilo10" name="btdepto" type="button" id="btdepto" title="Abrir Catalogo de Departamentos"  onClick="VentanaCentrada('Cat_departamento.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep" type="text" id="txtdescripcion_dep" size="70" maxlength="80" readonly value="<?echo $des_departamento?>"></span></td>
               </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="140"><span class="Estilo5">TIPO DE PERSONAL : </span></td>
                <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_tipo_personal" type="text" id="txtcod_tipo_personal" size="6" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_tipo_personal?>"></span></td>
                <td width="40"><input class="Estilo10" name="bttipo_per" type="button" id="bttipo_per" title="Abrir Catalogo Tipo de Personal"  onClick="VentanaCentrada('Cat_Tipo_personal.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_personal" type="text" id="txtdes_tipo_personal" size="35" maxlength="80" readonly value="<?echo $des_tipo_personal?>"></span></td>
                <td width="60"><span class="Estilo5">GRADO : </span></td>
                <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtgrado" type="text" id="txtgrado" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apaga_grado(this)" value="<?echo $grado?>"></span></td>
                <td width="50"><span class="Estilo5">PASO : </span></td>
                <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtpaso" type="text" id="txtpaso" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apaga_grado(this)" value="<?echo $paso?>"></span></td>

              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="100"><span class="Estilo5">SUELDO :</span> </td>
                <td width="150"><span class="Estilo5"><div id="dsueldo"><input class="Estilo10" name="txtsueldo" type="text" id="txtsueldo" size="16" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $sueldo?>" onKeypress="return validarNum(event)"></div></span></td>
                <td width="110"><span class="Estilo5">COMPENSACION :</span> </td>
                <td width="150"><span class="Estilo5"><div id="dcompen"><input class="Estilo10" name="txtcompensacion" type="text" id="txtcompensacion" size="16" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $compensacion?>" onKeypress="return validarNum(event)"></div></span></td>
                <td width="100"><span class="Estilo5">PRIMA :</span> </td>
                <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtprima" type="text" id="txtprima" size="16" maxlength="16" style="text-align:right" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?echo $prima?>" onKeypress="return validarNum(event)"></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="10"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="10"><input class="Estilo10" name="txttrab_grado_paso" type="hidden" id="txttrab_grado_paso" value="<?echo $trab_grado_paso?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="115">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>