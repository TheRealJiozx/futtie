<?php
include('../inc/config.php');
?>

<html>
<head>
<title>FUTTIE - GOLD PACK</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="../js/js.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="../css/pack.css">
<link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
<canvas id="myCanvas" height="200" width="800"></canvas>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="../js/script.js"></script>
<div class="background"></div>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

$sql = "SELECT * FROM user_items ORDER BY rating * user_id DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	  echo "<script>";
echo "$(function () { ";
  echo "count = 0; ";
  echo "wordsArray = ['" . $row['card_type']. "', '" . $row['country']. "', '" . $row['name']. "'];"; 
  echo "setInterval(function () { ";
    echo "count++; ";
    echo "$('#word').fadeOut(500, function () { ";
      echo "$(this).text(wordsArray[count % wordsArray.length]).fadeIn(500); ";
   echo "});"; 
  echo "}, 3000); ";
echo "}); ";
echo "</script>";
	echo "<section-pack>";
	 echo "<p id='pack'><img src='img/gold.png'></img></p>";
	 echo "</section-pack>";
	 echo "<section-pack-rotate>";
	 echo "<p id='pack-rotate'><img src='img/gold.png'></img></p>";
	 echo "</section-pack-rotate>";
echo "<div class='country'><img src=img/" . $row['country_img']. "></img></div>";
echo "<div class='position'>" . $row['position']. "</div>";
echo "<div class='club'><img src=img/" . $row['club_img']. "></img></div>";
echo "<section-confetti>";
		echo "<img id='conf1' src='img/confetti.gif'></img>";
	echo "</section-confetti>";
	echo "<section-confetti-right>";
		echo "<img id='conf2' src='img/confetti.gif'></img>";
	echo "</section-confetti-right>";
	echo "<section-fireworks>";
		echo "<p id='fireworks-yellow-left'><img src='img/fireworks-yellow-left.gif'></img></p>";
	echo "</section-fireworks>";
	echo "<section-fireworks-right>";
		echo "<p id='fireworks-yellow'><img src='img/fireworks-yellow.gif'></img></p>";
	echo "</section-fireworks-right>";
	echo "<section-rocket>";
		echo "<p id='rocket-red-left'><img src='img/rocket-red-left.gif'></img></p>";
	echo "</section-rocket>";
	echo "<section-rocket-right>";
		echo "<p id='rocket-red'><img src='img/rocket-red.gif'></img></p>";
	echo "</section-rocket-right>";
	echo "<section-fireworks-middle-left>";
		echo "<img src='img/fireworks-middle.gif'></img>";
	echo "</section-fireworks-middle-left>";
	echo "<section-fireworks-middle>";
		echo "<img src='img/fireworks-middle.gif'></img>";
	echo "</section-fireworks-middle>";
	echo "<section-fireworks-bottom>";
		echo "<img src='img/fireworks-bottom.gif'></img>";
	echo "</section-fireworks-bottom>";
echo "<div class='card'><img src=players/" . $row['card_img']. "></img></div>";
echo "<div class='border'><div style='margin:0px 0'>" . $row['rating']. "</div><div style='margin:0px 0'><img src=img/" . $row['club_img']. "></img></div><div style='margin:20px 0'><img src=img/" . $row['country_img']. " style='min-width: 290px;'></img></div></div>";
echo "<div class='border-right'><div style='margin:0px 0'>" . $row['rating']. "</div><div style='margin:0px 0'><img src=img/" . $row['club_img']. "></img></div><div style='margin:20px 0'><img src=img/" . $row['country_img']. " style='min-width: 290px;'></img></div></div>";
echo "<div class='round-borders'><div style='margin: 10px 0'><b><span id='word'></span></b></div></div>";
echo "<div class='walkout'><img src=img/" . $row['walkout_img']. "></img></div>";
echo "<div class='skip'><a href='displayall.php'><center>SKIP</center></font></a></div>";
}
} else {
  echo "0 results";
}
$conn->close();
?>
<script type="text/javascript">
$(document).ready(function () {
    $(document).on("keydown", function(e) {
        e = e || window.event;
        if (e.ctrlKey) {
            var c = e.which || e.keyCode;
            if (c == 82) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    });
});
</script>
</body>
</html>