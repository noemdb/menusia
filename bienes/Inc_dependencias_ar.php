<?php include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Dependencia)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript">
</script><script language="JavaScript" type="text/JavaScript">
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
function chequea_tipo(mform){var mref;
   mref=mform.txtcod_dependencia.value;   mref = Rellenarizq(mref,"0",4);   mform.txtcod_dependencia.value=mref; return true;}
function revisar(){
var f=document.form1;
    if(f.txtcod_dependencia.value==""){alert("Codigo de Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtdenominacion_dep.value==""){alert("Denominacion Dependencia no puede estar Vacia"); return false; } else{f.txtdenominacion_dep.value=f.txtdenominacion_dep.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtdireccion_dep.value==""){alert("La Direccion no puede estar Vacia"); return false; } else{f.txtdireccion_dep.value=f.txtdireccion_dep.value.toUpperCase();}
    
	//if(f.txtcod_postal_dep.value==""){alert("El Codigo Postal no puede estar Vacio"); return false; } else{f.txtcod_postal_dep.value=f.txtcod_postal_dep.value.toUpperCase();}
    //if(f.txttelefonos_dep.value==""){alert("Telefono no puede estar Vacio"); return false; } else{f.txttelefonos_dep.value=f.txttelefonos_dep.value.toUpperCase();}
    //if(f.txtced_responsable.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    //if(f.txtnombre_res.value==""){alert("Nombre del Responsable no puede estar Vacia"); return false; } else{f.txtnombre_res.value=f.txtnombre_res.value.toUpperCase();}
    
	//if(f.txtdistrito.value==""){alert("El Distrito no puede estar Vacia"); return false; } else{f.txtdistrito.value=f.txtdistrito.value.toUpperCase();}
    //if(f.txtdireccion_dep.value==""){alert("La Direccion no puede estar Vacia"); return false; } else{f.txtdireccion_dep.value=f.txtdireccion_dep.value.toUpperCase();}
    //if(f.txtcod_alterno.value==""){alert("El Codigo Alterno no puede estar Vacia"); return false; } else{f.txtcod_alterno.value=f.txtcod_alterno.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DEPENDENCIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_dependencias_ar.php?Gcod_dependencia=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_dependencias_ar.php?Gcod_dependencia=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Insert_dependencias_ar.php" onSubmit="return revisar()">
	  

        <table width="850" border="0" align="center" >
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">C&Oacute;D. DEPENDENCIA :</span></div></td>
                <td width="720"><div align="left"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_tipo(this.form);">  </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span></div></td>
                <td width="720"><div align="left"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850">
                 <tr>
                 <td width="130"><div align="left"><span class="Estilo5">REG&Iacute;ON :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"><input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">                     
                     <input name="btcat_reg" type="button" id="btcat_reg" title="Abrir Catalogo de Regiones" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </span></div></td>
                 <td width="620"><div align="left"><span class="Estilo5"><input name="txtnombre_region" type="text" id="txtnombre_region" size="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="850">
                <tr>
                 <td width="130"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"><input name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     <input name="btcat_ent" type="button" id="btcat_ent" title="Abrir Catalogo de Entidades Federal" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIPAP','','750','500','true')" value="...">
                </span></div></td>
                 <td width="620"><div align="left"><span class="Estilo5"><input name="txtestado" type="text" id="txtestado" size="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                 <td width="130"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"><input name="txtcod_municipio" type="text" id="txtcod_municipio" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     <input name="btcat_mun" type="button" id="btcat_mun" title="Abrir Catalogo de Municipios" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></div></td>
                 <td width="620"><div align="left"><span class="Estilo5"><input name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="850">
                 <tr>
                 <td width="130"><div align="left"><span class="Estilo5">CIUDAD :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"><input name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                   <input name="btcat_ciu" type="button" id="btcat_ciu" title="Abrir Catalogo de Ciudades" onClick="VentanaCentrada('Cat_ciudadesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></div></td>
                 <td width="620"><div align="left"><span class="Estilo5">  <input name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="850">
                        <tr>
                 <td width="130"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                 <td width="120"><div align="left"><span class="Estilo5"> <input name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     <input name="btcat_parr" type="button" id="btcat_parr" title="Abrir Catalogo de Parroquias" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5">  <input name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="68" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                <td width="720"><div align="left"><textarea name="txtdireccion_dep" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdireccion_dep"></textarea>   </div></td>
              </tr>
            </table></td>
          </tr>
       
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                <td width="120"><div align="left"><span class="Estilo5"><input name="txtcod_postal_dep" type="text" id="txtcod_postal_dep" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="100"><div align="left"><span class="Estilo5">TEL&Eacute;FONOS :</span></div></td>
                <td width="500"><div align="left"><span class="Estilo5"> <input name="txttelefonos_dep" type="text" id="txttelefonos_dep" size="35" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                    </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">C.I. RESPONSABLE :</span></div></td>
                <td width="200"><div align="left"><span class="Estilo5"><input name= "txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                    <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </span></div></td>
                <td width="70"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                <td width="450"><div align="left"><span class="Estilo5"><input name="txtnombre_respp" type="text" id="txtnombre_respp" size="50" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" readonly>
                   </span> </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850">
              <tr>
                <td width="130"><div align="left"><span class="Estilo5">DISTRITO :</span></div></td>
                <td width="70"><div align="left"><span class="Estilo5"> <input name="txtdistrito" type="text" id="txtdistrito" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     </span></div></td>
                <td width="120"><div align="left"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></div></td>
                <td width="530"><div align="left"><span class="Estilo5"><input name="txtcod_alterno" type="text" id="txtcod_alterno" size="35" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="812">
              <tr>
                <td width="664">&nbsp;</td>
				<td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
				<td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
              </tr>
            </table></td>
          </tr>
        </table>
		
		</div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
