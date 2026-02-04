<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PRE006".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);$ref_comp="N";}else{$codigo_mov=$_GET["codigo_mov"];$ref_comp=$_GET["ref_comp"];}
$referencia_comp=""; $tipo_compromiso=""; $nombre_abrev_comp=""; $clave_empresa="DATOS"; $clave_empresa=$dbname;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Cargar Compromiso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function llamar_anterior(){  history.back(); }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;  mref=Rellenarizq(mref,"0",4);    mform.txttipo_compromiso.value=mref;
 return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4); }
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_comp.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_comp.value=mref;
return true;}
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtclave_empresa.value==""){alert("Clave de Empresa no puede estar Vacia"); f.txtclave_empresa.focus(); return false;}
   if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio"); f.txtreferencia_comp.focus(); return false;}
   if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); f.txttipo_compromiso.focus();  return false; } else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="carga_comp.php" onSubmit="return revisar()">
  <table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CARGAR COMPROMISO</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="740" border="0">
              <tr>
                <td width="140"><span class="Estilo5">CLAVE DE EMPRESA  : </span></td>
				<td width="600"><span class="Estilo5"> <input class="Estilo10" name="txtclave_empresa" type="text" id="txtclave_empresa" value="<?php echo $clave_empresa?>" title="Registre la Clave de Empresa Origen Compromiso a Cargar"  size="10" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $codest?>">    </span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
		  <tr>
			<td>
			  <table width="866" align="center">
				<tr>
				  <td><table width="832" border="0">
					<tr>
					  <td width="168"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
					  <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apaga_doc(this)"  onchange="chequea_tipo(this.form);" onkeypress="return stabular(event,this)" value="<?php echo $tipo_compromiso?>"></td>
					  <td width="41"><span class="Estilo5"><input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('Cat_doc_comp.php?criterio=','SIPAP','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
					  <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" readonly value="<?php echo $nombre_abrev_comp?>" onkeypress="return stabular(event,this)">   </span></td>
					  <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
					  <td width="170"><div id="refer"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" value="<?php echo $referencia_comp?>" onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)"></div></td>
					  <td width="177"><span class="Estilo5">  </span></td>
					</tr>
				  </table></td>
				</tr>
			  </table>  </td>
		  </tr> 
		<tr> <td>&nbsp;</td>  </tr>
		<tr> <td>&nbsp;</td>  </tr>
        
        <tr> <td><p>&nbsp;</p> </td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="100" align="center" valign="middle"><input name="Cargar Compromiso" type="submit" id="Cargar Compromiso"  value="Cargar Compromiso"></td>
            <td width="100" align="center">&nbsp;</td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>