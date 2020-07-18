<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cmsweb','chesteve','che');
} catch (PDOException $th) {
    exit('Unable to connect to database');
}
if (isset($_POST['username'],$_POST['comment'])) {
    # code...
    $username=$_POST['username'];
    $comment =$_POST['comment'];

    //check if not empty
    if (empty($username) or empty($comment)) {
         //diplay erro
         $error = "fill all fields";          
    }else {
         $query = $pdo->prepare('INSERT INTO comments
          (username,comment,time) VALUES(?,?,?)');
         $query->bindValue(1,$username);
         $query->bindValue(2,$comment);
         $query->bindValue(3,time());
     
         $query->execute();
     
         
    }
}
?>


<div class="card bg-secondary">
    <div class="card-header">
        <h2 class="text-center lead text-justify text-white">Add a Comment</h2>
    </div>
    <form action="comment.php" method="post" class="form-control" >
        <div class="form-control">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
         </div>
        <div class="form-control">
            <textarea rows="" cols="" name="comment" class="form-control" placeholder="comment text"></textarea> 
                       
        </div>
        <div class="form-control">
            <input type="submit" class="form-control btn btn-success" value="Submit">
        </div>
    </form>
</div>