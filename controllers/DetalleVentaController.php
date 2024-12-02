<?php
// Importar el modelo DetalleVenta
require_once __DIR__ . '/../models/DetalleVenta.php';

/**
 * Clase DetalleVentaController
 * 
 * Controlador para gestionar las operaciones relacionadas con los detalles de una venta,
 * como registrar detalles y listar los productos vendidos en una venta específica.
 */
class DetalleVentaController {
    // Propiedades privadas
    private $db;             // Conexión a la base de datos
    private $detalleVenta;   // Instancia del modelo DetalleVenta
    private $conn;           // Propiedad para almacenar la conexión directamente

    /**
     * Constructor de DetalleVentaController
     * 
     * Inicializa la conexión a la base de datos y el modelo DetalleVenta.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->conn = $db; // Inicializamos $conn con la conexión proporcionada
        $this->detalleVenta = new DetalleVenta($db);
    }

    /**
     * Registrar detalles de una venta
     * 
     * Itera sobre una lista de productos y registra cada uno como un detalle de la venta.
     * Calcula el subtotal de cada producto basado en su precio y cantidad.
     * 
     * @param int $id_venta ID de la venta a la que pertenecen los detalles.
     * @param array $productos Lista de productos con `id_producto`, `precio` y `cantidad`.
     * @return bool Retorna `true` si todos los detalles se registraron correctamente, `false` en caso contrario.
     */
    public function registrarDetalleVenta($id_venta, $productos) {
        foreach ($productos as $producto) {
            // Calcular el subtotal del producto
            $subtotal = $producto['precio'] * $producto['cantidad'];

            // Asignar valores al modelo
            $this->detalleVenta->id_venta = $id_venta;
            $this->detalleVenta->id_producto = $producto['id_producto'];
            $this->detalleVenta->cantidad = $producto['cantidad'];
            $this->detalleVenta->subtotal = $subtotal;

            // Intentar registrar el detalle de la venta
            if (!$this->detalleVenta->agregarDetalleVenta()) {
                return false; // Si ocurre un error, detener y retornar `false`
            }
        }

        return true; // Si todo fue exitoso, retornar `true`
    }

    /**
     * Listar detalles por venta
     * 
     * Obtiene la lista de productos vendidos en una venta específica.
     * Incluye datos como el código del producto, nombre, cantidad y subtotal calculado.
     * 
     * @param int $id_venta ID de la venta cuyos detalles se desean listar.
     * @return array Lista de detalles de la venta en formato asociativo.
     */
    public function listarDetallesPorVenta($id_venta) {
        // Consulta para obtener los detalles de la venta
        $query = "SELECT 
                    p.codigo_producto, 
                    p.nombre_producto, 
                    dv.cantidad, 
                    (dv.cantidad * p.precio_producto) AS subtotal 
                  FROM detalle_venta dv
                  INNER JOIN productos p ON dv.id_producto = p.id_producto
                  WHERE dv.id_venta = ?";

        // Preparar y ejecutar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_venta);
        $stmt->execute();

        // Retornar los resultados en formato asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
