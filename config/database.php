<?php
/**
 * Clase Database
 * 
 * Esta clase gestiona la conexión a la base de datos utilizando PDO.
 * Proporciona un método `getConnection` para establecer y devolver la conexión activa.
 */
class Database
{
    // Propiedades para la conexión a la base de datos
    private $host = "localhost";         // Dirección del servidor de base de datos
    private $db_name = "caja_registradora"; // Nombre de la base de datos
    private $username = "root";          // Nombre de usuario de la base de datos
    private $password = "";              // Contraseña de la base de datos
    public $conn;                        // Variable para almacenar la conexión activa

    /**
     * Método getConnection
     * 
     * Este método establece una conexión a la base de datos utilizando PDO.
     * Si la conexión es exitosa, devuelve el objeto PDO.
     * En caso de error, captura la excepción y muestra un mensaje descriptivo.
     * 
     * @return PDO|null Retorna la conexión PDO o null si falla la conexión.
     */
    public function getConnection()
    {
        // Inicializar la conexión como null
        $this->conn = null;

        try {
            // Crear una nueva instancia de PDO con los parámetros de conexión
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            // Configurar el manejo de errores para lanzar excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            // Mostrar un mensaje de error si ocurre una excepción
            echo "Error de conexión: " . $exception->getMessage();
        }

        // Retornar la conexión activa o null si falló
        return $this->conn;
    }
}
