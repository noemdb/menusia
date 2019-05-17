<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $nro_aut="N"; $equipo=getenv("COMPUTERNAME");  $tipo_comp="EM001";
$fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $codigo_mov=$_POST["txtcodigo_mov"]; $cod_dep=$_POST["txtcod_dep"]; $nom_dep=$_POST["txtnom_dep"]; 
$fec_fin_e=$_POST["txtfecha_fin"]; $Cod_Emp=$_POST["txtcod_emp"]; $ced_rif_emp=$_POST["txtced_rif_emp"]; $fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Orden de Salida Bienes Muebles)</title>
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
var mnro_aut='<?php echo $nro_aut ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mced_rif_emp='<?php echo $ced_rif_emp ?>';
var patronfecha = new Array(2,2,4);
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_desin.value;  mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_desin.value=mref; return true;}   
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}

function apaga_dep(mthis){var mref; 
 apagar(mthis); mref=mthis.value; 
 ajaxSenddoc('GET', 'vcoddep.php?cod_cont='+mref+'&cedrif='+mced_rif_emp+'&norden='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'coddep', 'innerHTML');
}
function revisar(){
var f=document.form1;
    if(f.txtreferencia.value.length==8){f.txtreferencia.value=f.txtreferencia.value.toUpperCase();}      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_salida.value==""){alert("El Codigo no puede estar Vacia");return false;}else{f.txttipo_salida.value=f.txttipo_salida.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio"); return false; } else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    document.form1.submit;
return true;}

</script>

</head>
<body>

<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ORDEN DE SALIDA  BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="600" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="600" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="600"><table width="94" height="600" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_orden_salida_bienes_muebles_pro.php?Greferencia=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_orden_salida_bienes_muebles_pro.php?Greferencia=U">Atras</A></td>
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
            <form name="form1" method="post" action="Insert_orden_salida_bienes_muebles_pro.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center">   
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="120"><span class="Estilo5">REFERENCIA :</span></td>
                 <td width="130"><div id="refmov"><input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" class="Estilo10"> </div> </td>
                 <td width="100"><span class="Estilo5">FECHA  :</span></td>
                 <td width="145"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="120"><span class="Estilo5">TIPO DE SALIDA :</span></td>
                 <td width="230"><span class="Estilo5"><select class="Estilo10" name="txttipo_salida">
                      <option value="1" selected>ORDEN POR REPARACION</option> <option value="2">DONACION</option> <option value="3">RETORNO A PROVEEDOR</option>
                      <option value="4">TRASLADO POR REPARACION</option> <option value="5">PUNTO CUENTA DONACION</option><option value="6">COMODATO</option>
                    </select>	 </span></td>                
               </tr>
             </table></td>
           </tr>
		  
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5"><div id="coddep">C&Oacute;DIGO DEPENDENCIA :</div> </span></td>
                 <td width="65"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dep?>" onFocus="encender(this)" onBlur="apaga_dep(this)" class="Estilo10">    </span></td>
                 <td width="70"><span class="Estilo5"> <input name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $nom_dep?>" readonly class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript"> var mref=document.form1.txtcod_dependencia.value; var mdir=""; var mdep="";
                ajaxSenddoc('GET', 'refordsalaut.php?nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refmov', 'innerHTML');
				ajaxSenddoc('GET', 'vcoddep.php?cod_cont='+mref+'&cedrif='+mced_rif_emp+'&norden='+mref+'&tcaus='+mdir +'&ccontab='+mdep+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'coddep', 'innerHTML');
           </script>		   
	       <tr>
            <td><table width="845">
              <tr>
                <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="720"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="Estilo10" id="txtdescripcion"></textarea>    </div></td>
              </tr>
            </table></td>
          </tr>          
        </table>
        <iframe src="Det_inc_bienes_ord_salida.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        
        <table width="812">
		  <tr>
		  <td >&nbsp;</td>
		  </tr>
          <tr>
            <td width="614"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="20"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td> 
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

