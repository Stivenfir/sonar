# Abc Sonar
Sistema de Gestion Sonar ABC repecev, para el control interno operaivo, visualización de KPIS con alcance a toda la operación Repecev en la linea de importaciones. Cuenta con funcionalidad de modificar datos. El aplicativo se alimenta por procesos automaticos controlados por medio de Cron Jobs y administrados por MySql y con Task Scheduler. La información que se utiliza como insumo a paritr de este proceso proviene de RPC Tracking


# Estructura

La estructura es semejante a los demás proyectos, donde se cuenta con un Stack de HTML con Bootstrap, JavaScript jQuery, y PHP. El aplicativo se encuentra hosteado en el servidor 10.35. Los procesos automáticos apuntan a la base de datos MsSql del servidor 1.16.

![Estructura](docs/general.PNG)

Los ficheros para cada caso son mencionados de manera general:

- HTML se encuentra en la ruta `\abc-sonar\app`. Se apoya con el bootstrap en la ruta `\abc-sonar\dist\bootstrap`.
- JS se encuentra en la ruta `\abc-sonar\dist\js`. Los plugins utilizados se encuentran en el siguiente directorio: `dist\plugins`
- PHP se encuentra en la ruta `\abc-sonar\dist\php`


## Front-end.

### HTML

Las vistas del aplicativo, se encuentran en la ruta `\abc-sonar\app`. 
![Estructura](docs/front_html.PNG)

En esta ruta encontrará 3 rutas principales:

- `\app\impo`: Incluye el front del contenido principal de la lógica de negocio.
- `\app\includes`: Partes del front correspondientes a los menus, encabezados, y pie de paginas, donde se incluyen los scripts de JS y las clases de CSS (bootstrap).
- `\app\login`: Vista de la pantalla de login de la plataforma.


Tenga en cuenta que las clases utilizadas en el front corresponde a clases principalmente de Bootstrap. por lo cual, en caso de requerir cambios o ajustes, puede consultar en la documentación del Bootstrap.

### JavaScript

La parte Javascript front end del proyecto se encuentra en la ruta `\abc-sonar\dist\js`.
![Estructura](docs/front_js.PNG)

Encontramos los siguientes directorios:

#### `\dist\js\func_config`

Contiene un unico archivo de Javascript `func_config`. Este repositorio contiene un código que utiliza la biblioteca Flatpickr para generar un calendario de fechas. El calendario es utilizado para seleccionar un rango de fechas y generar un informe en formato PDF.

Para ejecutar este código, necesitarás: La biblioteca Flatpickr, jQuery, sweetalert2.

#### `\dist\js\func_dashboard`
  
Este directorio tiene las principales funcionalidades front-end que comprende la logica del negocio. El nombrado de cada uno de los archivos se elabora para mantener conexión con sus pares en backend, es decir, por ejemplo el `a_modulo.js` y `b_modulo.js` tendrán sus pares correspondientes PHP `a_modulo.php` y `b_modulo.php`.

##### `a_dashboard.js`

Este es un fragmento de código en JavaScript que contiene dos funciones: "ActivaScripts()" y "Animaciones()". La función "ActivaScripts()" llama a cuatro funciones diferentes: "FechaTablero()", "Estado_Procesos()", "HistoricoChart()", y "KpisGenerales()". La función "Animaciones()" no recibe parámetros ni llama a ninguna otra función.

Es posible que estas funciones se utilicen en un proyecto o sitio web para activar determinados scripts y animaciones en la página. En particular, "FechaTablero()" podría utilizarse para mostrar la fecha actual en un tablero, "Estado_Procesos()" podría mostrar el estado actual de ciertos procesos, "HistoricoChart()" podría mostrar un gráfico histórico y "KpisGenerales()" podría mostrar métricas clave de rendimiento.

La función "Animaciones()" probablemente se utiliza para agregar efectos de animación a elementos en la página, aunque no hay suficiente información en el fragmento de código para estar seguro.

##### `b_estado_procesos.js`

El código contiene una función llamada Estado_Procesos que se encarga de obtener y mostrar información sobre el estado de los procesos en una interfaz gráfica. Para ello, hace uso de una petición AJAX al archivo controller.php y una vez que se reciben los datos, se muestran en una tabla y en un gráfico de pastel.

##### `c_detalle_operaciones.js`

Contiene las funciones Front útiles para la visualización detallada de las operaciones. Dado a que ofrece un mayor grado de detalle, hay mayor cantidad de funcionalidades. Algunas anotaciones relevantes son las siguientes:

- InputDocImpoNoDO: #InputDocImpoNoDO es un campo de entrada que está siendo observado. Cuando el usuario escribe en este campo, se desencadena una búsqueda en la tabla.
- HabilitarSelectDO(): La función HabilitarSelectDO() muestra un elemento con una alerta, y oculta otro. Esta función también maneja eventos de clic en algunos botones con la clase BtnSelectDO.
- PeticionDO(ID, DoSelected = 'NO'): La función PeticionDO(ID, DoSelected = 'NO') realiza una solicitud asíncrona para recuperar algunos datos del servidor. Esta función toma dos argumentos: ID, que es el ID del elemento que se está seleccionando, y DoSelected, que es un parámetro que indica si el elemento se ha seleccionado o no. Esta función también hace algunas operaciones en la página para mostrar los datos que se reciben del servidor.
- BtnActualizarDatos: #BtnActualizarDatos es un botón que permite al usuario actualizar los datos en la página. Cuando se hace clic en el botón, se recuperan los datos ingresados en los campos de entrada y se envían al servidor.


##### `d_kpis_conf.js`
##### `e_historico.js`
##### `f_mails.js`

- `\dist\js\func_filtro`
- `\dist\js\func_login`
- `\dist\js\func_session`
- `\dist\js\main`