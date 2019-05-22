<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ladda upp</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        Upload your CSV file:<br>
        <input type="file" name="books_file"><br>
        <input type="submit" name="action" value="Upload File">
    </form>
</body>
</html>


<?php
// Open and read file, store values in array.
if (!empty($_FILES)) {
    $file = $_FILES['books_file']['tmp_name'];
    $books = [];
    $books[] = ['Book Title', 'Description', 'Pages', 'ISBN'];
    if($file_handle = fopen($file, 'r')) {
        while ($data = fgetcsv($file_handle)) {
            // här kan vi kalla på metod som tar emot
            // isbn och hämtar bokinfo. 
            $books[] = get_book_info($data[0]);
        }
        fclose($file_handle);
    }
} 

// Ändra innehållet i filen, lagra innehållet i sessionen.  
if(isset($books)) {
    $file_to_write = fopen($file, 'w');

    foreach ($books as $book) {
        fputcsv($file_to_write, $book);
    }
    fclose($file_to_write);
    $_SESSION['response_data'] = $books;

    echo '<a href="redir.php">Everything </a>';
}

function get_book_info($isbn) 
{
    $url = "http://anelene.se/api/index.php";
    $query_string = "?5ce51a1464335&books&$isbn";

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
    $result = [];
    foreach($obj->results[0] as $key => $val) {
        if($key == 'ISBN' || $key == 'title' || $key == 'description' || $key == 'pages') {
            $result[] = $val;
        }
    }
    return $result;
    // return $obj->results[0];
}



