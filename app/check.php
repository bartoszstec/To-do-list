<?php

if(isset($_POST['TaskId'])){
    require '../db_config.php';

    $id = $_POST['TaskId'];

    if(empty($id)){
        echo 'error';
    }else {
        $todos = $conn->prepare("SELECT ID, checked FROM tasks WHERE ID=?");
        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['ID'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $stmt = $conn->prepare("UPDATE tasks SET checked=? WHERE ID=?");
        $res = $stmt->execute([$uChecked, $uId]);
         
        if($res){
            echo $checked;
        } else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}
?>