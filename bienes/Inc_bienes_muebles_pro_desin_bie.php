<?php include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $nro_aut="N"; $equipo=getenv("COMPUTERNAME");   $tipo_comp="ED004";
$fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $codigo_mov=$_POST["txtcodigo_mov"]; $cod_dep=$_POST["txtcod_dep"]; $nom_dep=$_POST["txtnom_dep"]; 
$formato_bien=$_POST["txtformato_bien"]; $long_num_bien=$_POST["txtlong_num_bien"]; $fec_fin_e=$_POST["txtfecha_fin"]; $Cod_Emp=$_POST["txtcod_emp"]; $ced_rif_emp=$_POST["txtced_rif_emp"];
$fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Desincorporacion de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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

function apaga_cuenta(mthis){var mref; var norden;
 apagar(mthis); mref=mthis.value; norden=document.form1.txtreferencia_desin.value;
 ajaxSenddoc('GET', 'vctabien.php?cod_cont='+mref+'&cedrif='+mced_rif_emp+'&norden='+norden+'&codigo_mov=<?php echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'descta', 'innerHTML');
}
function llama_cat_dir(mform){  var mcod_dep; var murl; mcod_dep=mform.txtcod_dependencia.value;
  murl='Cat_direcc_dep.php?cod_dependen='+mcod_dep+'&criterio=';   VentanaCentrada(murl,'SIPAP','','750','500','true');
return true;}
function llama_cat_dep(mform){  var mcod_dep; var murl;  var mcod_dir;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value;
  murl='Cat_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&criterio=';   VentanaCentrada(murl,'SIPAP','','750','500','true');
return true;}
function revisar(){var f=document.form1; var valido;
        if(f.txtreferencia_desin.value==""){alert("Referencia Desincorporacion no puede estar Vacia");return false;}else{f.txtreferencia_desin.value=f.txtreferencia_desin.value;}
        if(f.txtfecha_desin.value==""){alert("Fecha Desincorporacion no puede estar Vacia");return false;}else{f.txtfecha_desin.value=f.txtfecha_desin.value;}
        if(f.txtcod_dependencia.value==""){alert("Dependencia no puede estar Vacia");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value;}
        if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value;}
	r=confirm("Desea Grabar la Desincoporacion de Bienes Mueble ?");  if (r==true) { valido=true;} else{return false;} 	
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DESINCORPORACI&Oacute;N BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="620" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="620" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="620"><table width="94" height="620" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=U">Atras</A></td>
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
            <form name="form1" method="post" action="Insert_bienes_muebles_pro_desin_bie.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center">
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="100"><span class="Estilo5">REFERENCIA :</span></td>
                 <td width="150"><div id="refdesin"><input name="txtreferencia_desin" type="text" id="txtreferencia_desin" size="10" maxlength="8"  onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" class="Estilo10"> </div> </td>
                 <td width="100"><span class="Estilo5">FECHA :</span></td>
                 <td width="145"><span class="Estilo5"><input name="txtfecha_desin" type="text" id="txtfecha_desin" size="15" maxlength="15"  value="<?php echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="180"><span class="Estilo5">TIPO DESINCORPORACION :</span></td>				 
                 <td width="170"><span class="Estilo5"><select class="Estilo10" name="txttipo_desin">
                      <option value="056">INSERVIBILIDAD</option>    <option value="060">FALTANTES POR INVESTIGAR</option>					  
					  <option value="052">VENTAS</option>	<option value="055">DESARME</option>
					  <option value="057">DETERIORO</option>	<option value="058">DEMOLICION</option>
					  <option value="051">POR TRABAJO</option> <option value="054">SUMINISTRO A OTRAS ENTIDADES</option>
					  <option value="062">POR DONACION</option>    <option value="067" selected>OTROS CONCEPTOS</option>      </select> </span></td>
               </tr>
             </table></td>
           </tr>
		   <script language="JavaScript" type="text/JavaScript">
                ajaxSenddoc('GET', 'refdesinaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refdesin', 'innerHTML');
           </script>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="65"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dep?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
                 <td width="70"><span class="Estilo5"> <input name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?php echo $nom_dep?>" readonly class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="65"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"  class="Estilo10">   </span></td>
                 <td width="70"><span class="Estilo5"> <input name="btdirecciones" type="button" id="btdirecciones" title="Abrir Catalogo de Direcciones" onClick="javascript:llama_cat_dir(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="60"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btdepartamento" type="button" id="btdepartamento" title="Abrir Catalogo de Departamentos" onClick="javascript:llama_cat_dep(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="100" maxlength="100"  value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr> 
           <tr>
            <td><table width="845">
              <tr>
                <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="720"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="Estilo10" id="txtdescripcion"></textarea>    </div></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
			  <td width="845"><table width="845"> 
				<tr>
				  <td width="170"><span class="Estilo5"><div id="descta">CUENTA CONTABLE :</div></span></td>
				  <td width="155"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="30" onFocus="encender(this); " onBlur="apaga_cuenta(this);"></span></td>
				  <td width="30"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
				  <td width="490"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="65" maxlength="250" readonly></span></td>
				</tr>
			  </table></td>
		  </tr> 
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 240px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_bienes_desin.php?&codigo_mov=<?php echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_comp_desin.php?codigo_mov=<?php echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
        <div id="Layer3" style="position:absolute; width:868px; height:25px; z-index:3; left: 2px; top: 580px;">
        <table width="812">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="20"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td> 
			<td width="30"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?php echo $ced_rif_emp?>" ></td> 
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </div>

            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
