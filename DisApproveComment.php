<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php 
if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $Admin = $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter' ";
    $Execute = $ConnectingDB->query($sql);
    if($Execute){
        $_SESSION["SuccessMessage"]="Comment Dis-Approved Successfully !";
        Redirect_to("Comments.php");
    } else {
        $_SESSION["ErrorMeessage"]="Somthing Went Wrong. Try Again !";
        Redirect_to("Comments.php");
    }
}
?>