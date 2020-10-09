<html>
<head>
</head>
<body>
<style>
.display {
  display: inline-block;
    position: relative;
    margin: 0;
    width: 200px;
    height: 400px;
	-webkit-transform: scale(0.6); /* Saf3.1+, Chrome */
     -moz-transform: scale(0.6); /* FF3.5+ */
      -ms-transform: scale(0.6); /* IE9 */
       -o-transform: scale(0.6); /* Opera 10.5+ */
          transform: scale(0.6);
             /* IE6–IE9 */
             filter: progid:DXImageTransform.Microsoft.Matrix(M11=0.9999619230641713, M12=-0.008726535498373935, M21=0.008726535498373935, M22=0.9999619230641713,SizingMethod='auto expand');
    margin-left: 192px;
}
</style>
<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php
$conn=mysqli_connect("localhost","root","","futtie");
$set=$_POST['name'];
if($set) {
$show="SELECT * FROM user_items WHERE name='$set' AND duplicate = 0";
$result=mysqli_query($conn,$show);
if( mysqli_num_rows($result) == 0 ){
    echo "<div>Uh-oh. You don't have this player!";
}
else {
while($row=mysqli_fetch_array($result)) {
	echo "<div class='display'><img src=../store/players/" . $row['card_img']. "></img></div>";
	
}
}
}
else {
	echo "Uh-oh. You don't have this player!";
}
?>
</body>
</html>