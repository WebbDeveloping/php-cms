<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php $DownImg = './Images/down.jpeg' ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- fontawesome -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
      crossorigin="anonymous"
    />
    <!-- bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="Css/Styles.css" />
    <title>Blog Page</title>
    <style media="screen">
      .heading{
    font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
    font-weight: bold;
    color: #005e90;
}
.heading:hover{
    color: #0090db;
}
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <div style="height:10px; background:#27aae1"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
      <div class="container">
        <a href="#" class="navbar-brand">JoeDirt.Com</a>
        <button
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarcollapseCMS"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a href="Blog.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">About Us</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php" class="nav-link">Blog</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Features</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <form class="form-inline d-none d-sm-block" action="Blog.php">
                  <div class="form-group">

                      <input class="form-control mr-2" type="text" name="Search" placeholder="Search" value="">
                      <button  class="btn btn-primary" name="SearchButton">Go</button>

                    </div>
              </form>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height:10px; background:#27aae1"></div>
    <!-- NAVBAR END -->

<div class='container'>
    <div class="row">
        <!-- MAIN START -->
        <div class="col-sm-8">
            <h1>Welcome to My PHP site</h1>
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <?php 
            $ConnectingDB;
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $sql = "SELECT * FROM posts WHERE 
                datetime LIKE :search
                OR title LIKE :search
                OR category LIKE :search
                OR post LIKE :search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search', '%'.$Search.'%');
                $stmt->execute();
            } elseif(isset($_GET["page"])){
              $Page = $_GET["page"];
              if($Page==0 || $Page < 1){
                $ShowPostsFrom=0;
              } else {
                $ShowPostsFrom = ($Page*5)-5;
              }
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostsFrom, 5";
                $stmt = $ConnectingDB->query($sql);
            }elseif(isset($_GET["category"])){
              $Category = $_GET["category"];
              $sql= "SELECT * FROM posts WHERE category=:categoryName ORDER by id desc";
              $stmt=$ConnectingDB->prepare($sql);
              $stmt->bindValue(':categoryName', $Category);
              $stmt->execute();
            }
                // default query
             else {
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                $stmt = $ConnectingDB->query($sql);
            }
            
            while($DataRows = $stmt->fetch()){
                $IMG = 'http://placekitten.com/g/200/300';
                $PostId = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $PostTitle = $DataRows["title"];
                $Category = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $PostDescription = $DataRows['post'];          
            ?>
            <div class="card">
                <img class="img-fluid card-img-top" style="max-height:450px;" src="<?php  echo htmlentities($IMG)?>" >
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle);?></h4>
                    <small class="text-muted">Category: <span class="text-dark"> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>                    <span class='badge badge-dark' style="float:right">  Comments <?php  echo ApproveCommentsAccordingPost($PostId);?></span>
                    <hr>
                    
                    <p class="card-text"><?php if(strlen($PostDescription) > 150){ $PostDescription = substr($PostDescription, 0, 150)."...";}
                     echo htmlentities($PostDescription); ?>
                    </p>
                    <a href='FullPost.php?id=<?php echo $PostId; ?>' style="float:right;">
                    <span class="btn btn-info">Read More >></span>
                </a>
                </div>
            </div>
            <?php  } ?>
            <!-- PAGINATIONSTART -->
            <nav>

              <ul class="pagination pagination-lg">
               <!-- // backwards button -->
              <?php 
              if(isset($Page)){
                if($Page>1){               
              ?>
                 <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                </li>
            <?php } }?>
                <?php 
                $ConnectingDB;
                $sql = "SELECT count(*) FROM posts";
                $stmt=$ConnectingDB->query($sql);
                $Row=$stmt->fetch();
                $ttl=array_shift($Row);
                $PostPag = $ttl/5;
                $PostPag=ceil($PostPag);
                for($i=1; $i <=$PostPag; $i++){
                  if(isset($Page)){  
                    if($i==$Page){ ?>
                <li class="page-item active">
                  <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                </li>
                 <?php   
                 }else {              
                  ?>
                  <li class="page-item">
                  <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                </li>
             <?php }
              } }?>
              <!-- // forward button -->
              <?php 
              if(isset($Page)&&!empty($Page)){
                if($Page+1<=$PostPag){

                
              ?>
                 <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                </li>
            <?php } }?>
              </ul>
            </nav>
            <!-- PAGINATION END -->
            </div>
            <!-- MAIN END -->

            <!-- SIDE ARE START -->
            <div class="col-sm-4" >
                <div class='card mt-4'>
                  <div class='card-body'>
                    <img src="<?php echo $DownImg;?>" class='d-block img-fluid mb-3' alt="">
                    <div class='text-center'>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. 
                    Cumo sociis natoque penatibus et magnis dis p. Aenean commodo ligula eget dolor. Aenean massa. Cumi sociis natoque 
                    penatibus et magnis dis p
                    </div>
                  </div>
                </div>
                <br>
                <div class='card'>
                  <div class='card-header bg-dark text-light'>
                    <h2 class='lead'>Sign Up !</h2>
                  </div>
                  <div class='card-body'>
                    <button type='button' class='btn btn-success btn-block text-center text-white mb-4' name='button'>Join The Forum</button>
                    <button type='button' class='btn btn-danger btn-block text-center text-white mb-4' name='button'>Login</button>
                    <div class='input-group mb-3'>
                      <input class='form-control' name="" placeholder="Enter your email" value="">
                      <div class='input-group-append'>
                        <button type="button" class="btn btn-primary btn-sm text-center-text-white" name="button">Subscribe Now</button>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                  <div class="card">
                    <div class='card-header bg-primary text-light'>
                      <h2 class='lead'>Categories</h2>
                      </div>
                      <div class='card-body'>
                        <?php 
                        $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $ConnectingDB->query($sql);
                        while($DR = $stmt->fetch()){
                          $CategoryId = $DR["id"];
                          $Cn = $DR['title'];
                          ?>
                          <a href="Blog.php?category=<?php echo $Cn?>">
                            <span class="heading"> <?php echo $Cn ?></span><br>
                          </a>
                        <?php } ?>
                      
                    </div>
                  </div>
<br>
                  <div class='card'>
                    <div class='card-header bg-info text-white'>
                      <h2 class="lead"> Recent Posts</h2>
                    </div>
                    <div class='card-body'>
                      <?php 
                      $ConnectingDB;
                      $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                      $stmt=$ConnectingDB->query($sql);
                      while($rows =$stmt->fetch()){
                        $PostId = $rows["id"];
                        $PostTitle= $rows["title"];
                        $DateTime= $rows["datetime"];
                        $Image= $rows["image"];
                      
                      ?>
                      <div class='media'>
                        <img src=<?php echo $IMG?>  class='d-block img-fluid align-self-start'alt="" width="90" height='94'>
                        <div class='media-body ml-2'>
                          <a href="FullPost.php?id=<?php echo htmlentities($PostId)?>" target="_blank">
                            <h6 class='lead'><?php echo htmlentities($PostTitle);?></h6>
                          </a>
                          <p class='small'><?php echo htmlentities($DateTime)?></p>
                        </div>
                      </div>
                      <hr>
                      <?php }?>
                    </div>
                  </div>


            </div>
                <!-- SIDE ARE END -->
    </div>
</div>

    <br />
    <!-- FOOTER -->
    <footer class="bg-dark text-white">
      <div class="container">
        <div class="row">
          <div class="col">
            <p class="lead text-center">
              Theme By | Joe Dirt |<span id="year"></span> &copy; ----ALL Rights
              Reserved
            </p>
            <p class="text-center small">
              <a style="color: white; text-decoration: none; cursor: pointer;"
                >This site is only used for study purposes. No one is allowed to
                use it.</a
              >
            </p>
          </div>
        </div>
      </div>
    </footer>
    <div style="height:10px; background:#27aae1"></div>
    <script
      src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
    <script>
      $('#year').text(new Date().getFullYear());
    </script>
  </body>
</html>
