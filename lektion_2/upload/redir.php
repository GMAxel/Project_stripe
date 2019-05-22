<?php
session_start();
function redir() 
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sample.csv"');
    $data = $_SESSION['response_data'];

    
    $fp = fopen('php://output', 'w');
    foreach ( $data as $line ) {
        // $val = explode(",", $line);
        fputcsv($fp, $line);
    }
    fclose($fp);
}
redir();

