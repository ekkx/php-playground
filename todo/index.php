<?php
require './db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">

                <?php if (isset($_GET['message']) && $_GET['message'] == 'error') { ?>

                    <input type="text" name="title" style="border-color: #ff6666" placeholder="This field is required" />
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>

                <?php } else { ?>

                    <input type="text" name="title" placeholder="What are you planning to do?" />
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>

                <?php } ?>

            </form>
        </div>

        <?php
        $tasks = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
        ?>

        <div class="show-todo-section">

            <?php if ($tasks->rowCount() <= 0) { ?>

                <div class="todo-item" align="center">
                    <img src="./img/f.png" width="100%" alt="empty" />
                    <img src="./img/Ellipsis.gif" width="80px" alt="Ellipsis" />
                </div>

            <?php } ?>

            <?php while ($task = $tasks->fetch(PDO::FETCH_ASSOC)) { ?>

                <div class="todo-item">
                    <span class="remove-to-do" id="<?php echo $task['id']; ?>">X</span>

                    <?php if ($task['checked']) { ?>

                        <input class="check-box" type="checkbox" checked />
                        <h2 class="checked"><?php echo $task['title']; ?></h2>

                    <?php } else { ?>

                        <input class="check-box" checkbox-id="<?php echo $task['id']; ?>" type="checkbox" />
                        <h2><?php echo $task['title']; ?></h2>

                    <?php } ?>

                    <br>
                    <small>created: <?php echo $task['date_time']; ?></small>
                </div>

            <?php } ?>
        </div>
    </div>

    <script src="./js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(() => {
            $('.remove-to-do').click(function() {
                const id = $(this).attr('id');

                $.post("app/remove.php", {
                    id: id
                }, (data) => {
                    if (data) {
                        $(this).parent().hide(600);
                    }
                });
            });
        });

        $('.check-box').click(function(e) {
            const id = $(this).attr('checkbox-id');

            $.post("app/check.php", {
                id: id
            }, (data) => {
                if (data != 'error') {
                    const h2 = $(this).next();

                    if (data === '1') {
                        h2.removeClass('checked');
                    } else {
                        h2.addClass('checked');
                    }
                }
            });
        });
    </script>
</body>

</html>