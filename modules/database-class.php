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
        //$from = implode(' INNER JOIN ', $from);
        //$from .= " INNER JOIN `transactions` USING (`user_id`)";
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
            $data = $q->fetch(PDO::FETCH_ASSOC);
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
    
}


// //connect to database
// $DB_HOST = 'localhost';
// $DB_USER = 'root';
// $DB_PASSWORD = '';
// $DB_NAME ='budget';
// $dbs = new Database($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
// $dbs->dbConnect();
// $col = array("`first_name`","`last_name`","`amount`");
// $fr = "`users`";
// $join = array("`transactions`" => "`user_id`");//, "`ola`", "`dkd`");
// $wh = array(
//     '`user_id`' => ':user_id',
//     '`transaction_id`' => ':trans_id'
    
// );/**'`ola`' => ':ola',
// '`muy`' => ':muy' */
// $val = array(
//     ':user_id' => 5,
//     ':trans_id' => 30
    
// );/**':ola' => "wealth",
// ':muy' => "more" */
// $dbs->dbGetData( $col ,$fr, $join, $wh, $val);
// echo password_hash("funyunsss1", PASSWORD_DEFAULT);
?>

