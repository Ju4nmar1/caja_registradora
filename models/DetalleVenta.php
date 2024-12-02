<?php
/**
 * Clase DetalleVenta
 * 
 * Modelo que representa los detalles de cada venta. Proporciona métodos
 * para agregar registros de productos vendidos y listar los detalles
 * asociados a una venta específica.
 */
class DetalleVenta {
    // Propiedades privadas
    private $conn;          // Conexión a la base de datos
    private $table_name = "detalle_venta"; // Nombre de la tabla en la base de datos

    // Propiedades públicas (campos de la tabla detalle_venta)
    public $id_detalle_venta; // ID único del detalle de la venta
    public $id_venta;         // ID de la venta asociada
    public $id_producto;      // ID del producto vendido
    public $cantidad;         // Cantidad del producto vendido
    public $subtotal;         // Subtotal del detalle (cantidad * precio)

    /**
     * Constructor de DetalleVenta
     * 
     * Inicializa la conexión a la base de datos.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Agregar un nuevo detalle de venta
     * 
     * Inserta un registro en la tabla `detalle_venta` con la información del
     * producto, cantidad y subtotal.
     * 
     * @return bool Retorna `true` si el detalle fue agregado exitosamente o `false` en caso contrario.
     */
    public function agregarDetalleVenta() {
        // Consulta SQL para insertar un nuevo detalle de venta
        $query = "INSERT INTO " . $this->table_name . " (id_venta, id_producto, cantidad, subtotal)
                  VALUES (:id_venta, :id_producto, :cantidad, :subtotal)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->id_venta = htmlspecialchars(strip_tags($this->id_venta));
        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->subtotal = htmlspecialchars(strip_tags($this->subtotal));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":id_venta", $this->id_venta);
        $stmt->bindParam(":id_producto", $this->id_producto);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":subtotal", $this->subtotal);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Detalle agregado correctamente
        }

        return false; // Error al agregar el detalle
    }

    /**
     * Listar los detalles de una venta específica
     * 
     * Obtiene todos los productos vendidos en una venta, incluyendo su información
     * básica (nombre del producto) y cantidad.
     * 
     * @param int $id_venta ID de la venta cuyos detalles se desean obtener.
     * @return PDOStatement Objeto PDOStatement con los resultados de la consulta.
     */
    public function listarDetallesPorVenta($id_venta) {
        // Consulta SQL para obtener los detalles de una venta específica
        $query = "SELECT dv.*, p.nombre_producto 
                  FROM " . $this->table_name . " dv
                  JOIN productos p ON dv.id_producto = p.id_producto
                  WHERE dv.id_venta = :id_venta";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        
        // Enlazar el parámetro con el valor
        $stmt->bindParam(":id_venta", $id_venta);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar el objeto PDOStatement con los resultados
        return $stmt;
    }
}
?>
