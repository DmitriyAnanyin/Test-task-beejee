<div class="container d-flex flex-row align-items-center justify-content-end">
    <h4 class="m-0">
        <?php 
        if (!empty($_SESSION['loggedUser'])){
            echo 'Welcome '.$_SESSION['loggedUser'][0]['login'].'</h4>';
            echo '
            <form action="/" method="post">
                <input class="btn btn-primary m-3" type="submit" name="logOut" value="Log out">
            </form>';
        } else {
            echo '<a href="/account/login"><button type="submit" class="btn btn-primary m-3">Sign in</button></a>';
        }
        ?>
</div>
<div class="container">
    <div class="d-flex flex-column align-items-center">
        <h1>Task list</h1>
    </div>
    <?php
    if (!empty($vars['error'])){
        echo '<h4 style="color: red;">'.$vars['error'].'</h4>';
    } else {
        echo '<h4 style="color: green;">'.$vars['success'].'</h4>';
    }
    ?>
    <form action="/" class="form mb-3" method="post">
        <div class="form-group mr-5">
            <label for="username" class="mr-3">Username</label>
            <input type="text" class="form-control" name="uname" id="username" value="<?php echo $vars['putTaskArray']['uname'];?>">
        </div>
        <div class="form-group mr-5">
            <label for="email" class="mr-3">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo $vars['putTaskArray']['email'];?>">
        </div>
        <div class="form-group mr-5">
            <label for="text">Text</label>
            <textarea class="form-control" placeholder="Leave a text here" name="text" id="text"><?php echo $vars['putTaskArray']['text'];?></textarea>
        </div>
        <div class="form-group mr-5">
            <?php            
            if ($_SESSION['loggedUser'][0]['is_admin'] == 1) {
                echo '<label for="status">Complete</label>';
                if ($vars['putTaskArray']['status'] == 1){
                    echo '<input type="checkbox" name="status" id="status" checked>';
                } else {
                    echo '<input type="checkbox" name="status" id="status">';
                }
            }
            ?>
        </div>
        <input style="display: none;" name="taskId" value="<?php echo $vars['putTaskArray']['task_id']?>">
        <?php
        if ($_SESSION['loggedUser'][0]['is_admin']){
            if (!empty($vars['putTaskArray'])){
                echo '<input class="btn btn-primary mt-3" type="submit" name="putTask" value="Put"></input>';
            } else {
                echo '<input class="btn btn-primary mt-3" type="submit" name="taskForm" value="Add"></input>';
            }
        } else {
            echo '<input class="btn btn-primary mt-3" type="submit" name="taskForm" value="Add"></input>';
        }
        ?>
    </form>
    <form class="d-flex mb-3" action="/" method="post">
    <select class="form-select" name="sortSelect" aria-label="Default select example">
        <?php 
            foreach ($vars['sortArray'] as $optionValue => $optionText) {
                if ($optionValue == $_SESSION['sortSelect']) {
                    echo '<option value="'.$optionValue.'" selected>'.$optionText.'</option>';
                } else {
                    echo '<option value="'.$optionValue.'">'.$optionText.'</option>';
                }
                
            }
        ?>
    </select>
    <input class="btn btn-primary" type="submit" name="sortSelectSubmit" value="Sort"></input>
    </form>
    <?php foreach ($vars['tasks'] as $task): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title "><?php echo $task['uname'];?></h5>
            <p class="card-text mb-1"><?php echo $task['email'];?></p>
            <p class="card-text mb-1"><?php echo $task['text'];?></p>
            <?php 
            if ($task['status'] == '0') {
                echo '<p class="card-text" style="color: red;">Not completed</p>';
            } else 
                echo '<p class="card-text" style="color: green;">Completed</p>';
            ?>
            <?php
            if ($_SESSION['loggedUser'][0]['is_admin'] == 1) {
                echo '
                <form action="/" method="post">
                    <input style="display: none;" name="taskId" value="'.$task['task_id'].'">
                    <input class="btn btn-primary" type="submit" name="setTaskToForm" value="Put">
                </form>';
            }
            ?>
            
        </div>
    </div>
    <?php endforeach; ?>
    <div class="d-flex flex-column align-items-center">
        <nav aria-label="...">
            <ul class="pagination">
                <?php 
                for ($i = 1; $i < $vars['totalPages'] + 1; $i++){
                    if ($i == $_SESSION['page']){
                        echo '
                        <form action="/" class="page-item" method="post" >
                            <input type="submit" name="page" 
                            style="background-color: #0d6efd;border-color: #0d6efd;color: #fff;"
                            class="page-link" value="'.$i.'">
                         </form>';
                    } else {
                        echo '
                        <form action="/" class="page-item" method="post" >
                            <input type="submit" name="page" class="page-link" value="'.$i.'">
                        </form>';
                    }
                    
                }  
                ?>
                <form action="/" class="page-item" method="post" >
                    <button type="submit" name="page" class="page-link" value="<?php echo $vars['totalPages']?>">end</button>
                </form>
            </ul>
        </nav>
    </div>
</div>