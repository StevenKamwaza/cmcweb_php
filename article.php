
<?php 
//connection to database
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cmsweb','chesteve','che');
    } catch (PDOException $th) {
        exit('Unable to connect to database');
    }

//end of database con
 include_once("post.php");

 $dataItem = new Post;
// $datacom =new Post;
// $numberOfComments= new Post;

// $post = new Post;
// $posts=$post->fetch();

//print_r($posts); 
//echo time();

if (isset($_GET['id'])) {
    //display articllle
    $id =$_GET['id'];
    $data =$dataItem->fetchData($id); 
   // print_r($data);
    $dataComments=$dataItem->fetchComments($id);
    //print_r($dataComments);
    //number of comments
    $numbers=$dataItem->numComments($id);
    
   // print_r($numbers);
    


   //handling comment boxs 
    if (isset($_POST['username'],$_POST['comment'])) {
     # code...
     $username=$_POST['username'];
     $comment =$_POST['comment'];

     //check if not empty
     if (empty($username) or empty($comment)) {
          //diplay erro
          $error = "fill all fields";          
     }else {
          $query = $pdo->prepare('INSERT INTO postcomments (username,comment,time,id) VALUES(?,?,?,?)');
          $query->bindValue(1,$username);
          $query->bindValue(2,$comment);
          $query->bindValue(3,time());
          $query->bindValue(4,$id);
     
          $query->execute();
     
         
    }
 }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="news.css">
    <script src="js/bootstrap.js"/>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>News Page</title>
</head>
<body>
        <div class="menu-bar">
            <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="#">ALL JOBS <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">COMPANIES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">WALKING</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">GOVT JOBS</a>
                </li>
                </ul>
            </div>
            </nav>
        </div>
       
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card bg-white">
                        <!---->
                        <div class="card-header">
                            <h2 class="text-center bg-dark text-white text-justify"><?php echo $data['title'];?></h2>
                            <center>
                               <span class="bg-secondary text-white mt-1"><small class="text-center"><i class="ml-2">posted <?php   echo date('l jS',$data['time']); ?></i></small></span>
                            </center>
                            
                            <p class="lead jext-justify">
                                <?php echo $data['post'];?>
                            </p>
                            <div>
                            </div>
                            <p class="text-justfiy lead text-warning"><a href="index.php">&larr;Back</a></p>
                            <div class="form-control">
                           
                            
                            <div class="card bg-secondary">
                                <div class="card-header">
                                    <h2 class="text-center lead text-justify text-white">Add a Comment</h2>
                                </div>
                                <form action="article.php?id=<?php echo $data['id'];?>" method="post" class="form-control" >

                                    <?php
                                         //if we dont have a comment
                                      
                                        if ($numbers['number']==0) {
                                            # code...?>
                                            <i class="form-control text-center text-warning"><?php echo "Be first to comment!";?></i>
                                            <?php
                                           
                                        }
                                    ?>
                                    
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

                            <div class="card-header bg-secondary mt-3">
                            
                                <h3 class="lead text-justify text-white text-center"><span class="text-success">
                                
                                <?php echo $numbers['number'];?></span> Comments</h3>
                                <?php foreach ($dataComments as $comments){?>
                                    <div class="bg-secondary mt-2">
                                        <div class="form-control">
                                            
                                            <p class="lead jext-justify ">
                                                <i class="text-center text-justify bf-white"><?php echo $comments['username'];?></i><br>
                                                <p class="text-primary"><?php echo $comments['comment']?></p>
                                            </p>
                                            <small><i class="text-success"><?php echo date('l, F jS Y.',$comments['time']); ?></i></small>
                                            <hr class="bg-secondary"> 
                                        
                                        </div>
                                       
                                    </div>
                                                         
                                <?php } ?>
                            </div>
                            </div>
                            

                            
                        </div>
                       

                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
}else {
    header('Location: index.php');
    exit();
}  
?>