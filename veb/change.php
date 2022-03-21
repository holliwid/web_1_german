<?php
    require 'config.php';
    $id = $_GET['id'];

    $task = $_POST['task'];
    if($task == ''){
        echo 'Enter a task';
        exit();
    };
    
    $sql = 'UPDATE tasks
            SET NAME_TASK=?
            WHERE id = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$task, $id]);

    header('Location: todo.php');
?>