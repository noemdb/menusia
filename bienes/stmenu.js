/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.2
   http://deluxe-menu.com
*/


// -- Deluxe Tuner Style Names
var tstylesNames=["Top Item",];
var tXPStylesNames=[];
// -- End of Deluxe Tuner Style Names

//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=0;
var tcloseExpanded=0;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="_self";
var titemCursor="pointer";
var statusString="link";
var tblankImage="../imagenes/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="250px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=1;
var tleft="15px";
var ttop="60px";

//--- Font
var tfontStyle="normal 10pt Arial";
var tfontColor=["#3F3D3D","#7E7C7C"]; tfontColor=["#000066","#0033FF"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="#E0E0E0";  tmenuBackColor="#FFFFFF";
var tmenuBackImage="back1.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=2;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=26;
var titemBackColor=["",""];
var titemBackImage=["../imagenes/blank.gif","../imagenes/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["../imagenes/expandbtn2.gif","../imagenes/expandbtn2.gif","../imagenes/collapsebtn2.gif"];
var texpandBtnW=15;
var texpandBtnH=15;
var texpandBtnAlign="left";

//--- Lines
var tpoints=1;
var tpointsImage="../imagenes/hpoint.gif";
var tpointsVImage="../imagenes/vpoint.gif";
var tpointsCImage="../imagenes/cpoint.gif";
var tpointsBImage="../imagenes/bpoint.gif";

//--- Floatable Menu
var tfloatable=1;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="#AA0000";
var tmoveImage="";

//--- XP-Style
var tXPStyle=0;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPAlign="left";
var tXPTitleBackColor="#AFB1C3";
var tXPTitleBackImg="../imagenes/xptitle_s.gif";
var tXPTitleLeft="../imagenes/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=31;
var tXPIconHeight=32;
var tXPMenuSpace=10;
var tXPExpandBtn=["../imagenes/xpexpand1_s.gif","../imagenes/xpexpand1_s.gif","../imagenes/xpcollapse1_s.gif","../imagenes/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Advanced
var tdynamic=0;
var tajax=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontDecoration=none,none"],
];
var tXPStyles = [];
var tmenuItems = [
     ["Archivo","", "", "", "", "Menu Archivos", "", "0", "", "", ],
        ["|Dependencias","Act_dependencias_ar.php", "", "", "", "", "", "", "", "", ],
		["|Direcciones","Act_direcciones_ar.php", "", "", "", "", "", "", "", "", ],
		["|Departamentos","Act_departamentos_ar.php", "", "", "", "", "", "", "", "", ],
		["|Responsables","", "", "", "", "", "", "", "", "", ],
			["||Primario","Act_primario_ar_resp.php", "", "", "", "", "", "", "", "", ],
			["||Verificador","Act_verificador_ar_resp.php", "", "", "", "", "", "", "", "", ],
			["||De Uso","Act_de_uso_ar_resp.php", "", "", "", "", "", "", "", "", ],
			["||Rotulador","Act_rotulador_ar_resp.php", "", "", "", "", "", "", "", "", ],
		["|Clasificacion de Bienes","Act_clasifi_bienes_ar.php", "", "", "", "", "", "", "", "", ],
		["|Descripcion de Bienes","Act_descrip_bienes_ar.php", "", "", "", "", "", "", "", "", ],
		["|Definicion de Color","Act_defini_colores_ar.php", "", "", "", "", "", "", "", "", ],
		["|Definicion de Material","Act_defini_materiales_ar.php", "", "", "", "", "", "", "", "", ],
        ["|Tipo de movimientos","Act_tipos_movimi_ar.php", "", "", "", "", "", "", "", "", ],
		["|Estado de Conservacion","Act_edo_conservacion_ar.php", "", "", "", "", "", "", "", "", ],
		["|Situacion Legal del Bien","Act_situ_legal_bien_ar.php", "", "", "", "", "", "", "", "", ],
		["|Situacion Contable del Bien","Act_situ_contable_bien_ar.php", "", "", "", "", "", "", "", "", ],
		["|Metodos de Rotulacion","Act_meto_rotulacion_ar.php", "", "", "", "", "", "", "", "", ],        
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
		["|Menu de Fichas","", "", "", "", "", "", "", "", "", ],
			["||Muebles","Act_fichas_bienes_muebles_pro.php", "", "", "", "", "", "", "", "", ],
			["||Inmueble","Act_ficha_bienes_inmuebles_pro.php", "", "", "", "", "", "", "", "", ],
		["|Desincorporacion de Bienes","", "", "", "", "", "", "", "", "", ],
			["||Bienes Mueble por Correccion","Act_desin_bienes_muebles_correccion.php", "", "", "", "", "", "", "", "", ],
            ["||Bienes Mueble","Act_bienes_muebles_pro_desin_bie.php", "", "", "", "", "", "", "", "", ],			
		["|Menu Movimientos","", "", "", "", "", "", "", "", "", ],
			["||Bienes Muebles","Act_bienes_muebles_pro_movi_conta.php", "", "", "", "", "", "", "", "", ],
			["||Bienes Inmuebles","Act_bienes_inmuebles_pro_movi_conta.php", "", "", "", "", "", "", "", "", ],
        ["|Menu de Transferencias","", "", "", "", "", "", "", "", "", ],
			["||Bienes Mueble","Act_bienes_muebles_pro_trasn_bie.php", "", "", "", "", "", "", "", "", ],		 			
		["|Orden de Salida Bienes Muebles","Act_orden_salida_bienes_muebles_pro.php", "", "", "", "", "", "", "", "", ],
		["|Menu Depreciacion","", "", "", "", "", "", "", "", "", ],
			["||Bienes Muebles","Act_bienes_muebles_pro_depre_act.php", "", "", "", "", "", "", "", "", ],	
            //["||Bienes Inmuebles","Act_bienes_inmuebles_pro_depre_act.php", "", "", "", "", "", "", "", "", ],						
    ["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
        ["|+Catalogos","", "", "", "", "", "", "0", "", "", ],
            ["||Dependencia","../bienes/rpt/Rpt_depen_repor_cata.php", "", "", "", "", "", "", "", "", ],
            ["||Dependencia, Dierecciones","../bienes/rpt/Rpt_depen_direc_depar_repor_cata.php", "", "", "", "", "", "", "", "", ],
            ["||Resp. Primarios","../bienes/rpt/Rpt_resp_pri_repor_cata.php", "", "", "", "", "", "", "", "", ],
            ["||Resp. Verificadores","../bienes/rpt/Rpt_resp_veri_repor_cata.php", "", "", "", "", "", "", "", "", ],
	        ["||Resp. de Uso","../bienes/rpt/Rpt_resp_uso_repor_cata.php", "", "", "", "", "", "", "", "", ],
	        ["||Resp. Rotulador","../bienes/rpt/Rpt_resp_rotu_repor_cata.php", "", "", "", "", "", "", "", "", ],
			["||Tipos de Movimientos","javascript:window.open('../bienes/rpt/Rpt_tipo_movi_repor_cata.php','Reporte Tipos de Movimientos');", "", "", "", "", "", "", "", "", ],
			["||Estado de Conservacion","javascript:window.open('../bienes/rpt/Rpt_esta_conser_repor_cata.php','Reporte Estado de Conservacion');", "", "", "", "", "", "", "", "", ],
	        ["||Situacion Legal del Bien","javascript:window.open('../bienes/rpt/Rpt_situ_legal_bien_repor_cata.php','Reporte Situacion Legal del Bien');", "", "", "", "", "", "", "", "", ],
	        ["||Situacion Contable del Bien","javascript:window.open('../bienes/rpt/Rpt_situ_conta_bien_repor_cata.php','Reporte Situacion Contable del Bien');", "", "", "", "", "", "", "", "", ],
	        ["||Metodos de Rotulacion","javascript:window.open('../bienes/rpt/Rpt_meto_rotu_repor_cata.php','Reporte Metodos de Rotulacion');", "", "", "", "", "", "", "", "", ],
        ["|Menu de Bienes Muebles","", "", "", "", "", "", "0", "", "", ],
            ["||Listado de Bienes Muebles","../bienes/rpt/Rpt_lista_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Listado de Bienes Muebles por Proveedores","../bienes/rpt/Rpt_lista_bie_mue_proveedor_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Inventario de Bienes Muebles","../bienes/rpt/Rpt_inve_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Ficha de Bien Mueble","../bienes/rpt/Rpt_ficha_bie_mue_mo3_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Resumen Ficha de Bien Mueble","../bienes/rpt/Rpt_resumen_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Etiquetas de Bienes Muebles","../bienes/rpt/Rpt_eti_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Movimientos de Bienes Muebles","../bienes/rpt/Rpt_movi_bie_mue_mov_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Bienes Muebles Faltantes","../bienes/rpt/Rpt_lista_bie_mue_faltantes_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
			["||Resumen de la Cuenta de Bienes Muebles","../bienes/rpt/Rpt_res_cuenta_bienes_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Depreciacion de Bienes Muebles","../bienes/rpt/Rpt_depre_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            //["||Ficha del Bien Mueble Depreciado","../bienes/rpt/Rpt_fi_bie_mue_depre_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
           //["||Listado de Bienes Muebles sin Movimiento","../bienes/rpt/Rpt_lista_bie_mue_sin_movi_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
            ["||Depreciacion Acumulada Mensual","../bienes/rpt/Rpt_lista_bie_mue_depre_acu_mensual_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],           
	        ["||Listado de Transferencia de Bienes Muebles","../bienes/rpt/Rpt_lista_trans_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
           // ["||Listado de Orden de Salida de Bienes Muebles","../bienes/rpt/Rpt_lista_or_sali_bie_mue_repor_bie_mue.php", "", "", "", "", "", "", "", "", ],
			["||Listado Componentes de Bienes Muebles","../bienes/rpt/Rpt_lista_comp_bie_mue.php", "", "", "", "", "", "", "", "", ],
			["||Listado Incorporaciones de Bienes Muebles","../bienes/rpt/Rpt_lista_incor_bie_mue.php", "", "", "", "", "", "", "", "", ],
			//INI nmdb 28-02-2018 - rboza
			["||Listado Descorporaciones de Bienes Muebles","/sia/bienes/rpt/Rpt_lista_descor_bie_mue.php", "", "", "", "", "", "", "", "", ],
			//FIN nmdb 28-02-2018 - rboza
        ["|Menu de Bienes Inmuebles","", "", "", "", "", "", "0", "", "", ],
            ["||Listado de Bienes Inmuebles","../bienes/rpt/Rpt_lista_bie_inmu_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
            ["||Inventario de Bienes Inmuebles","../bienes/rpt/Rpt_inve_bie_inmu_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
            ["||Fichas de Bienes Inmuebles","../bienes/rpt/Rpt_ficha_bie_inmu_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
            ["||Movimientos de Bienes Inmuebles","../bienes/rpt/Rpt_movi_bie_inmu_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
           // ["||Depreciacion de Bienes Inmuebles","../bienes/rpt/Rpt_depre_bie_inmu_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
           // ["||Listado de Bienes Inmuebles sin Movimiento","../bienes/rpt/Rpt_lista_bie_inmu_sin_movi_repor_bie_inmu.php", "", "", "", "", "", "", "", "", ],
  ["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
      ["|Auditoria","Auditoria_bienes.php", "", "", "", "", "", "", "", "", ],
      ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ], 
   ["Salir","salir.php", "", "", "", "", "", "", "", "", ],


];dtree_init();
