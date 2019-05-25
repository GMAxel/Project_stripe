<?php
require_once('vendor/init.php');
require_once('config/db.php');

class Customer {
    private $db;
    private $pdo;
    protected $table = 'customers';
    protected $fields = null;
    public $id = null;
    public $response = [
        'message' => ''
        // 'status' => false
    ];


    public function __construct() {
        $this->db = new Database;
        $this->pdo = $this->db->pdo;
        $this->fields = array_column($this->getFields(), 'Field');
    }

    public function update_customer($stripe_id) 
    {
        /**
         * Kanske ska hämta de inputs som användaren skrev i och uppdatera de i db?
         */
        // Customer
        $id = $_SESSION['customer_id'];
        $sql = "UPDATE $this->table SET stripe_id = :stripe_id WHERE id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('stripe_id', $stripe_id);
        $stmt->execute();

        // Update customer and set session stripe id.
        if($stmt->rowCount()) {
            // Session Customer
            $id = $_SESSION['customer_id'];
            // Sql 
            $sql = "SELECT stripe_id FROM customers WHERE id = :id";
            // Prepare
            $get_id = $this->pdo->prepare($sql);
            // Bind
            $get_id->bindValue('id', $id);
            // Execite
            $get_id->execute();
            $result = $get_id->fetchColumn();
            $_SESSION['stripe_id'] = $result; 
            echo $_SESSION['stripe_id'];
        }

        return $stmt->rowCount() ? true : false;
    }

    public function getFields()
    {
        $fields = $this->pdo->query("SHOW COLUMNS FROM $this->table;")->fetchAll();
        $filtered_fields = [];
        foreach($fields as $field) {
            if($field['Field'] !== 'id' && $field['Field'] !== 'stripe_id') {
                $filtered_fields[]= $field;
            }
        }
        return $filtered_fields;
    }

    public function addCustomer($data) {
        // Prepare query
        $this->db->query('INSERT INTO customers (stripe_id, first_name, last_name, email)
        VALUES(:stripe_id, :first_name, :last_name, :email)');

        // bind values
        $this->db->bind(':stripe_id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);

        // execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomer() {
        $id = $_SESSION['customer_id'];
        $sql = "SELECT * FROM $this->table WHERE id = :id ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function login() 
    {
        // Get values
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

        $value_checker = [$user, $pass];

        foreach($value_checker as $value) {
            if(strlen($value) === 0) {
                $this->response['message'] = 'Fill all the inputs'; 
            } else if(strlen($value) < 4) {
                $this->response['message'] = 'That\'s not even enough characters, come on hacker. At least 4!'; 

            }
        }
       
        // Retrieve Customer Information
        $sql = "SELECT * FROM $this->table WHERE username = :username";

        // prepare
        $stmt = $this->pdo->prepare($sql);

        // bind value
        $stmt->bindValue('username', $user);

        // execute
        $stmt->execute();

        // Result
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if(!$result) {
            $this->response['message'] = 'There\'s no user with this username - ta bort detta senare'; 
            return false;
        }
        // Password 
        $hash = $result->password;

        if(!password_verify($pass, $hash)) {
            $this->response['message'] = 'Fel lösenord - ta bort detta senare'; 
            return false;
        } else {
            $_SESSION['stripe_id'] = $result->stripe_id;
            $_SESSION['customer_id'] = $result->id; 
            $_SESSION['first_name'] = $result->first_name;        
            $_SESSION['last_name'] = $result->last_name;
            $_SESSION['email'] = $result->email;        
        
       
            return true;
        }
    }
    
    public function create_account() 
    {
        // Setup query.
        $sql = "INSERT INTO $this->table (" . implode(', ', $this->fields) . ") " .
        'VALUES (:' . implode(', :', $this->fields) . ')';
        // Prepare query
        $stmt = $this->pdo->prepare($sql);
        // Bind Values
        foreach($this->getFields() as $field) {  
            // Store DB-field and use it to fetch elements. 
            $param  = $field['Field']; 
            echo "<h2>$param</h2>";

            // Different filters depending on if the field is INT, STRING or EMAIL.
            $filter = FILTER_SANITIZE_NUMBER_INT;
            // Different PDO types depending on if the field is STRING or INT. 
            $pdo_type = PDO::PARAM_INT;

            // If varchar, alter filter and PDO type. 
            if (in_array(substr($field['Type'], 0, 4), ['varc', 'char', 'text']) ||
                in_array(substr($field['Type'], 0, 4), ['date', 'DATE']) ) {
                $pdo_type = PDO::PARAM_STR;
                $filter = FILTER_SANITIZE_STRING;

                if($param === 'email') {
                    $filter = FILTER_SANITIZE_EMAIL;
                }
            }
            // Store value from INPUT. 
            $value  = filter_input(INPUT_POST, $param, $filter);

            // Override values.
            if($param === 'created_at') {
                $value = date("Y-m-d H:i:s");
            }
            if($param === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            
            // Check values
            if(strlen($value) < 1) {
                $this->response['message'] = "Fill all the inputs";
                return false;
            }
            if($param === 'username') {
                if(!$this->check_user($value)) {
                    return false;
                }
            }
            if($param === 'email') {
                $value = $this->check_email($value); 
                if(!$value) {
                    return false;
                }
            }         
            

            // Bind value
            echo "<h2>$value</h2>";
            $stmt->bindValue($param, $value, $pdo_type);            
        }

        // Execute query and return result.
        // die;
        return $stmt->execute();
    }
    
    public function set_filter($type, $field) 
    {
        // Different filters depending on if the field is INT, STRING or EMAIL.
        // If email
        if($field === 'email') {
            return FILTER_SANITIZE_EMAIL;
        } 
        // if varchar or date
        else if (in_array(substr($type, 0, 4), ['varc', 'char', 'text']) ||
                 in_array(substr($type, 0, 4), ['date', 'DATE'])) {
            return FILTER_SANITIZE_STRING;
        } 
        else {
            return FILTER_SANITIZE_NUMBER_INT;
        }
    }

    public function check_user($username) {
        if(strlen($username) < 4) {
            $this->response['message'] = 'Username too short - At least 4 characters';
            return false;
        }

        $sql = "SELECT * FROM $this->table WHERE username = :user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        var_dump($user);
        if($user) {
            $this->response['message'] = 'Username is already in use';
            return false;
        } else {
            return true;
        }
    }

    // Checks if email is valid and not already in use.
    // If true - Returns validated email.
    // If false - returns false and stores error message.
    public function check_email($email) {
        $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$valid_email) {
            $this->response['message'] = 'Email not valid';
            return false;
        }  
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user) {
            $this->response['message'] = 'Email is already in use';
            return false;
        } else {
            return $valid_email;
        }       
    }   
}