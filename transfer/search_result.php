<?php
// Initialize the session
 session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
?>
<?php
	$conn = mysqli_connect("localhost", "root", "", "futtie");	
	$search_players = "";
	$search_friendsusernames = "";
	$search_nationality = "";
	$search_clubs = "";
	$search_positions = "";
	$search_rarity = "";
	$search_quality = "";
	$search_league = "";
	$search_bid = "";
	$search_buy_now = "";
	$max = "15000000";
	$min = "200";
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	
	$queryCondition = "";
	if(!empty($_POST["search"])) {
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("search_players","search_friendsusernames","search_nationality","search_clubs", "search_positions","search_quality","search_league","search_rarity","search_quality","search_bid","search_buy_now");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " AND ";
					} else {
						$queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "search_players":
						$search_names = $v;
							$queryCondition .= "name LIKE '%" . $v . "%'";
						break;
					case "search_friendsusernames":
						$search_friendsusernames = $v;
							$queryCondition .= "username LIKE '%" . $v . "%'";
						break;
					case "search_nationality":
						$search_nationality = $v;
							$queryCondition .= "nationality LIKE '%" . $v . "'";
						break;
					case "search_clubs":
						$search_clubs = $v;
							$queryCondition .= "club LIKE '%" . $v . "'";
						break;
					case "search_positions":
						$search_positions = $v;
							$queryCondition .= "position LIKE '%" . $v . "' OR role LIKE '%" . $v ."'";
						break;
					case "search_rarity":
						$search_rarity = $v;
							$queryCondition .= "rarity LIKE '%" . $v . "'";
						break;
					case "search_quality":
						$search_quality = $v;
							$queryCondition .= "quality LIKE '%" . $v . "'";
						break;
					case "search_league":
						$search_league = $v;
							$queryCondition .= "league LIKE '%" . $v . "'";
						break;
					case "search_bid":
						$search_bid = $v;
							$queryCondition .= "bid_price BETWEEN ". $v ." AND ". $max ."";
					break;
					case "search_buy_now":
						$search_buy_now = $v;
							$queryCondition .= "buy_price BETWEEN ". $min ." AND " . $v . "";
						break;
					
				}
			}
		}
	}
	$orderby = " ORDER BY id desc"; 
	$sql = "SELECT name, username, club, position, rarity, quality, league, bid_price, buy_price, card_img, end_time FROM transfer_market" . $queryCondition;
	$result = mysqli_query($conn,$sql);
	
?>
<?php
// Initialize the session
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html>
	<head>
	<title>FUTTIE - Transfer Market</title>
	</head>
<body>
  <link rel='stylesheet' href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">
	<style>
.display {
	position: relative;
	display: inline-block;
    margin: -80px 283px 50px -400px;
    width: 400px;
    height: 400px;
	-webkit-transform: scale(0.6); /* Saf3.1+, Chrome */
     -moz-transform: scale(0.6); /* FF3.5+ */
      -ms-transform: scale(0.6); /* IE9 */
       -o-transform: scale(0.6); /* Opera 10.5+ */
          transform: scale(0.6);
             /* IE6–IE9 */
             filter: progid:DXImageTransform.Microsoft.Matrix(M11=0.9999619230641713, M12=-0.008726535498373935, M21=0.008726535498373935, M22=0.9999619230641713,SizingMethod='auto expand');
}
</style>
<?php
// Create connection
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM users WHERE username = '". $_SESSION['username'] ."'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
  // output data of each row
  while($row = $result2->fetch_assoc()) {
	echo "<div class='container-fluid'>";
  echo "<div id='upper'>";
    echo "<div id='user'>";
      echo "<span id='username'><b>" . $row["username"]. "</b></span><span id='established' class='est'>EST.</span>	&nbsp;<h10>" . $row["established"]. "</h10><p><span id='logout' class='logout'><a href='../logout.php'>LOGOUT</a></span></p></br><p><img src='../img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["coins"]. " Coins</span></p><p class='diamonds'><img src='../img/diamond.png' height='20px' width='20px'>&nbsp;<span id='diamond'>" . $row["diamonds"]. " Diamonds</span></p><p class='record'><img src='../img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Record: " . $row["wins"]. "-" . $row["draws"]. "-" . $row["losses"]. "</span></p>";
    echo "</div>";
  echo "</div>";
  echo "<div id='upper'>";
    echo "<div id='user-right'>";
      echo "<span id='level'><b>LEVEL: </b>" . $row["level"]. "</span><span id='xp' class='xp'>XP</span>	&nbsp;<h10>" . $row["current_xp"]. " / " . $row["next_level"]. "</h10></br><p><img src='../img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["bonus_coins"]. " Bonus Coins</span></p><p class='record'><img src='../img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Winstreak: " . $row["win_streak"]. "</span></p>";
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
      <a href="../main.php"><li class="main">FUTTIE CENTRAL</li></a><a href="market.php"><li class="active">PLAYERS</li></a><a href="../play.php"><li class="main">PLAYERS ON AUCTION</li></a><a href="../club.php"><li class="right">BUY WITH DIAMONDS</li></a>
    </ul>
</nav>
</center>
<div id="menu-wrapper">
  <section id="big-menu-market" class="container-fluid">
    <div class="d-flex flex-row">
				</div>
				
				<div>
			<?php if(ISSET($_POST['go'])) {
				while($row = mysqli_fetch_assoc($result)) { 
			echo "<div class='display'><img src=../store/players/" . $row['card_img']. "></img></div>";
			 }
			}
			?>
			 </div>
    </div>
  </section>
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