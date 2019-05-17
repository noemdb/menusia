var TREE_NODES1={
        format:{
                left:12,
                top:65,
                width:355,
                height:532,
                e_image:"../imagenes/e2.gif",
                c_image:"../imagenes/c2.gif",
                i_image:"../imagenes/d2.gif",
                b_image:'../imagenes/b.gif',
                img_size:[16,16],
                animation: false,  // nuevo true
                anim_step: 16,    // 16 nuevo
                anim_timer: 100,  // 100 nuevo
                back_class:'clsLinkContainer',  // nuevo
                div_class:'clsNodeDIV',         // nuevo
                item_class:'clsNodeText',       // nuevo
                link_class:'clsNodeLink',       // nuevo
                table_class:'clsFullNode',      // nuevo
                level_ident: 4,                                // nuevo
                y_offset: 1,                                       // nuevo
                one_branch: true,                                // nuevo
                padding:1,
                dont_resize_back:2
        },
        sub:[
                {html:'Archivo',
                sub:[
                        {html:'Información de Elegibles',url:'Act_info_elegibles.php'},
                        {html:'Tipos de Nómina', url:'Act_tip_nomi_ar.php'},
                        {html:'Conceptos', url:'Act_concep_ar.php'},
                        {html:'Formulas de Conceptos',
                    sub:[
                            {html:'Calculo Nómina Ordinaria', url:'Act_formula.php'},
                            {html:'Calculo Nómina Extraordinaria', url:'Act_formula_ex.php'},
                                ]
                     },
                        {html:'Cargos', url:'Act_cargo_ar.php'},
                        {html:'Departamento', url:'Act_Departamentos.php'},
                        {html:'Tipos de Personal', url:'Act_tip_perso_ar.php'},
                        {html:'Ubicaciones', url:'Act_ubi_ar.php'},
                        {html:'Información del Trabajador', url:'Act_info_trabajadores.php'},
                        {html:'Trabajadores Retirados', url:'Act_traba_reti_ar.php'},
                        {html:'Asignación de Conceptos', url:'Act_asig_concep_ar.php'},
                        {html:'Tabla de Indemnización', url:'Act_tabla_indemnizacion.php'},
                        {html:'Tasa de Interes Prestaciones', url:'Act_tasa_inte_pres_ar.php'},
                        ]
                },
                {html:'Procesos',
                sub:[
                         {html:'Movimiento de Nómina',
                    sub:[
                            {html:'Carga por Manual', url:'Act_car_manual.php'},
                           // {html:'Carga por Fómula', url:'Act_car_formula.php'},
                          //  {html:'Carga por Archivo', url:'Act_car_archivo.php'},
                          //  {html:'Carga por Archivo Cédula', url:'Act_car_archi_cedula.php'},
                            {html:'Carga por Trabajador', url:'Act_car_trabajador.php'},
                            {html:'Carga por Prestamo', url:'Act_prestamo.php'},
                           ]
                     },
					    {html:'Calculo de Nómina',
                    sub:[
                            {html:'Ordinaria', url:'Cal_nomina_ord.php'},
                            {html:'Extraordinaria', url:'Cal_nomina_ext.php'},
                           ]
                     },
                        {html:'Cierre de Nómina', url:'Cierre_nomina.php'},
                        {html:'Prestaciones y Liquidación',
                    sub:[
                            {html:'Saldo de Prestaciones', url:'Act_saldo_prestaciones.php'},
                            {html:'Calculo de Prestaciones', url:'Act_cal_prestaciones.php'},
                            {html:'Pago de Intereses', url:'Act_pago_prestaciones.php'},
                            {html:'Adelanto de Prestaciones', url:'Act_adelanto_prestaciones.php'},
                            {html:'Sueldo de Prestaciones', url:'Act_sueldo_prestaciones.php'},
                            {html:'Liquidación de Prestaciones', url:'Act_liqui_pres_preli_pro.php'},
                          ]
                     },
                        {html:'Vacaciones',
                    sub:[
                          //  {html:'Carga Bono Vacacional', url:'Act_carga_bono_vaca_pro.php'},
                            {html:'Saldo de Vacaciones', url:'Act_sal_vacaciones.php'},
                            {html:'Calculo de Vacaciones', url:'Act_calculo_vacaciones.php'},
                            {html:'Salida de Vacaciones', url:'Salir_vacaciones.php'},
                            {html:'Retornar de Vacaciones', url:'Retornar_vacaciones.php'},
                         ]
                     },
                        ]
                },
				{html:'Reportes',
                sub:[
                        {html:'Menu Catalogo',
                    sub:[
                            {html:'Tipos de Nómina', url:'/sia/nomina/rpt/Catalogo_tip_nomi_cata_re.php'},
                            {html:'Conceptos', url:'/sia/nomina/rpt/Catalogo_concep_cata_re.php'},
                                {html:'Formulas de Conceptos', url:'/sia/nomina/rpt/Cat_formu_concep_cata_re.php'},
                                {html:'Cargos', url:'/sia/nomina/rpt/Rpt_cargos_cata_re.php'},
                                {html:'Departamentos', url:'/sia/nomina/rpt/Rpt_depar_cata_re.php'},
                                {html:'Cargos por Departamentos', url:'/sia/nomina/rpt/Catalogo_carg_depar_cata_re.php'},
                                {html:'Conceptos Asignación por Trabajador', url:'/sia/nomina/rpt/Rpt_con_asig_trab_cata_re.php'},
                                {html:'Prestamos Asignados', url:'/sia/nomina/rpt/Rpt_pres_asig_cata_re.php'},
                                {html:'Prestamos Asignado Trabajador', url:'/sia/nomina/rpt/Rpt_pres_asig_traba_cata_re.php'},
                                ]
                        },
                        {html:'Reportes de Nómina',
                    sub:[
                            {html:'Nómina por Departamento', url:'/sia/nomina/rpt/Rpt_nomi_depar_rn_re.php'},
                                {html:'Relación de Nómina', url:'/sia/nomina/rpt/Rpt_rela_nomi_rn_re.php'},
                                {html:'Relación de Conceptos', url:'/sia/nomina/rpt/Rpt_rela_concep_rn_re.php'},
                                {html:'Conceptos por Departamentos', url:'/sia/nomina/rpt/Rpt_concep_depart_rn_re.php'},
                                {html:'Resumen de Conceptos', url:'/sia/nomina/rpt/Rpt_resu_concep_rn_re.php'},
                                {html:'Detalles del Conceptos', url:'/sia/nomina/rpt/Rpt_deta_concep_rn_re.php'},
                                {html:'Detalles del Concepto por (Aportes)', url:'/sia/nomina/rpt/Rpt_deta_concep_apor_rn_re.php'},
                                {html:'Detalles del Concepto por (Aportes/Retención)', url:'/sia/nomina/rpt/Rpt_deta_concep_reten_apor_rn_re.php'},
                                {html:'Relación de Pago', url:'/sia/nomina/rpt/Rpt_rela_pago_rn_re.php'},
                                {html:'Resumen Relación de Nómina ', url:'/sia/nomina/rpt/Rpt_resu_rela_nomi_rn_re.php'},
                                {html:'Desglose de Nómina', url:'/sia/nomina/rpt/Rpt_desglo_nomi_rn_re.php'},
                                {html:'Relación Conceptos Códigos Presupuestario', url:'/sia/nomina/rpt/Rpt_rela_con_cod_pre_rn_re.php'},
                                {html:'Relación Conceptos Códigos Presupuestario (Aportes)', url:'/sia/nomina/rpt/Rpt_rela_con_cod_pre_apor_rn_re.php'},
                                {html:'Recibos de Pago', url:'/sia/nomina/rpt/Rpt_reci_pago_rn_re.php'},
                                {html:'Historicos de Conceptos', url:'/sia/nomina/rpt/Rpt_histo_concep_rn_re.php'},
                                {html:'Listado Historicos', url:'/sia/nomina/rpt/Rpt_lista_histo_rn_re.php'},
                                {html:'Consolidado de Conceptos', url:'/sia/nomina/rpt/Rpt_conso_conce_rn_re.php'},
                                {html:'Gasto de Personal por Tipo', url:'/sia/nomina/rpt/Rpt_gas_per_tip_rn_re.php'},
                                {html:'Comprobante Retención de Pago', url:'/sia/nomina/rpt/Rpt_com_rete_pa_rn_re.php'},
                                {html:'Disponibilidad Actualizada', url:'/sia/nomina/rpt/Rpt_dispo_actu_rn_re.php'},
                                {html:'Disponibilidad Diaria', url:'/sia/nomina/rpt/Rpt_dispo_dia_rn_re.php'},
                                ]
                        },
                        {html:'Reportes de Elegibles',
                     sub:[
                             {html:'Maestro Elegibles', url:'/sia/nomina/rpt/Rpt_ma_ele_me_re.php'},
                             {html:'Información de Elegibles',
                         sub:[
                                 {html:'Información Personal', url:'/sia/nomina/rpt/Rpt_info_ele_me_mi_re.php'},
                             {html:'Información Curricular', url:'/sia/nomina/rpt/Rpt_info_curri_me_mi_re.php'},
                                         {html:'Experiencia Laboral', url:'/sia/nomina/rpt/Rpt_info_expe_labo_me_mi_re.php'},
                                         {html:'Información Familiar', url:'/sia/nomina/rpt/Rpt_info_fami_me_mi_re.php'},
                                     ]
                              },
                                 ]
                          },
                         {html:'Reportes de Personal',
                      sub:[
                              {html:'Maestro de Trabajadores', url:'/sia/nomina/rpt/Rpt_ma_traj_mp_re.php'},
                                  {html:'Listado de Trabajadores con Criterio', url:'/sia/nomina/rpt/Rpt_lis_traj_cri_mp_re.php'},
                          {html:'Hoja de Vida', url:'/sia/nomina/rpt/Rpt_ho_vida_mp_re.php'},
                              {html:'Información del Personal',
                           sub:[
                                   {html:'Información Laboral', url:'/sia/nomina/rpt/Rpt_info_labo_mp_mit_re.php'},
                               	   {html:'Información Personal', url:'/sia/nomina/rpt/Rpt_info_perso_mp_mit_re.php'},
                                   {html:'Información Hoja de vida', url:'/sia/nomina/rpt/Rpt_info_ho_vid_mp_mit_re.php'},
                                   {html:'Información Asignación de Cargos', url:'/sia/nomina/rpt/Rpt_info_asig_carg_mp_mit_re.php'},
                                   {html:'Información Curricular', url:'/sia/nomina/rpt/Rpt_info_curri_mp_mit_re.php'},
                                   {html:'Información Experiencia Laboral', url:'/sia/nomina/rpt/Rpt_info_expe_labo_mp_mit_re.php'},
                                   {html:'Información Familiar', url:'/sia/nomina/rpt/Rpt_info_fami_mp_mit_re.php'},
                                       ]
                                  },
                                {html:'Constancia de Trabajo', url:'/sia/nomina/rpt/Rpt_cons_traba_mp_re.php'},
                                ]
                        },
                    {html:'Reportes de Prestaciones',
                     sub:[
                             {html:'Listado de Intereses de las Prestaciones', url:'/sia/nomina/rpt/Rpt_list_inter_pres_mpr_re.php'},
                                 {html:'Listado de Sueldos de las Prestaciones', url:'/sia/nomina/rpt/Rpt_list_suel_pres_mpr_re.php'},
                                 {html:'Control Individual de las Prestaciones', url:'/sia/nomina/rpt/Rpt_con_indi_pres_mpr_re.php'},
                                 {html:'Control General de las Prestaciones', url:'/sia/nomina/rpt/Rpt_con_gene_pres_mpr_re.php'},
                                 {html:'Relación Saldo de Prestaciones e Intereses', url:'/sia/nomina/rpt/Rpt_rela_sal_pres_inte_mpr_re.php'},
                                 {html:'Relación de Prestaciones e Intereses por Mes', url:'/sia/nomina/rpt/Rpt_rela_pres_inte_mes_mpr_re.php'},
                                 {html:'Relación Dias de Sueldo a Depositar', url:'/sia/nomina/rpt/Rpt_rela_di_suel_depo_mpr_re.php'},
                                 {html:'Listado de Movimientos de Prestaciones e Intereses', url:'/sia/nomina/rpt/Rpt_lis_movi_pres_inte_mpr_re.php'},
                                 {html:'Comprobante de Pago e Intereses', url:'/sia/nomina/rpt/Rpt_compro_pago_inte_mpr_re.php'},
                                 {html:'Comprobante Anticipo de Prestaciones', url:'/sia/nomina/rpt/Rpt_compro_anti_presta_mpr_re.php'},
                                 {html:'Comprobante de Liquidación', url:'/sia/nomina/rpt/Rpt_compro_liqui_mpr_re.php'},
                                 ]
                         },
                 {html:'Reportes de Vacaciones',
                      sub:[
                              {html:'Control de Vacaciones', url:'/sia/nomina/rpt/Rpt_contro_vaca_mpv_re.php'},
                                  {html:'Comprobante de Vacaciones', url:'/sia/nomina/rpt/Rpt_compro_vaca_mpv_re.php'},
                                  {html:'Trabajadores en Vacaciones', url:'/sia/nomina/rpt/Rpt_traba_vaca_mpv_re.php'},
                                  {html:'Relación dias de Vacaciones', url:'/sia/nomina/rpt/Rpt_rela_dia_vaca_mpv_re.php'},
                                  {html:'Trabajadores a Derechos de Vacaciones', url:'/sia/nomina/rpt/Rpt_traba_dere_vaca_mpv_re.php'},
                                  ]
                          },
                        {html:'Reportes Definidos por el Usuario', url:'/sia/nomina/rpt/Rpt_Definido_Usuario.php'},
                 ]
                },               
           {html:'Utilidades',
            sub:[
                    {html:'Auditoria', url:'/sia/nomina/Auditoria_nomina_uti.php'},
                    {html:'Archivo de Banco',
                     sub:[
                             {html:'Definir Archivo Banco', url:'/sia/nomina/Act_archivo_banco.php'},
                              {html:'Generar Archivo Banco', url:'/sia/nomina/Gen_archivo_banco.php'},
                         ]
                    },
                    {html:'Genera Información de Pago',
                      sub:[
                              {html:'Nóminas Calculadas', url:'/sia/nomina/Gen_orden_nomina.php'},
                              {html:'Aportes', url:'/sia/nomina/Gen_orden_aporte.php'},
                         //     {html:'Nómina por Departamentos', url:'/sia/nomina/Act_nom_dep_uti.php'}
                          ]
                    },
                        // {html:'Genera Archivo Fondo de jubilaciones', url:'#'},
                         //{html:'Genera Archivo Ley de Politica', url:'/#'},
                         {html:'Archivo de Trabajadores',
                     sub:[
                             {html:'Definir Archivos de Trabajadores', url:'#'},
                             {html:'Generar Archivos del Trabajador', url:'#'},
                         ]
                    },
                    {html:'Archivo de Nómina',
                     sub:[
                             {html:'Definir Archivos de Nómina', url:'#'},
                             {html:'Generar Archivos de Nómina', url:'#'},
                          ]
                    },
                    {html:'Archivo de Prestaciones',
                     sub:[
                             {html:'Definir Archivos de Prestaciones', url:'#'},
                             {html:'Generar Archivos de Prestaciones', url:'#'},
                         ]
                    },
                    {html:'Cambio de Clave', url:'Cambio_clave.php'},
                  //  {html:'Asignar Nómina a Usuario', url:'/sia/nomina/Asig_tipo_nomi_usuario_uti.php'},
                  //  {html:'Seleccionar Nómina Actual', url:'/sia/nomina/Seleccionar_nomi_actual_uti.php'},
              ]
        },{html:'Salir', url:'salir.php'}
        ]
}

