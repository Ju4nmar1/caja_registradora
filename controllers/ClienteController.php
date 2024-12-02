<?php
// Importar el modelo Cliente
require_once __DIR__ . '/../models/Cliente.php';

/**
 * Clase ClienteController
 * 
 * Controlador para manejar las operaciones relacionadas con los clientes, 
 * como listar, agregar, actualizar y obtener clientes.
 */
class ClienteController {
    // Propiedades privadas
    private $db;        // Conexión a la base de datos
    private $cliente;   // Instancia del modelo Cliente

    /**
     * Constructor de ClienteController
     * 
     * Inicializa la conexión a la base de datos y el modelo Cliente.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->cliente = new Cliente($db);
    }

    /**
     * Listar todos los clientes
     * 
     * Obtiene todos los clientes registrados en la base de datos.
     * 
     * @return array Lista de clientes en formato asociativo.
     */
    public function listarClientes() {
        $stmt = $this->cliente->listarClientes(); // Llama al método del modelo
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna los resultados
    }

    /**
     * Agregar un cliente
     * 
     * Registra un nuevo cliente en la base de datos.
     * 
     * @param string $nombre Nombre del cliente.
     * @param string $cedula_nit Cédula o NIT del cliente.
     * @param string $tipo_cliente Tipo de cliente (Natural/Jurídico).
     * @return bool Indica si el cliente se agregó exitosamente.
     */
    public function agregarCliente($nombre, $cedula_nit, $tipo_cliente) {
        // Asignar valores al modelo
        $this->cliente->nombre = $nombre;
        $this->cliente->cedula_nit = $cedula_nit;
        $this->cliente->tipo_cliente = $tipo_cliente;

        return $this->cliente->agregarCliente(); // Llama al método del modelo
    }

    /**
     * Actualizar un cliente
     * 
     * Modifica los datos de un cliente existente en la base de datos.
     * 
     * @param int $id_cliente ID del cliente a actualizar.
     * @param string $nombre Nuevo nombre del cliente.
     * @param string $cedula_nit Nueva cédula o NIT del cliente.
     * @param string $tipo_cliente Nuevo tipo de cliente.
     * @return bool Indica si la actualización fue exitosa.
     */
    public function actualizarCliente($id_cliente, $nombre, $cedula_nit, $tipo_cliente) {
        // Asignar valores al modelo
        $this->cliente->id_cliente = $id_cliente;
        $this->cliente->nombre = $nombre;
        $this->cliente->cedula_nit = $cedula_nit;
        $this->cliente->tipo_cliente = $tipo_cliente;

        return $this->cliente->actualizarCliente(); // Llama al método del modelo
    }

    /**
     * Listar clientes por ID
     * 
     * Obtiene el nombre del cliente según su ID.
     * 
     * @param int $id_cliente ID del cliente.
     * @return array Nombre del cliente.
     */
    public function listarClientesById($id_cliente) {
        $query = "SELECT nombre FROM cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_cliente", $id_cliente);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener cliente por ID
     * 
     * Devuelve todos los datos de un cliente según su ID.
     * 
     * @param int $id_cliente ID del cliente.
     * @return array|null Datos del cliente o null si no se encuentra.
     */
    public function obtenerClientePorId($id_cliente) {
        $query = "SELECT * FROM cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Editar un cliente
     * 
     * Permite modificar los datos de un cliente en la base de datos.
     * 
     * @param int $id_cliente ID del cliente.
     * @param string $nombre Nuevo nombre del cliente.
     * @param string $cedula_nit Nueva cédula o NIT del cliente.
     * @param string $tipo_cliente Nuevo tipo de cliente.
     * @return bool Indica si la edición fue exitosa.
     */
    public function editarCliente($id_cliente, $nombre, $cedula_nit, $tipo_cliente) {
        $query = "UPDATE cliente 
                  SET nombre = :nombre, cedula_nit = :cedula_nit, tipo_cliente = :tipo_cliente 
                  WHERE id_cliente = :id_cliente";

        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros con los valores proporcionados
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cedula_nit', $cedula_nit);
        $stmt->bindParam(':tipo_cliente', $tipo_cliente);

        return $stmt->execute();
    }
}
?>
