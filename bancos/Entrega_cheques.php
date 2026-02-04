<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){$cod_banco='';$num_cheque='';$nombre_recib=""; }  else{$cod_banco=$_GET["txtcod_banco"];$num_cheque=$_GET["num_cheque"];$ced_rif_recib=$_GET["ced_rif"]; $nombre_recib=$_GET["nombre"];  }
$fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Entrega de Cheques)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha_recep.value;
  if(mform.txtfecha_recep.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_recep.value=mfec;}
return true;}
function checkcedrif(mform){ var mcrif;
  mcrif=mform.txtced_rif_recib.value;
  ajaxSenddoc('GET', 'vcedent.php?ced_rif='+mcrif+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nombrec', 'innerHTML');
return true;}
function revisar(){ var f=document.form1;var r;
var Valido=true;
    if(f.txtfecha_recep.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtfecha_recep.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txtced_rif_recib.value==""){alert("Cedula/Rif no puede estar Vacio");return false;}
    if(f.txtnombre_recib.value==""){alert("Nombre no puede estar Vacio");return false;}
    r=confirm("Desea Entregar el Cheque ?");  if (r==true) {Valido=true;} else {return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Update_edo_cheque.php" onSubmit="return revisar()">
  <table width="774" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ENTREGA DE CHEQUE A BENEFICIARIO</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="760" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">FECHA DE ENTREGA: </span></td>
                <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtfecha_recep" type="text" id="txtfecha_recep" size="15" value="<?echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  ></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="760" border="0" align="center">
              <tr>
                <td width="160"><span class="Estilo5">RECIBIDO POR CED/RIF :</span></td>
                <td width="600"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_recib" type="text"  id="txtced_rif_recib"  value="<?echo $ced_rif_recib?>" onchange="checkcedrif(this.form)" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" ></span></td></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="760">
              <tr>
                <td width="160"><span class="Estilo5">NOMBRE DE RECIBIDO  :</span></td>
                <td width="600"><span class="Estilo5"><div id="nombrec"><input class="Estilo10" name="txtnombre_recib" type="text"  id="txtnombre_recib"  value="<?echo $nombre_recib?>" size="85" maxlength="85" onFocus="encender(this)" onBlur="apagar(this)"> </div></span></td>
               </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td>   </tr>
          <td><table width="360" border="0" align="center"> <tr>
            <td width="40"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>"></td>
            <td width="40"><input name="txtentregado" type="hidden" id="txtentregado" value="N"></td>
            <td width="40"><input name="txtopcion" type="hidden" id="txtopcion" value="E"></td>
            <td width="40"><input name="txtnum_cheque" type="hidden" id="txtnum_cheque" value="<?echo $num_cheque?>"></td>
          </tr></table></td>
          </tr>
          <tr>
            <td><span class="Estilo5"> </span>                </td>
          </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="30">&nbsp;</td>
                <td width="100" align="center" valign="middle"><input name="Entregar" type="submit" id="Entregar"  value="Entregar"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="90" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:window.close()"></td>
                <td width="30">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p>
          </tr>
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>