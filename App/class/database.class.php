<?php namespace App\class;


use App\interface\Database as DatabaseInterface;
use \PDO as PDO;
use \PDOException;
use \Dotenv\Dotenv as Dotenv;

class Database implements DatabaseInterface
{
    
    protected ?PDO $pdo = null;
    protected $stmt; // Statement

   public function __construct(){

        $dotenv = Dotenv::createImmutable(__DIR__); 
        $dotenv->load();

        $this->connect(); 

   }

   public function connect(){
      
        if($this->pdo) return $this->pdo; //if connection is already established

        if ( !extension_loaded('pdo') ) return "PDO is not enabled on this machine. PDO is required for this application"; 
        
        try {

            $dsn = 'mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'];
            $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->pdo;

        } catch (PDOException $th) {
            throw $th;
        }
    
    }

    public static function __callStatic ( $name, $args ) {
        $callback = array ( self :: getLink ( ), $name ) ;
        return call_user_func_array ( $callback , $args ) ;
    }
 
    public function __call( $name, $arguments )
    {
        if ( $name === 'send' ) {
            call_user_func( array( $this, 'sendNonStatic' ) );
        }
    }

    public function prepare($query){
        $this->stmt = $this->pdo->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
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

    public function execute(){ //timestamP?
        return $this->stmt->execute();
    }

    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Debug Function
     */
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }

    /**
     * Random function to test database connection
     */
    public function connected(){
        return "database connection";
    }

}
