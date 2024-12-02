<?php
/**
 * Clase Cliente
 * 
 * Modelo que representa a los clientes en el sistema. Proporciona métodos
 * para listar, agregar y actualizar registros en la tabla `cliente`.
 */
class Cliente
{
    // Propiedades privadas
    private $conn;          // Conexión a la base de datos
    private $table_name = "cliente"; // Nombre de la tabla en la base de datos

    // Propiedades públicas (campos de la tabla cliente)
    public $id_cliente;     // ID único del cliente
    public $nombre;         // Nombre del cliente
    public $cedula_nit;     // Identificación (cédula o NIT)
    public $tipo_cliente;   // Tipo de cliente: Natural o Jurídico

    /**
     * Constructor de Cliente
     * 
     * Inicializa la conexión a la base de datos.
     * 
     * @param PDO $db Conexión activa a la base de datos.
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Listar todos los clientes
     * 
     * Obtiene todos los registros de la tabla `cliente`.
     * 
     * @return PDOStatement Resultado de la consulta.
     */
    public function listarClientes()
    {
        // Consulta para seleccionar todos los clientes
        $query = "SELECT * FROM " . $this->table_name;

        // Preparar y ejecutar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Retornar el resultado como un objeto PDOStatement
        return $stmt;
    }

    /**
     * Agregar un nuevo cliente
     * 
     * Inserta un nuevo registro en la tabla `cliente` con los datos proporcionados.
     * 
     * @return bool Indica si el cliente fue agregado exitosamente.
     */
    public function agregarCliente()
    {
        // Consulta para insertar un nuevo cliente
        $query = "INSERT INTO " . $this->table_name . " (nombre, cedula_nit, tipo_cliente) 
                  VALUES (:nombre, :cedula_nit, :tipo_cliente)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->cedula_nit = htmlspecialchars(strip_tags($this->cedula_nit));
        $this->tipo_cliente = htmlspecialchars(strip_tags($this->tipo_cliente));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":cedula_nit", $this->cedula_nit);
        $stmt->bindParam(":tipo_cliente", $this->tipo_cliente);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualizar un cliente existente
     * 
     * Modifica los datos de un cliente en la base de datos.
     * 
     * @return bool Indica si el cliente fue actualizado exitosamente.
     */
    public function actualizarCliente()
    {
        // Consulta para actualizar los datos de un cliente
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, cedula_nit = :cedula_nit, tipo_cliente = :tipo_cliente
                  WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos de entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->cedula_nit = htmlspecialchars(strip_tags($this->cedula_nit));
        $this->tipo_cliente = htmlspecialchars(strip_tags($this->tipo_cliente));
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));

        // Enlazar parámetros con los valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":cedula_nit", $this->cedula_nit);
        $stmt->bindParam(":tipo_cliente", $this->tipo_cliente);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
