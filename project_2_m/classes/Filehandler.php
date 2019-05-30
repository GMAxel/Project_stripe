<?php
require_once('classes/Database.php');

class Filehandler 
{
    private $pdo;
    public $response = null;
    public $file;

    /**
     * Store database connection.
     */
    public function __construct() 
    {
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    /**
     * Reads the user inserted file and gets and returns information about the books. 
     */
    public function read_isbn() 
    {
        $isbn_arr = $_SESSION['isbn'];
        $books = [ 0 => ['ISBN', 'Book Title', 'Categories', 'Pages', 'Author', 'Author Contact', 'Publisher', 'Publisher Contact']];
        foreach($isbn_arr as $isbn) {
            $books[] = $this->return_result_set($isbn);
            if(end($books) === false) {
                return false;
            }
        }
        $_SESSION['books'] = $books;
        return $books;
        
    }   
    public function read_file() 
    {
        $this->file = $_FILES['books_file']['tmp_name'];

        $books = [ 0 => ['ISBN', 'Book Title', 'Categories', 'Pages', 'Author', 'Author Contact', 'Publisher', 'Publisher Contact']];
        if($file_handle = fopen($this->file, 'r')) {
            while ($data = fgetcsv($file_handle)) {
                $books[] = $this->return_result_set($data[0]);
                $_SESSION['isbn'] = $data[0];
                if(end($books) === false) {
                    return false;
                }
            }
            fclose($file_handle);
        }
        $_SESSION['books'] = $books;
        return $books;
        // return $books;
    }

    // Gets and returns data from foreign ISBN API.
    public function get_book_info($table_name, $table_id) 
    {
        $url = "https://5ce8007d9f2c390014dba45e.mockapi.io";
        $table = "/$table_name";
        $id = "/$table_id";
        // Create a curl instance.
        $ch = curl_init($url);
        // Setup curl options
        curl_setopt($ch, CURLOPT_URL, $url . $table . $id);
        // Det svaret som servern spottar ur sig ska vi skicka tillbaka. 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Vi ska skicka med data till anropet. 
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // Don't check our self assigned SSL certificate.
        // Självsignerade SSL certifikat är inte giltiga. 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // Perform the request and get the response.
        // Här skickar vi alltså iväg vår data och lagrar i repsons. 
        $response = curl_exec($ch);
        // Stänger objektet.    
        curl_close($ch);
        // skriver ut objektet. 
        $obj = json_decode($response);

        $result = [];
        foreach($obj as $key => $val) {
            $result[$key] = $val;
        }
        return $result;
    }


/** 
 * Helper function which returns bookdata related to the ISBN. 
 */
    public function return_result_set($isbn) 
    {
        $result = [];
        $books = $this->get_book_info('books', $isbn);
        foreach($books as $key => $val) {
            if($key === 'isbn' || $key === 'title'  || $key === 'pages') {
                $result []= $val;
            } else if($key === 'categories') {
                $result []= $val[0];
            } else if($key === 'author_id') {
                $author_id = $val;
            } else if ($key === 'publisher_id') {
                $publisher_id = $val;
            }
        }
        $author = $this->get_book_info('authors', $author_id);
        $result[] = $author['firstName'] . ' ' . $author['lastName'];
        $result[] = $author['email'];

        $publisher = $this->get_book_info('publishers', $publisher_id);
        foreach($publisher as $key => $val) {
            if($key !== 'id') {
                $result []= $val;
            }
        }
        return $result;
    }

    /**
     * Uploads the file so the user can download it. 
     */
    public function upload_file() 
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample.csv"');
        $books = $_SESSION['books'];
        $fp = fopen('php://output', 'w');
        foreach ( $books as $line ) {
            fputcsv($fp, $line);
        }
        fclose($fp);
    }
}