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
phpinfo();
echo "<h1>Files</h1>";
if (isset($_FILES)) {
    var_dump($_FILES['books_file']);
    $file = $_FILES['books_file']['tmp_name'];
    var_dump($file);

    $books = [];
    if($file_handle = fopen($file, 'r')) {
        while ($data = fgetcsv($file_handle)) {
            // här kan vi kalla på metod som tar emot
            // isbn och hämtar bokinfo. 
            $books[] = $data[0];
        }
        fclose($file_handle);
    }
    var_dump($books);
} 



