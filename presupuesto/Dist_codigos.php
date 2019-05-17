<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{$Nom_Emp=busca_conf();}
if (!$_GET){  $cod_presup=''; $cod_fuente='00'; $p_letra='';  $sql="SELECT * FROM codigos ORDER BY cod_presup,cod_fuente";}
else {$codigo=$_GET["Gcodigo"]; $cod_fuente=substr($codigo,0,2);$cod_presup=substr($codigo,2,32);
  $codigo=$cod_fuente.$cod_presup;  $sql="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (C&oacute;digos/Asignaci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<SCRIPT language=JavaScript src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}

function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function LlamarURL(url){  document.location = url; }
function CargarUrl(mcodigo) {var murl;  murl="Act_codigos.php?Gcodigo="+mcodigo;  document.location = murl;}

function Aplicar_Dist(){var f=document.form1; var mmonto; var masignacion; var mf; var mp; var smonto=document.form1.txtasignado.value; 
   var mtrim1; var mtrim2; var mtrim3; var mtrim4; var strim; var mmonto2;
   smonto=eliminapunto(smonto);  masignacion=quitacomas(smonto);    masignacion=(masignacion*1); 
   if(f.txtdistribucion.value=="ANUAL"){  
     if(masignacion==0){ mf=0; } else {  mf=(masignacion/12);  mf=Math.round(mf*100)/100;   }  mmonto=mf*12;
	 if(mmonto==masignacion){ mf2=mf; } else { mp=masignacion-mmonto; mp=Math.round(mp*100)/100; mf2=mf+mp; mf2=Math.round(mf2*100)/100; }
	 f.txtasignado01.value=mf; f.txtasignado02.value=mf; f.txtasignado03.value=mf; f.txtasignado04.value=mf;
	 f.txtasignado05.value=mf; f.txtasignado06.value=mf; f.txtasignado07.value=mf; f.txtasignado08.value=mf;
	 f.txtasignado09.value=mf; f.txtasignado10.value=mf; f.txtasignado11.value=mf; f.txtasignado12.value=mf2;
	 mmonto=(mf*11)+mf2;
	 f.txttotal_dist.value=mmonto; 
	 f.txtasignado01.value=daformatomonto(f.txtasignado01.value); f.txtasignado02.value=daformatomonto(f.txtasignado02.value); f.txtasignado03.value=daformatomonto(f.txtasignado03.value); f.txtasignado04.value=daformatomonto(f.txtasignado04.value);
	 f.txtasignado05.value=daformatomonto(f.txtasignado05.value); f.txtasignado06.value=daformatomonto(f.txtasignado06.value); f.txtasignado07.value=daformatomonto(f.txtasignado07.value); f.txtasignado08.value=daformatomonto(f.txtasignado08.value);
	 f.txtasignado09.value=daformatomonto(f.txtasignado09.value); f.txtasignado10.value=daformatomonto(f.txtasignado10.value); f.txtasignado11.value=daformatomonto(f.txtasignado11.value); f.txtasignado12.value=daformatomonto(f.txtasignado12.value);
	}   
   if(f.txtdistribucion.value=="TRIMESTRAL (%)") {
    strim=document.form1.txttrim1.value;    strim=eliminapunto(strim);  mtrim1=quitacomas(strim);    mtrim1=(mtrim1*1); 
	mp=(masignacion*mtrim1)/100; if(mp==0){ mf=0; } else {  mf=(mp/3);  mf=Math.round(mf*100)/100;   }  mmonto2=mf*3;
	if(mp==mmonto2){ mf2=mf; } else { mp=mp-mmonto2; mp=Math.round(mp*100)/100; mf2=mf+mp; mf2=Math.round(mf2*100)/100; }
	f.txtasignado01.value=mf; f.txtasignado02.value=mf; f.txtasignado03.value=mf2;
	mmonto=mf+mf+mf2;	
	strim=document.form1.txttrim2.value;    strim=eliminapunto(strim);  mtrim2=quitacomas(strim);    mtrim2=(mtrim2*1); 
	mp=(masignacion*mtrim2)/100; if(mp==0){ mf=0; } else {  mf=(mp/3);  mf=Math.round(mf*100)/100;   }  mmonto2=mf*3;
	if(mp==mmonto2){ mf2=mf; } else { mp=mp-mmonto2; mp=Math.round(mp*100)/100; mf2=mf+mp; mf2=Math.round(mf2*100)/100; }
	f.txtasignado04.value=mf; f.txtasignado05.value=mf; f.txtasignado06.value=mf2;
	mmonto=mmonto+mf+mf+mf2;	
	strim=document.form1.txttrim3.value;    strim=eliminapunto(strim);  mtrim3=quitacomas(strim);    mtrim3=(mtrim3*1); 
	mp=(masignacion*mtrim3)/100; if(mp==0){ mf=0; } else {  mf=(mp/3);  mf=Math.round(mf*100)/100;   }  mmonto2=mf*3;
	if(mp==mmonto2){ mf2=mf; } else { mp=mp-mmonto2; mp=Math.round(mp*100)/100; mf2=mf+mp; mf2=Math.round(mf2*100)/100; }
	f.txtasignado07.value=mf; f.txtasignado08.value=mf; f.txtasignado09.value=mf2;
	mmonto=mmonto+mf+mf+mf2;	
	strim=document.form1.txttrim4.value;    strim=eliminapunto(strim);  mtrim4=quitacomas(strim);    mtrim4=(mtrim4*1); 
	mp=(masignacion*mtrim4)/100; if(mp==0){ mf=0; } else {  mf=(mp/3);  mf=Math.round(mf*100)/100;   }  mmonto2=mf*3;
	if(mp==mmonto2){ mf2=mf; } else { mp=mp-mmonto2; mp=Math.round(mp*100)/100; mf2=mf+mp; mf2=Math.round(mf2*100)/100; }
	f.txtasignado10.value=mf; f.txtasignado11.value=mf; f.txtasignado12.value=mf2;
	mmonto=mmonto+mf+mf+mf2;	
	mf=mf2; mmonto=Math.round(mmonto*100)/100;
	if(mmonto==masignacion){ mf2=mf; } else { 	
	 if(masignacion>mmonto){ mp=masignacion-mmonto; mp=Math.round(mp*100)/100; mf2=mf+mp; mmonto=mmonto+mp;  f.txtasignado12.value=mf2; }
	 else{ mp=mmonto-masignacion; mp=Math.round(mp*100)/100;  alert(mp); mf2=mf-mp; mmonto=mmonto-mp;  f.txtasignado12.value=mf2; }	  
	}	
	f.txttotal_dist.value=mmonto; 
	f.txtasignado01.value=daformatomonto(f.txtasignado01.value); f.txtasignado02.value=daformatomonto(f.txtasignado02.value); f.txtasignado03.value=daformatomonto(f.txtasignado03.value); f.txtasignado04.value=daformatomonto(f.txtasignado04.value);
	f.txtasignado05.value=daformatomonto(f.txtasignado05.value); f.txtasignado06.value=daformatomonto(f.txtasignado06.value); f.txtasignado07.value=daformatomonto(f.txtasignado07.value); f.txtasignado08.value=daformatomonto(f.txtasignado08.value);
	f.txtasignado09.value=daformatomonto(f.txtasignado09.value); f.txtasignado10.value=daformatomonto(f.txtasignado10.value); f.txtasignado11.value=daformatomonto(f.txtasignado11.value); f.txtasignado12.value=daformatomonto(f.txtasignado12.value);
   }
}

function apaga_monto(mthis){var f=document.form1; var mmonto; var miva;
 apagar(mthis);
} 
function revisar(){var f=document.form1;var Valido;
    if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
    if(f.txtcod_fuente.value==""){alert("Fuente de Financiamiento no puede estar Vacio");return false;}
    if(f.txtdenominacion.value==""){alert("Denominacion del odigo Presupuestario no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtasignado.value==""){alert("Asignacion Inicial no puede estar Vacio");return false;}
    if(MontoValido(f.txtasignado.value)) {Valido=true;} else{alert("Asignacion Inicial debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$denominacion="";$des_fuente="";$cod_contable="";$nombre_cuenta="";$status_dist="";$func_inv="";$aplicacion="";$distribucion="ANUAL";
$asignado=0;$disponible=0;$diferido=0;$disp_diferida=0;$montod=0; $asignado01=0;$asignado02=0;$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$asignado01=0;
  $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];  $denominacion=$registro["denominacion"];
  $cod_contable=$registro["cod_contable"];  $func_inv=$registro["func_inv"];  $aplicacion=$registro["aplicacion"];  $status_dist=$registro["status_dist"];
  $asignado=$registro["asignado"];  $disponible=formato_monto($registro["disponible"]);
  $diferido=$registro["diferido"]; $disp_diferida=formato_monto($registro["disp_diferida"]);
  $des_fuente=$registro["des_fuente_financ"];  $nombre_cuenta=$registro["nombre_cuenta"];
  $asignado01=$registro["asignado01"];  $asignado02=$registro["asignado02"];  $asignado03=$registro["asignado03"];  $asignado04=$registro["asignado04"];
  $asignado05=$registro["asignado05"];  $asignado06=$registro["asignado06"];  $asignado07=$registro["asignado07"];  $asignado08=$registro["asignado08"];
  $asignado09=$registro["asignado09"];  $asignado10=$registro["asignado10"];  $asignado11=$registro["asignado11"];  $asignado12=$registro["asignado12"];  
}
 $trim1=0; $trim2=0; $trim3=0; $trim4=0;
if($status_dist=='1'){$distribucion="ANUAL"; If($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}
$asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f; $asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
$monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
if($monto!=$asignado){ $f=round($f,2); $p=$asignado-$monto; $p=round($p,2); $f=$f+$p; $asignado12=$f;}
}
if($status_dist=='2'){$distribucion="MENSUAL";}
if($status_dist=='3'){$distribucion="TRIMESTRAL";}
if($status_dist=='4'){$distribucion="TRIMESTRAL (%)"; $monto1=$asignado01+$asignado02+$asignado03; $monto2=$asignado04+$asignado05+$asignado06;
$monto3=$asignado07+$asignado08+$asignado09; $monto4=$asignado10+$asignado11+$asignado12;
$trim1=($monto1*100)/$asignado; $trim2=($monto2*100)/$asignado; $trim3=($monto3*100)/$asignado; $trim4=($monto4*100)/$asignado;
}
$total_dist=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
$trim1=formato_monto($trim1); $trim2=formato_monto($trim2);  $trim3=formato_monto($trim3);  $trim4=formato_monto($trim4);  $total_dist=formato_monto($total_dist);
$asignado=formato_monto($asignado); $asignado01=formato_monto($asignado01); $asignado02=formato_monto($asignado02); $asignado03=formato_monto($asignado03); $asignado04=formato_monto($asignado04);
$asignado05=formato_monto($asignado05); $asignado06=formato_monto($asignado06); $asignado07=formato_monto($asignado07); $asignado08=formato_monto($asignado08);
$asignado09=formato_monto($asignado09); $asignado10=formato_monto($asignado10); $asignado11=formato_monto($asignado11); $asignado12=formato_monto($asignado12);
?>
<script language="JavaScript" type="text/JavaScript">
function asig_dist(mvalor){ var f=document.form1;
    if(mvalor=="1"){f.txtdistribucion.options[0].selected = true;}
    if(mvalor=="2"){f.txtdistribucion.options[1].selected = true;}
	if(mvalor=="4"){f.txtdistribucion.options[2].selected = true;}
}
</script>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DISTRIBUIR ASIGNACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="420" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="410" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:CargarUrl('<? echo $codigo; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:CargarUrl('<? echo $codigo; ?>')">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:410px; z-index:1; top: 62px; left: 113px;">
            <form name="form1" method="post" action="Update_distribucion.php" onSubmit="return revisar()">
        <table width="861" border="0" align="center">
            <tr>
              <td><table width="860" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                  <td width="227"><span class="Estilo5"><input name="txtcod_presup" type="text" id="txtcod_presup" value="<?echo $cod_presup?>" size="33" maxlength="33" readonly> </span></td>
                  <td width="115"><span class="Estilo5">FUENTE FINANC. :</span></td>
                  <td width="33"><span class="Estilo5"><input name="txtcod_fuente" type="text" id="txtcod_fuente" value="<?echo $cod_fuente?>" size="3" maxlength="2" readonly>   </span></td>
                  <td width="282"><span class="Estilo5"><input name="txtdes_fuente" type="text" id="txtdes_fuente" value="<?echo $des_fuente?>" size="38" readonly> </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="860" border="0">
                <tr>
                  <td width="109"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="730"><textarea name="txtdenominacion" cols="84" readonly="readonly" class="headers" id="txtdenominacion"><?echo $denominacion?></textarea></td>
                </tr>
              </table>  </td>
            </tr>
            <tr>
              <td><table width="860" border="0">
                <tr>
                  <td width="100" class="Estilo5">ASIGNACI&Oacute;N :</td>
                  <td width="200" class="Estilo5"> <input name="txtasignado" type="text" id="txtasignado" size="20" style="text-align:right" maxlength="20" readonly value="<?echo $asignado?>">  </td>
                  <td width="100" class="Estilo5">DISTRIBUCI&Oacute;N :</td>
				   <td width="260"><span class="Estilo5"><select name="txtdistribucion" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>ANUAL</option> <option>MENSUAL POR MONTO</option> <option>TRIMESTRAL (%)</option> </select></span></td>
				  <script language="JavaScript" type="text/JavaScript"> asig_dist('<?echo $status_dist;?>');</script> 
				   <td width="200"><span class="Estilo5"> <input type="button" name="btaplica_dist" value="Aplica Distribucion" title="Aplica Distribucion Seleccionada" onClick="javascript:Aplicar_Dist()" > </span></td>
				</tr>
              </table></td>
            </tr>
            <tr><td >&nbsp;</td></tr>
			<tr>
              <td><table width="850" border="1" cellspacing='0' cellpadding='0' align="center">
			     <td width="90" class="Estilo5">PORCENTAJES</td>
				 <td width="190" class="Estilo5">1ER TRIM.  <input name="txttrim1" type="text" id="txttrim1" size="8" style="text-align:right" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $trim1?>"> </td>
				 <td width="190" class="Estilo5">2DO TRIM.  <input name="txttrim2" type="text" id="txttrim2" size="8" style="text-align:right" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $trim2?>"></td>
				 <td width="190" class="Estilo5">3ER TRIM.  <input name="txttrim3" type="text" id="txttrim3" size="8" style="text-align:right" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $trim3?>"></td>
				 <td width="190" class="Estilo5">4TO TRIM.  <input name="txttrim4" type="text" id="txttrim4" size="8" style="text-align:right" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $trim4?>"></td>
			  </table></td>
            </tr>
			<tr><td >&nbsp;</td></tr>
			<tr>
              <td><table width="850" border="1" cellspacing='0' cellpadding='0' align="center">
			    <tr>
                  <td><table width="840" border="0" cellspacing='1' cellpadding='2'>
                    <tr>
                      <td width="90" class="Estilo5">ENERO :  </td>
					  <td width="120" class="Estilo5"><input name="txtasignado01" type="text" id="txtasignado01" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado01?>">  </td>
					  <td width="90" class="Estilo5">FEBRERO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado02" type="text" id="txtasignado02" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado02?>">  </td>
					  <td width="90" class="Estilo5">MARZO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado03" type="text" id="txtasignado03" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado03?>">  </td>
					  <td width="90" class="Estilo5">ABRIL : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado04" type="text" id="txtasignado04" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado04?>">  </td>
					</tr>
					<tr>
                      <td width="90" class="Estilo5">MAYO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado05" type="text" id="txtasignado05" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado05?>">  </td>
					  <td width="90" class="Estilo5">JUNIO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado06" type="text" id="txtasignado06" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado06?>">  </td>
					  <td width="90" class="Estilo5">JULIO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado07" type="text" id="txtasignado07" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado07?>">  </td>
					  <td width="90" class="Estilo5">AGOSTO : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado08" type="text" id="txtasignado08" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado08?>">  </td>					  
					</tr>
					<tr>
                      <td width="90" class="Estilo5">SEPTIEMBRE : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado09" type="text" id="txtasignado09" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado09?>">  </td>					  
					  <td width="90" class="Estilo5">OCTUBRE : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado10" type="text" id="txtasignado10" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado10?>">  </td>					  
					  <td width="90" class="Estilo5">NOVIEMBRE : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado11" type="text" id="txtasignado11" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado11?>">  </td>					  
					  <td width="90" class="Estilo5">DICIEMBRE : </td>
					  <td width="120" class="Estilo5"><input name="txtasignado12" type="text" id="txtasignado12" size="13" style="text-align:right" maxlength="13" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" value="<?echo $asignado12?>">  </td>					  
					</tr>
                   </table></td>  
				</tr>   
				
			  </table></td>
            </tr>
			<tr>
              <td><table width="850" border="0">
                <tr>
                  <td width="650" align="right" class="Estilo5">TOTAL DISTRIBUCI&Oacute;N :</td>
                  <td width="200" align="right"  class="Estilo5"> <input name="txttotal_dist" type="text" id="txttotal_dist" size="20" style="text-align:right" maxlength="20" readonly value="<?echo $total_dist?>">  </td>
                  </tr>
              </table></td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>