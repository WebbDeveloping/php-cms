<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
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
    <title>Dashboard</title>
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
                <h1><i class='fas fa-cog' style='color:#72aae1'></i> Dashboard</h1>
            </div>
            <div class='col-lg-3'>
              <a href="AddNewPost.php" class='btn btn-primary btn-block mb-2'>
                <i class='fas fa-edit'> Add New Post</i>
              </a>
            </div>
            <div class='col-lg-3'>
              <a href="Categories.php" class='btn btn-info btn-block mb-2'>
                <i class='fas fa-folder-plus'> Add New Category</i>
              </a>
            </div>
            <div class='col-lg-3'>
              <a href="Admins.php" class='btn btn-warning btn-block mb-2'>
                <i class='fas fa-user-plus'> Add New Admin</i>
              </a>
            </div>
            <div class='col-lg-3'>
              <a href="Comments.php" class='btn btn-success btn-block mb-2'>
                <i class='fas fa-check'> Approve Comments</i>
              </a>
            </div>
            
        </div>
      </div>
    </header>
    <!-- Header END -->


    <!-- MAINAREA -->
    <section class="container py-2 mb-4">
      <div class="row">
      <?php 
          echo SuccessMessage();
          echo ErrorMessage();
          ?>
          <!-- LEFT SIDE START ARE -->
        <div class="col-lg-2 d-none d-md-block">
            <div class="card text-center bg-dark text-white mb-3">
                <div class="body">
                    <h1 class="lead">Posts</h1>
                    <h4 class="display-5">
                        <i class="fab fa-readme"></i>
                        <?php 
                            TotalPosts();
                        ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="body">
                    <h1 class="lead">Category</h1>
                    <h4 class="display-5">
                        <i class="fas fa-folder"></i>
                        <?php 
                            TotalCategory();
                        ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="body">
                    <h1 class="lead">Admins</h1>
                    <h4 class="display-5">
                        <i class="fas fa-users"></i> 
                            <?php 
                            TotalAdmins();
                            ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="body">
                    <h1 class="lead">Comments</h1>
                    <h4 class="display-5">
                        <i class="fas fa-comments"></i> 
                        <?php 
                            TotalComments();
                        ?>
                    </h4>
                </div>
            </div>
            <!-- LEFT AREA END -->

        </div>  
                    <!-- RIGHT SIDE AREA  -->
                    <div class='col-lg-10'>
                <h1>Top Posts</h1>
                <table class='table table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php 
                    $SrNo =0;
                    $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt= $ConnectingDB->query($sql);
                    while($DR=$stmt->fetch()){
                        $PostID = $DR["id"];
                        $DateTime = $DR['datetime'];
                        $Author = $DR["author"];
                        $Title = $DR['title'];
                        $SrNo++;
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
                            <td><?php echo htmlentities($Title)?></td>
                            <td><?php echo htmlentities($DateTime)?></td>
                            <td><?php echo htmlentities($Author)?></td>
                            <td>
                                    <?php 
                                        $Ttl=ApproveCommentsAccordingPost($PostID);
                                    if($Ttl > 0){
                                        ?>
                                        <span class='badge badge-success'>
                                            <?php
                                        echo $Ttl; ?>
                                         </span>
                                  <?php  }
                                    ?>
                               
                               <?php 
                                    $Ttl=DisApproveCommentsAccordingPost($PostID);
                                    if($Ttl > 0){
                                        ?>
                                        <span class='badge badge-danger'>
                                            <?php
                                        echo $Ttl; ?>
                                         </span>
                                  <?php  }
                                    ?>
                            </td>
                            <td>
                                <a target="_blank" href="FullPost.php?id=<?php echo $PostID ?>">
                                <span class='btn btn-info'>Preview</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
                </div>
                <!-- RIGHT SIDE AREA END  -->    
      </div>
    </section>
    <!-- MAINAREA END -->




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
