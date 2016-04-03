<?php 
    include('../../../wp-config.php');
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $sql='SELECT user_email FROM '.$table_prefix.'users WHERE ID=1';
    return print_r(mysqli_fetch_array(mysqli_query($con,$sql))[0]);
?>