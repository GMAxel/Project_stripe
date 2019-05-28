<?php
require_once('classes/Database.php');

class Customer 
{
    private $pdo;
    protected $table = 'customers';
    protected $fields = null;
    public $id = null;
    public $response = null;
    public $logged_in = null;

    /**
     * Store database connection and db-table-column-names.
     */
    public function __construct() 
    {
        $db = new Database();
        $this->pdo = $db->pdo;
        $this->fields = array_column($this->getFields(), 'Field');        
    }

    /**
     * Returns column information from database.
     */
    public function getFields() 
    {
        $fields = $this->pdo->query("SHOW COLUMNS FROM $this->table;")->fetchAll();
        $filtered_fields = [];
        foreach($fields as $field) {
            if($field['Field'] !== 'id' 
            && $field['Field'] !== 'stripe_id' 
            && $field['Field'] !== 'licenses') {
                $filtered_fields[]= $field;
            }
        }
        return $filtered_fields;
    }

    /**
     * login function.
     */
    public function login()
    {
        // Get values
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

        // Make sure values pass basic criteria.
        $value_checker = [$user, $pass];
        foreach($value_checker as $value) {
            if(strlen($value) === 0) {
                $this->response = 'Fill all the inputs'; 
            } else if(strlen($value) < 4) {
                $this->response = 'That\'s not even enough characters, come on hacker. At least 4!'; 

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
        // Store Customer Information in obj. 
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        // Make sure that there is a user with this username - Might be 
        // dumb for security reasons... :)
        if(!$result) {
            $this->response = 'There\'s no user with this username'; 
            return false;
        }
        // Store hashed password.
        $hash = $result->password;
        // Make sure the password is indeed correct.
        if(!password_verify($pass, $hash)) {
            $this->response = 'Fel lösenord - ta bort detta senare'; 
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

    /** 
     * Makes sure that: 
     * 1. The username has the correct amount of
     * characters
     * 2. The username isn't already in use.
     */
    public function check_user($username) 
    {
        if(strlen($username) < 4) {
            $this->response = 'Username too short - At least 4 characters';
            return false;
        }

        $sql = "SELECT * FROM $this->table WHERE username = :user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('user', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user) {
            $this->response = 'Username is already in use';
            return false;
        } else {
            return true;
        }
    }

    // Checks if email is valid and not already in use.
    // If true - Returns validated email.
    // If false - returns false and stores error message.
    public function check_email($email) 
    {
        $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$valid_email) {
            $this->response = "Email: '$email' is not valid";
            return false;
        }  
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user) {
            $this->response = 'Email is already in use';
            return false;
        } else {
            return $valid_email;
        }       
    }   

    /**
     * Creates an account for customers.
     */
    public function create_account()
    {
        // Setup query.
        $sql = "INSERT INTO $this->table (" . implode(', ', $this->fields) . ") " .
        'VALUES (:' . implode(', :', $this->fields) . ')';
        // Prepare query
        $stmt = $this->pdo->prepare($sql);
        // Bind Values
        foreach($this->getFields() as $field) { 
            // Store DB-table-field and use it to fetch elements. 
            $param  = $field['Field']; 
            // Different filters depending on if the field is INT, STRING or EMAIL.
            $filter = FILTER_SANITIZE_NUMBER_INT;
            // Different PDO types depending on if the field is STRING or INT. 
            $pdo_type = PDO::PARAM_INT;
            // If varchar, alter filter and PDO type. 
            if (in_array(substr($field['Type'], 0, 4), ['varc', 'char', 'text']) ||
                in_array(substr($field['Type'], 0, 4), ['date', 'DATE']) ) {
                $pdo_type = PDO::PARAM_STR;
                $filter = FILTER_SANITIZE_STRING;
                // If email - alter filter.
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
                $this->response = "Fill all the inputs";
                return false;
            }
            // Make sure username is valid and not in use.
            if($param === 'username') {
                if(!$this->check_user($value)) {
                    return false;
                }
            }
            // Make sure email is valid and not in use.
            if($param === 'email') {
                $value = $this->check_email($value); 
                if(!$value) {
                    return false;
                }
            }         
            // Bind value
            $stmt->bindValue($param, $value, $pdo_type);            
        }
        // Execute query and return true/false.
        if($stmt->execute()) {
            $this->response = "Account Successfully Created";
            return true;
        }
        
    }

    /**
     * Update customer is called when a customer makes a
     * purchase. It needs an update. CUrrently it updates
     * how many licenses the customer haves, and their
     * stripe id. Stripe id should only be changed if
     * they aren't already a customer.
     */
    public function update_customer($licenses, $stripe_id = null) 
    {
        $id = $_SESSION['customer_id'];

        if ($stripe_id === null) {
            $sql = "UPDATE $this->table 
                    SET licenses = licenses + :licenses 
                    WHERE id = $id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue('licenses', $licenses);
            $stmt->execute();
        } else {
            $sql = "UPDATE $this->table 
                    SET stripe_id = :stripe_id, 
                    licenses = licenses + :licenses
                    WHERE id = $id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue('stripe_id', $stripe_id);
            $stmt->bindValue('licenses', $licenses);
            $stmt->execute();
        }

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
            // Execute
            $get_id->execute();
            $result = $get_id->fetchColumn();
            $_SESSION['stripe_id'] = $result; 
            echo $_SESSION['stripe_id'];
        }
        return $stmt->rowCount() ? true : false;
    }

    public function remove_license($licenses) 
    {
        $id = $_SESSION['customer_id'];        

        $pre_sql = "SELECT licenses FROM $this->table
                WHERE id = :id";
        $pre_stmt = $this->pdo->prepare($pre_sql);
        $pre_stmt->bindValue('id', $id);
        $pre_stmt->execute();
        $license_saldo = $pre_stmt->fetchColumn();

        if($license_saldo < $licenses) {
            $this->response = 'You currently have ' . $license_saldo . 
            ' licenses, and you are trying to use ' . $licenses . 
            ' licenses <br><a href="licenses.php">Buy some more</a>';
            return false;
        } else {
            $sql = "UPDATE $this->table 
                SET licenses = licenses - :licenses 
                WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue('licenses', $licenses);
            $stmt->bindValue('id', $id);
            $stmt->execute();
            return true;
        }
    }


    /**
     * Gets customer by session customer id
     * and returns info.
     * Alter so it doesn't return password 
     * and other bad data.
     * This is called on the customer details page.
     */
    public function getCustomer() 
    {
        $id = $_SESSION['customer_id'];
        $sql = "SELECT * FROM $this->table WHERE id = :id ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }


}