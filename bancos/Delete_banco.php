<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$cod_banco=$_GET["txtcod_banco"];$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;  $sSQL="Select * from ban002 WHERE cod_banco='$cod_banco'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE BANCO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $anombre=$registro["nombre_banco"]; $saldo_ant_libro=$registro["s_inic_libro"]; $saldo_ant_banco=$registro["s_inic_banco"]; $error=0;
     if(($saldo_ant_libro>0)||($saldo_ant_banco>0)){$error=1; ?>  <script language="JavaScript">  muestra('BANCO TIENE SALDOS INICIALES');  </script> <? }
     if($error==0){ $sSQL="Select * from ban004 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE BANCO TIENE MOV. LIBROS');  </script> <? }
     }
     if($error==0){ $sSQL="Select * from ban005 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE BANCO TIENE MOV. BANCOS');  </script> <? }
     }
     if($error==0){ $sSQL="Select * from ban007 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO BANCO TIENE MOV. TRANS. LIBROS');  </script> <? }
     }
     if($error==0){ $sSQL="Select * from ban008 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO BANCO TIENE MOV. TRANS. BANCOS');  </script> <? }
     }
     if($error==0){ $sSQL="Select * from pag008 WHERE cod_banco_t='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('CODIGO BANCO TIENE TIPO ORDENES ASOCIADA');  </script> <? }
     }
     if($error==0){ $sSQL="SELECT ACTUALIZA_ban002(4,'$cod_banco','','','','','','','00000000','00000000','N','','S','','$sfecha','$sfecha',0,0,'','',0,0,'$minf_usuario')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
         $desc_doc="DEFINICION DE BANCO, CODIGO:".$cod_banco.", NOMBRE:".$anombre;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");  $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }} }
  }
}pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>