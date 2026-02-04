<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../class/imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Informaci&oacute;n del Trabajador)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
.Estilo11 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR - INFORMACIÓN DEL TRABAJADOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="493" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="487"><table width="92" height="498" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_info_traba_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_info_traba_ar.php?Gced_rif=U">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td height="424">&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>      <div id="Layer1" style="position:absolute; width:867px; height:374px; z-index:1; top: 74px; left: 115px;">
        <form name="form1" method="post">
          <table width="865" border="0" >
                <tr>
                  <td width="850" height="27"><table width="854">
                    <tr>
                      <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR:</span></div></td>
                      <td width="121" scope="col"><div align="left"><span class="Estilo5">
                          <span class="Estilo11">
                          <input name="txtcedula" type="text" class="Estilo5" id="txtcedula5"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                          </span>                        <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                      <td width="123" scope="col"><span class="Estilo5">C&Eacute;DULA IDENTIDAD :</span></td>
                      <td width="179" scope="col"><span class="Estilo5">
                      <span class="Estilo11">
                        <input name="txtcedula2" type="text" class="Estilo5" id="txtcedula6"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                      </span>                      </span></td>
                      <td width="98" scope="col"><div align="left"><span class="Estilo5">NACIONALIDAD : </span></div></td>
                      <td width="157" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo11">
                        <strong><strong><strong><strong><strong><strong>
                          <select name="select" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)">
                            <option>VENEZOLANO</option>
                            <option>EXTRANJERO</option>
                          </select>
                          </strong></strong></strong></strong></strong></strong>                      </span></strong></strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="832">
                    <tr>
                      <td width="138" scope="col"><div align="left"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></div></td>
                      <td width="682" scope="col"><div align="left"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtcedula22" type="text" class="Estilo5" id="txtcedula22"  onFocus="encender(this)" onBlur="apagar(this)" size="126" maxlength="126">
                      </span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
        </form> 
        <div id="Layer3" style="position:absolute; width:731px; height:309px; z-index:2; left: 6px; top: 67px;">
          <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 846;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Inf. Laboral";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Inf. Personal";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Hoja de Vida";        // Requiere: <div id="T13" class="tab-body">  ... </div>
   rows[1][4] = "Asig. de Cargos";        // Requiere: <div id="T14" class="tab-body">  ... </div>
   rows[1][5] = "Inf. Curricular";        // Requiere: <div id="T15" class="tab-body">  ... </div>
   rows[1][6] = "Exp. Laboral";        // Requiere: <div id="T16" class="tab-body">  ... </div>
   rows[1][7] = "Inf. Familiar";        // Requiere: <div id="T17" class="tab-body">  ... </div>
   rows[1][8] = "Conceptos";        // Requiere: <div id="T18" class="tab-body">  ... </div>
        </script>
          <?include ("../class/class_tab.php");?>
          <script type="text/javascript" language="javascript"> DrawTabs(); </script>
          <!-- PESTAÑA 1 -->
          <div id="T11" class="tab-body">
            <iframe src="Det_inf_laboral.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
          <!--PESTAÑA 2 -->
          <div id="T12" class="tab-body" >
            <iframe src="Det_inf_personal.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
          <!-- PESTAÑA 3 -->
          <div id="T13" class="tab-body">
            <iframe src="Det_hoja_vida.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
		  <!-- PESTAÑA 4 -->
          <div id="T14" class="tab-body">
            <iframe src="Det_asig_cargos.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
		  <!-- PESTAÑA 5 -->
          <div id="T15" class="tab-body">
            <iframe src="Det_inf_curricular.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
		  <!-- PESTAÑA 6 -->
          <div id="T16" class="tab-body">
            <iframe src="Det_exp_laboral.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
		  <!-- PESTAÑA 7 -->
          <div id="T17" class="tab-body">
            <iframe src="Det_inf_familiar.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
		  <!-- PESTAÑA 8 -->
          <div id="T18" class="tab-body">
            <iframe src="Det_concepto.php?criterio=<?echo $cod_estructura?>"      width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
          </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>    
      <table width="870" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="722">&nbsp;</td>
          <td width="148"><table width="118" border="0" align="left" cellpadding="0" cellspacing="0">
            <tr>
              <td width="53"><img src="../imagenes/Guardar.bmp"></td>
              <td width="55"><img src="../imagenes/Cancelar%2016.bmp"></td>
              <td width="91"><img src="../imagenes/Blanquear%2016.bmp"></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
</tr>
</table>
</body>
</html>