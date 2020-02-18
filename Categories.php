<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
if(isset($_POST["Submit"])){
  $Category = $_POST["CategoryTitle"];
  $Admin = $_SESSION["UserName"];
  date_default_timezone_set("America/Denver");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S" , $CurrentTime);
  if(empty($Category)){
    $_SESSION["ErrorMessage"]= "All fileds must be filled out";
    Redirect_to("Categories.php");
  }elseif(strlen($Category)< 3){
    $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
    Redirect_to("Categories.php");
  }elseif(strlen($Category)> 49){
    $_SESSION["ErrorMessage"]= "Category title should be less than 50 characters";
    Redirect_to("Categories.php");
  } else {
    $sql = "INSERT INTO category(title, author, datetime)
              VALUES(:categoryName, :adminName, :dateTime)";
              $stmt = $ConnectingDB->prepare($sql);
              $stmt->bindValue(':categoryName', $Category);
              $stmt->bindValue(':adminName', $Admin);
              $stmt->bindValue(':dateTime', $DateTime);
              $Execute=$stmt->execute();
              if($Execute){
                $_SESSION["SuccessMessage"]="Category with id : ".$ConnectingDB->lastInsertId()." Added Succesfully!";
                Redirect_to("Categories.php");
              } else{
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
                Redirect_to("Categories.php");
              }
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
    <title>Categories</title>
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
    <!-- NANBAR END -->
    <!-- Header -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
            <div class='col-md-12'>
                <h1><i class='fas fa-edit' style='color:#72aae1'></i> Manage Categories</h1>
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
        <form class="" action="Categories.php" method="post">
          <div class='card bg-secondary text-light mb-3'>
            <div class="card-header">
              <h1>Add New Category</h1>
              </div>
              <div class='card-body bg-dark'>
                <div class='form-group'>
                  <label for="title">
                    <span class="FieldInfo">Category Title: </span>
                  </label>
                  <input class='form-control' type="text" name="CategoryTitle" id="title" placeholder="Type title here.." value="">
                </div>  
                <div class='row'>
                  <div class='col-lg-6 mb-2'>
                    <a href="Dashboard.php" class='btn btn-warning btn-block'>
                      <i class='fas fa-arrow-left'>Back To Dashboard</i>
                    </a>
                  </div>
                  <div class='col-lg-6 mb-2'>
                    <button type="submit" name="Submit" class='btn btn-success btn-block'>
                    <i class='fas fa-check'> Publish</i>
                    </button>
                  </div>
                </div>           
            </div>
          </div>
        </form>
        <h2>Existing Categories</h2>
    <table class='table table-striped table-hover'>
        <thead class='thead-dark'>
            <tr>
                <th>No.</th>
                <th>Date&Time</th>
                <th>Category Name</th>
                <th>Creator Name</th>
                <th>Action</th>
            </tr>

        </thead>


    
    <?php 
    $ConnectingDB;
    $sql = "SELECT * FROM category ORDER BY id desc;";
    $Execute=$ConnectingDB->query($sql);
    $SrNo = 0;
    while($DataRows=$Execute->fetch()){
        $CategoryId = $DataRows["id"];
        $CategoryDate = $DataRows["datetime"];
        $CategoryName = $DataRows["title"];
        $CreatorName = $DataRows["author"];
        // $CommentPostId = $DataRows["post_id"];
        $SrNo++; 
        // if(strlen($CategoryName)>10){$CategoryName = substr($CategoryName,0,10)."...";}
    ?>
    <tbody>
        <tr>
            <td><?php echo htmlentities($SrNo);?></td>
            <td><?php echo htmlentities($CategoryDate);?></td>
            <td><?php echo htmlentities($CategoryName);?></td>
            <td><?php echo htmlentities($CreatorName);?></td>
            <td><a class='btn btn-danger' href="DeleteCategory.php?id=<?php echo $CategoryId?>">Delete</a></td>
        </tr>
    </tbody>
<?php } ?>
        </table>
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
