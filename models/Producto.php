<?php
/**
 * Clase Producto
 * 
 * Modelo que representa los productos en el sistema. Proporciona métodos
 * para listar, agregar y actualizar productos en la base de datos.
 */
class Producto {
    // Propiedades privadas
    private $conn;          // Conexión a la base de datos
    private $table_name = "productos"; // Nombre de la tabla en la base de datos

    // Propiedades públicas (campos de la tabla productos)
    public $id_producto;     // ID único del producto
    public $nombre_producto; // Nombre del producto
    public $precio_producto; // Precio del producto
    public $cantidad_stock;  // Cantidad de productos en stock
    public $codigo_producto; // Código único del producto

    /**
     * Constructor de Producto
     * 
     * Inicializa la conexión a la base de datos.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Listar todos los productos
     * 
     * Obtiene todos los registros de la tabla `productos`.
     * 
     * @return PDOStatement Resultado de la consulta.
     */
    public function listarProductos() {
        // Consulta para seleccionar todos los productos
        $query = "SELECT * FROM " . $this->table_name;

        // Preparar y ejecutar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Retornar el resultado como un objeto PDOStatement
        return $stmt;
    }

    /**
     * Agregar un nuevo producto
     * 
     * Inserta un nuevo registro en la tabla `productos` con la información proporcionada.
     * 
     * @return bool Retorna `true` si el producto fue agregado exitosamente o `false` en caso contrario.
     */
    public function agregarProducto() {
        // Consulta para insertar un nuevo producto
        $query = "INSERT INTO " . $this->table_name . " (nombre_producto, precio_producto, cantidad_stock, codigo_producto) 
                  VALUES (:nombre_producto, :precio_producto, :cantidad_stock, :codigo_producto)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->nombre_producto = htmlspecialchars(strip_tags($this->nombre_producto));
        $this->precio_producto = htmlspecialchars(strip_tags($this->precio_producto));
        $this->cantidad_stock = htmlspecialchars(strip_tags($this->cantidad_stock));
        $this->codigo_producto = htmlspecialchars(strip_tags($this->codigo_producto));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":nombre_producto", $this->nombre_producto);
        $stmt->bindParam(":precio_producto", $this->precio_producto);
        $stmt->bindParam(":cantidad_stock", $this->cantidad_stock);
        $stmt->bindParam(":codigo_producto", $this->codigo_producto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Producto agregado correctamente
        }
        return false; // Error al agregar el producto
    }

    /**
     * Actualizar un producto existente
     * 
     * Modifica los datos de un producto en la base de datos.
     * 
     * @return bool Retorna `true` si el producto fue actualizado exitosamente o `false` en caso contrario.
     */
    public function actualizarProducto() {
        // Consulta para actualizar los datos de un producto
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre_producto = :nombre_producto, precio_producto = :precio_producto, 
                      cantidad_stock = :cantidad_stock, codigo_producto = :codigo_producto
                  WHERE id_producto = :id_producto";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->nombre_producto = htmlspecialchars(strip_tags($this->nombre_producto));
        $this->precio_producto = htmlspecialchars(strip_tags($this->precio_producto));
        $this->cantidad_stock = htmlspecialchars(strip_tags($this->cantidad_stock));
        $this->codigo_producto = htmlspecialchars(strip_tags($this->codigo_producto));
        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":nombre_producto", $this->nombre_producto);
        $stmt->bindParam(":precio_producto", $this->precio_producto);
        $stmt->bindParam(":cantidad_stock", $this->cantidad_stock);
        $stmt->bindParam(":codigo_producto", $this->codigo_producto);
        $stmt->bindParam(":id_producto", $this->id_producto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Producto actualizado correctamente
        }
        return false; // Error al actualizar el producto
    }
}
?>
