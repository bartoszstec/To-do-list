<?php

if(isset($_POST['TaskId'])){
    require '../db_config.php';

    $id = $_POST['TaskId'];

    if(empty($id)){
        echo 0;
    }else {
        $stmt = $conn->prepare("DELETE FROM tasks WHERE ID=?");
        $res = $stmt->execute([$id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}
?>