<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $nro_aut="N";
$equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN027".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_comp="ED001";
$fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $port=$_POST["txtport"]; $host=$_POST["txthost"];
$codigo_mov=$_POST["txtcodigo_mov"]; $cod_dep=$_POST["txtcod_dep"]; $nom_dep=$_POST["txtnom_dep"]; 
$formato_bien=$_POST["txtformato_bien"]; $long_num_bien=$_POST["txtlong_num_bien"];
$fec_fin_e=$_POST["txtfecha_fin"]; $Cod_Emp=$_POST["txtcod_emp"]; $ced_rif_emp=$_POST["txtced_rif_emp"];
$fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Depreciacion Bienes Inmuebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
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
</script>
<script language="JavaScript" type="text/JavaScript">

var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mnro_aut='<?php echo $nro_aut ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mced_rif_emp='<?php echo $ced_rif_emp ?>';
var patronfecha = new Array(2,2,4);
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia.value;  mref = Rellenarizq(mref,"0",8);   mform.txtreferencia.value=mref; return true;
}   
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
function revisar(){var f=document.form1; var r; var valido;
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacia");return false;}else{f.txtreferencia.value=f.txtreferencia.value;}
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}else{f.txtfecha.value=f.txtfecha.value;}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value;}
	r=confirm("Desea Grabar la Depreciacion de Bienes Mueble ?");  if (r==true) { valido=true;} else{return false;} 		
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DEPRECIACION DE BIENES INMUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="600" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="600" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="600"><table width="94" height="600" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=U">Atras</A></td>
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
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 77px; left: 133px;">
            <form name="form1" method="post" action="Insert_bienes_inmuebles_pro_depre_act.php" onSubmit="return revisar()">
		
        <table width="848" border="0" align="center">   
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="170"><span class="Estilo5">REFERENCIA DEPRECIACION:</span></td>
                 <td width="115"><div id="refmov"><input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" class="Estilo5"> </div> </td>
                 <td width="145"><span class="Estilo5">FECHA DEPRECIACION:</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="165"><span class="Estilo5">CALCULAR DEPRECIACION:</span></td>
				 <td width="130"><span class="Estilo5"><select name="txtmet_calculo"> <option value="M">MENSUAL</option><option value="A">ANUAL</option> </select> </span> </td>               
               </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript"> 
		        ajaxSenddoc('GET', 'refdepaut.php?nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refmov', 'innerHTML');
		   </script>		   
	       <tr>
            <td><table width="845">
              <tr>
                <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="720"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdescripcion"></textarea>    </div></td>
              </tr>
            </table></td>
          </tr>          
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 120px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Causado Presupuestario";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_bienes_inmu_depreciacion.php?&codigo_mov=<?echo $codigo_mov?>"  width="846" height="350" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_comp_inmu_depreciacion.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="350" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <div id="T13" class="tab-body" >
                <iframe src="Det_inc_causado_depreciacion.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="350" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>

        <div id="Layer3" style="position:absolute; width:868px; height:25px; z-index:3; left: 2px; top: 450px;">
        <table width="812" height="200">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="50"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td> 
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
