<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php Confirm_Login(); ?>
<?php 
$SearchQueryParameter = $_GET["id"];
$ConnectingDB;
$sql = "SELECT * FROM posts WHERE id = $SearchQueryParameter";
$stmtPost = $ConnectingDB->query($sql);
while($DataRows = $stmtPost->fetch()){
      $TitleToBeDeleted = $DataRows['title'];
      $CategoryToBeDeleted = $DataRows['category'];
      $ImageToBeDeleted = $DataRows['image'];
      $PostToBeDeleted = $DataRows["post"];
}
echo $ImageToBeDeleted;
if(isset($_POST["Submit"])){
   
            $ConnectingDB;
            $sql = "DELETE FROM posts WHERE id = '$SearchQueryParameter'";
            $Execute=$ConnectingDB->query($sql);             
              if($Execute){
                  $Taregt_Path_To_Delete_Image = "Upload/$ImageToBeDeleted";
                  unlink($Taregt_Path_To_Delete_Image);
                $_SESSION["SuccessMessage"]="Post Deleted Succesfully!";
                Redirect_to("Posts.php");
              } else{
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
                Redirect_to("Posts.php");
              }
}
?>
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
    <title>Delete Post</title>
  </head>
  <body>
    <!-- Navbar -->
    <div style="height:10px; background:#27aae1"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark text-light">
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
              <a href="MyProfile.php" class="nav-link"
                ><i class="text-success fas fa-user"></i> My Profile</a
              >
            </li>
            <li class="nav-item">
              <a href="Dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="Posts.php" class="nav-link">Posts</a>
            </li>
            <li class="nav-item">
              <a href="Categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
              <a href="Admins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link text-danger" href="Logout.php"
                ><i class="fas fa-user-times"></i> Logout</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height:10px; background:#27aae1"></div>
    <!-- NAVBAR END -->

    <!-- Header -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
            <div class='col-md-12'>
                <h1><i class='fas fa-edit' style='color:#72aae1'></i> Delete Post</h1>
            </div>
            
        </div>
      </div>
    </header>
    <!-- Header END -->





<!-- MAIN AREA -->
<section class='container py-2 mb-4'>
    <div class='row' >
      <div class='offset-lg-1 col-lg-10' style="min-height:400px;" >
      <?php 
      echo ErrorMessage();
      echo SuccessMessage();

      ?>
        <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
          <div class='card bg-secondary text-light mb-3'>
              <div class='card-body bg-dark'>
                <div class='form-group'>
                  <label for="title">
                    <span class="FieldInfo">Post Title: </span>
                  </label>
                  <input disabled class='form-control' type="text" name="PostTitle" id="title" placeholder="Type title here.." value="<?php echo $TitleToBeUpdated ?>">
                </div>  
                <div class='form-group'>
                    <span class='FieldInfo'>Existing Category: </span> 
                    <?php echo $CategoryToBeDeleted; ?>
                    <br>
                </div>  
                <div class="form-group">
                <span class='FieldInfo'> Existing Image: </span> 
                    <?php echo $ImageToBeDeleted; ?>
                    <!-- CANT GET IMAGES TO WORK... PLEASE HELP -->
                    <!-- <img src="Upload/<?php echo $ImageToBeDeleted;?>" width="170px"; height="70px";> -->

                </div>
                <div class="form-group">
                <label for="Post">
                    <span class="FieldInfo">Post:     </span>
                  </label>   
                  
                  <textarea disabled class='form-control' id="Post" name="PostDescription" rows="8" cols="80"><?php echo $PostToBeDeleted;?></textarea>
                </div>
                <div class='row'>
                  <div class='col-lg-6 mb-2'>
                    <a href="Dashboard.php" class='btn btn-warning btn-block'>
                      <i class='fas fa-arrow-left'>Back To Dashboard</i>
                    </a>
                  </div>
                  <div class='col-lg-6 mb-2'>
                    <button type="submit" name="Submit" class='btn btn-danger btn-block'>
                    <i class='fas fa-trash'> Delete</i>
                    </button>
                  </div>
                </div>           
            </div>
          </div>
        </form>
    </div>
    </div>
</section>
<!-- MAIN AREA END -->




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
