<?php
include("../inc/config.php");
?>
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
.duplicate {
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
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

$sql = "SELECT * FROM user_items WHERE duplicate = 0 ORDER BY user_id DESC LIMIT 12";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
echo "<div class='display'><img src=players/" . $row['card_img']. "></img></div>";
}
} else {
  echo "0 results";
}
?>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

$sql = "SELECT * FROM user_items WHERE duplicate = 1 ORDER BY user_id DESC LIMIT 12";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
echo "<div class='duplicate'><img src=players/" . $row['card_img']. "></img><p style='color:red; font-size:20px;'>Duplicate</p></div>";
}
} else {
  echo "0 results";
}
$conn->close();
?>
</body>
</html>