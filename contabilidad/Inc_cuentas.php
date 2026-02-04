<?php include ("../class/seguridad.inc"); include ("../class/ventana.php"); include ("../class/fun_fechas.php"); 
 $SIA_Definicion=$_POST["txtSIA_Definicion"];  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];  
 $ced_r=$_POST["txtced_r"]; $nomb_r=$_POST["txtnomb"]; $fecha_fin=$_POST["txtfecha_fin"]; $Formato_Cuenta=$_POST["txtformato"]; 
 $fecha_hoy=asigna_fecha_hoy(); $fecha_c="01/01/".substr($fecha_fin,0,4);
 $mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($Formato_Cuenta);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FISCAL (Cuentas Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js" type=text/javascript></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
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
   apagar(mthis);    mmonto=document.form1.txtsaldo_anterior.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtsaldo_anterior.value=mmonto;
 return true;}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtFecha_Creado.value;
  if(mform.txtFecha_Creado.value.length==8){mfec=mref.substring(0,6)+"20"+ mref.charAt(6)+mref.charAt(7); mform.txtFecha_Creado.value=mfec;}
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}
    if(f.txtNombre_Cuenta.value==""){alert("Denominacion de Cuenta no puede estar Vacia"); return false; }
         else{f.txtNombre_Cuenta.value=f.txtNombre_Cuenta.value.toUpperCase();}
    if(f.txtTSaldo.value=="Deudor" || f.txtTSaldo.value=="Acreedor") {Valido=true;}
        else{alert("Tipo de Saldo no valida");return false; }
    if(f.txtClasificacion.value=="Activo del Tesoro" || f.txtClasificacion.value=="Pasivo del Tesoro" || f.txtClasificacion.value=="Activo de la Hacienda" || f.txtClasificacion.value=="Pasivo de la Hacienda" || f.txtClasificacion.value=="Gastos del Presupuesto" || f.txtClasificacion.value=="Ingresos del Presupuesto" || f.txtClasificacion.value=="Resultado del Presupuesto" || f.txtClasificacion.value=="Cuenta de Patrimonio") {Valido=true;}
        else{alert("Clasificacion de Cuenta no valida");return false;}
    if(f.txtsaldo_anterior.value==""){alert("Saldo Anterior no puede estar Vacio");return false;}
    if(MontoValido(f.txtsaldo_anterior.value)) {Valido=true;}
       else{alert("Saldo Anterior debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CUENTAS CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_cuentas.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 80px; left: 112px;">
      <form name="form1" method="post" action="Insert_cuentas.php" onSubmit="return revisar()">
        <table width="861" border="0">
          <tr>
            <td width="432"><blockquote>
                <p><span class="Estilo5">C&Oacute;DIGO DE CUENTA :
                          <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el Codigo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarNum(event)" onkeyup="mascara(this,'-',patroncodigo,true)">
                </span></p>
            </blockquote></td>
            <td width="419"><input name="button3" type="button" id="button3" title="Abrir Catalogo Plan de Cuentas" onclick="VentanaCentrada('Cat_plan_cuentas.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
          </tr>
        </table>
        <table width="859" border="0">
          <tr>
            <td width="177"><blockquote><span class="Estilo5">NOMBRE DE LA CUENTA :</span></blockquote></td>
            <td width="672"><textarea name="txtNombre_Cuenta" cols="80" class="headers" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" id="txtNombre_Cuenta"></textarea></td>
          </tr>
        </table>
        <table width="863" border="0">
          <tr>
            <td width="279"><blockquote><span class="Estilo5">TIPO DE SALDO :
              <select name="txtTSaldo" size="1" id="txtTSaldo" onFocus="encender(this)" onBlur="apagar(this)">
                <option>Deudor</option><option>Acreedor</option></select>
            </span> </blockquote></td>
            <td width="261" class="Estilo5">CLASIFICACI&Oacute;N :
              <select name="txtClasificacion" size="1" id="txtClasificacion" onFocus="encender(this)" onBlur="apagar(this)">
                <option selected>Activo del Tesoro</option> <option>Pasivo del Tesoro</option><option>Activo de la Hacienda</option> <option>Pasivo de la Hacienda</option> <option>Gastos del Presupuesto</option><option>Ingresos del Presupuesto</option> <option>Resultado del Presupuesto</option> <option>Cuenta de Patrimonio</option> </select></td>
            <td width="309" class="Estilo5">SALDO ANTERIOR :
            <?php  IF($SIA_Definicion=="N"){?>
                <input name="txtsaldo_anterior" type="text" id="txtsaldo_anterior" size="25" style="text-align:right" maxlength="22" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)" value="0">
            <?php } else { ?>
                <input name="txtsaldo_anterior" type="text" id="txtsaldo_anterior" size="25" style="text-align:right" maxlength="22" readonly value="0">
            <?php }?>
          </tr>
        </table>
        <table width="861" border="0">
          <tr>
            <td width="833"><blockquote><span class="Estilo5">FECHA DE REGISTRO :
                  <input name="txtFecha_Creado" type="text" id="txtFecha_Creado" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_c?>" size="12" maxlength="10" onchange="checkrefecha(this.form)">  </span></blockquote></td>
            <td width="18"> </td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
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