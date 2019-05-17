<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
$fecha_hoy=asigna_fecha_hoy();  $num="01"; $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $fec_fin_e=$_POST["txtfecha_fin"];
$fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
$ano=substr($fecha_hoy,6,4); $antiguedad=0; $tasa_deprec=0; $vida_util=0; $valor_residual=0; $monto_depreciado=0;
$codigo_tipo_incorp=""; $denomina_tipo="";
$cod_bien_mue=$_POST["txtcod_bien_mue"];  $cod_clasificacion=$_POST["txtcod_clasificacion"];  $num_bien=$_POST["txtnum_bien"];
$nom_clasificacion=$_POST["txtnom_clasificacion"];$denominacion=$_POST["txtdenominacion"];    $cod_empresa="00"; 
$cod_dependencia=$_POST["txtcod_dependencia"]; $denominacion_dep=$_POST["txtdenominacion_dep"]; 
$cod_direccion=$_POST["txtcod_direccion"]; $denominacion_dir=$_POST["txtdenominacion_dir"];
$cod_departamento=$_POST["txtcod_departamento"]; $denominacion_depart=$_POST["txtdenominacion_depart"];
$codigo_tipo_incorp=$_POST["txtcodigo_tipo_incorp"]; $denomina_tipo=$_POST["txtdenomina_tipo"];
$tipo_incorporacion=$_POST["txttipo_incorporacion"];$cod_imp_presup=$_POST["txtcod_imp_presup"];$nom_imp_presup=$_POST["txtnom_imp_presup"];
$valor_incorporacion=$_POST["txtvalor_incorporacion"];$fecha_incorporacion=$_POST["txtfecha_incorporacion"]; $garantia=$_POST["txtgarantia"];  
?>  
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript"  src="../class/sia.js"  type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="javascript" src="ajax_bien.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mnum_bien_unico='<?php echo $num_bien_unico ?>';
var mlong_num_bien='<?php echo $long_num_bien ?>';
var patronfecha = new Array(2,2,4);
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
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_clasificacion.value==""){alert("Codigo de Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_mue.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}else{f.txtcod_bien_mue.value=f.txtcod_bien_mue.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo Departamento no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txcodigo_tipo_incorp.value==""){alert("Codigo Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txcodigo_tipo_incorp.value=f.txcodigo_tipo_incorp.value.toUpperCase();}
    if(f.txtfecha_desincorporado.value==""){alert("Fecha de Desincorporacion no puede estar Vacio"); return false; } else{f.txtfecha_desincorporado.value=f.txtfecha_desincorporado.value;}
    if(f.txtdes_desincorporado.value==""){alert("Motivo de Desincorporacion no puede estar Vacio"); return false; } else{f.txtdes_desincorporado.value=f.txtdes_desincorporado.value.toUpperCase();}
    r=confirm("Desea Registrar la Desicorporacion del Bien ?");  
	if (r==true) { r=confirm("Esta Realmente Seguro de Registrar la Desicorporacion del Bien ?");  
	if (r==true) { valido=true;} else{return false;} } else{return false;} 
	document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR FICHA BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="491" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="490" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="490"><table width="94" height="490" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_desin_bienes_muebles_correccion.php?Gcod_bien_mue=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_desin_bienes_muebles_correccion.php?Gcod_bien_mue=U">Atras</A></td>
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
      <div id="Layer1" style="position:absolute; width:873px; height:1992px; z-index:1; top: 78px; left: 119px;">
        <form name="form1" method="post" action="Insert_des_bienes_correccion.php" onSubmit="return revisar()">
         <table width="848" border="0" align="center" >
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="145"><span class="Estilo5"><input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion"  size="10" maxlength="10" value="<?echo $cod_clasificacion?>"  readonly class="Estilo5"> </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="100" maxlength="250" value="<?echo $nom_clasificacion?>"  readonly class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="250"><span class="Estilo5"><div id="numbien"> <input name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20" value="<?echo $num_bien?>"  readonly class="Estilo5"></div></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="40" value="<?echo $cod_bien_mue?>" readonly class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="680"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="120" maxlength="250" value="<?echo $denominacion?>"  readonly  class="Estilo5"></div></td>
               </tr>
             </table></td>
           </tr>          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="135"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" readonly class="Estilo5">    </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $denominacion_dep?>" readonly class="Estilo5">    </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="135"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" readonly value="<?echo $cod_direccion?>"  class="Estilo5">   </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?echo $denominacion_dir?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" readonly value="<?echo $cod_departamento ?>" class="Estilo5">   </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="100" maxlength="100"  value="<?echo $denominacion_depart ?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></td>
                 <td width="100"><span class="Estilo5"><input name="txcodigo_tipo_incorp" type="text" id="txtcodigo_tipo_incorp" size="5" maxlength="5" value="<?echo $codigo_tipo_incorp ?>" readonly class="Estilo5">  </span></td>
                 <td width="500"><span class="Estilo5"><input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="100" maxlength="150" value="<?echo $denomina_tipo?>" readonly class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></td>
                 <td width="650"><span class="Estilo5"><input name="txttipo_incorporacion" type="text" id="txttipo_incorporacion" size="30" maxlength="30" value="<?echo $tipo_incorporacion ?>" readonly class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtcod_imp_presup" type="text" id="txtcod_imp_presup" size="35" maxlength="32"  value="<?echo $cod_imp_presup?>" readonly class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtnom_imp_presup" type="text" id="txtnom_imp_presup" size="130" maxlength="150" value="<?echo $nom_imp_presup?>" readonly class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>           
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" value="<?echo $valor_incorporacion?>" readonly class="Estilo5">   </span></td>
                 <td width="150"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="15"  value="<?echo $fecha_incorporacion?>" readonly class="Estilo5">   </span></td>
                 <td width="90"><span class="Estilo5">GARANTIA :</span></td>
                 <td width="140"><span class="Estilo5"><input name="txtgarantia" type="text" id="txtgarantia" size="10" maxlength="15" value="<?echo $garantia?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><span class="Estilo10"><strong>DESINCORPORACI&Oacute;N</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DESINCORPORADO :</span></td>
				 <td width="300"><span class="Estilo5"><input name="txtdesincorporado" type="text" id="txtdesincorporado" size="4" maxlength="2" value="SI" readonly class="Estilo5">   </span></td>                 
                 <td width="200"><span class="Estilo5">FECHA DESINCORPORACI&Oacute;N :</span></td>
				 <td width="200"><span class="Estilo5"><input name="txtfecha_desincorporado" type="text" id="txtfecha_desincorporado" size="20" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">MOTIVO DESINCORPORACI&Oacute;N :</span></td>
                 <td width="680"><div align="left"><textarea name="txtdes_desincorporado" cols="70" onFocus="encender(this)" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdes_desincorporado"></textarea>   </div></td>
               </tr>
             </table></td>
           </tr>
        </table>
        <table width="812">
		  <tr>
             <td width="840" height="39">&nbsp;</td>
		   </tr>
          <tr>
            <td width="627">&nbsp;</td>
			<td width="5"><input name="txtcod_fuente" type="hidden" id="txtcod_fuente" value="" ></td>
            <td width="81"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
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
		   