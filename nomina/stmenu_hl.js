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
        ["|Informacion de Elegibles","Act_info_elegibles.php", "", "", "", "", "", "", "", "", ],
        ["|Tipos de Nomina","Act_tip_nomi_ar.php", "", "", "", "", "", "", "", "", ],
        ["|Conceptos","Act_concep_ar.php", "", "", "", "", "", "", "", "", ],
		["|Formulas de Conceptos","", "", "", "", "", "", "0", "", "", ],
            ["||Calculo Nomina Ordinaria","Act_formula.php", "", "", "", "", "", "", "", "", ],
            ["||Calculo Nomina Extraordinaria","Act_formula_ex.php", "", "", "", "", "", "", "", "", ],
        ["|Cargos","Act_cargo_ar.php", "", "", "", "", "", "", "", "", ],
        ["|Departamento","Act_Departamentos.php", "", "", "", "", "", "", "", "", ],
		["|Tipos de Personal","Act_tip_perso_ar.php", "", "", "", "", "", "", "", "", ],
        ["|Ubicaciones","Act_ubi_ar.php", "", "", "", "", "", "", "", "", ],
		["|Informacion del Trabajador","Act_info_trabajadores.php", "", "", "", "", "", "", "", "", ],        
		["|Trabajadores Retirados","Act_traba_reti_ar.php", "", "", "", "", "", "", "", "", ],
        ["|Asignacion de Conceptos","Act_asig_concep_ar.php", "", "", "", "", "", "", "", "", ],
		["|Tabla de Indemnizacion","Act_tabla_indemnizacion.php", "", "", "", "", "", "", "", "", ],
        ["|Tasa de Interes Prestaciones","Act_tasa_inte_pres_ar.php", "", "", "", "", "", "", "", "", ],
		["|Consulta Disponibilidad","Consulta_dispon.php", "", "", "", "", "", "", "", "", ],
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
        ["|Movimiento de Nomina","", "", "", "", "", "", "0", "", "", ],
		    ["||Carga Manual","Act_car_manual.php", "", "", "", "", "", "", "", "", ],
            ["||Carga por Trabajador","Act_car_trabajador.php", "", "", "", "", "", "", "", "", ],
			["||Carga por Prestamo","Act_prestamo.php", "", "", "", "", "", "", "", "", ],
			["||Carga por Archivo","Act_car_arch.php", "", "", "", "", "", "", "", "", ],
        ["|+Calculo de Nomina","", "", "", "", "", "", "0", "", "", ],
		    ["||Ordinaria","Cal_nomina_ord.php", "", "", "", "", "", "", "", "", ],
            ["||Extraordinaria","Cal_nomina_ext.php", "", "", "", "", "", "", "", "", ],
        ["|Cierre de Nomina","Cierre_nomina.php", "", "", "", "", "", "", "", "", ],
        ["|Prestaciones y Liquidacion","", "", "", "", "", "", "0", "", "", ],   
		    ["||Saldo de Prestaciones","Act_saldo_prestaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Calculo de Prestaciones","Act_cal_prestaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Pago de Intereses","Act_pago_prestaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Adelanto de Prestaciones","Act_adelanto_prestaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Sueldo de Prestaciones","Act_sueldo_prestaciones.php", "", "", "", "", "", "", "", "", ],
           // ["||Liquidacion de Prestaciones","Act_liqui_pres_preli_pro.php", "", "", "", "", "", "", "", "", ],
		["|Vacaciones","", "", "", "", "", "", "0", "", "", ],            
            ["||Saldo de Vacaciones","Act_sal_vacaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Calculo de Vacaciones","Act_calculo_vacaciones.php", "", "", "", "", "", "", "", "", ],
            ["||Salida de Vacaciones","Salir_vacaciones.php", "", "", "", "", "", "", "", "", ],	
			["||Retornar de Vacaciones","Retornar_vacaciones.php", "", "", "", "", "", "", "", "", ],	
    ["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
        ["|+Catalogos","", "", "", "", "", "", "0", "", "", ],
            ["||Tipos de Nomina","/sia/nomina/rpt/Rpt_cata_tipo_nomina.php", "", "", "", "", "", "", "", "", ],
            ["||Conceptos","/sia/nomina/rpt/Rpt_cata_conceptos.php", "", "", "", "", "", "", "", "", ],
            ["||Formulas","/sia/nomina/rpt/Rpt_cata_formulas.php", "", "", "", "", "", "", "", "", ],
			["||Cargos","/sia/nomina/rpt/Rpt_cargos_cata_re.php", "", "", "", "", "", "", "", "", ],
            ["||Departamentos","/sia/nomina/rpt/Rpt_depar_cata_re.php", "", "", "", "", "", "", "", "", ],
			["||Cargos por Departamentos","/sia/nomina/rpt/Rpt_catalogo_carg_depar_cata_re.php", "", "", "", "", "", "", "", "", ],
			["||Conceptos Asignacion por Trabajador","/sia/nomina/rpt/Rpt_con_asig_trab_cata_re.php", "", "", "", "", "", "", "", "", ],
            ["||Prestamos Asignados","/sia/nomina/rpt/Rpt_pres_asig_cata_re.php", "", "", "", "", "", "", "", "", ],
            ["||Prestamos Asignado Trabajador","/sia/nomina/rpt/Rpt_pres_asig_traba_cata_re.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Nomina","", "", "", "", "", "", "0", "", "", ],
            ["||Nomina por Departamento","/sia/nomina/rpt/Rpt_nomi_depar_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion de Nomina","/sia/nomina/rpt/Rpt_rela_nomi_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion de Conceptos","/sia/nomina/rpt/Rpt_rela_concep_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Conceptos por Departamento","/sia/nomina/rpt/Rpt_concep_depart_rn_re.php", "", "", "", "", "", "", "", "", ], 
            ["||Detalles de Conceptos","/sia/nomina/rpt/Rpt_deta_concep_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Detalles de Concepto (Aportes)","/sia/nomina/rpt/Rpt_deta_concep_apor_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Detalles de Concepto (Aportes/Retencion)","/sia/nomina/rpt/Rpt_deta_concep_reten_apor_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion de Pago","/sia/nomina/rpt/Rpt_rela_pago_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Resumen Relacion de Nomina ","/sia/nomina/rpt/Rpt_resu_rela_nomi_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion Conceptos Codigos Presupuestario","/sia/nomina/rpt/Rpt_rela_con_cod_pre_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion Conceptos Codigos Presupuestario (Aportes)","/sia/nomina/rpt/Rpt_rela_con_cod_pre_apor_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Recibos de Pago","/sia/nomina/rpt/Rpt_reci_pago_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Historicos de Conceptos","/sia/nomina/rpt/Rpt_histo_concep_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Listado Historicos","/sia/nomina/rpt/Rpt_lista_histo_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Consolidado de Conceptos","/sia/nomina/rpt/Rpt_conso_conce_rn_re.php", "", "", "", "", "", "", "", "", ],            
		["|Reportes de Personal","", "", "", "", "", "", "0", "", "", ],  
            ["||Maestro de Trabajadores","/sia/nomina/rpt/Rpt_ma_traj_mp_re.php", "", "", "", "", "", "", "", "", ],
            ["||Listado de Trabajadores con Criterio","/sia/nomina/rpt/Rpt_lis_traj_cri_mp_re.php", "", "", "", "", "", "", "", "", ],
            ["||Hoja de Vida","/sia/nomina/rpt/Rpt_info_ho_vid_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Laboral","/sia/nomina/rpt/Rpt_info_labo_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Personal","/sia/nomina/rpt/Rpt_info_perso_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Asignacion de Cargos","/sia/nomina/rpt/Rpt_info_asig_carg_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Curricular","/sia/nomina/rpt/Rpt_info_curri_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Experiencia Laboral","/sia/nomina/rpt/Rpt_info_expe_labo_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Familiar","/sia/nomina/rpt/Rpt_info_fami_mp_mit_re.php", "", "", "", "", "", "", "", "", ],
            ["||Constancia de Trabajo","/sia/nomina/rpt/Rpt_cons_traba_mp_re.php", "", "", "", "", "", "", "", "", ],  
	   ["|Otros Reportes","", "", "", "", "", "", "0", "", "", ],	
		    //["||Gasto de Personal por Tipo","/sia/nomina/rpt/Rpt_gas_per_tip_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Comprobante Retencion de Pago","/sia/nomina/rpt/Rpt_com_rete_pa_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Disponibilidad Actualizada","/sia/nomina/rpt/Rpt_dispo_actu_rn_re.php", "", "", "", "", "", "", "", "", ],
            ["||Disponibilidad Diaria","/sia/nomina/rpt/Rpt_dispo_dia_rn_re.php", "", "", "", "", "", "", "", "", ],
			["||Disponibilidad Periodo","/sia/nomina/rpt/Rpt_Disponibilidad_Periodo.php", "", "", "", "", "", "", "", "", ],
			["||Compromisos","/sia/nomina/rpt/Rpt_compromisos_causar_pagar.php", "", "", "", "", "", "", "", "", ],
			["||Causados","/sia/nomina/rpt/Rpt_causados_general.php", "", "", "", "", "", "", "", "", ],
			["||Consolidado de Ejecucion","/sia/nomina/rpt/Rpt_consolidacion_ejecucion.php", "", "", "", "", "", "", "", "", ],
            ["||Modificaciones Presupuestarias","/sia/nomina/rpt/Rpt_modificaciones.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Presupuestaria","/sia/nomina/rpt/Rpt_ejecu_presup.php", "", "", "", "", "", "", "", "", ],
		["|Reportes de Elegibles","", "", "", "", "", "", "0", "", "", ],
	        ["||Maestro Elegibles","/sia/nomina/rpt/Rpt_ma_ele_me_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Personal","/sia/nomina/rpt/Rpt_info_ele_me_mi_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Curricular","/sia/nomina/rpt/Rpt_info_curri_me_mi_re.php", "", "", "", "", "", "", "", "", ],
            ["||Experiencia Laboral","/sia/nomina/rpt/Rpt_info_expe_labo_me_mi_re.php", "", "", "", "", "", "", "", "", ],
            ["||Informacion Familiar","/sia/nomina/rpt/Rpt_info_fami_me_mi_re.php", "", "", "", "", "", "", "", "", ],	
        ["|Reportes de Prestaciones","", "", "", "", "", "", "0", "", "", ],
            ["||Listado de Intereses de las Prestaciones","/sia/nomina/rpt/Rpt_list_inter_pres_mpr_re.php", "", "", "", "", "", "", "", "", ],
            ["||Listado de Sueldos de las Prestaciones","/sia/nomina/rpt/Rpt_list_suel_pres_mpr_re.php", "", "", "", "", "", "", "", "", ],
            ["||Control Individual de las Prestaciones","/sia/nomina/rpt/Rpt_con_indi_pres_mpr_re.php", "", "", "", "", "", "", "", "", ],
            ["||Control General de las Prestaciones","/sia/nomina/rpt/Rpt_con_gene_pres_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Relacion Saldo de Prestaciones e Intereses","/sia/nomina/rpt/Rpt_rela_sal_pres_inte_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Relacion de Prestaciones e Intereses por Mes","/sia/nomina/rpt/Rpt_rela_pres_inte_mes_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Relacion Dias de Sueldo a Depositar","/sia/nomina/rpt/Rpt_rela_di_suel_depo_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Listado de Movimientos de Prestaciones e Intereses","/sia/nomina/rpt/Rpt_lis_movi_pres_inte_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Comprobante de Pago e Intereses","/sia/nomina/rpt/Rpt_compro_pago_inte_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Comprobante Anticipo de Prestaciones","/sia/nomina/rpt/Rpt_compro_anti_presta_mpr_re.php", "", "", "", "", "", "", "", "", ],
         //   ["||Comprobante de Liquidacion","/sia/nomina/rpt/Rpt_compro_liqui_mpr_re.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Vacaciones","", "", "", "", "", "", "0", "", "", ],
            ["||Control de Vacaciones","/sia/nomina/rpt/Rpt_contro_vaca_mpv_re.php", "", "", "", "", "", "", "", "", ],
            ["||Trabajadores en Vacaciones","/sia/nomina/rpt/Rpt_traba_vaca_mpv_re.php", "", "", "", "", "", "", "", "", ],
            ["||Trabajadores a Derechos de Vacaciones","/sia/nomina/rpt/Rpt_traba_dere_vaca_mpv_re.php", "", "", "", "", "", "", "", "", ],
    ["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
         ["|Auditoria","/sia/nomina/Auditoria_nomina_uti.php", "", "", "", "", "", "", "", "", ],
		 ["|Archivo de Banco","", "", "", "", "", "", "0", "", "", ],
            ["||Definir Archivo Banco","Act_archivo_banco.php", "", "", "", "", "", "", "", "", ],
            ["||Generar Archivo Banco","Gen_archivo_banco.php", "", "", "", "", "", "", "", "", ],
		 ["|Generar Informacion Orden de pago","", "", "", "", "", "", "", "", "", ],
            ["||Nominas Calculadas","Gen_orden_nomina.php", "", "", "", "", "", "", "", "", ],
            ["||Aportes","Gen_orden_aporte.php", "", "", "", "", "", "", "", "", ],	
			["||Nominas con Contratos","Gen_orden_cont.php", "", "", "", "", "", "", "", "", ],
		 ["|Generar Archivo Fondo Jubilaciones","Gen_archivo_fpj.php", "", "", "", "", "", "", "", "", ],	
		 ["|Generar Archivo FAOV","Gen_archivo_faov.php", "", "", "", "", "", "", "", "", ],
		 ["|Generar Archivo ISLR","Gen_archivo_islr.php", "", "", "", "", "", "", "", "", ],
         ["|Archivo de Nomina","", "", "", "", "", "", "0", "", "", ],
            ["||Definir Archivo Nomina","Act_archivo_nomina.php", "", "", "", "", "", "", "", "", ],
            ["||Generar Archivo Nomina","Gen_archivo_nomina.php", "", "", "", "", "", "", "", "", ],
         ["|Generar Dias Prestaciones","Gen_dias_prestaciones.php", "", "", "", "", "", "", "", "", ], 
         ["|Generar Dias Adic. Prest.","Gen_dias_adic_prest.php", "", "", "", "", "", "", "", "", ], 		 
         ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ],   		
   ["Salir","salir.php", "", "", "", "", "", "", "", "", ],
];dtree_init();
