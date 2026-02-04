<?php include ("../class/conect.php"); include ("../class/funciones.php");$dbdatos="DATOS"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); window.close(); </script> <?php }
else{ $SIA_Cierre="N"; $SIA_Precierre="N"; $cod_modulo="06";$sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$SIA_Integrado=$registro["campo036"];$Fec_Ini_Ejer=$registro["campo031"];$Fec_Fin_Ejer=$registro["campo032"];$SIA_Precierre=substr($SIA_Integrado,16,1); $SIA_Cierre=substr($SIA_Integrado,17,1);} else{ ?><script language="JavaScript">muestra('INFORMACION DE EMPRESA NO LOCALIZADA'); window.close(); </script><?php }
if($SIA_Precierre=="S"){$SIA_Precierre="S";}else{ ?><script language="JavaScript">muestra('PREC-CIERRE DEL EJERCICIO NO EJECUTADO'); window.close(); </script><?php } 
if($SIA_Cierre=="S"){ ?><script language="JavaScript">muestra('EJERCICIO YA CERRADO'); window.close(); </script><?php } 
echo "ESPERE REGISTRANDO CIERRE....","<br>";$sSQL="UPDATE SIA000 SET campo033='99',CAMPO036=SUBSTRING(CAMPO036,1,16)||'SSNN'";
$resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
}
?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?php pg_close();?> <script language="JavaScript"> window.close();  </script>