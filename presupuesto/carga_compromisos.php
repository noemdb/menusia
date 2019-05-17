<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>COMPROMISOS PRESUPUESTARIOS </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo1 {
        color: #FF0000;
        font-weight: bold;
}
.Estilo2 {color: #FFFFFF}
.Estilo3 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo4"><label></label>COMPROMISOS PRESUPUESTARIOS</p>
<p>&nbsp;</p>
<table width="981" border="1" cellspacing="1" cellpadding="0">
  <tr bgcolor="#FF0000">
    <td width="100" bgcolor="#0033FF"><div align="center" class="Estilo1 Estilo2">Referencia</div></td>
    <td width="100" bgcolor="#0000FF"><div align="center" class="Estilo3">Tipo</div></td>
    <td width="100" bgcolor="#0000FF"><div align="center" class="Estilo3">Fecha</div></td>
    <td width="200" bgcolor="#0000FF"><div align="center" class="Estilo3">Códgo</div></td>
    <td width="200" bgcolor="#0000FF"><div align="center" class="Estilo3">Monto</div></td>
  </tr>
<?php

 include ("../class/funciones.php");
 $nograbada="";  
 $conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=YACAMBU");
 if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
 $ult_ref="00005000"; $fecha="2014-01-27"; $tipo="0003"; $cod_fuente="07"; $cod_tipo_comp="000000"; $aprobado="S"; $clave=""; $num_proyecto="0000000000"; 
 $usuario_sia="CARGA POR LOTES";  $equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
 
 $path="liqui.csv"; $fp = fopen($path,"r");
 while ($linea= fgets($fp,1024)) { 
    $datos = explode(";", $linea); 
    $ult_ref=$ult_ref+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;	
	$cedula=elimina_puntos($datos[2]); $ced_rif="V".$cedula;
	$nombre=$datos[4];
	$sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){ 	
	    $temp1=$ced_rif;
		$temp2=$nombre;
		$temp3=$cedula;
		$temp4="";
		$temp5="";
		$temp6="";
		$temp7="Natural";
		$temp8=$ced_rif;
		$temp9=$nombre;
		$temp10="";
		$temp11="";
		$temp12="";
		$temp13="LARA";
		$temp14="VENEZUELA";
		$temp15="";
		$temp16="";
		$temp17="";
		$temp18="";
		$temp19="VENEZOLANO";
		$temp20="SI";
		$temp21="";
		$temp22="";
		$temp23="";
		$temp24="";
		$temp25="";
		$temp26=$fecha;
		$temp27="";
		$temp28=$minf_usuario;
		
		$temp2=str_replace("Á","A",$temp2);
		$temp2=str_replace("É","E",$temp2);
		$temp2=str_replace("Í","I",$temp2);	
		$temp2=str_replace("Ó","O",$temp2);
		$temp2=str_replace("Ú","U",$temp2);
		$temp2=str_replace("'","",$temp2);
		$temp2=str_replace("°","o",$temp2);
		$temp2=str_replace("Nº","No",$temp2);
		$temp2=str_replace("Nª","No",$temp2);		
		$temp2=str_replace("'","",$temp2);
		$temp9=str_replace("'","",$temp9);		
		$temp23=str_replace("Á","A",$temp23);
		$temp23=str_replace("É","E",$temp23);
		$temp23=str_replace("Í","I",$temp23);	
		$temp23=str_replace("Ó","O",$temp23);
		$temp23=str_replace("Ú","U",$temp23);
		$temp23=str_replace("'","",$temp23);
		$temp23=str_replace("°","o",$temp23);
		$temp23=str_replace("Nº","No",$temp23);
		$temp23=str_replace("Nª","No",$temp23);		
		$temp23=str_replace("'","",$temp23);		
		$temp9=str_replace("Á","A",$temp9);
		$temp9=str_replace("É","E",$temp9);
		$temp9=str_replace("Í","I",$temp9);	
		$temp9=str_replace("Ó","O",$temp9);
		$temp9=str_replace("Ú","U",$temp9);
		$temp9=str_replace("'","",$temp9);
		$temp9=str_replace("°","o",$temp9);
		$temp9=str_replace("Nº","No",$temp9);
		$temp9=str_replace("Nª","No",$temp9);		
		$temp6=str_replace("Á","A",$temp6);
		$temp6=str_replace("É","E",$temp6);
		$temp6=str_replace("Í","I",$temp6);	
		$temp6=str_replace("Ó","O",$temp6);
		$temp6=str_replace("Ú","U",$temp6);
		$temp6=str_replace("'","",$temp6);
		$temp6=str_replace("°","o",$temp6);
		$temp6=str_replace("Nº","No",$temp6);
		$temp6=str_replace("Nª","No",$temp6);		
		$sql="SELECT ACTUALIZA_PRE099(1,'$temp1','$temp2','$temp3','$temp4','$temp5','$temp6','$temp7','$temp8','$temp9','$temp10','$temp11','$temp12','$temp13','$temp14','$temp15','$temp16','$temp17','$temp18','$temp19','$temp20','$temp21','$temp22','$temp23','$temp24','$temp25','$temp26','$temp27','','','','','',0,0,'$temp28')";
		$resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ $nograbada=$nograbada.$sql.";<br>"; }
	}
	$monto=elimina_puntos($datos[7]); 	$monto=cambia_coma_numero($monto);		
    $temp1=$ult_ref;
    $temp2=$tipo;
    $temp3=$datos[6];
    $temp4=$cod_fuente;
    $temp5=$fecha;
    $temp6=$cod_tipo_comp;
    $temp7=$temp1;
    $temp8=$num_proyecto;
    $temp9=$fecha;
    $temp10=$datos[4];
    $temp11="";
    $temp12="";
    $temp13=$datos[5];
    $temp14="N";
    $temp15="N";
    $temp16=$fecha;
    $temp17=$datos[1];
    $temp18=$ced_rif;
    $temp19=$monto;
    $temp20=0;
    $temp21=0;
    $temp22=0;
    $temp23=$fecha;
    $temp24="N";
    $temp26=0;
    $temp27="M";
    $temp28=$fecha;
    $temp29="C";
    $temp30="P";
    $temp31="00000000";
    $temp32=0;
    $temp33="N";
    $temp34="";
    $temp35="N";
    $temp36="";
    $temp37=0;
    $temp38=0;
    $temp39=0;
    $temp40="P";
    $temp41="P";
    $temp42=$aprobado;
    $temp43="";
    $temp44=$minf_usuario;
    $temp25=$temp10.$temp11;
    $temp45=$temp2;
    if($temp29=="F"){$temp29="C";}
    if($temp30=="" or $temp30==" "){$temp30="P";$temp31="00000000";}
    if ($temp45=="0000"){if ($temp19<0){$temp2="A000"; $temp45="A000";}}
    $temp=$temp1.$temp2.$temp45.$temp5;
    //echo $temp;
    if($clave==$temp) {
      $ssql = "INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) VALUES ('".$temp1."','".$temp2."','".$temp45."','".$temp5."','".$temp3."','".$temp4."','".$temp30."','".$temp31."',".$temp19.",0,0,0,".$temp32.")";
      $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){ $nograbada=$nograbada.$ssql.";<br>"; }
    }
    else {
      $clave=$temp;
      $sql="INSERT INTO PRE006 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_tipo_comp,ref_aep,num_proyecto,fecha_aep,tipo_documento,nro_documento,diferido,anulado,fecha_anu,unidad_sol,ced_rif,fecha_vencim,pago_periodico,cantidad_pago,frecuencia,fecha_prim_pago,func_inv,genera_comprobante,cod_con_g_pagar,tiene_anticipo,cod_con_anticipo,monto_anticipo,tasa_anticipo,amort_anticipo,tipo_anticipo,modulo,aprobado,status,nro_expediente,inf_usuario,descripcion_comp) VALUES ('".$temp1."','".$temp2."','".$temp45."','".$temp5."','".$temp6."','".$temp7."','".$temp8."','".$temp9."','".$temp12."','".$temp13."','".$temp14."','".$temp15."','".$temp16."','".$temp17."','".$temp18."','".$temp23."','".$temp24."',".$temp26.",'".$temp27."','".$temp28."','".$temp29."','".$temp33."','".$temp34."','".$temp35."','".$temp36."',".$temp37.",".$temp38.",".$temp39.",'".$temp40."','".$temp41."','".$temp42."','','".$temp43."','".$temp44."','".$temp25."')" ;
      $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){ $nograbada=$nograbada.$sql.";<br>"; }
      $ssql = "INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) VALUES ('".$temp1."','".$temp2."','".$temp45."','".$temp5."','".$temp3."','".$temp4."','".$temp30."','".$temp31."',".$temp19.",0,0,0,".$temp32.")";
      $resultado=pg_exec($conn,$ssql);	 $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){ $nograbada=$nograbada.$ssql.";<br>"; } 
	  //echo $sql."<br>";
    }
  ?>
  <tr>
    <td align="left"><?php echo($temp1);?></td>
    <td><?php echo($temp2);?></td>
    <td><?php echo($temp5);?></td>
    <td><?php echo($temp3);?></td>
    <td><?php echo($temp19);?></td>
  </tr>
  <?php
  }  
 ECHO " ","<br>";
 ECHO "SQL NO REGISTRADOS","<br>";
 ECHO $nograbada;
?>
</table>
</body>
</html>