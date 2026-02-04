1._ para respaldar

	pg_dump  -Fp -h localhost -U postgres DATOS > respdatos21.sql
	pg_dump  -Fp -h localhost -U postgres DATOS > respdatos22.sql


2._ para restaurar

	psql -U postgres -d DATOS21 -h localhost -f respdatos21.sql
	psql -U postgres -d DATOS22 -h localhost -f respdatos22.sql


3._ COMPARAR DATOS y DATOS22 (SACAR UNA EJECUCION GENERAL DE PRESUPUESTO EN AMBAS BASES DE DATOS Y COMPARAR QUE ESTEN IGUALES)

si esta  iguales

4._ proceder a ejecutar lo siguiente:se anexan los archivos limpia1.sql, limpia2.sql y cambioprecierre.sql, copiar estos archivos en la siguiente ruta
        var\www\html\sia


	4.1._    psql -U postgres -d DATOS -h localhost -f "/var/www/html/sia/contrasan/limpia1.sql"
	4.2._    psql -U postgres -d DATOS -h localhost -f "/var/www/html/sia/contrasan/limpia2.sql"
	4.3._    psql -U postgres -d DATOS -h localhost -f "/var/www/html/sia/contrasan/cambioprecierre.sql"

5.- Reactualizar maestro en contabilidad, presupuesto , bancos e ingresos

5.1 - Marcar campo036 para realizacion del precierre ($SIA_Precierre=substr($SIA_Integrado,16,1))

    UPDATE public.sia000 SET campo036 = 'SSSSSNNNNNNNSNNNSNNN' where campo001 = '38'; 

6.- Abrir la etapa de definicion en DATOS por empresa para proceder a cargar la asignacion inicial de presupuesto.

6.1- Actualizar precierre (DATOS22 -> EMPRESA -> UTILIDADES -> ACTUALIZAR PRECIERRE (SI, NO, NO))

7.- pg_dump  -Fp -h localhost -U postgres DATOS > "/tmp/respdatos22.sql"
7.- pg_dump  -Fp -h localhost -U postgres DATOS > "/tmp/respdatos23.sql"


