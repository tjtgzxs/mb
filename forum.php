<?php
  include('includes/header.html');
  if(isset($_SESSION['user_tz'])){
      $first="CONVERT_TZ(p.posted_on,'UCT','{$_SESSION['user_tz']}')";
      $last="CONVERT_TZ(p.posted_on,'UTC','{$_SESSION['user_tz']}')";
  }else{
      $first='p.posted_on';
      $last='p.posted_on';
  }
$q="SELECT t.thread_id,t.subject,username,COUNT(post_id)-1 AS responses,MAX(DATE_FORMAT($last,'%e-%b-%y %l:%i %p')) AS last,
   MIN(DATE_FORMAT($first,'%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON
   t.user_id=u.user_id WHERE t.lang_id={$_SESSION['lid']} GROUP BY (p.thread_id)
   ORDER BY last DESC";
$r=mysqli_query($dbc,$q);
if(mysqli_num_rows($r)>0){
echo '<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
        <tr>
         <td align="left" width="50%"><em>'.$words['subject'] .'</em>:</td>
         <td align="left" width="20%" ><em>'.$words['posted_by'] .'</em>:</td>
         <td align="center" width="10%"><em>'.$words['posted_on'].'</em>:</td>
         <td align="center" width="10%"><em>'.$words['replies'].'</em>:</td>
         <td align="center" width="10%"><em>'.$words['latest_reply'].'</em>:</td>
       </tr>';
    while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
       echo '<tr>
              <td align="left"><a href="read.php?tid='.$row['thread_id'].'">'.$row['subject'].'</a> </td>
              <td align="left">'.$row['username'].'</td>
              <td align="center">'.$row['first'].'</td>
              <td align="center">'.$row['responses'].'</td>
              <td align="center">'.$row['last'].'</td>
              </tr>';
    }
    echo '</table>';
}else{
    echo '<p>There are currently no messages in this forum</p>';
}
include 'includes/footer.html';