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
    if (Gcod_estructura==""){alert("Código de la Cédula debe ser Seleccionada");} else {document.location = murl;}
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
<table width="978" height="470" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="464"><table width="92" height="458" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
      <div id="Layer1" style="position:absolute; width:867px; height:472px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post">
          <table width="865" border="0" >
                <tr>
                  <td width="850" height="27"><table width="836">
                    <tr>
                      <td width="137" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA IDENTIDAD :</span></div></td>
                      <td width="420" scope="col"><div align="left"><span class="Estilo5"> <span class="Estilo11"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                        <input name="txtcedula" type="text" class="Estilo5" id="txtcedula4"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                      </strong></strong></strong></strong></strong></strong></strong></strong></span> </span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="99" scope="col"><div align="left"><span class="Estilo5">NACIONALIDAD : </span></div></td>
                      <td width="160" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11"> <strong><strong><strong><strong>
                          <input name="txtnacionalidad_e" type="text" class="Estilo5" id="txtnacionalidad_e" size="20" maxlength="20" readonly>
                      </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="837">
                    <tr>
                      <td width="136" scope="col"><div align="left"><span class="Estilo5">NOMBRE TRABAJADOR :</span></div></td>
                      <td width="689" scope="col"><div align="left"><span class="Estilo5">
                        <span class="Estilo11">
                        <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                          <input name="txtnombre_e" type="text" class="Estilo5" id="txtnombre_e" size="126" maxlength="126" readonly>
                        </strong></strong></strong></strong></strong></strong></strong></strong></span>                        </span>                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
          <table width="1200" height="468" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <div id="Layer3" style="position:absolute; width:850px; height:323px; z-index:2; left: 3px; top: 55px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 848;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Información Personal";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Información Curricular";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Experiencia Laboral";        // Requiere: <div id="T13" class="tab-body">  ... </div>
   rows[1][4] = "Información Familiar";        // Requiere: <div id="T14" class="tab-body">  ... </div>
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                <!-- PESTAÑA 1 -->
                <div id="T11" class="tab-body">
                  <iframe src="Det_inf_personal.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!--PESTAÑA 2 -->
                <div id="T12" class="tab-body" >
                  <iframe src="Det_inf_curricular.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 3 -->
                <div id="T13" class="tab-body">
                  <iframe src="Det_exp_laboral.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 4 -->
                <div id="T14" class="tab-body">
                  <iframe src="Det_inf_familiar.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="812">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Submit23" type="reset" value="Blanquear"></td>
                </tr>
              </table>              
              <p>&nbsp;</p>
              </td>
            </tr>
          </table>
      </form> </div>
    </td>
</tr>
</table>
</body>
</html>