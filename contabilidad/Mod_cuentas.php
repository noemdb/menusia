<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
if (!$_GET){  $codigo_cuenta='';} else {  $codigo_cuenta = $_GET["Gcodigo_cuenta"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FISCAL</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>

<script language="Javascript" type="text/Javascript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="Javascript" type="text/Javascript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); document.mthis.value=mmonto;
 return true;}
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtFecha_Creado.value;
  if(mform.txtFecha_Creado.value.length==8){mfec=mref.substring(0,6)+"20"+ mref.charAt(6)+mref.charAt(7); mform.txtFecha_Creado.value=mfec;}
return true;}
function Llamar_Ventana(url) { var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;   document.location = murl;
}
function Asigna_TSaldo(mvalor){var f=document.form1;
  if(mvalor=="Deudor"){document.form1.txtTSaldo.options[0].selected = true;}else{f.txtTSaldo.options[1].selected = true;}
}
function revisar(){var f=document.form1;
var Valido=true;
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}
    if(f.txtNombre_Cuenta.value==""){alert("Denominacion de Cuenta no puede estar Vacia"); return false; }         else{f.txtNombre_Cuenta.value=f.txtNombre_Cuenta.value.toUpperCase();}
    if(f.txtTSaldo.value=="Deudor" || f.txtTSaldo.value=="Acreedor") {Valido=true;}        else{alert("Tipo de Saldo no valida");return false; }
	if(f.txtClasificacion.value=="Activo del Tesoro" || f.txtClasificacion.value=="Pasivo del Tesoro" || f.txtClasificacion.value=="Activo de la Hacienda" || f.txtClasificacion.value=="Pasivo de la Hacienda" || f.txtClasificacion.value=="Gastos del Presupuesto" || f.txtClasificacion.value=="Ingresos del Presupuesto" || f.txtClasificacion.value=="Resultado del Presupuesto" || f.txtClasificacion.value=="Cuenta de Patrimonio") {Valido=true;}
        else{alert("clasificacion de Cuenta no valida");return false; }
        if(f.txtsaldo_anterior.value==""){alert("Saldo Anterior no puede estar Vacio");return false;}
        if(MontoValido(f.txtsaldo_anterior.value)) {Valido=true;}    else{alert("Saldo Anterior debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$nombre_cuenta="";$clasificacion="";$tSaldo="";$saldo_anterior=0; $fecha_creado=""; $cargable="N";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="Javascript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $Nom_Emp=busca_conf();  $sql="Select * from con001 where codigo_cuenta='$codigo_cuenta'";   $res=pg_query($sql);
  if ($registro=pg_fetch_array($res,0)){ $codigo_cuenta=$registro["codigo_cuenta"];  $nombre_cuenta=$registro["nombre_cuenta"];  $fecha_creado=$registro["fecha_creado"];
    $clasificacion=$registro["clasificacion"]; $tSaldo=$registro["tsaldo"];     $saldo_anterior=$registro["saldo_anterior"];  $cargable=$registro["cargable"];}
}$saldo_anterior=formato_monto($saldo_anterior);   if($fecha_creado==""){$fecha_creado="";}else{$fecha_creado=formato_ddmmaaaa($fecha_creado);} 
$MClasif_Fiscal=$clasificacion;   $clasificacion="Activo del Tesoro";
If ($MClasif_Fiscal=="11") {$clasificacion="Activo del Tesoro";}
if ($MClasif_Fiscal=="12") {$clasificacion="Pasivo del Tesoro";}
if ($MClasif_Fiscal=="21") {$clasificacion="Activo de la Hacienda";}
if ($MClasif_Fiscal=="22") {$clasificacion="Pasivo de la Hacienda";}
if ($MClasif_Fiscal=="31") {$clasificacion="Gastos del Presupuesto";}
if ($MClasif_Fiscal=="32") {$clasificacion="Ingresos del Presupuesto";}
if ($MClasif_Fiscal=="4") {$clasificacion="Resultado del Presupuesto";}
if ($MClasif_Fiscal=="5") {$clasificacion="Cuenta de Patrimonio";}
if ($MClasif_Fiscal=="99") {$clasificacion="No Clasificada";}

?>
<body>

<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CUENTAS CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Act_cuentas.php?Gcodigo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Act_cuentas.php?Gcodigo_cuenta=')">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 80px; left: 112px;">
      <form name="form1" method="post" action="Update_cuentas.php" onSubmit="return revisar()">
        <table width="848" border="0">
          <tr>
            <td width="669"> <p><span class="Estilo5">C&Oacute;DIGO DE CUENTA :
                                <input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" value="<?echo $codigo_cuenta?>"  size="30" maxlength="30" readonly">
                </span></p>
            </td>
            <td width="157">&nbsp;</td>
          </tr>
		  <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="859" border="0">
          <tr>
            <td width="177"><span class="Estilo5">NOMBRE DE LA CUENTA :</span></td>
            <td width="672"><textarea name="txtNombre_Cuenta" cols="80" class="headers" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" id="txtNombre_Cuenta"><?echo $nombre_cuenta?></textarea></td>
          </tr>
		  <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="863" border="0">
          <tr>
            <td width="279"><span class="Estilo5">TIPO DE SALDO :
              <select class="Estilo10" name="txtTSaldo" size="1" id="txtTSaldo" onFocus="encender(this)" onBlur="apagar(this)">
                <option>Deudor</option> <option>Acreedor</option> </select></span> </td>
            <td width="261" class="Estilo5">CLASIFICACI&Oacute;N :
              <select class="Estilo10" name="txtClasificacion" size="1" id="txtClasificacion" onFocus="encender(this)" onBlur="apagar(this)">
                <option selected>Activo del Tesoro</option> <option>Pasivo del Tesoro</option><option>Activo de la Hacienda</option> <option>Pasivo de la Hacienda</option> <option>Gastos del Presupuesto</option><option>Ingresos del Presupuesto</option> <option>Resultado del Presupuesto</option> <option>Cuenta de Patrimonio</option> <option>No Clasificada</option> </select></td>
<script language="Javascript"> Asigna_TSaldo('<?echo $tSaldo?>');</script>             
			 <script language="Javascript" type="text/Javascript">
var valor='<?echo $clasificacion?>';
        if(valor=="Activo del Tesoro"){document.form1.txtClasificacion.options[0].selected = true;}
        if(valor=="Pasivo del Tesoro"){document.form1.txtClasificacion.options[1].selected = true;}
        if(valor=="Activo de la Hacienda"){document.form1.txtClasificacion.options[2].selected = true;}
        if(valor=="Pasivo de la Hacienda"){document.form1.txtClasificacion.options[3].selected = true;}
		if(valor=="Gastos del Presupuesto"){document.form1.txtClasificacion.options[4].selected = true;}
        if(valor=="Ingresos del Presupuesto"){document.form1.txtClasificacion.options[5].selected = true;}
        if(valor=="Resultado del Presupuesto"){document.form1.txtClasificacion.options[6].selected = true;}
        if(valor=="Cuenta de Patrimonio"){document.form1.txtClasificacion.options[7].selected = true;}
            </script>
                <td width="309" class="Estilo5">SALDO ANTERIOR :
                <? $SIA_Definicion="N"; IF(($SIA_Definicion=="N")and($cargable=="C")){?>
                <input class="Estilo10" name="txtsaldo_anterior" type="text" id="txtsaldo_anterior" value="<?echo $saldo_anterior?>" size="25" style="text-align:right" maxlength="22" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)"></td>   </tr>
            <?} else { ?>
               <input class="Estilo10" name="txtsaldo_anterior" type="text" id="txtsaldo_anterior" value="<?echo $saldo_anterior?>" size="25" style="text-align:right" maxlength="22" readonly></td>   </tr>
            <?}?>
		   </tr>
           <tr> <td>&nbsp;</td> </tr>		   
        </table>
        <table width="861" border="0">
          <tr>
            <td width="833"><span class="Estilo5">FECHA DE REGISTRO :
                  <input class="Estilo10" name="txtFecha_Creado" type="text" id="txtFecha_Creado" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_creado?>" size="12" maxlength="10" onchange="checkrefecha(this.form)">  </span></td>
            <td width="18"> </td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="642">&nbsp;</td>
            <td width="55" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="55">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>
  </tr>
</table>
</body>
</html>