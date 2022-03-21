<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
<!-- Bootstrap CSS (jsDelivr CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Bootstrap Bundle JS (jsDelivr CDN) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/todo.css">
    <title>TOdo</title>
</head>
<body>
    <div class="row">
    <div class="d-flex justify-content-center flex-nowrap">
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
            <!-- <p>
                <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
            </p> -->
    </div>
    </div>
    <div class="row d-flex justify-content-center container">
        <div class="col-md-8">
            <div class="card-hover-shadow-2x mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="fa fa-tasks"></i>&nbsp;Task Lists</div>
                </div>
                <div class="scroll-area-sm">
                    <perfect-scrollbar class="ps-show-limits">
                        <div style="position: static;" class="ps ps--active-y">
                            <div class="ps-content">
                                <ul class=" list-group list-group-flush">
                                    
                                    <?php 
                                    require 'config.php';
                                    $id = $_SESSION["id"];

                                    $query = $pdo->prepare('SELECT name_task, author,id FROM tasks WHERE author=? ORDER BY id DESC');
                                    $query->execute([$id]);
                                    foreach($query as $row )
                                    {
                                    echo '<li class="list-group-item">
                                            <div class="todo-indicator bg-info"></div>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-2">
                                                        <div class="custom-checkbox custom-control"><input class="custom-control-input" id="exampleCustomCheckbox2" type="checkbox"><label class="custom-control-label" for="exampleCustomCheckbox2">&nbsp;</label></div>
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">'.$row['name_task'].'</div>
                                                    </div>
                                                    <div class="widget-content-right"> 
                                                        <a href="change_modal.php?id='.$row['id'].'"><button class="border-0 btn-transition btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#changeModal"> <i class="fa fa-pencil"></i></button></a>
                                                        <a href="delete.php?id='.$row['id'].'"><button class="border-0 btn-transition btn btn-outline-danger"> <i class="fa fa-trash"></i></button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';
                                    }
                                    ?>


                                </ul>
                            </div>
                        </div>
                    </perfect-scrollbar>
                </div>
                <div class="d-block text-right card-footer">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add
                    </button>
                </div>

                
            

                
                
                <!-- Modal ADD -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <!-- <div class="modal-body">
                            <input type="text" name="1" class="task_input">
                        </div> -->
                        <div class="modal-footer">
                            <form action='add_task.php' method="post">
                                <input type="text" name="task" class="task_input">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-secondary" data-bs-dismiss="modal" value="Save" />
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
                


                <!-- Modal Change -->
                <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <!-- <div class="modal-body">
                            <input type="text" name="1" class="task_input">
                        </div> -->
                        <?php
                        echo '<div class="modal-footer">
                            <form action="change.php?id='.$row['id'].'" method="post">
                                <input type="text" name="task" class="task_input">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-secondary" data-bs-dismiss="modal" value="Save" />
                            </form>
                        </div>'
                        ?>
                    </div>
                    </div>
                </div>
            </div>
            <p>
                <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
            </p>
</body>
</html>