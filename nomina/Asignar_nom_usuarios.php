<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  $posicion=strpos($Mcamino,'S'); $criterio="";
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $codigo_mov=""; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Asignar Nominas a Usuarios)</title>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function Cargar_tipos_nominas(mform){ var mref;
   mref=mform.txtLogin.value;
   ajaxSenddoc('GET', 'carganomusu.php?criterio='+mref+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ASIGNAR NOMINAS A USUARIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="520" border="1" id="tablacuerpo">
  <tr>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:945px; height:491px; z-index:1; top: 71px; left: 20px;">
        <form name="form1" method="post">
          <table width="922" border="0" >
                <tr>
                  <td><table width="920">
                        <tr>
                          <td width="130"><p><span class="Estilo5">USUARIO:</span></p></td>
                          <td width="130"><input class="Estilo10" name="txtLogin" type="text"  id="txtLogin" size="20" onFocus="encender(this); " onBlur="apagar(this);"></td>
                          <td width="40"><span class="Estilo5"><input class="Estilo10" name="btcat_prog" type="button" id="btcat_prog" title="Abrir Catalogo de Categorias Programaticas" onClick="VentanaCentrada('../empresa/Cat_usuarios.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                          <td width="620"><input class="Estilo10" name="txtNombre" type="text"  id="txtNombre" size="75" readonly></td>

                        </tr>

                  </table></td>
                </tr>
                <tr>
                  <td><table width="920">
                    <tr>
                      <td width="720">&nbsp;</td>
                      <td width="200"><span class="Estilo5"> <input type="button" name="btcarga_ret" value="Cargar Nomina" title="Cargar Nominas Asignadas al Usuario" onClick="javascript:Cargar_tipos_nominas(this.form)" > </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>

              <div id="T11" class="tab-body">
              <iframe src="Det_nom_usuarios.php?criterio=<?echo $criterio?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table>
        <table width="923">
          <tr>
            <td width="626"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="139"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="142" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>