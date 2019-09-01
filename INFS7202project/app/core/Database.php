<?php
/**
 * The main Database class with PDO
 * Uses defined variables in config.php file
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    /**
     * Creates new PDO connection to database with ATTR_PERSISTENT on, ERRMODE_EXCEPTION, and
     * FETCH_OBJ
     */
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Maintain consistent connection, Allow error handling, fetch returns as objects
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        );

        // Create PDO instance
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepare statement with query. Will save statment as property in database object
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Binds the paramter name with the value given as second parameter
     * Optional 3rd parameter used to specify type, e.g. PDO::PARAM_STR
     */
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute prepared statement
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Returns a result set as array of objects by default.
     * Will call execute automatically first.
     * 
     * params: (optional) true to return associative array as result,
     *          default false will return as object
     */
    public function resultSet($type = false) {
        $this->execute();
        if($type == true) {
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->stmt->fetchAll();
        }
    }

    /**
     * Returns a single record as object by default
     * Calls execute method first then returns first value
     * 
     * params: (optional) true to return associative array as result,
     *          default false will return as object
     */
    public function single($type = false) {
        $this->execute();
        if($type == true) {
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $this->stmt->fetch();
        }
    }

    /**
     * Returns row count
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}