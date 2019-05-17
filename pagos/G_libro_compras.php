<?include ("../class/seguridad.inc");?>
<?include ("../class/conects.php");  include ("../class/funciones.php");
if (!$_GET){ $mes_libro='';  $p_letra='';  $sql="SELECT * FROM PAG032 ORDER BY mes_libro";}
else {  $mes_libro = $_GET["Gmes_libro"];  $p_letra=substr($mes_libro, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$mes_libro=substr($mes_libro,1,20);}
  $sql="Select * from PAG032 where mes_libro='$mes_libro'";
  if ($p_letra=="P"){$sql="SELECT * FROM PAG032 ORDER BY mes_libro";}
  if ($p_letra=="U"){$sql="SELECT * From PAG032 Order by mes_libro Desc";}
  if ($p_letra=="S"){$sql="SELECT * From PAG032 Where (mes_libro>'$mes_libro') Order by mes_libro";}
  if ($p_letra=="A"){$sql="SELECT * From PAG032 Where (mes_libro<'$mes_libro') Order by mes_libro Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Generar Libros de Compras)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">

function Mover_Registro(MPos)
{ var murl;
   murl="Generar_libro_compras.php";
   if(MPos=="P"){murl="Generar_libro_compras.php?Gmes_libro=P"}
   if(MPos=="U"){murl="Generar_libro_compras.php?Gmes_libro=U"}
   if(MPos=="S"){murl="Generar_libro_compras.php?Gmes_libro=S"+document.form1.txtmes_libro.value;}
   if(MPos=="A"){murl="Generar_libro_compras.php?Gmes_libro=A"+document.form1.txtmes_libro.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url; var r;
  r=confirm("Esta seguro en Eliminar el Libro de Compras ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Libro de Compras ?");
    if (r==true) {url="Delete_libro_lompras.php?txtmes_libro="+document.form1.txtmes_libro.value; VentanaCentrada(url,'Eliminar Libro de Compras','','400','400','true');}
  }else { url="Cancelado, no elimino"; }
}
</script>
<script language=JavaScript src="../class/sia.js" type=text/javascript></script>
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
.Estilo6 {font-size: 16pt; font-weight: bold;}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px; font-weight: bold; color: #0000FF;}
.Estilo11 {font-size: 12px}
-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre_mes="";$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="A"){$sql="SELECT * FROM PAG032 ORDER BY mes_libro";}
  if ($p_letra=="S"){$sql="SELECT * FROM PAG032 ORDER BY mes_libro desc";}
  $res=pg_query($sql); $filas=pg_num_rows($res);
}
if($filas>0){  $registro=pg_fetch_array($res);
  $mes_libro=$registro["mes_libro"]; $ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"];   $fecha=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];
}
$clave=$mes_libro;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR LIBROS DE COMPRAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_def_bancos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_def_bancos.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=');">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
  </tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="menu.php" class="menu">Menu Principal </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post">
          <table width="856" border="0" >
                <tr>
                  <td width="850" height="14">&nbsp;</td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110"><span class="Estilo5">MES PROCESO: </span></td>
                      <td width="126"><span class="Estilo5">
                        <select name="nomb_mes" readonly>
                          <option value='01'>ENERO</option>
                          <option>FEBRERO</option>
                          <option>MARZO</option>
                          <option>ABRIL</option>
                          <option>MAYO</option>
                          <option>JUNIO</option>
                          <option>JULIO</option>
                          <option>AGOSTO</option>
                          <option>SEPTIEMBRE</option>
                          <option>OCTUBRE</option>
                          <option>NOBIEMBRE</option>
                          <option>DICIEMBRE</option>
                        </select> </span></td>
                      <td width="174"><span class="Estilo5">
                        <input name="txtced_rif222" type="text" id="$mes_libro" size="3" maxlength="3" readonly>
                      </span></td>
                      <td width="260"><span class="Estilo5">SOLO FACTURA DEL MES DE PROCESO :</span></td>
                      <td width="191"><span class="Estilo5">
                        <input name="txtsolo_fact" type="text" id="txtsolo_fact" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td><span class="Estilo5"> </span></td>
                </tr>

              </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_cons_comp_iva.php?criterio=<?echo $clave?>" width="870" height="370" scrolling="auto" frameborder="1"></iframe>
              </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>