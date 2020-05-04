<?php

$conn = mysqli_connect('localhost','katleho','test1234','pizza');

if(!$conn)
{
    echo 'connection error: '. mysqli_connect_error();
}

?>