<?php
include('../inc/config.php');
?>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <title>FUTTIE - STORE</title>
  <link rel='stylesheet' href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<!-- partial:index.partial.php -->
<?php
// Create connection
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = '". $_SESSION['username'] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	echo "<div class='container-fluid'>";
  echo "<div role='sub' id='upper'>";
    echo "<div role='sub' id='user'>";
      echo "<span id='username'><b>" . $row["username"]. "</b></span><span id='established' class='est'>EST.</span>	&nbsp;<h10>" . $row["established"]. "</h10><p><span id='logout' class='logout'><a href='../logout.php'>LOGOUT</a></span></p></br><p><img src='../img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["coins"]. " Coins</span></p><p class='diamonds'><img src='../img/diamond.png' height='20px' width='20px'>&nbsp;<span id='diamond'>" . $row["diamonds"]. " Diamonds</span></p><p class='record'><img src='../img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Record: " . $row["wins"]. "-" . $row["draws"]. "-" . $row["losses"]. "</span></p>";
    echo "</div>";
  echo "</div>";
echo "</div>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
<center>
<nav role="sub" class="container-fluid">
    <ul>
      <a href="packs.php"><li class="main">BRONZE PACKS</li></a><a href="silvers.php"><li class="main">SILVER PACKS</li></a><a href="golds.php"><li class="main">GOLD PACKS</li></a><a href="lightning.php"><li class="active">LIGHTNING ROUND</li></a><a href="futties.php"><li class="main">FUTTIE PACKS</li></a>
    </ul>
</nav>
<div id="menu-wrapper">
  <section id="big-menu-two" class="container-fluid">
    <div class="d-flex flex-row">
      <a href="15kpack.php"><div class="p-0 item-packs first-pack-lightning">
        <img src="img/inform.png"></img><h5>15000 Coins <br> 150 Diamonds</h5>
      </div></a>
      <a href="20kpack.php"><div class="p-0 item-packs second-pack-lightning">
        <img src="img/inform.png"></img><h5>20000 Coins <br> or 200 Diamonds</h5>
      </div></a>
	  <a href="30kpack.php"><div class="p-0 item-packs third-pack-lightning">
        <img src="img/inform.png"></img><h5>30000 Coins <br> or 300 Diamonds</h5>
      </div></a>
	  <a href="../store.php"><div class="p-0 item-packs fourth-pack-lightning"><h1>GO BACK</h1>
      </div></a>
    </div>
  </section>

</div>
</center>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
<script src='../js/js.js'></script>
<div class="footer">
  <p>&copy; 2020 - FUTTIE 21. All rights reserved.</p>
</div>
</body>
</html>
