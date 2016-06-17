<?php
 include 'includes/header.html';
$tid=false;
if(isset($_GET['tid'])&&filter_var($_GET['tid'],FILTER_VALIDATE_INT,array('min_range'=>1))){
  $tid=$_GET['tid'];
    if(isset($_SESSION['user_tz'])){
        $posted="CONVERT_TZ(p.posted_on,'UTC','{$_SESSION['user_tz']}')";
    }else{
        $posted='p.posted_on';
    }
    //Run the query:
    $q="SELECT t.subject,p.message,username,DATE_FORMAT($posted,'%e-%b-%y %l:%i %p') AS posted FROM threads AS t LEFT JOIN posts AS p
        USING(thread_id) INNER JOIN users AS u ON p.user_id=u.user_id WHERE t.thread_id=$tid ORDER BY p.posted_on ASC ";
    $r=mysqli_query($dbc,$q);
    if(!(mysqli_num_rows($r)>0)){
        $tid=false;
    }
}//END OF isset if
if($tid){
    $printed=false;
    while($messages=mysqli_fetch_array($r,MYSQLI_ASSOC)){
        if(!$printed){
            echo "<h2>{$messages['subject']}</h2>\n";
            $printed=TRUE;
        }
        echo "<p>{$messages['subject']}({$messages['posted']})<br />
               {$messages['message']}</p>
               <br />\n";
    }//END of While Loop
    include "includes/post_form.php";
}else{//Invalid thread ID
  echo "<p>This page has been accessed in error";
}
include "includes/footer.html";