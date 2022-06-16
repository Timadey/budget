<?php
/**
 * Database - Handles repetitive actions done on database
 */
class Database
{
    public  $conn = NULL;
    private $dbHost = NULL;
    private $dbUser = NULL;
    private $dbPassword = NULL;
    private $dbName = NULL;

    /**
     * __construct - Initialize Database connection parameters
     */
    public function __construct($dbHost, $dbUser, $dbPassword, $dbName)
    {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassowrd = $dbPassword;
        $this->dbName = $dbName;
    }

    /**
     * dbConnect - Connect to the database
     */
    public function dbConnect()
    {
        try{
            $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }
        catch(PDOException $err){
            echo "Connection failed: ". $err->getMessage();
        }
    }
    /**
     * dbGetData - get row(s) from one or more tables
     * where the 'where parameters' exists.
     * @column: columns to select. Leave blank or NULL if you want to select all (*)
     * @join: array of tables to join and their using columns, leave null if no joined tables are required
     * @from: an associative array of tables where we want to get all the row
     * @where: an asscociative array of the columns to intersect and their placeholder
     * @value: an associative array containing the placeholder and value
     * Return: an associative array containing the fields gotten or NULL if not found
     */
    public function dbGetData(array $column = NULL, string $from, array $join = NULL, array $where, array $value)
    {
        if ($this->conn == NULL){
            throw New Exception("Database connection not found");
        }
        $query = "";
        if ($join != NULL){
            foreach ($join as $table => $using) {
                $from .= " INNER JOIN ".$table." USING (".$using.")";
            }
        }

        if ($column == NULL){
            $query = "SELECT * FROM $from WHERE ";
        }else{
            $column = implode(", ", $column);
            $query = "SELECT $column FROM $from WHERE ";
        }
        
        $where_list = array();
        foreach ($where as $col => $ph) {
            $where_list[] = $col.' = '.$ph;
        }
        $where = implode(' AND ', $where_list);
        $query .= $where;
        echo $query.'<br>';
        try {
            $q = ($this->conn)->prepare($query);
            $q->execute($value);
            $data = $q->fetchall(PDO::FETCH_ASSOC);
            echo ' sp <br>';
            var_dump($data);
            echo ' <br>sp <br>';
            if (is_array($data)){
                return $data;
            }; return NULL;
            
        } catch (PDOException $err) {
            throw new Exception("Error Processing Request", 1);  
        }
    }
    /**
     * insertData - insert a row into a table
     * @table: table to insert into
     * @column: columns to insert into
     * @values: values to insert
     * Return: true if successful
     */
    public function insertData(string $table, array $columns, array $values)
    {
        if ($this->conn == NULL)
        {
            return (false);
        }
        $query = "INSERT INTO ".$table." (";
        $col = implode(", ", $columns);
        $query .= $col.") VALUES (";
        $phs = array();
        foreach ($values as $ph => $value) {
           $phs[] = $ph;
        }
        $phs = implode(", ", $phs);
        $query .= $phs.")";
        echo $query;

        try{
            $q = $this->conn->prepare($query);
            $q->execute($values);
            return ($this->conn->lastInsertId());
        }
        catch (PDOException $err) {
            throw new Exception("Error Processing Request", 1);  
        }
    }
    
}


//insert into users (name, password, email) values (:name, :password, :email)
//connect to database
// $DB_HOST = 'localhost';
// $DB_USER = 'root';
// $DB_PASSWORD = '';
// $DB_NAME ='budget';
// $dbs = new Database($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
// $dbs->dbConnect();
// $col = array("`first_name`","`last_name`","`email`");
// $fr = "`users`";

// $wh = array(
//     ':first_name' => 'Olawale',
//     ':last_name' => 'Molola',
//     ':email' => 'new@budget.com'
// );
// $dbs->insertData($fr, $col, $wh);
    
?>

