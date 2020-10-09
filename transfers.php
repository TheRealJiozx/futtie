<?php
include('inc/config.php');
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
  <title>FUTTIE - TRANSFERS</title>
  <link rel='stylesheet' href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">

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
  echo "<div id='upper'>";
    echo "<div id='user'>";
      echo "<span id='username'><b>" . $row["username"]. "</b></span><span id='established' class='est'>EST.</span>	&nbsp;<h10>" . $row["established"]. "</h10><p><span id='logout' class='logout'><a href='logout.php'>LOGOUT</a></span></p></br><p><img src='img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["coins"]. " Coins</span></p><p class='diamonds'><img src='img/diamond.png' height='20px' width='20px'>&nbsp;<span id='diamond'>" . $row["diamonds"]. " Diamonds</span></p><p class='record'><img src='img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Record: " . $row["wins"]. "-" . $row["draws"]. "-" . $row["losses"]. "</span></p>";
    echo "</div>";
  echo "</div>";
  echo "<div id='upper'>";
    echo "<div id='user-right'>";
      echo "<span id='level'><b>LEVEL: </b>" . $row["level"]. "</span><span id='xp' class='xp'>XP</span>	&nbsp;<h10>" . $row["current_xp"]. " / " . $row["next_level"]. "</h10></br><p><img src='img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["bonus_coins"]. " Bonus Coins</span></p><p class='record'><img src='img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Winstreak: " . $row["win_streak"]. "</span></p>";
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
<nav class="container-fluid">
    <ul>
      <a href="main.php"><li class="main">FUTTIE CENTRAL</li></a><a href="play.php"><li class="main">PLAY</li></a><a href="online.php"><li class="main">ONLINE</li></a><a href="squads.php"><li class="main">SQUADS</li></a><a href="transfers.php"><li class="active"><b>TRANSFERS</b></li></a><a href="store.php"><li class="main">STORE</li></a><a href="club.php"><li class="right">MY CLUB</li></a>
    </ul>
</nav>
<div id="menu-wrapper">
  <section id="big-menu" class="container-fluid">
    <div class="d-flex flex-row">
      <a href="transfer/market.php"><div class="p-0 item first-transfers">
        <h2>TRANSFER MARKET</h2>
      </div></a>
    </div>
    <div class="d-flex flex-row">
      <a href="transfer/list.php"><div class="p-0 item second-transfers">
        <h2>TRANSFER LIST</h2>
      </div></a>
      <a href="transfer/targets.php"><div class="p-0 item third-transfers">
        <h2>TRANSFER TARGETS</h2>
      </div></a>
    </div>
  </section>

</div>
</center>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
<script src='js/js.js'></script>
<div class="footer">
  <p>&copy; 2020 - FUTTIE 21. All rights reserved.</p>
</div>
</body>
</html>
