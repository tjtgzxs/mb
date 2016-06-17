<?php
include 'includes/header.html';
if(isset($_SESSION['user_id'])){
    header ("Location: index.php");
    exit();
}else{

        if(isset($_POST['user_id_login'])&&isset($_POST['password'])&&(!empty($_POST['user_id_login']))&&(!empty($_POST['password']))){
            $user_id_login=htmlspecialchars($_POST['user_id_login']);
            $password=sha1(htmlspecialchars($_POST['password']));
            $q="SELECT * FROM users WHERE username='$user_id_login' AND pass='$password' ";
            $r=mysqli_query($dbc,$q);
            if(mysqli_num_rows($r)==1) {
                $user_info = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $_SESSION['user_id'] = $user_info['user_id'];
                $_SESSION['user_tz'] = $user_info['time_zone'];
                header("Location: index.php");
              }else{
                echo 'Please input right username and password.';
              }
            }elseif(((!isset($_POST['user_id_login']))||(empty($_POST['user_id_login'])))&&((isset($_POST['password']))||(!empty($_POST['password'])))){
                 echo 'Please input your username.';
            }elseif((!isset($_POST['password']))||(empty($_POST['password']))){
                 echo 'Please input your password.';
            }elseif(((!isset($_POST['user_id_login']))&&(!isset($_POST['password'])))||((empty($_POST['user_id_login']))&&(empty($_POST['password'])))){
                echo 'Please input your username and password.';
            }


}
?>
 <form action="login.php" method="post" accept-charset="utf-8">
     <label for="user_id_login">username:</label><input name="user_id_login" type="text" value="<?php if(isset($_POST['user_id_login'])) echo $_POST['user_id_login']; ?>" size="15" maxlength="30"/>
     <label for="password">password:</label><input name="password" type="password" />
     <input type="submit" name="submit" value="Submit">
 </form>
<?php
include 'includes/footer.html';
?>