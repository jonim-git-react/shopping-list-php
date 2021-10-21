<?php
require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));
$description = filter_var($input->description,FILTER_SANITIZE_STRING);
$amount = filter_var($input->amount,FILTER_SANITIZE_NUMBER_INT);

try {
    $db = openDb();
   // insert into item (description, amount) values (:description, :amount)'
    $query = $db->prepare('update item set description=:description, amount=:amount where id=:id');
    $query->bindValue(':description',$description,PDO::PARAM_STR);
    $query->bindValue(':amount',$amount,PDO::PARAM_INT);
    $query->bindValue(':id',$id,PDO::PARAM_INT);
    $query->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $id,'description' => $description, 'amount' => $amount);
    print json_encode($data);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}