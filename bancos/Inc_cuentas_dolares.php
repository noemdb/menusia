<? include ("../class/ventana.php"); include ("../class/fun_fechas.php"); 
 $SIA_Definicion=$_POST["txtSIA_Definicion"];  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];  
 $fecha_fin=$_POST["txtfecha_fin"];$Formato_Cuenta=$_POST["txtformato"]; 
 $fecha_hoy=asigna_fecha_hoy(); $fecha_c="01/01/".substr($fecha_fin,0,4);
 $mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($Formato_Cuenta);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Definicion de Cuentas en Dolares)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js"  type=text/javascript></SCRIPT>
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
var patroncodigo = new <?php echo $mpatron ?>;
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function revisar(){var f=document.form1;
  if(f.txtcodigo_cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}else{f.txtcodigo_cuenta.value=f.txtcodigo_cuenta.value.toUpperCase();}
  if(f.txtdescripcion_cuenta.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion_cuenta.value=f.txtdescripcion_cuenta.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DEFINICION DE CUENTAS DOLARES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cuentas_dolares.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_cuentas_dolares.php">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:343px; z-index:1; top: 70px; left: 116px;">
             <form name="form1" method="post" action="Insert_cuenta_dolares.php" onSubmit="return revisar()">
              <table width="839" height="110" border="0" align="center" >
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="830" height="24"><table width="830" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="150"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                        <td width="630"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cuenta" type="text" id="txtcodigo_cuenta" title="Registre el Codigo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarNum(event)" onkeyup="mascara(this,'-',patroncodigo,true)"></span></td>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td>  </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                     <tr>
						<td width="150"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
						<td width="630"><textarea name="txtdescripcion_cuenta" cols="80" class="Estilo10" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" id="txtdescripcion_cuenta"></textarea></td>
					 
                    </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td>  </tr>
                
                <tr>  <td>&nbsp;</td>  </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="Grabar" type="submit" id="submit"  value="Grabar"></td>
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