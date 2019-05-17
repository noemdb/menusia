<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL); $equipo = getenv("COMPUTERNAME");  $error=0; $fecha_hoy=asigna_fecha_hoy(); 
echo "ESPERE POR FAVOR ACTULIZANDO CODIGOS DE BIENES....","<br>"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{  $Nom_Emp=busca_conf();
  $sql="SELECT * FROM BIEN008 ORDER BY grupo_c,codigo_c"; $res=pg_query($sql); 
  while(($registro=pg_fetch_array($res)) ){ $grupo_c=$registro["grupo_c"];  $codigo_c=$registro["codigo_c"];
    $cod_presup=$registro["cod_presup"];  $cod_contable=$registro["cod_contable"];  $cod_contable_c=$registro["cod_contable_c"];
    $sqlg="update bien015 set cod_contablea='$cod_contable',cod_contabled='$cod_contable_c',cod_presup_dep='$cod_presup' where cod_clasificacion='$codigo_c'";
    $resg=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); if (!$resg){?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? }
  }
}
?><script language="JavaScript">muestra('PROCESO FINALIZADO');</script><?
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>