Proyecto: Caja Registradora


**Descripción**


Este proyecto es un sistema de Caja Registradora desarrollado en PHP con MySQL. El sistema está diseñado para gestionar clientes, productos y ventas. 

Permite realizar las siguientes operaciones:

* Registrar clientes (naturales o jurídicos).

* Registrar productos con su respectiva información (nombre, precio, cantidad, código).

* Realizar ventas, generando detalles y actualizando el inventario de productos.

* Generación de facturas electrónicas en formato PDF para cada venta realizada.
Este sistema está diseñado para facilitar la gestión de ventas e inventarios de una tienda o negocio.

**Características**


* Gestión de Clientes: Añadir, listar y editar clientes.

* Gestión de Productos: Añadir, listar, editar y gestionar el inventario de productos.

* Gestión de Ventas: Realizar ventas, mostrar detalles de las ventas y generar facturas electrónicas.

* Interfaz de Usuario: Usando Bootstrap 5 para una interfaz amigable y responsiva.

* Generación de Facturas: Creación de facturas electrónicas en formato PDF con los detalles de la venta.

**Requisitos**


* XAMPP (para ejecutar el servidor PHP y MySQL localmente)

* PHP 7.0 o superior

* MySQL 5.7 o superior

* Composer (para la instalación de dependencias como DOMPDF)


**Instalación**


* Descargar el proyecto. se debe descomprimir cada una de las carpetas

* Instala las dependencias utilizando Composer:

composer install
* instalar Dompdf,biblioteca PHP que permite convertir HTML a PDF

Instala Dompdf usando Composer: 

composer require dompdf/dompdf

* Configura la base de datos:

Crea una base de datos llamada caja_registradora.

Importa el archivo db.sql ubicado en la raíz del proyecto para crear las tablas necesarias.


**Configuración de la base de datos**


En el archivo config/database.php, ajusta las credenciales de la base de datos según tu configuración local de MySQL:

private $hostname = "localhost";
private $db_name = "caja_registradora";
private $username = "root";
private $password = "";

**Accede al proyecto desde tu navegador*

http://localhost/caja_registradora/


**Uso**


**Gestión de Clientes**


* Registra clientes, ya sea naturales o jurídicos, con su nombre, cédula o NIT y tipo de cliente.

* Puedes visualizar, editar y gestionar la información de los clientes desde el panel de administración.


**Gestión de Productos**


* Registra productos con su nombre, precio, cantidad en stock y código de producto.

* Puedes gestionar el inventario y editar productos según sea necesario.


**Gestión de Ventas**


* Realiza ventas seleccionando productos, la cantidad y el cliente correspondiente.

* El sistema calcula automáticamente el total de la venta, incluyendo el IVA.

* Genera facturas electrónicas en formato PDF con todos los detalles de la venta, que se pueden imprimir o enviar por correo.


**Funcionalidades de la Aplicación**


* Registrar ventas con IVA calculado automáticamente.

* Generar facturas electrónicas en PDF para cada venta realizada.

* Actualizar inventario después de cada venta.

* Interfaz web para gestionar clientes, productos y ventas de forma sencilla y rápida.


**Estructura del Proyecto**


* config/ - Archivos de configuración, como la conexión a la base de datos.
  
* controllers/ - Controladores que manejan la lógica de negocio.
  
* models/ - Clases que representan las entidades en la base de datos (Clientes, Productos, Ventas, etc.).
  
* views/ - Plantillas HTML para la visualización de las diferentes pantallas de la aplicación (gestión de clientes, productos, ventas, etc.).
  
* public/ - Archivos públicos, como CSS.
