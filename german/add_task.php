<?php
	session_start();
    require_once "config.php";

    $task = $_POST['task'];
    if($task == ''){
        echo 'Enter a task';
        exit();
    }
    $id = $_SESSION["id"];

  
    $sql = 'INSERT INTO tasks (NAME_TASK, AUTHOR) VALUES(?,?)';
    $query = $pdo->prepare($sql);
    $query->execute([$task, $id]);

    header("location: todo.php");
?>