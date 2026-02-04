<? include ("../class/conect.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PAG001".$usuario_sia.$equipo;$codigo_mov=substr($mcod_m,0,49);}
else{$codigo_mov=$_GET["codigo_mov"];$user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Retencion de IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_inc_ret_orden.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N'; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_retencion.value;  mref=Rellenarizq(mref,"0",3);    mform.txttipo_retencion.value=mref;
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txttipo_retencion.value==""){alert("Tipo de Retenecion no puede estar Vacio"); return false; }
   if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacia"); return false; } else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
   if(f.txttasa.value==""){alert("Tasa no puede estar Vacio");return false;}   
   document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;        font-weight: bold;        color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$tipo_retencion="";$descripcion_ret="";$tasa=0;$ced_rif="";$nombre="";
$sql="select * from RETENCIONES where ret_grupo='A' order by tipo_retencion";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_retencion=$registro["tipo_retencion"];   $tasa=$registro["tasa"];  $descripcion_ret=$registro["descripcion_ret"];  $ced_rif=$registro["ced_rif_ret"];  $nombre=$registro["nombre"];}
$tasa=formato_monto($tasa);
?>
<body>
<form name="form1" method="post" action="Insert_ret_iva.php" onSubmit="return revisar()">
  <table width="736" height="190" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="732" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR  RETENCIONES DE IVA EN LA ORDEN</span></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="737">
            <tr>
              <td width="112"><span class="Estilo5">TIPO RETENCI&Oacute;N:</span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);" value="<?echo $tipo_retencion?>">  </span></td>
              <td width="43"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion" onclick="VentanaCentrada('Cat_tipo_ret_iva.php?criterio=','SIA','','750','500','true')" value="..."></td>
			  <td width="497"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret" value="<?echo $descripcion_ret?>"  readonly  size="77"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="739" border="0">
            <tr>
              <td width="117"><span class="Estilo5">TASA :</span></td>
              <td width="153"><span class="Estilo5"> <input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6" style="text-align:right" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tasa?>" onKeypress="return validarNum(event)"></span> </td>
              <td width="143">&nbsp;</td>
              <td width="308"><span class="Estilo5">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="737" border="0">
            <tr>
              <td width="145"><span class="Estilo5">CED/RIF BENEFICIARIO:</span></td>
              <td width="153"><span class="Estilo5">  <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $ced_rif?>" > </span> </td>
              <td width="40"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="375"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="60" value="<?echo $nombre?>" readonly>  </span> </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>            </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="10"><input name="txtdes_orden_ret" type="hidden" id="txtdes_orden_ret" ></td>
            <td width="10"><input name="txtsustraendo" type="hidden" id="txtsustraendo" value=""></td>
            <td width="80">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
