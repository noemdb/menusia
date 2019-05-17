<?include ("../class/ventana.php");?>
<?php include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $codigo_mov=$_POST["txtcodigo_mov"]; $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $p_apellido=$_POST["txtprimero_apellido"];
$region_e=$_POST["txtregion_e"]; $estado_e=$_POST["txtestado_e"];  $municipio_e=$_POST["txtmunicipio_e"];  $ciudad_e=$_POST["txtciudad_e"]; $parroquia_e=$_POST["txtparroquia_e"]; $cod_estado=$_POST["txtcod_estado"];  $cod_muni=$_POST["txtcod_municipio"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Informaci&oacute;n Elegibles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mp_apellido='<?php echo $p_apellido ?>';
function chequea_nombre(mform){
var mnombre; var mnombre2; var mnombre2; var mapellido1; var mapellido2;
   mnombre1=mform.txtnombre1.value;  mnombre2=mform.txtnombre2.value; mapellido1=mform.txtapellido1.value; mapellido2=mform.txtapellido2.value;
   mnombre=mnombre1+' '+mnombre2+' '+mapellido1+' '+mapellido2;
   if(mp_apellido=="S"){ mnombre=mapellido1+' '+mapellido2+' '+mnombre1+' '+mnombre2;  }
   mform.txtnombre.value=mnombre;
return true;}

function chequea_estado(mform){ var cod_edo;  var cod_mun; cod_edo=mform.txtestado.value;  cod_mun=mform.txtestado.value+'01';
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio_e;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad_e;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia_e;?>&cod_muni='+cod_mun, 'parro', 'innerHTML');
return true;}
function apaga_municipio(mthis){
var mcod_mun;  apagar(mthis); mcod_mun=mthis.value;}
function chequea_municipio(mform){ var mcod_mun; mcod_mun=mform.txtmunicipio.value;
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia_e;?>&cod_muni='+mcod_mun, 'parro', 'innerHTML');
return true;}
function chequea_fecha_nac(mform){ var mfecha; var mref=mform.txtfecha_nacimiento.value; var mfec; var yearn; var miFecha; var dif;
var mhoy=new Date();  var year=mhoy.getFullYear(); var mmonth=mhoy.getMonth(); var mday=mhoy.getDay(); var ano=2000; var mes; var dia; mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtfecha_nacimiento.value=mfec; mfecha=mref;}
 dia=mfecha.charAt(0)+mfecha.charAt(1); mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
 miFecha=new Date(ano,mes-1,dia);  yearn=miFecha.getFullYear(); dif=mhoy-miFecha; dif=dif/(86400000*365); dif=year-yearn;
 if(mmonth<(mes-1)){dif=dif-1;} if((mmonth==(mes-1))&&(dia>mday)){dif=dif-1;} mform.txtedad.value=dif;
return true;}
function revisar(){
var f=document.form1;
    if(f.txtcedula.value==""){alert("Cedula del Elegible no puede estar Vacio");return false;}else{f.txtcedula.value=f.txtcedula.value.toUpperCase();}
    if(f.txtnombre.value==""){alert("Nombre del Elegible no puede estar Vacia"); return false; } else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo6 {font-size: 16pt;font-weight: bold;}
-->
</style>
</head>
<body>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR INFORMACI&Oacute;N ELEGIBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="835" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="820"><table width="92" height="823" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_info_elegibles.php?Gcedula=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="Act_info_elegibles.php?Gcedula=U">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>

    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:867px; height:472px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post" action="Insert_inf_elegible.php" onSubmit="return revisar()">
          <table width="865" border="0" >
            <tr>
             <td><table width="864">
               <tr>
                 <td width="156"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="391"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                 <td width="122"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="175"><span class="Estilo5"><select name="txtnacionalidad" size="1" id="txtnacionalidad" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>VENEZOLANO</option> <option>EXTRANJERO</option> </select>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="124"><span class="Estilo5">NOMBRE COMPLETO  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="85" maxlength="100"  readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="75"><span class="Estilo5">NOMBRES :</span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre1" type="text" id="txtnombre1" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"> </span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre2" type="text" id="txtnombre2" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"> </span></td>
                 <td width="75"><span class="Estilo5">APELLIDOS :</span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido1" type="text" id="txtapellido1" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"></span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido2" type="text" id="txtapellido2" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="166"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></td>
                 <td width="200"><span class="Estilo5"><select name="txgrado_inst" size="1" id="txgrado_inst" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>PRIMARIA</option> <option>BASICO</option> <option>BACHILLER</option> <option>TECNICO MEDIO</option> <option>TECNICO SUPERIOR</option>
                      <option>UNIVERSITARIO</option>  <option>MAESTRIA</option> <option>DOCTORADO</option>  <option>NINGUNO</option>
                    </select>
                 </span></td>
                 <td width="82"><span class="Estilo5">PROFESI&Oacute;N : </span></td>
                 <td width="396"><span class="Estilo5"> <input class="Estilo10" name="txtprofesion" type="text" id="txtprofesion" size="55" maxlength="55" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">EXPERIENCIA EN A&Ntilde;OS : </span></td>
                 <td width="104"><span class="Estilo5"><input class="Estilo10" name="txttiempo" type="text" id="txttiempo" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="169"><span class="Estilo5">DISPONIBILIDAD EN DIAS : </span></td>
                 <td width="178"><span class="Estilo5"> <input class="Estilo10" name="txtdisponibilidad" type="text" id="txtdisponibilidad" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL  : </span></td>
                 <td width="136"><span class="Estilo5"> <select name="txtedo_civil" size="1" id="txtedo_civil" onFocus="encender(this)" onBlur="apagar(this)">
                    <option>SOLTERO</option> <option>CASADO</option>
                    <option>VIUDO</option> <option>DIVORCIADO</option> <option>CONCUBINO</option> <option>OTROS</option>
                  </select>
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="57"><span class="Estilo5">SEXO : </span></td>
                 <td width="228"><span class="Estilo5"> <select name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
                 <td width="161"><span class="Estilo5">FECHA DE NACIMIENTO  :</span></td>
                 <td width="189"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onchange="chequea_fecha_nac(this.form)" > </span></td>
                 <td width="75"><span class="Estilo5">EDAD : </span></td>
                 <td width="117"><span class="Estilo5"><input class="Estilo10" name="txtedad" type="text" id="txtedad" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></td>
                 <td width="695"><span class="Estilo5"><input class="Estilo10" name="txtlugar_nacimiento" type="text" id="txtlugar_nacimiento" size="85" maxlength="85"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" class="headers" onFocus="encender(this)" onBlur="apagar(this)" id="txtdireccion"></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">ESTADO :</span></td>
                 <td width="323"><span class="Estilo5"> <div id="estado"><select name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_estado(this.form)">
                    <option value="<? echo $cod_estado;?>"><? echo $estado_e;?></option></div></span></td>
<script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado_e;?>', 'estado', 'innerHTML'); </script>
                 <td width="92"><span class="Estilo5">MUNICIPIO  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="municipio"><select name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_municipio(this.form)" >
                     <option value="<? echo $cod_muni;?>"><? echo $municipio_e;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio_e;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">CIUDAD  : </span></td>
                 <td width="333"><span class="Estilo5"> <div id="ciudad"><select name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $ciudad_e;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad_e;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML'); </script>
                 <td width="92"><span class="Estilo5">PARROQUIA  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="parro"><select name="txtparroquia" id="txtparroquia" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $parroquia_e;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtmunicipio.value; ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia_e;?>&cod_muni='+cod_e, 'parro', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></td>
                 <td width="163"><span class="Estilo5"> <input class="Estilo10" name="txttelefono" type="text" id="txttelefono" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="165"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></td>
                 <td width="172"><span class="Estilo5"> <input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                 <td width="109"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                 <td width="78"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">CORREO ELECTRONICO  :</span></td>
                 <td width="308"><span class="Estilo5"> <input class="Estilo10" name="txtcorreo" type="text" id="txtcorreo" size="40" maxlength="40"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="142"><span class="Estilo5">APARTADO POSTAL  : </span></td>
                 <td width="241"><span class="Estilo5"> <input class="Estilo10" name="txtaptdo_postal" type="text" id="txtaptdo_postal" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="108"><span class="Estilo5">TALLA CAMISA  : </span></td>
                 <td width="225"><span class="Estilo5"> <input class="Estilo10" name="txttalla_camisa" type="text" id="txttalla_camisa" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="125"><span class="Estilo5">TALLA PANTALON  : </span></td>
                 <td width="129"><span class="Estilo5"> <input class="Estilo10" name="txttalla_pantalon" type="text" id="txttalla_pantalon" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="111"><span class="Estilo5">TALLA CALZADO  : </span></td>
                 <td width="138"><span class="Estilo5"><input class="Estilo10" name="txttalla_calzado" type="text" id="txttalla_calzado" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
        </table>
          <table width="864" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:860px; height:290px; z-index:2; left: 1px; top: 442px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 848;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Informaci&oacute;n Curricular";
   rows[1][2] = "Experiencia Laboral";
   rows[1][3] = "Informaci&oacute;n Familiar";
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                <!-- PESTAÑA 1 -->
                <div id="T11" class="tab-body" >
                  <iframe src="Det_inc_inf_curricular_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body">
                  <iframe src="Det_inc_exp_laboral_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 3 -->
                <div id="T13" class="tab-body">
                  <iframe src="Det_inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>
              </td>
            </tr>
          </table>
                  <div id="Layer3" style="position:absolute; width:859px; height:37px; z-index:2; left: 0px; top: 785px;">
          <table width="859">
                <tr>
                  <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
                  <td width="564">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
                  </div>
      </form> </div>
    </td>
</tr>
</table>
</body>
</html>