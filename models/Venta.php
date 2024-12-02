<?php
/**
 * Clase Venta
 * 
 * Modelo que representa una venta en el sistema. Proporciona métodos para registrar
 * una nueva venta y listar todas las ventas realizadas en el sistema.
 */
class Venta {
    // Propiedades privadas
    private $conn;          // Conexión a la base de datos
    private $table_name = "ventas"; // Nombre de la tabla en la base de datos

    // Propiedades públicas (campos de la tabla ventas)
    public $id_venta;      // ID único de la venta
    public $id_cliente;    // ID del cliente asociado a la venta
    public $fecha_venta;   // Fecha en que se realizó la venta
    public $total_sin_iva; // Total de la venta sin IVA
    public $total_iva;     // Valor del IVA aplicado
    public $total_con_iva; // Total de la venta con IVA incluido

    /**
     * Constructor de la clase Venta
     * 
     * Inicializa la conexión con la base de datos.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Registrar una nueva venta
     * 
     * Inserta una nueva venta en la base de datos con los detalles proporcionados.
     * 
     * @return bool Retorna `true` si la venta fue registrada exitosamente o `false` en caso contrario.
     */
    public function agregarVenta() {
        // Consulta SQL para insertar una nueva venta
        $query = "INSERT INTO " . $this->table_name . " (id_cliente, total_sin_iva, total_iva, total_con_iva)
                  VALUES (:id_cliente, :total_sin_iva, :total_iva, :total_con_iva)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->total_sin_iva = htmlspecialchars(strip_tags($this->total_sin_iva));
        $this->total_iva = htmlspecialchars(strip_tags($this->total_iva));
        $this->total_con_iva = htmlspecialchars(strip_tags($this->total_con_iva));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":total_sin_iva", $this->total_sin_iva);
        $stmt->bindParam(":total_iva", $this->total_iva);
        $stmt->bindParam(":total_con_iva", $this->total_con_iva);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la venta fue registrada, obtener el ID de la venta recién insertada
            $this->id_venta = $this->conn->lastInsertId();
            return true; // Venta registrada correctamente
        }

        return false; // Error al registrar la venta
    }

    /**
     * Listar todas las ventas
     * 
     * Obtiene todas las ventas realizadas, junto con el nombre del cliente asociado,
     * ordenadas por fecha de venta en orden descendente.
     * 
     * @return PDOStatement Resultado de la consulta para obtener las ventas.
     */
    public function listarVentas() {
        // Consulta SQL para listar todas las ventas
        $query = "SELECT v.*, c.nombre AS nombre_cliente 
                  FROM ventas v
                  JOIN cliente c ON v.id_cliente = c.id_cliente
                  ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; // Retorna el resultado de la consulta
    }
}
?>
