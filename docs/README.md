# Prueba Técnica - Programador (Back-end)
La siguiente es una prueba para evaluar a los postulantes a programador **Back-end** en MUY.

## INTRODUCCIÓN
Este documento contiene una serie de requerimientos de un Caso Práctico (API), que busca evaluar las capacidades técnicas del candidato con respecto a las principales funciones y responsabilidades que se requieren dentro del área de Desarrollo de Tecnología de _MUY_.

#### ¿Qué se busca evaluar?
Principalmente los siguientes aspectos:
* Creatividad para resolver los requerimientos,
* Calidad del código entregado (estructura y buenas prácticas),
* Eficiencia de los algoritmos entregados,
* Familiaridad con Frameworks y plataformas de desarrollo.

## IMPORTANTE
1. Recomendamos emplear un máximo de **2 (dos) días** y enviar todo lo que puedas.
2. Se requiere de una cuenta de **GitHub**, **GitLab** o **Bitbucket** para realizar este ejercicio.
3. **Antes de comenzar a programar:**
    * Crear un repositorio en alguna de las mencionadas plataformas
    * Clonar el repositorio a su máquina local
6. **Al finalizar**, existen 2 (dos) opciones para entregar su proyecto:
    * 1) Realizar un `Commit` final de su proyecto, subir los cambios con todas las ramas creadas, y notificar a la siguiente dirección de correo electrónico  [lmiranda@muy.co](mailto:lmiranda@muy.co).
    * 2) Crear un archivo comprimido (_.zip_ o _.rar_) de su proyecto y enviar a la siguiente dirección de correo electrónico  [lmiranda@muy.co](mailto:lmiranda@muy.co).

## EJERCICIOS

### Ejercicio #
Se desea administrar el acceso de vehículos a un estacionamiento de pago. El estacionamiento no se encuentra automatizado, por lo que existe un empleado encargado de registrar las entradas y salidas de vehículos.

Los vehículos se identifican por su número de placa. Cuando un vehículo entra en el estacionamiento el empleado registra su entrada y al salir registra su salida y, en algunos casos, cobra el importe correspondiente por el tiempo de estacionamiento.

El importe cobrado depende del tipo de vehículo:
* Los vehículos VIP no pagan, pero se registran sus estancias para llevar el control.
(Una estancia consiste en una hora de entrada y una de salida)
* Los residentes pagan a final de mes a razón de COP$50,000 el mes, se registran sus estancias para llevar el control.
* **Bonus**: Los residentes postpago pagan a final de mes a razón de COP$30 el minuto. La aplicación irá acumulando el tiempo (en minutos) que han permanecido estacionados.
* Los no residentes pagan a la salida del estacionamiento a razón de $50 por minuto.
* Se prevé que en el futuro puedan cambiar las tarifas.
* **Bonus**: En un futuro se pueden llegar a incluir nuevos tipos de vehículos, por lo que será preferible que la aplicación desarrollada sea fácilmente extensible en ese aspecto.

La aplicación contará con un programa principal basado en un menú que permitirá al empleado interactuar con la aplicación (dicho programa principal no forma parte de este ejercicio, es decir, se evaluará unicamente el backend).


##### Casos de uso

A continuación se describen los casos de uso. No se entra en detalles de la interacción entre el empleado y la aplicación (punto 1 de cada caso de uso), puesto que no va a ser tarea de este ejercicio desarrollar esa parte.

###### **Caso de uso "Registra entrada"**
1. El empleado elige la opción "registrar entrada" e introduce el número de placa del coche que entra.
2. La aplicación apunta la hora de entrada del vehículo.

###### **Caso de uso "Registra salida"**
1. El empleado elige la opción "registrar salida" e introduce el número de placa del coche que sale.
2. La aplicación realiza las acciones correspondientes al tipo de vehículo:
    * VIP: asocia la estancia (hora de entrada y hora de salida) con el vehículo
    * Residente: suma la duración de la estancia al tiempo total acumulado
    * No residente: obtiene el importe a pagar

###### **Caso de uso "Ingresar o dar de alta vehículo residente"**
1. El empleado elige la opción "Nuevo vehículo residente", introduce su número de placa y selecciona el tipo de vehiculo (VIP, residente, etc).
2. La aplicación añade el vehículo a la lista de vehículos de residentes.
3. La aplicación registra el día actual como fecha de corte para el vehiculo.

###### **Caso de uso "Informe Pagos de residentes"**
1. El empleado elige la opción "genera informe de pagos de residentes".
2. La aplicación genera un archivo (csv o excel) que detalla el tiempo estacionado, el tipo de vehiculo y el dinero a pagar por cada uno de los vehículos de residentes. El formato del archivo será el mostrado a continuación:

| Núm. placa | Tipo | Tiempo estacionado (min.) | Cantidad a pagar |
|------------|------------------|--------------:|-------:|
| SAS123     | No Residente     |  20134        | 100670 |
| JQK456     | Residente Fijo   |   4896        |  50000 |
| LMN237     | VIP              |   7836        |      0 |
| ...        | .....            | .....         | ...    |

###### **Caso de uso "Pagos de residentes"**
1. El empleado elige la opción "realizar pagos de residentes" e ingresará la placa del vehiculo
2. La aplicación mostrará el importe adeudado
3. El empleado registrará el pago del vehiculo correspondiente

##### Persistencia de datos
La información de cada una de las estancias de los vehículos será almacenada en una base de datos.

##### Puntos que se deben desarrollar
* API para gestionar las estancias de los vehículos. Deberá incluir:
    * Código de las clases que permitan gestionar los vehículos con sus datos asociados (estancias, tiempo, etc.), las listas de vehículos registrados como oficiales y residentes, etc.
    * Mapeo de las clases para poder almacenar la información en la base de datos.
    * Clases para gestionar la persistencia de datos, incluida la configuración de conexión a la base de datos.

##### Consideraciones.
* El lenguaje con el cual se desarrollará la API será a elección del postulante.
* El uso del framework será también a elección del postulante.
* Se pueden usar las librerías que el postulante considere, (Ej, manejo de fechas, etc).
* Se deben incluir tests de los diferentes casos de uso y/o partes del programa, recomendamos documentación en postman y/o swagger para consumir los servicios.
* Se debe incluir un archivo README en el cual se especificará los pasos para instalar el ambiente y realizar los tests.
* Bonus: Consideraciones de seguridad como implementación de flujos de Oauth serán bienvenidas.
