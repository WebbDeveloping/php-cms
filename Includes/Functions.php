<?php require_once("Includes/DB.php");?>
<?php 
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}
function CheckUserName($UserName){
global $ConnectingDB;
$sql = "SELECT username FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName', $UserName);
$stmt->execute();
$Result=$stmt->rowcount();
if($Result==1){
    return true;
} else {
    return false;
}
}
function Login_Attempt($UserName, $Password){
    global $ConnectingDB;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt=$ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $UserName);
    $stmt->bindValue(':passWord', $Password);
    $Execute = $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
        return $Found_Account=$stmt->fetch();
    } else {
        return null;
    }
}
function Confirm_Login(){
    if(isset($_SESSION["UserId"])){
        return true;
    } else {
        $_SESSION["ErrorMessage"]='Login Required';
        Redirect_to("Login.php");
    }
}
// I can probably turn this into a single function?
function TotalPosts(){
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM posts';
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    // turning an array into a sstring function
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}
function TotalCategory(){
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM category';
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    // turning an array into a sstring function
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;
}
function TotalAdmins(){
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM admins';
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    // turning an array into a sstring function
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;

}
function TotalComments(){
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM comments';
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    // turning an array into a sstring function
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}
function ApproveCommentsAccordingPost($PostID){
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id = '$PostID' AND status='ON'";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $RT = $stmtApprove->fetch();
    $Ttl = array_shift($RT);
    return $Ttl;
}
function DisApproveCommentsAccordingPost($PostID){
    global $ConnectingDB;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id = '$PostID' AND status='OFF'";
    $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
    $RT = $stmtDisApprove->fetch();
    $Ttl = array_shift($RT);
    return $Ttl;
}
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
?>