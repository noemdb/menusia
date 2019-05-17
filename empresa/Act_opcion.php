<?php include ("../class/conect.php"); include ("../class/funciones.php");
$opcion=$_GET["opcion"]; $criterio=$_GET["modulo"]; $copcion=$_GET["des_opcion"];
$modulo=substr($criterio, 0, 2); $login=substr($criterio, 2, 15); $cmodulo="";
if($modulo=='01'){$cmodulo="ORDENAMINETO DE PAGOS";}
if($modulo=='02'){$cmodulo="CONTROL BANCARIO";}
if($modulo=='03'){$cmodulo="CONTABILIDAD FINANCIERA";}
if($modulo=='04'){$cmodulo="NOMINA Y PERSONAL";}
if($modulo=='05'){$cmodulo="CONTABILIDAD PRESUPUESTARIA";}
if($modulo=='06'){$cmodulo="CONTABILIDAD FINANCIERA";}
if($modulo=='07'){$cmodulo="PRESUPUESTO DE INGRESO";}
if($modulo=='09'){$cmodulo="COMPRAS,SERVICIOS Y ALMACEN";}
if($modulo=='13'){$cmodulo="CONTROL DE BIENES NACIONALES";}
$nombre="";$nder1="";$der1="";$nder2="";$der2="";$nder3="";$der3="";$nder4="";$der4="";
$nder5="";$der5=""; $nder6="";$der6="";$nder7=""; $der7="";$nder8="";$der8="";
$nder9="";$der9="";$nder10="";$der10="";$nder11="";$der11="";$nder12="";$der12=""; $disponible="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sql="Select * from sia001 WHERE campo101='$login'";  $res=pg_query($sql);
  if ($registro=pg_fetch_array($res,0)){$nombre=$registro["campo104"];}
  $sql="SELECT campo701,campo702,campo703,campo704,campo705,campo706,campo707,campo708,campo709,campo710,campo711,campo712,campo713,campo714,campo715,campo716,campo717,campo718,campo719,campo720,campo721,campo722,campo723,campo724,campo725,campo607,campo608,campo609,campo610,campo611,campo612,campo613,campo614,campo615,campo616,campo617,campo618,campo619,campo620,campo621,campo622,campo623,campo624,campo625,campo626,campo706,campo707,campo708,campo709,campo710,campo711,campo712,campo713,campo714,campo715,campo716,campo717,campo718,campo719,campo720,campo721,campo722,campo723,campo724,campo725  FROM sia007 LEFT JOIN sia006 ON (sia006.campo602=sia007.campo701) And (sia006.campo603=sia007.campo702)  And (sia006.campo601 ='$login') Where (sia007.campo701='$modulo') And (sia007.campo702 ='$opcion') Order By sia007.campo702";   $res=pg_query($sql);
  //echo $sql;
  if ($registro=pg_fetch_array($res,0)){
     if($registro["campo706"]!=""){$nder1=$registro["campo706"];$disponible=$disponible."S";} else {$nder1="";$der1="";$disponible=$disponible."N";}
     if($registro["campo607"]=="S"){$der1="S";} else {$der1="N";}
     if($registro["campo707"]!=""){$nder2=$registro["campo707"];$disponible=$disponible."S";} else {$nder2="";$der2="";$disponible=$disponible."N";}
     if($registro["campo608"]=="S"){$der2="S";} else {$der2="N";}
     if($registro["campo708"]!=""){$nder3=$registro["campo708"];$disponible=$disponible."S";} else {$nder3="";$der3="";$disponible=$disponible."N";}
     if($registro["campo609"]=="S"){$der3="S";} else {$der3="N";}
     if($registro["campo709"]!=""){$nder4=$registro["campo709"];$disponible=$disponible."S";} else {$nder4="";$der4="";$disponible=$disponible."N";}
     if($registro["campo610"]=="S"){$der4="S";} else {$der4="N";}
     if($registro["campo710"]!=""){$nder5=$registro["campo710"];$disponible=$disponible."S";} else {$nder5="";$der5="";$disponible=$disponible."N";}
     if($registro["campo611"]=="S"){$der5="S";} else {$der5="N";}
     if($registro["campo711"]!=""){$nder6=$registro["campo711"];$disponible=$disponible."S";} else {$nder6="";$der6="";$disponible=$disponible."N";}
     if($registro["campo612"]=="S"){$der6="S";} else {$der6="N";}
     if($registro["campo712"]!=""){$nder7=$registro["campo712"];$disponible=$disponible."S";} else {$nder7="";$der7="";$disponible=$disponible."N";}
     if($registro["campo613"]=="S"){$der7="S";} else {$der7="N";}
     if($registro["campo713"]!=""){$nder8=$registro["campo713"];$disponible=$disponible."S";} else {$nder8="";$der8="";$disponible=$disponible."N";}
     if($registro["campo614"]=="S"){$der8="S";} else {$der8="N";}
     if($registro["campo714"]!=""){$nder9=$registro["campo714"];$disponible=$disponible."S";} else {$nder9="";$der9="";$disponible=$disponible."N";}
     if($registro["campo615"]=="S"){$der9="S";} else {$der9="N";}
     if($registro["campo715"]!=""){$nder10=$registro["campo715"];$disponible=$disponible."S";} else {$nder10="";$der10="";$disponible=$disponible."N";}
     if($registro["campo616"]=="S"){$der10="S";} else {$der10="N";}
     if($registro["campo716"]!=""){$nder11=$registro["campo716"];$disponible=$disponible."S";} else {$nder11="";$der11="";$disponible=$disponible."N";}
     if($registro["campo617"]=="S"){$der11="S";} else {$der11="N";}
      if($registro["campo717"]!=""){$nder12=$registro["campo717"];$disponible=$disponible."S";} else {$nder12="";$der12="";$disponible=$disponible."N";}
     if($registro["campo618"]=="S"){$der12="S";} else {$der12="N";}
  }
 }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Cuentas de Usuarios)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llama_grabar(mcodigo,modu,disponible){var url;var derecho;
 derecho="";
 if(disponible.charAt(0)=="S"){if(document.form1.checkbox1.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(1)=="S"){if(document.form1.checkbox2.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(2)=="S"){if(document.form1.checkbox3.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(3)=="S"){if(document.form1.checkbox4.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(4)=="S"){if(document.form1.checkbox5.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(5)=="S"){if(document.form1.checkbox6.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(6)=="S"){if(document.form1.checkbox7.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(7)=="S"){if(document.form1.checkbox8.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(8)=="S"){if(document.form1.checkbox9.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(9)=="S"){if(document.form1.checkbox10.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(10)=="S"){if(document.form1.checkbox11.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 if(disponible.charAt(11)=="S"){if(document.form1.checkbox12.checked==true){derecho=derecho+"S";}else{derecho=derecho+"N";}}
  else{derecho=derecho+"N";}
 derecho=derecho+"NNNNNNNN";
 url="Update_Opcion.php?opcion="+mcodigo+"&modulo="+modu+"&derecho="+derecho;
 document.location = url;
}
function llamar_anterior(){ document.location ='Det_acceso.php?modulo=<?echo $criterio?>'; }
function asigna_todos(disponible){
 if(disponible.charAt(0)=="S"){document.form1.checkbox1.checked=true;}
 if(disponible.charAt(1)=="S"){document.form1.checkbox2.checked=true;}
 if(disponible.charAt(2)=="S"){document.form1.checkbox3.checked=true;}
 if(disponible.charAt(3)=="S"){document.form1.checkbox4.checked=true;}
 if(disponible.charAt(4)=="S"){document.form1.checkbox5.checked=true;}
 if(disponible.charAt(5)=="S"){document.form1.checkbox6.checked=true;}
 if(disponible.charAt(6)=="S"){document.form1.checkbox7.checked=true;}
 if(disponible.charAt(7)=="S"){document.form1.checkbox8.checked=true;}
 if(disponible.charAt(8)=="S"){document.form1.checkbox9.checked=true;}
 if(disponible.charAt(9)=="S"){document.form1.checkbox10.checked=true;}
 if(disponible.charAt(10)=="S"){document.form1.checkbox11.checked=true;}
 if(disponible.charAt(11)=="S"){document.form1.checkbox12.checked=true;}
}
function quita_todos(disponible){
 if(disponible.charAt(0)=="S"){document.form1.checkbox1.checked=false;}
 if(disponible.charAt(1)=="S"){document.form1.checkbox2.checked=false;}
 if(disponible.charAt(2)=="S"){document.form1.checkbox3.checked=false;}
 if(disponible.charAt(3)=="S"){document.form1.checkbox4.checked=false;}
 if(disponible.charAt(4)=="S"){document.form1.checkbox5.checked=false;}
 if(disponible.charAt(5)=="S"){document.form1.checkbox6.checked=false;}
 if(disponible.charAt(6)=="S"){document.form1.checkbox7.checked=false;}
 if(disponible.charAt(7)=="S"){document.form1.checkbox8.checked=false;}
 if(disponible.charAt(8)=="S"){document.form1.checkbox9.checked=false;}
 if(disponible.charAt(9)=="S"){document.form1.checkbox10.checked=false;}
 if(disponible.charAt(10)=="S"){document.form1.checkbox11.checked=false;}
 if(disponible.charAt(11)=="S"){document.form1.checkbox12.checked=false;}
}
function llama_mostrar(mcodigo,modu){var url; var mdes_modulo; var mdes_opcion;
  mdes_modulo=document.form1.txtModulo.value; mdes_opcion=document.form1.txtopcion.value;
  url="Mostrar_usuarios_Opcion.php?opcion="+mcodigo+"&modulo="+modu+"&des_modulo="+mdes_modulo+"&des_opcion="+mdes_opcion;
  VentanaCentrada(url,'Anular Orden','','1000','500','true');
}
</script>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">

</head>
<body>
<form name="form1" method="post" action="Update_Opcion.php" onSubmit="return revisar()">
  <table width="744" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="26" align="center" bgcolor="#003399"><span class="Estilo2 Estilo6">ACTUALIZAR OPCION DE ACCESO</span></td>
        </tr>
        <tr>
          <td><table width="739" border="0">
              <tr>
                <td width="708"><span class="Estilo5">NOMBRE USUARIO  :
                      <input name="txtNombre" type="text" id="txtNombre" value="<?echo $nombre?>" class="Estilo5" size="71" readonly>
                </span></td>
                </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="739" border="0">
              <tr>
                <td width="708"><span class="Estilo5">MODULO :
                    <input name="txtModulo" type="text" id="txtModulo" value="<?echo $cmodulo?>" class="Estilo5" size="80" maxlength="250" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="739" border="0">
                <tr>
                  <td width="708"><span class="Estilo5">OPCION :
                      <input name="txtopcion" type="text" id="txtopcion" value="<?echo $copcion?>" class="Estilo5" size="82" readonly>
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><table width="733" border="1" cellspacing="0" cellpadding="0">
            <tr>
               <? if($nder1==""){ ?> <td width="180">&nbsp;</td>
               <? } else{ if($der1=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox1" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder1; ?></span> </td>
                <? } ?>
                        <? if($nder4==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der4=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox4" type="checkbox" id="checkbox4" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder4; ?></span> </td>
                <? } ?>
                        <? if($nder7==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der7=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox7" type="checkbox" id="checkbox7" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder7; ?></span> </td>
                <? } ?>
                        <? if($nder10==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der10=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox10" type="checkbox" id="checkbox10" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder10; ?></span> </td>
                <? } ?>
            </tr>
            <tr>
            <? if($nder2==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der2=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox2" type="checkbox" id="checkbox2" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder2; ?></span> </td>
                <? } ?>
             <? if($nder5==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der5=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox5" type="checkbox" id="checkbox5" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder5; ?></span> </td>
                <? } ?>
                        <? if($nder8==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der8=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox8" type="checkbox" id="checkbox8" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder8; ?></span> </td>
                <? } ?>
             <? if($nder11==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der11=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox11" type="checkbox" id="checkbox11" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder11; ?></span> </td>
                <? } ?>
            </tr>
            <tr>
            <? if($nder3==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der3=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox3" type="checkbox" id="checkbox3" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder3; ?></span> </td>
                <? } ?>
            <? if($nder6==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der6=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox6" type="checkbox" id="checkbox6" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder6; ?></span> </td>
                <? } ?>
                    <? if($nder9==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der9=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox9" type="checkbox" id="checkbox9" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder9; ?></span> </td>
                <? } ?>
                        <? if($nder12==""){ ?> <td width="180">&nbsp;</td>
                        <? } else{ if($der12=="S"){$nchk='checked';}else{$nchk='';} ?>
              <td width="180"><input class="Estilo5" name="checkbox12" type="checkbox" id="checkbox12" value="checkbox" <? echo $nchk; ?>>
                <span class="Estilo5"><? echo $nder12; ?></span> </td>
                <? } ?>
          </table>          </td>
        </tr>
                <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="110" align="center"><input name="btgrabar" type="button" id="btgrabar"  value="Grabar" onClick="JavaScript:llama_grabar('<? echo $opcion;?>','<? echo $criterio;?>','<? echo $disponible ?>')"></td>
            <td width="110" align="center"><input name="btcancelar" type="button" id="btcancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="110" align="center"><input name="bttodos" type="button" id="bttodos" value="Todos" onClick="JavaScript:asigna_todos('<? echo $disponible ?>')"></td>
            <td width="110" align="center"><input name="btquitar" type="button" id="btquitar" value="Quitar" onClick="JavaScript:quita_todos('<? echo $disponible ?>')"></td>
			<td width="100" align="center"><input name="btgrabar" type="button" id="btgrabar"  value="Mostrar Usuarios" onClick="JavaScript:llama_mostrar('<? echo $opcion;?>','<? echo $criterio;?>')"></td>
            
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?
  pg_close();
?>