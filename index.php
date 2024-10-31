<?php
require 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-List</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<?php 
    $todos = $conn->query("SELECT * FROM tasks ORDER BY ID DESC");
?>
<body>
    <div class="main-section">
    <h2>Add task:</h2>
        <div class="add-section">
            <form action="app/add_task.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                    <input type="text" name="title" style="border-color: red" placeholder="This field is required" type="required">
                    <button type="submit">Add &#43;</button>
                <?php } else {?>
                    <input type="text" name="title" placeholder="task name" type="required">
                    <button type="submit">Add &#43;</button>
                <?php }?>
            </form>
        </div>

        <div class="show-todo-section">
            <?php if($todos->rowCount() === 0 ){ ?>
                    <div class="empty">
                        <img src="assets/images/dog.gif" alt="add your task :)">
                    </div>
            <?php }?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="todo-item">
                <span id="<?php echo $todo['ID'];?>" class="remove-to-do">X</span>
                <?php if($todo['checked'] === 0) {?>
                    <h1><?php echo $todo['name']?></h1>
                    Done:<input
                    type="checkbox"
                    data-todo-id="<?php echo $todo['ID'];?>"
                    class="check-box">
                    <br>
                <?php } else { ?>
                    <h1 class="checked"><?php echo $todo['name']?></h1>
                    Done:<input
                    type="checkbox"
                    data-todo-id="<?php echo $todo['ID'];?>"
                    class="check-box"
                    checked>
                    <br>
                    <?php }?>
                <small>Created at: <?php echo $todo['created_at']?></small>
            </div>
            <?php }?>
        </div>
    </div>

<script>
    $(document).ready(function(){
        $('.remove-to-do').click(function(){
            const id = $(this).attr('id');
            $.post("app/remove_task.php",
                {
                    TaskId: id
                },
                (data) => {
                    if(data){
                        $(this).parent().hide(500);
                    }
                }
            );
        });

        $('.check-box').click(function(){
            const id = $(this).attr('data-todo-id');
            $.post("app/check.php",
            {
                TaskId: id
            },
                (data) => {
                    if(data != 'error'){
                        const h1 = $(this).siblings('h1');
                        if(data === '1'){
                            h1.removeClass('checked');
                        } else {
                            h1.addClass('checked');
                        }
                    }
                }
            );
        });
    });
</script>

</body>
</html>