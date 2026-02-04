<?php include ("../class/ventana.php");?>
<?php include ("../class/fun_fechas.php");
 if (!$_GET){   $equipo = getenv("COMPUTERNAME");   $mcod_m = "BIEN026".$equipo;  $codigo_mov=substr($mcod_m,0,49);}
 else{$codigo_mov=$_GET["codigo_mov"];} $fecha_hoy=asigna_fecha_hoy();$nro_aut=$_POST["txtnro_aut"]; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Movimientos Bienes Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
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
function checkreferencia(mform){
var mref;
   mref=mform.txtreferencia.value;
   mref = Rellenarizq(mref,"0",8);
   mform.txtreferencia.value=mref;
return true;}
function checkrefecha(mform){
var mref;
var mfec;
  mref=mform.txtfecha.value;
  mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha.value=mfec;}
return true;}
function checkorden(mform){
var mref;
   mref=mform.txtnro_orden.value;
   mref = Rellenarizq(mref,"0",8);
   mform.txtnro_orden.value=mref;
return true;}
function revisar(){
var f=document.form1;
        if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacia");return false;}else{f.txtreferencia.value=f.txtreferencia.value;}
        if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}else{f.txtfecha.value=f.txtfecha.value;}
        if(f.txtcod_dependencia_e.value==""){alert("Dependencia no puede estar Vacia");return false;}else{f.txtcod_dependencia_e.value=f.txtcod_dependencia_e.value;}
        if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value;}
document.form1.submit;
return true;}

</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR MOVIMIENTOS DE BIENES SEMOVIENTES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="700" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="95" height="700"><table width="95" height="700" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_semovientes_pro_movi_conta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_semovientes_pro_movi_conta.php">Atras</A></td>
      </tr>

      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 77px; left: 133px;">
            <form name="form1" method="post" action="Insert_bienes_semovientes_pro_movi_conta.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="962">
              <tr>
                                          <td width="106">
                          <p><span class="Estilo5">N&Uacute;MERO REFERENCIA:</span></p></td>
                      <td width="147"><span class="Estilo5"> <div id="refaju">
                            <?php  if($nro_aut=='S'){?>
                              <input name="txtreferencia" type="text"  id="txtreferencia" size="8" maxlength="8" readonly class="Estilo5">
                            <?php }else{?>
                             <input name="txtreferencia" type="text"  id="txtreferencia" size="8" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo5"   onchange="checkreferencia(this.form);">
                            <?php }?>
                             </div>
                           <script language="JavaScript" type="text/JavaScript">
                            ajaxSenddoc('GET', 'refmovisemoaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refaju', 'innerHTML');
                          </script></td>
                <td width="90" scope="col"><span class="Estilo5">FECHA DEL MOVIMIENTO :</span></td>
                <td width="653" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?php echo $fecha_hoy?>">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td><table width="821">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia_e" type="text" id="txtcod_dependencia_e" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="5" maxlength="4">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_dependencias_ed.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="575" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dependencia_e" type="text" id="txtdenominacion_dependencia_e" size="68" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="91" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="859" scope="col"><div align="left">
                    <textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtdescripcion"></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 140px;">
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
                <iframe src="Det_inc_bienes_semo_movimientos.php?&codigo_mov=<?php echo $codigo_mov?>"  width="846" height="380" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_comp_semo_movimientos.php?codigo_mov=<?php echo $codigo_mov?>"  width="846" height="380" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>

        <div id="Layer3" style="position:absolute; width:868px; height:25px; z-index:3; left: 2px; top: 500px;">
        <table width="812" height="200">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="50"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td> 
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
