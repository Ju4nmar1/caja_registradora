<?php
// Importar el modelo Venta
require_once __DIR__ . '/../models/Venta.php';

/**
 * Clase VentaController
 * 
 * Controlador para gestionar las operaciones relacionadas con las ventas,
 * como registrar una venta, listar todas las ventas y obtener detalles específicos.
 */
class VentaController {
    // Propiedades privadas
    private $db;    // Conexión a la base de datos
    private $venta; // Instancia del modelo Venta

    /**
     * Constructor de VentaController
     * 
     * Inicializa la conexión a la base de datos y la instancia del modelo Venta.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->venta = new Venta($db);
    }

    /**
     * Registrar una nueva venta
     * 
     * Calcula los totales con y sin IVA, registra la venta en la base de datos
     * y devuelve el ID de la venta registrada.
     * 
     * @param int $id_cliente ID del cliente asociado a la venta.
     * @param array $productos Lista de productos con `precio` y `cantidad`.
     * @return int|bool Retorna el ID de la venta registrada o `false` si ocurre un error.
     */
    public function registrarVenta($id_cliente, $productos) {
        // Inicializar los totales
        $total_sin_iva = 0;

        // Calcular el total sin IVA basado en los productos
        foreach ($productos as $producto) {
            $subtotal = $producto['precio'] * $producto['cantidad'];
            $total_sin_iva += $subtotal;
        }

        // Calcular el IVA y el total con IVA
        $total_iva = $total_sin_iva * 0.19;  // IVA del 19%
        $total_con_iva = $total_sin_iva + $total_iva;

        // Asignar valores al modelo Venta
        $this->venta->id_cliente = $id_cliente;
        $this->venta->total_sin_iva = $total_sin_iva;
        $this->venta->total_iva = $total_iva;
        $this->venta->total_con_iva = $total_con_iva;

        // Intentar registrar la venta en la base de datos
        if ($this->venta->agregarVenta()) {
            return $this->venta->id_venta; // Retornar el ID de la venta registrada
        }

        return false; // Retornar falso si ocurre un error
    }

    /**
     * Listar todas las ventas
     * 
     * Obtiene todas las ventas registradas en la base de datos con sus detalles asociados.
     * 
     * @return array Lista de ventas en formato asociativo.
     */
    public function listarVentas() {
        $stmt = $this->venta->listarVentas(); // Llama al método del modelo
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna los resultados
    }

    /**
     * Obtener los detalles de una venta por ID
     * 
     * Devuelve los detalles de una venta específica, incluyendo información del cliente,
     * totales de la venta, y fecha.
     * 
     * @param int $id_venta ID de la venta.
     * @return array|null Datos de la venta o `null` si no se encuentra.
     */
    public function obtenerVentaPorId($id_venta) {
        // Consulta para obtener los datos de la venta con información del cliente
        $query = "SELECT 
                    v.id_venta, 
                    c.nombre, 
                    c.cedula_nit, 
                    v.fecha_venta, 
                    v.total_sin_iva, 
                    v.total_con_iva
                  FROM ventas v
                  JOIN cliente c ON v.id_cliente = c.id_cliente
                  WHERE v.id_venta = :id_venta";

        // Preparar y ejecutar la consulta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_venta", $id_venta);
        $stmt->execute();

        // Retornar los datos de la venta
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
