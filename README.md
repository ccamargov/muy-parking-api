
<p align="center"><img src="https://i.postimg.cc/yYvPqBSt/logo-muynuevo.jpg" width="200"></p>

## Descripción

Este proyecto es un componente backend (API), encargado de exponer recursos REST, los cuales permiten administrar el ingreso y salida de vehículos dentro del parqueadero "MuyParking". Los servicios expuestos en este API permiten gestionar información de: Vehículos, propietarios, planes, contratos y tickets (Facturación). Este ejercicio se ha desarrollado con el objetivo de avanzar en el proceso de selección dentro del cual me encuentro participando, gracias a la oportunidad brindada por MUY.

## Especificaciones técnicas

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

- **Lenguaje de programación:** PHP 7.2.19
- **Framework:** Laravel Framework 6.5.1
- **Database:** MySQL
- **Gestor de versiones - Fuentes:** Git
- **Herramienta de versionamiento remota:** GitHub
- **Herramienta de gestión de requerimientos:** Trello
- **URL Trello:** https://trello.com/b/BJWoljPU/muy-prueba-t%C3%A9cnica
- **Metodología:** Agile - Scrum (Carriles estándar).
- **Ambiente de desarrollo:** Laragon.
- **Herramienta para pruebas funcionales:** Postman
- **Herramienta para documentación de APIs:** Postman
- **Herramienta de diagramación:** Draw.io

## Listado de APIs expuestas:
```
| 1 | POST | api/v1/ticket-entrance       | ticket.entrance                 | api,auth:api |
| 2 | POST | api/v1/ticket-departure      | ticket.departure                | api,auth:api |
| 3 | POST | api/v1/parking-contract      | parking.contract                | api,auth:api |
| 4 | GET  | api/v1/pending-balance       | ticket.pending_balance          | api,auth:api |
| 5 | PUT  | ticket-payment               | ticket-payment                  | api,auth:api |
```
Listado de parámetros de entrada (Usar como referencia el número de la primera columna de la tabla anterior):

### Documentación API REST
La documentación de los recursos REST expuestos se encuentra cenrtalizada en la colección postman incluida dentro de este repositorio, en la ruta **docs/PostmanCollections**. En esta ruta se encuentran dos archivos, **MUY ParkingAPI.postman_collection.json** corresponde a la colección con las peticiones REST previamente configuradas, y el archivo **MuyCollectionEnvironment.postman_environment.json** contiene las variables de entorno para facilitar el manejo de la colección (Tales como: URL API, API_KEY, etc).

## Modelo de datos

<p align="center"><img src="https://i.postimg.cc/Wbbyq5mR/MUY-Entity-Relation-BDModel-V1-2.jpg"></p>

## Consideraciones técnicas
### Configuración del ambiente para ejecutar la aplicación

1. Instalar Laragon (O el ambiente de desarrollo que prefiera).
2. Instalar Composer (Si el ambiente no lo tiene incluido).
3. Instalar laravel desde la terminal:
```
composer global require "laravel/installer"
```
4. Dentro de la carpeta www del servidor o ambiente que haya configurado, clonar este repositorio.
```
git clone https://github.com/ccamargov/muy-parking-api.git
```
5. Ingresar a la carpeta del aplicativo e instalar dependencias
```
composer install
```
6. Ingresar a la consola de MySQL mediante el terminal
```
mysql -u root
```
7. Configuración inicial de BD. En este repositorio, en la ruta **database/custom-sql-dumps**, se encuentra un archivo con extensión .SQL, el cual contiene los scripts necesarios para crear el usuario y la base de datos, con sus respectivos privilegios.

10. Ejecutar migraciones de base de datos
```
php artisan migrate
```
11. Ejecutar DUMP / Populado automático de datos.
Considerando que se utilizó el framework de **Laravel** para la construcción del aplicativo, se empleó el uso de **FACTORYS** y **SEEDS** para el llenado automático de las bases de datos. El comando es:
```
php artisan db:seed
```
12. Ejecución de pruebas unitarias (Es posible que se deban actualizar algunos valores dummy alohados allí. Considerando que la data que se ingresa se genera de manera automática y cambia por ejecución):
```
vendor\bin\phpunit
```
13. Validación de APIs expuestas:
```
php artisan route:list
```
## Consideraciones finales
Para la correcta conclusión de la evaluación se utilizó **TRELLO** para organizar todas y cada una de las actividades necesarias para concluir con el proyecto, tareas comprendidas entre: Análisis, diseño, desarrollo, documentación. Los invito a ingresar al [tablero](https://trello.com/b/BJWoljPU/muy-prueba-t%C3%A9cnica), se encuentra público. Allí podrán encontrar detalle de mis actividades, material adjunto que utilicé para organizar los recursos, de esta forma podrán evaluar también mi método de trabajo en temas no técnicos.

Para el versionamiento del código se utilizó el método GitFlow base, el cual comprende el manejo de las siguientes ramas base:

- master: Rama con el códiguo productivo, cuyas funcionalidades han sido certificadas en etapas previas.
- test: Rama con el código en evaluación, cuyas funcionalidades se encuentran en validación y testing, para luego pasar a la rama productiva (test->master).
- develop: Rama con el código en desarrollo centralizado, allí desembocan todos los feature que se vayan desarrollando, para luego disponerlos en la rama de test para la ejecución de pruebas funcionales.
- feature/[xxx]: Ramas que descienden de develop, las cuales tienen un propósito específico (eg. feature/api_inventory, etc). En esta rama, se empleó el prefijo huxxx para asociar las ramas a su respectiva tarea en Jira. Adicional a esto, en trello se encuentran relacionadas cada una de las ramas y pull request correspondientes.

<p align="center"><img src="https://i.postimg.cc/59Phgc29/trello1.png"></p>

El modelo de integración de cambios se basa en el uso de **PULL REQUESTS** de manera ascendente, de tal forma que, la rama featre/[xxx] llegará en algún momento a la rama master, pasando por las ramas intermedias develop y test. Los pull request se utilizan para validar el código a integrar. TODO PULL REQUEST está relacionado en una tarea puntual en TRELLO (Integración de tecnologías).

**Nota: Recomiendo revisar detenidamente los PRs generados hacia la rama DEVELOP, pues en estos se encuentran todas las evidencias de: Pruebas unitarias, Pruebas desde postman, Pruebas desde base de datos.**

Dentro de este repositorio, se han dejado todas las ramas empleadas para al conclusión de este proyecto, con el objetivo de manejar un histórico de ramas de tal forma que la evaluación sea más sencilla.

Por otro lado, se implementó un sistema de seguridad básico con el método **api_token**. Se agregó un campo api_token en el modelo de datos BASE de laravel denominado users, y luego se configuró un proxy para controlar el consumo de las APIs. Este parámetro siempre debe enviarse dentro de cada una de las peticiones, de lo contrario las APIs responderá con código **401 Unauthorized**. PAra evitar inconvenientes de tipo de contenido, es recomendable consumir las APIs incluyendo los siguientes HEADERS:

- Content-Type: application/json
- Accept: application/json

La arquitectura utilizada es la que el framework presenta por defecto, haciendo énfasis en el uso de los siguientes componentes:

- **routes/api.php:** Definición de todas las rutas asociadas a las APIs generadas. Aquí está incluido el filtro de validación de API_KEY.
- **database/migrations:** Creación de tablas, inserción de campos, validación de campos, inclusión de constraints, definición de llaves foráneas, etc.
- **database/factories:** Definición de factorías mediante la librería **Faker** de PHP, para la inserción automática de datos para cada modelo.
- **database/seeds:** Definición de algoritmos para implemetnar las factorias configuradas. Aquí se ejecuta la populación de data sobre la BD.
- **tests/Feature:** Definición de todas las pruebas unitarias a ejecutar, para validar la ingridad de las APIs. Se encuentran agrupadas por modelo.
- **.env:** Definición de variables de entorno asociadas a la configuración del ambiente sobre el que será desplegado el aplicativo. Definición de datos de conexión a BD, nombre de aplicación, etc.
- **app/Http/Resources:** Definición de clases de naturaleza JsonResource, encargadas de dar forma a la salida de algunos objetos anidados, como respuestas de algunas APIs (No se emplea para todos los casos, pues hay consultas más complejas que manejan su propio output).
- **app/Http/Controllers:** Definición de clases controladoras. Allí se definen los métodos asociados en el archivo de rutas para las APIs creadas. Cada método cuenta con validación. Esta clase invoca la configuración efectuada en los Resources (JsonResources).
- **app/Models:** Definición de clases con el modelo de datos de cada objeto creado en la base de datos. Allí se definen querys avanzados para consultar información, se configura la asociación entre modelos, etc.
- **app/UseCases:** Con el objetivo de desacoplar el código, e impulsar el principio **Single Responsibility Principle (SRP)** y **clean architecture**, se generaron archivos puntuales para cada caso de uso, con la lógica necesaria para la transacción asociada a cada recurso expuesto. Esta es una capa intermedia entre el controller y el model.

TODO EL CÓDIGO ESTÁ DOCUMENTADO, CON DISTINTAS CLASES DE COMENTARIOS LOS CUALES FACILITAN EL DESARROLLO Y ENTENDIMIENTO DEL CÓDIGO.

**Nota: Se utilizó como insumo inicial el documento README.md brindado por MUY para el entendimiento de la prueba. A partir de esta información, se hizo un análisis y se generaron un total de 7 historias de usuario, cuyo detalle podrán encontrar en el tablero de trello.**

## Agradecimientos
A MUY por haberme brindado la oportunidad de presentar esta evaluación, con el objetivo de avanzar en el proceso de selección y así buscar entrar en el equipo de trabajo de la empresa.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
