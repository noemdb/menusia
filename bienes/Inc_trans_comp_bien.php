<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $nro_aut="N";
$equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN054".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); 
$fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];
$codigo_mov=$_POST["txtcodigo_mov"]; $fec_fin_e=$_POST["txtfecha_fin"]; $Cod_Emp=$_POST["txtcod_emp"]; $ced_rif_emp=$_POST["txtced_rif_emp"];
$fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Transferencias Componentes Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
<script language="javascript" src="ajax_bien.js" type="text/javascript"></script>
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
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mced_rif_emp='<?php echo $ced_rif_emp ?>';
var patronfecha = new Array(2,2,4);
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_transf.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_transf.value=mref;
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}

function revisar(){var f=document.form1; var valido;
    if(f.txtreferencia.value.length==8){f.txtreferencia.value=f.txtreferencia.value.toUpperCase();}   else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_transferencia.value==""){alert("Tipo no puede estar Vacia");return false;}else{f.txttipo_transferencia.value=f.txttipo_transferencia.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    r=confirm("Desea Grabar la Transferencia Componentes de Bienes Mueble ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}

</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR COMPONENTES TRANSFERENCIAS BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="560" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="560"><table width="94" height="559" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_trans_comp_bien.php?Greferencia_transf_c=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_trans_comp_bien.php?Greferencia_transf_c=U">Atras</A></td>
		   </tr>
		   <tr>
			 <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
		   </tr>
		   <tr>
			<td >&nbsp;</td>
		  </tr>
		 </table></td>
	  </td>	 
	</table>
    <p>&nbsp;</p>	
    
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:1992px; z-index:1; top: 75px; left: 119px;">
            <form name="form1" method="post" action="Insert_trans_comp_bien.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center">   
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">REFERENCIA MOVIMIENTO :</span></td>
                 <td width="120"><div id="refmov"><input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" class="Estilo5"> </div> </td>
                 <td width="160"><span class="Estilo5">FECHA DEL MOVIMIENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="160"><span class="Estilo5">TIPO DE TRANSFERENCIA:</span></td>
				 <td width="120"><span class="Estilo5"><select name="txttipo_transferencia" onFocus="encender(this)" onBlur="apagar(this)">
				     <option>INTERNA</option>  <option>PRESTAMO</option> <option>CESION</option> <option>DESINCORPORACION</option>
                     <option>CAMBIO DE ESTADO</option> <option>MANTENIMIENTO</option> </select>					 
				 </span></td>
                </tr>
             </table></td>
           </tr>
            <script language="JavaScript" type="text/JavaScript"> 	 ajaxSenddoc('GET', 'reftransfcompaut.php', 'refmov', 'innerHTML');</script>		   
		   <tr>
            <td><table width="845">
              <tr>
                <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="720"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdescripcion"></textarea>    </div></td>
              </tr>
            </table></td>
          </tr>
		   <tr>
             <td><span class="Estilo10"><strong>DEPENDENCIA EMISORA</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">NOMBRE RESPONSABLE :</span></td>
                 <td width="690"><span class="Estilo5"><input name="txtnombre_e" type="text" id="txtnombre_e" size="100" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><span class="Estilo10"><strong>DEPENDENCIA RECEPTORA</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">NOMBRE RESPONSABLE :</span></td>
                 <td width="690"><span class="Estilo5"><input name="txtnombre_r" type="text" id="txtnombre_r" size="100" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr> 
        </table>
		
        <iframe src="Det_inc_trans_comp_bienes.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        
        <table width="812">
		  <tr>
		  <td >&nbsp;</td>
		  </tr>
          <tr>
            <td width="614"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="30"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?echo $ced_rif_emp?>" ></td> 
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
