<?php
 include "includes/header.html";
if(isset($_SESSION['user_id'])){
    header ("Location: index.php");
    exit();
}else{

        if((!isset($_POST['username_register']))||empty($_POST['username_register'])){
            echo 'Please inout your username';
        }elseif((!isset($_POST['ps1']))||(empty($_POST['ps1']))){
            echo 'Please input your password.';
        }elseif((!isset($_POST['ps2']))||empty($_POST['ps2'])){
            echo 'Please input your password confirmation';
        }elseif($_POST['ps1']!=$_POST['ps2']){
            echo 'Please input same password.';
        }elseif((!isset($_POST['email']))||empty($_POST['email'])) {
            echo 'Please input email';
        }elseif(isset($_POST['username_register'])&&isset($_POST['ps1'])&&isset($_POST['ps2'])&&($_POST['ps1']==$_POST['ps2'])){
            $username_register=htmlspecialchars(trim($_POST['username_register']));
            $pass=sha1(htmlspecialchars(trim($_POST['ps1'])));
            $email=htmlspecialchars(trim($_POST['email']));
            $q="SELECT username FROM users WHERE username='$username_register'";
            $r=mysqli_query($dbc,$q);
            if(mysqli_num_rows($r)>0){
                echo 'The username was registered, Please create a new one';
            }elseif(mysqli_num_rows($r)==0) {
                $q = "INSERT INTO users (lang_id,time_zone,username,pass,email)VALUES(1,'America/New_York','$username_register','$pass','$email') ";
                $r = mysqli_query($dbc, $q);
                if (mysqli_affected_rows($dbc) == 1) {
                    echo 'success';
                    $q="SELECT user_id FROM users WHERE username='$username_register'";
                    $r=mysqli_query($dbc,$q);
                    if(mysqli_num_rows($r)==1){
                        $user_id=mysqli_fetch_array($r,MYSQLI_ASSOC);
                        $_SESSION['user_id']=$user_id['user_id'];
                        $_SESSION['user_tz'] = $user_info['time_zone'];
                        header("Location: index.php");
                    }
                }
            }
        }

}
?>
 <form action="register.php" method="post" accept-charset="UTF-8">
     <label for="username_register">username</label><input type="text" name="username_register" size="15" maxlength="30" />
     <label for="ps1">Password</label><input type="password" name="ps1">
     <label for="ps2">Password Confirmation</label><input type="password" name="ps2">
     <label for="email">Email</label><input type="email" name="email">
     <input type="submit" value="Submit" name="submit">
 </form>
<?php
include "includes/footer.html";
?>