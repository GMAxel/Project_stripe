<?php
require_once('classes/Database.php');

class Filehandler 
{
    private $pdo;
    public $response = null;
    public $file;
    public $print_books_obj;
    /**
     * Store database connection and db-table-column-names.
     */
    public function __construct() 
    {
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    function get_book_info($isbn) 
    {
        $url = "http://anelene.se/api/index.php";
        $query_string = "?5ced07ae31e22&books&$isbn";
        // Create a curl instance.
        $ch = curl_init($url);
        // Setup curl options
        curl_setopt($ch, CURLOPT_URL, $url . $query_string);
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
        if(!$obj->info->no) {
            $this->response = "There is no book with ISBN " . $isbn . ". Try again with a different one :)";
            return false;
        }

        $result = [];
        foreach($obj->results[0] as $key => $val) {
            if($key == 'ISBN' || $key == 'title' || $key == 'description' || $key == 'pages') {
                $result[] = $val;
            }
        }
        return $result;
    }

    /**
     * Read file and store values.
     */
    public function read_file() 
    {
        $this->file = $_FILES['books_file']['tmp_name'];

        $books = [ 0 => ['Book Title', 'Description', 'Pages', 'ISBN']];
        if($file_handle = fopen($this->file, 'r')) {
            while ($data = fgetcsv($file_handle)) {
                $books[] = $this->get_book_info($data[0]);
                if(end($books) === false) {
                    return false;
                }
            }
            fclose($file_handle);
        }
        $_SESSION['books'] = $books;
        return $books;
    }

    public function write_file($books) 
    {   
        $file_to_write = fopen($this->file, 'w');
        foreach ($books as $book) {
            fputcsv($file_to_write, $book);
        }
        fclose($file_to_write);
    }

    public function upload_edited_file() 
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