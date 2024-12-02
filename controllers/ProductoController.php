<?php
// Importar el modelo Producto
require_once __DIR__ . '/../models/Producto.php';

/**
 * Clase ProductoController
 * 
 * Controlador que gestiona las operaciones relacionadas con los productos,
 * como listar, agregar, actualizar, y reducir el stock de productos.
 */
class ProductoController
{
    // Propiedades privadas
    private $db;         // Conexión a la base de datos
    private $producto;   // Instancia del modelo Producto

    /**
     * Constructor de ProductoController
     * 
     * Inicializa la conexión a la base de datos y la instancia del modelo Producto.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->producto = new Producto($db);
    }

    /**
     * Listar productos
     * 
     * Obtiene todos los productos registrados en la base de datos.
     * 
     * @return array Lista de productos en formato asociativo.
     */
    public function listarProductos()
    {
        $stmt = $this->producto->listarProductos(); // Llama al método del modelo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   // Retorna los resultados
    }

    /**
     * Agregar un producto
     * 
     * Registra un nuevo producto en la base de datos.
     * 
     * @param string $nombre Nombre del producto.
     * @param float $precio Precio del producto.
     * @param int $stock Cantidad en stock del producto.
     * @param string $codigo Código único del producto.
     * @return bool Indica si el producto se agregó exitosamente.
     */
    public function agregarProducto($nombre, $precio, $stock, $codigo)
    {
        // Asignar valores al modelo
        $this->producto->nombre_producto = $nombre;
        $this->producto->precio_producto = $precio;
        $this->producto->cantidad_stock = $stock;
        $this->producto->codigo_producto = $codigo;

        return $this->producto->agregarProducto(); // Llama al método del modelo
    }

    /**
     * Actualizar un producto
     * 
     * Modifica los datos de un producto existente en la base de datos.
     * 
     * @param int $id_producto ID del producto a actualizar.
     * @param string $nombre Nuevo nombre del producto.
     * @param float $precio Nuevo precio del producto.
     * @param int $stock Nueva cantidad en stock.
     * @param string $codigo Nuevo código del producto.
     * @return bool Indica si la actualización fue exitosa.
     */
    public function actualizarProducto($id_producto, $nombre, $precio, $stock, $codigo)
    {
        // Asignar valores al modelo
        $this->producto->id_producto = $id_producto;
        $this->producto->nombre_producto = $nombre;
        $this->producto->precio_producto = $precio;
        $this->producto->cantidad_stock = $stock;
        $this->producto->codigo_producto = $codigo;

        return $this->producto->actualizarProducto(); // Llama al método del modelo
    }

    /**
     * Obtener un producto por su ID
     * 
     * Devuelve los datos de un producto según su ID.
     * 
     * @param int $id_producto ID del producto.
     * @return array|null Datos del producto o null si no se encuentra.
     */
    public function obtenerProductoPorId($id_producto)
    {
        $query = "SELECT * FROM productos WHERE id_producto = :id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Reducir stock de un producto
     * 
     * Reduce la cantidad en stock de un producto específico.
     * 
     * @param int $id_producto ID del producto.
     * @param int $cantidad Cantidad a reducir.
     * @return bool Indica si la operación fue exitosa.
     */
    public function reducirStock($id_producto, $cantidad)
    {
        $query = "UPDATE productos SET cantidad_stock = cantidad_stock - :cantidad WHERE id_producto = :id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":id_producto", $id_producto);

        return $stmt->execute();
    }

    /**
     * Editar un producto
     * 
     * Permite modificar los datos de un producto en la base de datos.
     * 
     * @param int $id_producto ID del producto.
     * @param string $nombre_producto Nuevo nombre del producto.
     * @param float $precio_producto Nuevo precio del producto.
     * @param int $cantidad_stock Nueva cantidad en stock.
     * @param string $codigo_producto Nuevo código del producto.
     * @return bool Indica si la edición fue exitosa.
     */
    public function editarProducto($id_producto, $nombre_producto, $precio_producto, $cantidad_stock, $codigo_producto)
    {
        $query = "UPDATE productos 
                  SET nombre_producto = :nombre_producto, 
                      precio_producto = :precio_producto, 
                      cantidad_stock = :cantidad_stock, 
                      codigo_producto = :codigo_producto 
                  WHERE id_producto = :id_producto";

        $stmt = $this->db->prepare($query);

        // Enlazar parámetros con valores
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':precio_producto', $precio_producto);
        $stmt->bindParam(':cantidad_stock', $cantidad_stock);
        $stmt->bindParam(':codigo_producto', $codigo_producto);

        return $stmt->execute();
    }
}
?>
