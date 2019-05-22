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

// Ladda upp fil - uppladdad fil som finns på servern, flyttar vi från
// temporär plats till en mapp i vår server. 
echo "<h1>Files</h1>";
if (isset($_FILES)) {
    var_dump($_FILES['books_file']);

    $path = realpath('./') . '/recieved_files/kalle.csv';
    echo "<hr>" . $path . "<hr>";
    // flyttar filen. 
    move_uploaded_file($_FILES['books_file']['tmp_name'], "$path");
} 

