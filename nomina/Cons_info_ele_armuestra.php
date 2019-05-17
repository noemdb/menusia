<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../class/imagenes/sia.ico">
<html>
<head>
<title>SIA NÓMINA Y PERSONAL (Información Elegibles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){
var murl;
var Gcod_estructura=document.form1.txtcod_estructura.value;
    murl=url+Gcod_estructura;
    if (Gcod_estructura==""){alert("Código de Estructura debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_estructura_orden.php?Gcod_estructura=P"}
   if(MPos=="U"){murl="Act_estructura_orden.php?Gcod_estructura=U"}
   if(MPos=="S"){murl="Act_estructura_orden.php?Gcod_estructura=S"+document.form1.txtcod_estructura.value;}
   if(MPos=="A"){murl="Act_estructura_orden.php?Gcod_estructura=A"+document.form1.txtcod_estructura.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  r=confirm("Esta seguro en Eliminar la Infomación del Personal ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Infomación del Personal ?");
    if (r==true) {
       url="Delete_estructura.php?txtcod_estructura="+document.form1.txtcod_estructura.value;
       VentanaCentrada(url,'Eliminar Estructuras','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
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
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 { font-size: 16pt; font-weight: bold; }
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px; font-weight: bold; color: #0000FF; }
.Estilo11 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR - INFORMACIÓN ELEGIBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="820" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="814"><table width="92" height="967" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_info_ele_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_info_ele_ar.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:867px; height:780px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post">
          <table width="865" border="0" >
                <tr>
                  <td width="850" height="27"><table width="836">
                    <tr>
                      <td width="123" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA IDENTIDAD :</span></div></td>
                      <td width="412" scope="col"><div align="left"><span class="Estilo5">
                          <span class="Estilo11">
                          <input name="txtcedula" type="text" class="Estilo5" id="txtcedula"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                          </span>                        <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="99" scope="col"><div align="left"><span class="Estilo5">NACIONALIDAD : </span></div></td>
                      <td width="182" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                          <input name="txtnacionalidad_e" type="text" class="Estilo5" id="txtnacionalidad_e" size="25" maxlength="25" readonly>
                      </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="837">
                    <tr>
                      <td width="60" height="51" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                      <td width="765" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong>
                          <textarea name="txtnombre_e" cols="118" readonly="readonly" class="Estilo5" id="textnombre_e"></textarea>
                      </strong></strong></strong></strong> </span></strong></strong></strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="826">
                    <tr>
                      <th width="155" height="21" scope="col"><div align="right"><span class="Estilo12">INFORMACI&Oacute;N PRESONAL</span></div></th>
                      <th width="659" scope="col">&nbsp;</th>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="67" scope="col"><div align="left"><span class="Estilo5">NOMBRES :</span></div></td>
                      <td width="158" scope="col"><div align="left"><span class="Estilo5">
                          <input name="txtnombre1_e" type="text" class="Estilo5" id="txtnombre1_e" size="25" maxlength="25" readonly>
                          <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="167" scope="col"><div align="left"><span class="Estilo5">
                          <input name="txtnombre2_e" type="text" class="Estilo5" id="txtnombre2_e" size="25" maxlength="25" readonly>
                      </span></div></td>
                      <td width="77" scope="col"><span class="Estilo5">APELLIDOS :</span>
                          <div align="left"></div></td>
                      <td width="159" scope="col"><span class="Estilo5">
                        <input name="txtapellido1_e" type="text" class="Estilo5" id="txtapellido1_e" size="25" maxlength="25" readonly>
                      </span></td>
                      <td width="180" scope="col"><span class="Estilo5">
                        <input name="txtapellido2_e" type="text" class="Estilo5" id="txtapellido2_e" size="25" maxlength="25" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="154" scope="col"><div align="left"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></div></td>
                      <td width="88" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                          <input name="txtgrado_inst_e" type="text" class="Estilo5" id="txtgrado_inst_e" size="10" maxlength="45" readonly>
                      </span></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="77" scope="col"><div align="left"><span class="Estilo5">PROFESI&Oacute;N : </span></div></td>
                      <td width="256" scope="col"><div align="left"><span class="Estilo5">
                          <input name="txtprofesion_e" type="text" class="Estilo5" id="txtprofesion_e" size="42" maxlength="40" readonly>
                          <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="89" scope="col"><span class="Estilo5">EXPERIENCIA : </span></td>
                      <td width="144" scope="col"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                        <input name="txtCod_Banco37" type="text" class="Estilo5" id="txtCod_Banco310" size="18" maxlength="18" readonly>
                      </span></strong></strong></strong></strong></span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="108" scope="col"><div align="left"><span class="Estilo5">DISPONIBILIDAD : </span></div></td>
                      <td width="40" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong><strong><strong>
                          <input name="txtCod_Banco4" type="text" class="Estilo5" id="txtCod_Banco12" size="5" maxlength="15" readonly>
                      </strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="170" scope="col"><div align="left"><span class="Estilo5">EN DIAS </span></div></td>
                      <td width="92" scope="col"><div align="left"><span class="Estilo5">ESTADO CIVIL : </span></div></td>
                      <td width="209" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                        <input name="txtCod_Banco6" type="text" class="Estilo5" id="txtCod_Banco62" size="15" maxlength="15" readonly>
                      </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </span></strong></strong></strong></strong></span></span></td>
                      <td width="42" scope="col"><span class="Estilo5">SEXO : </span></td>
                      <td width="143" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                        <input name="txtsexo_e" type="text" class="Estilo5" id="txtsexo_e" size="17" maxlength="15" readonly>
                      </span></strong></strong></strong></strong></span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="142" scope="col"><div align="left"><span class="Estilo5">FECHA DE NACIMIENTO :</span></div></td>
                      <td width="491" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><span class="Estilo11">
                          <input name="txtfecha_nacimiento_e" type="text" class="Estilo5" id="txtfecha_nacimiento_e" size="15" maxlength="15" readonly>
                      </span> </strong></strong></span> </span></div></td>
                      <td width="43" scope="col"><div align="left"><span class="Estilo5">EDAD : </span></div></td>
                      <td width="140" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong> </strong></strong></strong></strong> </span></strong></strong></strong></strong></span> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo11"><strong><strong><strong><strong>
                          <input name="txtedad_e" type="text" class="Estilo5" id="txtedad_e" size="5" maxlength="15" readonly>
                      </strong></strong></strong></strong></span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="837">
                    <tr>
                      <td width="143" scope="col"><div align="left"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></div></td>
                      <td width="682" scope="col"><div align="left"><span class="Estilo5">
                          <input name="txtlugar_nacimiento_e" type="text" class="Estilo5" id="txtlugar_nacimiento_e" size="125" maxlength="120" readonly>
                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="837">
                    <tr>
                      <td width="77" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N : </span></div></td>
                      <td width="748" scope="col"><div align="left"><span class="Estilo5">
                          <textarea name="txtdireccion_e" cols="115" readonly="readonly" class="Estilo5" id="txtdireccion_e"></textarea>
                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="61" scope="col"><div align="left"><span class="Estilo5">ESTADO : </span></div></td>
                      <td width="410" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo11">
                          <input name="txtestado_e" type="text" class="Estilo5" id="txtestado_e" size="42" maxlength="42" readonly>
                      </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="79" scope="col"><div align="left"><span class="Estilo5">MUNICIPIO : </span></div></td>
                      <td width="266" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong>
                          <input name="txtmunicipio_e" type="text" class="Estilo5" id="txtmunicipio_e" size="42" maxlength="42" readonly>
                      </strong></strong></strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="58" scope="col"><div align="left"><span class="Estilo5">CIUDAD : </span></div></td>
                      <td width="407" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo11"><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong>
                          <input name="txtciudad_e" type="text" class="Estilo5" id="txtciudad_e" size="42" maxlength="42" readonly>
                      </strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="86" scope="col"><div align="left"><span class="Estilo5">PARROQUIA : </span></div></td>
                      <td width="265" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong>
                          <input name="txtparroquia_e" type="text" class="Estilo5" id="txtparroquia_e" size="42" maxlength="42" readonly>
                      </strong></strong></strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="144" scope="col"><div align="left"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></div></td>
                      <td width="102" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                          <input name="txttelefono_e" type="text" class="Estilo5" id="txttelefono_e" size="10" maxlength="10" readonly>
                      </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="166" scope="col"><div align="left"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></div></td>
                      <td width="158" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                          <input name="txttlf_movil_e" type="text" class="Estilo5" id="txttlf_movil_e" size="10" maxlength="10" readonly>
                      </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="107" scope="col"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                      <td width="131" scope="col"><span class="Estilo5">
                        <input name="txtcod_postal_e" type="text" class="Estilo5" id="txtcod_postal_e" size="15" maxlength="15" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="145" scope="col"><div align="left"><span class="Estilo5">CORREO ELECTRONICO :</span></div></td>
                      <td width="420" scope="col"><div align="left"><span class="Estilo5">
                          <input name="txtcorreo_e" type="text" class="Estilo5" id="txtcorreo_e" size="70" maxlength="50" readonly>
                          <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="120" scope="col"><div align="left"><span class="Estilo5">APARTADO POSTAL : </span></div></td>
                      <td width="131" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                          <input name="txtCod_Banco15" type="text" class="Estilo5" id="txtCod_Banco24" size="15" maxlength="15" readonly>
                      </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="836">
                    <tr>
                      <td width="94" scope="col"><div align="left"><span class="Estilo5">TALLA CAMISA : </span></div></td>
                      <td width="195" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong>
                          <input name="txttalla_camisa_e" type="text" class="Estilo5" id="txttalla_camisa_e" size="15" maxlength="15" readonly>
                      </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="108" scope="col"><div align="left"><span class="Estilo5">TALLA PANTALON : </span></div></td>
                      <td width="177" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo11">
                          <input name="txttalla_pantalon_e" type="text" class="Estilo5" id="txttalla_pantalon_e" size="15" maxlength="15" readonly>
                      </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                      <td width="104" scope="col"><span class="Estilo5">TALLA CALZADO : </span></td>
                      <td width="130" scope="col"><span class="Estilo5">
                        <input name="txttalla_calzado_e" type="text" class="Estilo5" id="txttalla_calzado_e" size="15" maxlength="15" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
<div id="Layer3" style="position:absolute; width:850px; height:309px; z-index:2; left: 4px; top: 462px;">
<script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Información Curricular";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Experieencia Laboral";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Información Familiar";        // Requiere: <div id="T13" class="tab-body">  ... </div>
</script>
<?include ("../class/class_tab.php");?>
<script type="text/javascript" language="javascript"> DrawTabs(); </script>
<!-- PESTAÑA 1 -->
<div id="T11" class="tab-body">
   <iframe src="Det_inf_curricular.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0">
   </iframe>
</div>
<!--PESTAÑA 2 -->
<div id="T12" class="tab-body" >
   <iframe src="Det_exp_laboral.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0">
   </iframe>
</div>
<!-- PESTAÑA 3 -->
<div id="T13" class="tab-body">
   <iframe src="Det_inf_familiar.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0">
   </iframe>
</div>
</div> </form> </div>
    </td>
</tr>
</table>
</body>
</html>
