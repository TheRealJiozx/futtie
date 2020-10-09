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
<html>
	<head>
	<title>FUTTIE - Transfer Market</title>
  <script type="text/javascript" src="//code.jquery.com/jquery-git.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	</head>
<body>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
	<style>
		.search-box {
			display: flex;
			flex-wrap: wrap;
			padding: 55 0 100 250;
			background-color:#EBECF0;
			height: 560px;
			margin: 25px 450px 0 300px;
			
		}
		.search-label{
			margin:10px 470px 0 0;
		}
		.search_players {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			height: 44px;
			flex: 0 0 33.333333%;
		}
		.search_friendsusernames {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			height: 44px;
			flex: 0 0 33.333333%;
		}
		.search_quality {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			height: 44px;
			flex: 0 0 33.333333%;
			width: 250px;
		}
		.search_rarity {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			height: 44px;
			flex: 0 0 33.333333%;
			width: 250px;
		}
		.search_clubs {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.search_nationality {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.search_leagues {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.search_positions {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 250px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.search_min_bid {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 10px;
			width: 306px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.search_buy_now {	
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin:10px 0 0 6px;
			width: 306px;
			flex: 0 0 33.333333%;
			height: 44px;
		}
		.btnSearch{	
			padding: 10px;
			background: #84D2A7;
			border: 0;
			border-radius: 4px;
			margin: 15px -4px;
			color: #FFF;
			width: 306px;
		}
		.btnReset{	
			padding: 10px;
			background: red;
			border: 0;
			border-radius: 4px;
			margin: 15px 10px;
			color: #FFF;
			width: 306px;
		}
		form {
  margin: 0 auto;
  text-align: center;
  padding-top: 50px;
}
		.text-market {
			margin: -20px 80px;
		}
		.value-button {
  display: inline-block;
  border: 1px solid #ddd;
  margin: 0px;
  width: 40px;
  height: 20px;
  text-align: center;
  vertical-align: middle;
  padding: 11px 0;
  background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.value-button:hover {
  cursor: pointer;
}

form #decrease {
  margin-right: -4px;
  border-radius: 8px 0 0 8px;
}

form #increase {
  margin-left: -4px;
  border-radius: 0 8px 8px 0;
}

form #input-wrap {
  margin: 0px;
  padding: 0px;
}

input#number {
  text-align: center;
  border: none;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  margin: 0px;
  width: 40px;
  height: 40px;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<?php
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM users WHERE username = '". $_SESSION['username'] ."'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
  // output data of each row
  while($row = $result2->fetch_assoc()) {
	echo "<div class='container-fluid'><div id='upper'><div id='user'><span id='username'><b>" . $row["username"]. "</b></span><span id='established' class='est'>EST.</span>	&nbsp;<h10>" . $row["established"]. "</h10><p><span id='logout' class='logout'><a href='../logout.php'>LOGOUT</a></span></p></br><p><img src='../img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["coins"]. " Coins</span></p><p class='diamonds'><img src='../img/diamond.png' height='20px' width='20px'>&nbsp;<span id='diamond'>" . $row["diamonds"]. " Diamonds</span></p><p class='record'><img src='../img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Record: " . $row["wins"]. "-" . $row["draws"]. "-" . $row["losses"]. "</span></p></div></div>";
  echo "<div id='upper'><div id='user-right'><span id='level'><b>LEVEL: </b>" . $row["level"]. "</span><span id='xp' class='xp'>XP</span>	&nbsp;<h10>" . $row["current_xp"]. " / " . $row["next_level"]. "</h10></br><p><img src='../img/coin.png' height='15px' width='15px'>&nbsp;<span id='coins'>" . $row["bonus_coins"]. " Bonus Coins</span></p><p class='record'><img src='../img/record.png' height='15px' width='15px'>&nbsp;<span id='record'>Winstreak: " . $row["win_streak"]. "</span></p></div></div></div>";
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
    <div>
			<form name="frmSearch" method="post" action="search_result.php">
			<div class="search-box">
					<input type="text" list="friendsusernames" name="search[search_friendsusernames]" id="search_friendsusernames" class="search_friendsusernames" value="<?php echo $search_friendsusernames; ?>" placeholder="Type Username" maxlength="50">
					<datalist id="friendsusernames">
					  <option value="OMARBIAAAATCH">OMARBIAAAATCH</option>
					  <option value="NOPE">NOPE</option>
					  </datalist>
					<input type="text" list="names" name="search[search_players]" id="search_players" class="search_players" value="<?php echo $search_players; ?>" placeholder="Type Player Name" maxlength="50">
					<datalist id="names">
					  <option value="Lionel Messi">Lionel Messi</option>
					  <option value="Cristiano Ronaldo">Cristiano Ronaldo</option>
					  <option value="Kylian Mbappé">Kylian Mbappé</option>
					  </datalist>
						<select name="search[search_rarity]" list="rarity" id="search_rarity" class="search_rarity" value="<?php echo $search_rarity; ?>">
							<datalist id="rarity">
							<option value="" disabled selected hidden <?php if($search_rarity=="rarity") { echo "selected"; } ?>>Rarity</option>
							<option value="Bronze" <?php if($search_rarity=="rarity") { echo "selected"; } ?>>Bronze</option>
							<option value="Silver" <?php if($search_rarity=="rarity") { echo "selected"; } ?>>Silver</option>
							<option value="Gold" <?php if($search_rarity=="rarity") { echo "selected"; } ?>>Gold</option>
							<option value="Special" <?php if($search_rarity=="rarity") { echo "selected"; } ?>>Special</option>
							</datalist>
						</select>
						<select name="search[search_quality]" list="quality" id="search_quality" class="search_quality" value="<?php echo $search_quality; ?>">
							<datalist id="quality">
							<option value="" disabled selected hidden <?php if($search_quality=="quality") { echo "selected"; } ?>>Quality</option>
							<option value="Common" <?php if($search_quality=="quality") { echo "selected"; } ?>>Common</option>
							<option value="Rare" <?php if($search_quality=="quality") { echo "selected"; } ?>>Rare</option>
							<option value="Team of The Season" <?php if($search_quality=="quality") { echo "selected"; } ?>>Team of The Season</option>
							<option value="Team of The Year" <?php if($search_quality=="quality") { echo "selected"; } ?>>Team of The Year</option>
							</datalist>
						</select>
						<select name="search[search_positions]" list="positions" id="search_positions" class="search_positions" value="<?php echo $search_positions; ?>">
							<datalist id="positions">
							<option value="" disabled selected hidden <?php if($search_positions=="position") { echo "selected"; } ?>>Position</option>
							<option value="Defender" <?php if($search_positions=="role") { echo "selected"; } ?>>Defenders</option>
							<option value="Midfielder" <?php if($search_positions=="role") { echo "selected"; } ?>>Midfielders</option>
							<option value="Attacker" <?php if($search_positions=="role") { echo "selected"; } ?>>Attackers</option>
							<option value="GK" <?php if($search_positions=="position") { echo "selected"; } ?>>GK</option>
							<option value="RWB" <?php if($search_positions=="position") { echo "selected"; } ?>>RWB</option>
							<option value="RB" <?php if($search_positions=="position") { echo "selected"; } ?>>RB</option>
							<option value="CB" <?php if($search_positions=="position") { echo "selected"; } ?>>CB</option>
							<option value="LB" <?php if($search_positions=="position") { echo "selected"; } ?>>LB</option>
							<option value="LWB" <?php if($search_positions=="position") { echo "selected"; } ?>>LWB</option>
							<option value="CDM" <?php if($search_positions=="position") { echo "selected"; } ?>>CDM</option>
							<option value="RM" <?php if($search_positions=="position") { echo "selected"; } ?>>RM</option>
							<option value="CM" <?php if($search_positions=="position") { echo "selected"; } ?>>CM</option>
							<option value="LM" <?php if($search_positions=="position") { echo "selected"; } ?>>LM</option>
							<option value="CAM" <?php if($search_positions=="position") { echo "selected"; } ?>>CAM</option>
							<option value="RF" <?php if($search_positions=="position") { echo "selected"; } ?>>RF</option>
							<option value="CF" <?php if($search_positions=="position") { echo "selected"; } ?>>CF</option>
							<option value="LF" <?php if($search_positions=="position") { echo "selected"; } ?>>LF</option>
							<option value="RW" <?php if($search_positions=="position") { echo "selected"; } ?>>RW</option>
							<option value="ST" <?php if($search_positions=="position") { echo "selected"; } ?>>ST</option>
							<option value="LW" <?php if($search_positions=="position") { echo "selected"; } ?>>LW</option>
							</datalist>
						</select>
						<select name="search[search_nationality]" list="nationality" id="search_nationality" class="search_nationality" value="<?php echo $search_nationality; ?>">
							<datalist id="nationality">
							<option value="" disabled selected hidden <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Nationality</option>
							<option value="" <?php if($search_nationality=="nationality") { echo "selected"; } ?>></option>
							<option value="Afghanistan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Afghanistan</option>
							<option value="Albania" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Albania</option>
							<option value="Algeria" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Algeria</option>
							<option value="Andorra" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Andorra</option>
							<option value="Angola" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Angola</option>
							<option value="Anti and Barbuda" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Anti and Barbuda</option>
							<option value="Argentina" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Argentina</option>
							<option value="Armenia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Armenia</option>
							<option value="Australia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Australia</option>
							<option value="Austria" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Austria</option>
							<option value="Azerbaijan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Azerbaijan</option>
							<option value="Bahamas" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bahamas</option>
							<option value="Bahrain" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bahrain</option>
							<option value="Bangladesh" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bangladesh</option>
							<option value="Barbados" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Barbados</option>
							<option value="Belarus" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Belarus</option>
							<option value="Belgium" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Belgium</option>
							<option value="Belize" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Belize</option>
							<option value="Benin" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Benin</option>
							<option value="Bhutan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bhutan</option>
							<option value="Bolivia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bolivia</option>
							<option value="Bosnia and Herzegovina" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bosnia and Herzegovina</option>
							<option value="Botswana" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Botswana</option>
							<option value="Brazil" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Brazil</option>
							<option value="Brunei" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Brunei</option>
							<option value="Bulgaria" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Bulgaria</option>
							<option value="Burkina Faso" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Burkina Faso</option>
							<option value="Burundi" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Burundi</option>
							<option value="Cambodia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cambodia</option>
							<option value="Cameroon" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cameroon</option>
							<option value="Canada" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Canada</option>
							<option value="Cape Verde" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cape Verde</option>
							<option value="Central African Republic" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Central African Republic</option>
							<option value="Chad" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Chad</option>
							<option value="Chile" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Chile</option>
							<option value="China" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>China</option>
							<option value="Colombia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Colombia</option>
							<option value="Comoros" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Comoros</option>
							<option value="Congo (Brazzaville)" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Congo(Brazzaville)</option>
							<option value="Congo" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Congo</option>
							<option value="Costa Rica" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Costa Rica</option>
							<option value="Cote d'Ivoire" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cote d'Ivoire</option>
							<option value="Croatia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Croatia</option>
							<option value="Cuba" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cuba</option>
							<option value="Cyprus" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Cyprus</option>
							<option value="Czech Republic" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Czech Republic</option>
							<option value="Denmark" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Denmark</option>
							<option value="Djibouti" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Djibouti</option>
							<option value="Dominica" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Dominica</option>
							<option value="Dominican Republic" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Dominican Republic</option>
							<option value="East Timor (Timor Timur)" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>East Timor (Timor Timur)</option>
							<option value="Ecuador" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Ecuador</option>
							<option value="Egypt" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Egypt</option>
							<option value="El Salvador" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>El Salvador</option>
							<option value="Equatorial Guinea" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Equatorial Guinea</option>
							<option value="Eritrea" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Eritrea</option>
							<option value="Estonia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Estonia</option>
							<option value="Ethiopia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Ethiopia</option>
							<option value="Fiji" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Fiji</option>
							<option value="Finland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Finland</option>
							<option value="France" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>France</option>
							<option value="Gabon" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Gabon</option>
							<option value="Gambia, The" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Gambia, The</option>
							<option value="Georgia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Georgia</option>
							<option value="Germany" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Germany</option>
							<option value="Ghana" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Ghana</option>
							<option value="Greece" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Greece</option>
							<option value="Grenada" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Grenada</option>
							<option value="Guatemala" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Guatemala</option>
							<option value="Guinea" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Guinea</option>
							<option value="Guinea-Bissau" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Guinea-Bissau</option>
							<option value="Guyana" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Guyana</option>
							<option value="Haiti" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Haiti</option>
							<option value="Honduras" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Honduras</option>
							<option value="Hungary" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Hungary</option>
							<option value="Iceland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Iceland</option>
							<option value="India" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>India</option>
							<option value="Indonesia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Indonesia</option>
							<option value="Iran" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Iran</option>
							<option value="Iraq" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Iraq</option>
							<option value="Ireland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Ireland</option>
							<option value="Israel" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Israel</option>
							<option value="Italy" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Italy</option>
							<option value="Jamaica" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Jamaica</option>
							<option value="Japan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Japan</option>
							<option value="Jordan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Jordan</option>
							<option value="Kazakhstan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Kazakhstan</option>
							<option value="Kenya" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Kenya</option>
							<option value="Kiribati" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Kiribati</option>
							<option value="Korea, North" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Korea, North</option>
							<option value="Korea, South" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Korea, South</option>
							<option value="Kuwait" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Kuwait</option>
							<option value="Kyrgyzstan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Kyrgyzstan</option>
							<option value="Laos" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Laos</option>
							<option value="Latvia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Latvia</option>
							<option value="Lebanon" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Lebanon</option>
							<option value="Lesotho" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Lesotho</option>
							<option value="Liberia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Liberia</option>
							<option value="Libya" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Libya</option>
							<option value="Liechtenstein" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Liechtenstein</option>
							<option value="Lithuania" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Lithuania</option>
							<option value="Luxembourg" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Luxembourg</option>
							<option value="Macedonia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Macedonia</option>
							<option value="Madagascar" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Madagascar</option>
							<option value="Malawi" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Malawi</option>
							<option value="Malaysia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Malaysia</option>
							<option value="Maldives" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Maldives</option>
							<option value="Mali" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mali</option>
							<option value="Malta" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Malta</option>
							<option value="Marshall Islands" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Marshall Islands</option>
							<option value="Mauritania" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mauritania</option>
							<option value="Mauritius" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mauritius</option>
							<option value="Mexico" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mexico</option>
							<option value="Micronesia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Micronesia</option>
							<option value="Moldova" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Moldova</option>
							<option value="Monaco" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Monaco</option>
							<option value="Mongolia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mongolia</option>
							<option value="Morocco" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Morocco</option>
							<option value="Mozambique" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Mozambique</option>
							<option value="Myanmar" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Myanmar</option>
							<option value="Namibia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Namibia</option>
							<option value="Nauru" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Nauru</option>
							<option value="Nepal" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Nepal</option>
							<option value="Netherlands" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Netherlands</option>
							<option value="New Zealand" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>New Zealand</option>
							<option value="Nicaragua" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Nicaragua</option>
							<option value="Niger" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Niger</option>
							<option value="Nigeria" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Nigeria</option>
							<option value="Norway" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Norway</option>
							<option value="Oman" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Oman</option>
							<option value="Pakistan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Pakistan</option>
							<option value="Palau" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Palau</option>
							<option value="Panama" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Panama</option>
							<option value="Papua New Guinea" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Papua New Guinea</option>
							<option value="Paraguay" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Paraguay</option>
							<option value="Peru" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Peru</option>
							<option value="Philippines" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Philippines</option>
							<option value="Poland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Poland</option>
							<option value="Palestine" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Palestine</option>
							<option value="Portugal" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Portugal</option>
							<option value="Qatar" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Qatar</option>
							<option value="Romania" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Romania</option>
							<option value="Russia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Russia</option>
							<option value="Rwanda" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Rwanda</option>
							<option value="Saint Kitts and Nevis" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Saint Kitts and Nevis</option>
							<option value="Saint Lucia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Saint Lucia</option>
							<option value="Saint Vincent" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Saint Vincent</option>
							<option value="Samoa" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Samoa</option>
							<option value="San Marino" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>San Marino</option>
							<option value="Sao Tome and Principe" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Sao Tome and Principe</option>
							<option value="Saudi Arabia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Saudi Arabia</option>
							<option value="Senegal" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Senegal</option>
							<option value="Serbia and Montenegro" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Serbia and Montenegro</option>
							<option value="Seychelles" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Seychelles</option>
							<option value="Sierra Leone" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Sierra Leone</option>
							<option value="Singapore" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Singapore</option>
							<option value="Slovakia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Slovakia</option>
							<option value="Slovenia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Slovenia</option>
							<option value="Solomon Islands" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Solomon Islands</option>
							<option value="Somalia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Somalia</option>
							<option value="South Africa" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>South Africa</option>
							<option value="Spain" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Spain</option>
							<option value="Sri Lanka" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Sri Lanka</option>
							<option value="Sudan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Sudan</option>
							<option value="Suriname" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Suriname</option>
							<option value="Swaziland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Swaziland</option>
							<option value="Sweden" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Sweden</option>
							<option value="Switzerland" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Switzerland</option>
							<option value="Syria" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Syria</option>
							<option value="Taiwan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Taiwan</option>
							<option value="Tajikistan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Tajikistan</option>
							<option value="Tanzania" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Tanzania</option>
							<option value="Thailand" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Thailand</option>
							<option value="Togo" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Togo</option>
							<option value="Tonga" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Tonga</option>
							<option value="Trinidad and Tobago" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Trinidad and Tobago</option>
							<option value="Tunisia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Tunisia</option>
							<option value="Turkey" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Turkey</option>
							<option value="Turkmenistan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Turkmenistan</option>
							<option value="Tuvalu" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Tuvalu</option>
							<option value="Uganda" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Uganda</option>
							<option value="Ukraine" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Ukraine</option>
							<option value="United Arab Emirates" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>United Arab Emirates</option>
							<option value="United Kingdom" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>United Kingdom</option>
							<option value="United States" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>United States</option>
							<option value="Uruguay" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Uruguay</option>
							<option value="Uzbekistan" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Uzbekistan</option>
							<option value="Vanuatu" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Vanuatu</option>
							<option value="Vatican City" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Vatican City</option>
							<option value="Venezuela" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Venezuela</option>
							<option value="Vietnam" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Vietnam</option>
							<option value="Yemen" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Yemen</option>
							<option value="Zambia" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Zambia</option>
							<option value="Zimbabwe" <?php if($search_nationality=="nationality") { echo "selected"; } ?>>Zimbabwe</option>
							</datalist>
							</select>
						<select name="search[search_clubs]" list="clubs" id="search_clubs" class="search_clubs" value="<?php echo $search_clubs; ?>">
							<datalist id="club">
							<option value="" disabled selected hidden <?php if($search_clubs=="club") { echo "selected"; } ?>>Club</option>
							<option value="FC Barcelona" <?php if($search_clubs=="club") { echo "selected"; } ?>>FC Barcelona</option>
							<option value="Juventus" <?php if($search_clubs=="club") { echo "selected"; } ?>>Juventus</option>
							<option value="Paris Saint Germain" <?php if($search_clubs=="club") { echo "selected"; } ?>>Paris Saint Germain</option>
							</datalist>
						</select>
						<select name="search[search_league]" list="league" id="search_league" class="search_leagues" value="<?php echo $search_league; ?>">
							<datalist id="league">
							<option value="" disabled selected hidden <?php if($search_league=="league") { echo "selected"; } ?>>League</option>
							<option value="" <?php if($search_league=="league") { echo "selected"; } ?>></option>
							<option value="Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Premier League</option>
							<option value="Premier League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Premier League Women</option>
							<option value="Sky Bet Championship" <?php if($search_league=="league") { echo "selected"; } ?>>Sky Bet Championship</option>
							<option value="Sky Bet League 1" <?php if($search_league=="league") { echo "selected"; } ?>>Sky Bet League 1</option>
							<option value="Sky Bet League 2" <?php if($search_league=="league") { echo "selected"; } ?>>Sky Bet League 2</option>
							<option value="LaLiga Santander" <?php if($search_league=="league") { echo "selected"; } ?>>LaLiga Santander</option>
							<option value="LaLiga Smartbank" <?php if($search_league=="league") { echo "selected"; } ?>>LaLiga Smartbank</option>
							<option value="Segunda B" <?php if($search_league=="league") { echo "selected"; } ?>>Segunda B</option>
							<option value="Primera Division Women" <?php if($search_league=="league") { echo "selected"; } ?>>Primera Division Women</option>
							<option value="Serie A" <?php if($search_league=="league") { echo "selected"; } ?>>Serie A</option>
							<option value="Serie A Women" <?php if($search_league=="league") { echo "selected"; } ?>>Serie A Women</option>
							<option value="Serie B" <?php if($search_league=="league") { echo "selected"; } ?>>Serie B</option>
							<option value="Bundesliga" <?php if($search_league=="league") { echo "selected"; } ?>>Bundesliga</option>
							<option value="Bundesliga Women" <?php if($search_league=="league") { echo "selected"; } ?>>Bundesliga Women</option>
							<option value="2nd Bundesliga" <?php if($search_league=="league") { echo "selected"; } ?>>2nd Bundesliga</option>
							<option value="Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>Ligue 1</option>
							<option value="Division 1 Women" <?php if($search_league=="league") { echo "selected"; } ?>>Division 1 Women</option>
							<option value="Ligue 2" <?php if($search_league=="league") { echo "selected"; } ?>>Ligue 2</option>
							<option value="Eridivise" <?php if($search_league=="league") { echo "selected"; } ?>>Eridivise</option>
							<option value="Eridivise Women" <?php if($search_league=="league") { echo "selected"; } ?>>Eridivise Women</option>
							<option value="Jupiler League" <?php if($search_league=="league") { echo "selected"; } ?>>Jupiler League</option>
							<option value="Belgium Super League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Belgium Super League Women</option>
							<option value="Primiera Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Primiera Liga</option>
							<option value="Campeonato Nacional Women" <?php if($search_league=="league") { echo "selected"; } ?>>Campeonato Nacional Women</option>
							<option value="Premiership" <?php if($search_league=="league") { echo "selected"; } ?>>Premiership</option>
							<option value="Championship" <?php if($search_league=="league") { echo "selected"; } ?>>Championship</option>
							<option value="Premier League 1 Women" <?php if($search_league=="league") { echo "selected"; } ?>>Premier League 1 Women</option>
							<option value="Austrian Bundesliga" <?php if($search_league=="league") { echo "selected"; } ?>>Austrian Bundesliga</option>
							<option value="Austrian Bundesliga Women" <?php if($search_league=="league") { echo "selected"; } ?>>Austrian Bundesliga Women</option>
							<option value="Cyrpus Super Cup" <?php if($search_league=="league") { echo "selected"; } ?>>Cyprus Super Cup</option>
							<option value="Superligaen" <?php if($search_league=="league") { echo "selected"; } ?>>Superligaen</option>
							<option value="Kvinde LP" <?php if($search_league=="league") { echo "selected"; } ?>>Kvinde LP</option>
							<option value="Veikkausliiga" <?php if($search_league=="league") { echo "selected"; } ?>>Veikkausliiga</option>
							<option value="Kansallinen Liiga Women" <?php if($search_league=="league") { echo "selected"; } ?>>Kansallinen Liiga Women</option>
							<option value="Greek Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Greek Super League</option>
							<option value="Greek Super League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Greek Super League Women</option>
							<option value="Urvalsdeild" <?php if($search_league=="league") { echo "selected"; } ?>>Urvalsdeild</option>
							<option value="1. Deild Women" <?php if($search_league=="league") { echo "selected"; } ?>>1. Deild Women</option>
							<option value="Irish Premier Division" <?php if($search_league=="league") { echo "selected"; } ?>>Irish Premier Division</option>
							<option value="Luxembourgers National Division" <?php if($search_league=="league") { echo "selected"; } ?>>Luxembourgers National Division</option>
							<option value="Eliteserien" <?php if($search_league=="league") { echo "selected"; } ?>>Eliteserien</option>
							<option value="Toppserien Women" <?php if($search_league=="league") { echo "selected"; } ?>>Toppserien</option>
							<option value="Northern Irish Premiership" <?php if($search_league=="league") { echo "selected"; } ?>>Northern Irish Premiership</option>
							<option value="Allsvenskan" <?php if($search_league=="league") { echo "selected"; } ?>>Allsvenskan</option>
							<option value="Damallsvenskan Women" <?php if($search_league=="league") { echo "selected"; } ?>>Damallsvenskan Women</option>
							<option value="Switzerland Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Switzerland Super League</option>
							<option value="NLA Women" <?php if($search_league=="league") { echo "selected"; } ?>>NLA Women</option>
							<option value="Super Lig" <?php if($search_league=="league") { echo "selected"; } ?>>Super Lig</option>
							<option value="Cymru Premier" <?php if($search_league=="league") { echo "selected"; } ?>>Cymru Premier</option>
							<option value="Belarusian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Belarusian Premier League</option>
							<option value="Premija Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Premija Liga</option>
							<option value="Parva Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Parva Liga</option>
							<option value="Croatian 1st League" <?php if($search_league=="league") { echo "selected"; } ?>>Croatian 1st League</option>
							<option value="Czechs 1st League" <?php if($search_league=="league") { echo "selected"; } ?>>Czechs 1st League</option>
							<option value="Czechs 1st League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Czechs 1st League Women</option>
							<option value="Meistriliiga" <?php if($search_league=="league") { echo "selected"; } ?>>Meistriliiga</option>
							<option value="OTP Bank Liga" <?php if($search_league=="league") { echo "selected"; } ?>>OTP Bank Liga</option>
							<option value="NB 1 Women" <?php if($search_league=="league") { echo "selected"; } ?>>NB 1 Women</option>
							<option value="Ligat Haal" <?php if($search_league=="league") { echo "selected"; } ?>>Ligat Haal</option>
							<option value="Ligat AI Women" <?php if($search_league=="league") { echo "selected"; } ?>>Ligat AI Women</option>
							<option value="Virsliga" <?php if($search_league=="league") { echo "selected"; } ?>>Virsliga</option>
							<option value="A Lyga" <?php if($search_league=="league") { echo "selected"; } ?>>A Lyga</option>
							<option value="Moldovan National Division" <?php if($search_league=="league") { echo "selected"; } ?>>Moldovan National Division</option>
							<option value="Telekom 1. CFL" <?php if($search_league=="league") { echo "selected"; } ?>>Telekom 1. CFL</option>
							<option value="North Macedonian First League" <?php if($search_league=="league") { echo "selected"; } ?>>North Macedonian First League</option>
							<option value="Ekstraklasa" <?php if($search_league=="league") { echo "selected"; } ?>>Ekstraklasa</option>
							<option value="Ekstraliga Women" <?php if($search_league=="league") { echo "selected"; } ?>>Ekstraliga Women</option>
							<option value="Romanian Liga 1" <?php if($search_league=="league") { echo "selected"; } ?>>Romanian Liga 1</option>
							<option value="Russian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Russian Premier League</option>
							<option value="Russian Premier League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Russian Premier League Women</option>
							<option value="Serbian Super Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Serbian Super Liga</option>
							<option value="Fortuna Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Fortuna Liga</option>
							<option value="Slovakian 1st League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Slovakian 1st League Women</option>
							<option value="Prva Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Prva Liga</option>
							<option value="Ukranian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Ukranian Premier League</option>
							<option value="Argentinian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Argentinian Premier League</option>
							<option value="Bolivian Premiera Division" <?php if($search_league=="league") { echo "selected"; } ?>>Bolivian Premiera Division</option>
							<option value="Brazilian Serie A" <?php if($search_league=="league") { echo "selected"; } ?>>Brazilian Serie A</option>
							<option value="Campeonato Brasileiro Women" <?php if($search_league=="league") { echo "selected"; } ?>>Campeonato Brasileiro Women</option>
							<option value="Primerá Division" <?php if($search_league=="league") { echo "selected"; } ?>>Primerá Division</option>
							<option value="Primera A" <?php if($search_league=="league") { echo "selected"; } ?>>Primera A</option>
							<option value="Liga Pro" <?php if($search_league=="league") { echo "selected"; } ?>>Liga Pro</option>
							<option value="Division Profesional" <?php if($search_league=="league") { echo "selected"; } ?>>Division Profesional</option>
							<option value="Primera División" <?php if($search_league=="league") { echo "selected"; } ?>>Primera División</option>
							<option value="Uruguyan Primera División" <?php if($search_league=="league") { echo "selected"; } ?>>Uruguyan Primera División</option>
							<option value="Venezuelan Primera División" <?php if($search_league=="league") { echo "selected"; } ?>>Venezuelan Primera División</option>
							<option value="Liga MX" <?php if($search_league=="league") { echo "selected"; } ?>>Liga MX</option>
							<option value="Liga MX Women" <?php if($search_league=="league") { echo "selected"; } ?>>Liga MX Women</option>
							<option value="MLS" <?php if($search_league=="league") { echo "selected"; } ?>>MLS</option>
							<option value="NWSL" <?php if($search_league=="league") { echo "selected"; } ?>>NWSL</option>
							<option value="Costa Rican Primera División" <?php if($search_league=="league") { echo "selected"; } ?>>Costa Rican Primera División</option>
							<option value="El Salvadoran Primera Division" <?php if($search_league=="league") { echo "selected"; } ?>>El Salvadoran Primera Division</option>
							<option value="Guatemalan Liga Nacional" <?php if($search_league=="league") { echo "selected"; } ?>>Guatemalan Liga Nacional</option>
							<option value="Honduran Liga Nacional" <?php if($search_league=="league") { echo "selected"; } ?>>Honduran Liga Nacional</option>
							<option value="Chinese Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Chinese Super League</option>
							<option value="Chinese Super League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Chinese Super League Women</option>
							<option value="Indian Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Indian Super League</option>
							<option value="Indonesian Liga 1" <?php if($search_league=="league") { echo "selected"; } ?>>Indonesian Liga 1</option>
							<option value="J-League" <?php if($search_league=="league") { echo "selected"; } ?>>J-League</option>
							<option value="Nadeshiko Women League 1" <?php if($search_league=="league") { echo "selected"; } ?>>Nadeshiko Women League 1</option>
							<option value="K-League 1" <?php if($search_league=="league") { echo "selected"; } ?>>K-League 1</option>
							<option value="SG. Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>SG. Premier League</option>
							<option value="Thai League" <?php if($search_league=="league") { echo "selected"; } ?>>Thai League</option>
							<option value="V-League" <?php if($search_league=="league") { echo "selected"; } ?>>V-League</option>
							<option value="Armenian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Armenian Premier League</option>
							<option value="Azerbaijani Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Azerbaijani Premier League</option>
							<option value="Crystalbet Erovnuli Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Crystalbet Erovnuli Liga</option>
							<option value="Kazakhstani Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Kazakhstani Premier League</option>
							<option value="Kuwaiti Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Kuwaiti Premier League</option>
							<option value="Irani Pro League" <?php if($search_league=="league") { echo "selected"; } ?>>Irani Pro League</option>
							<option value="Hyundai A-League" <?php if($search_league=="league") { echo "selected"; } ?>>Hyundai A-League</option>
							<option value="Brisbane Premier League Women" <?php if($search_league=="league") { echo "selected"; } ?>>Brisbane Premier League Women</option>
							<option value="NPL Queensland Women" <?php if($search_league=="league") { echo "selected"; } ?>>NPL Queensland Women</option>
							<option value="NPL South Austrlia Women" <?php if($search_league=="league") { echo "selected"; } ?>>NPL South Australia Women</option>
							<option value="NZ Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>NZ Premier League</option>
							<option value="Algerian Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>Algerian Ligue 1</option>
							<option value="Egyptian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Egyptian Premier League</option>
							<option value="Kenyan Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Kenyan Premier League</option>
							<option value="Botola Pro" <?php if($search_league=="league") { echo "selected"; } ?>>Botola Pro</option>
							<option value="South African Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>South African Premier League</option>
							<option value="Tunisian Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>Tunisian Ligue 1</option>
							<option value="Kategoria Superiore" <?php if($search_league=="league") { echo "selected"; } ?>>Kategoria Superiore</option>
							<option value="Andorran 1st Division" <?php if($search_league=="league") { echo "selected"; } ?>>Andorran 1st Division</option>
							<option value="Faraoese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Faraoese Premier League</option>
							<option value="Gibraltarian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Gibraltarian Premier League</option>
							<option value="Kosovon Superliga" <?php if($search_league=="league") { echo "selected"; } ?>>Kosovon Superliga</option>
							<option value="Swiss Football League" <?php if($search_league=="league") { echo "selected"; } ?>>Swiss Football League</option>
							<option value="Maltese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Maltese Premier League</option>
							<option value="Campionato" <?php if($search_league=="league") { echo "selected"; } ?>>Campionato</option>
							<option value="Canadian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Canadian Premier League</option>
							<option value="Cuban Liga Nacional" <?php if($search_league=="league") { echo "selected"; } ?>>Cuban Liga Nacional</option>
							<option value="Jamaican Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Jamaican Premier League</option>
							<option value="Nicaraguan Primera Division" <?php if($search_league=="league") { echo "selected"; } ?>>Nicaraguan Primera Division</option>
							<option value="LPF Apertura" <?php if($search_league=="league") { echo "selected"; } ?>>LPF Apertura</option>
							<option value="Professional League" <?php if($search_league=="league") { echo "selected"; } ?>>Professional League</option>
							<option value="Bahraini Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Bahraini Premier League</option>
							<option value="Bangladeshi Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Bangladeshi Premier League</option>
							<option value="C-League" <?php if($search_league=="league") { echo "selected"; } ?>>C-League</option>
							<option value="Hong Kongese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Hong Kongese Premier League</option>
							<option value="Iraqi Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Iraqi Premier League</option>
							<option value="Jordanian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Jordanian Premier League</option>
							<option value="Lebanese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Lebanese Premier League</option>
							<option value="Malaysian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Malaysian Premier League</option>
							<option value="Mongolian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Mongolian Premier League</option>
							<option value="Myanmarese National League" <?php if($search_league=="league") { echo "selected"; } ?>>Myanmarese National League</option>
							<option value="Omani Professional League" <?php if($search_league=="league") { echo "selected"; } ?>>Omani Professional League</option>
							<option value="West Bank Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>West Bank Premier League</option>
							<option value="Qatar Stars League" <?php if($search_league=="league") { echo "selected"; } ?>>Qatar Stars League</option>
							<option value="Saudi Arabian Pro League" <?php if($search_league=="league") { echo "selected"; } ?>>Saudi Arabian Pro League</option>
							<option value="Syrian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Syrian Premier League</option>
							<option value="Taiwanese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Taiwanese Premier League</option>
							<option value="Vysshaya Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Vysshaya Liga</option>
							<option value="Yokari Liga" <?php if($search_league=="league") { echo "selected"; } ?>>Yokari Liga</option>
							<option value="Uzbekistani Superliga" <?php if($search_league=="league") { echo "selected"; } ?>>Uzbekistani Superliga</option>
							<option value="PFL" <?php if($search_league=="league") { echo "selected"; } ?>>PFL</option>
							<option value="Girabola" <?php if($search_league=="league") { echo "selected"; } ?>>Girabola</option>
							<option value="Botswanian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Botswanian Premier League</option>
							<option value="Burundian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Burundian Premier League</option>
							<option value="Elite" <?php if($search_league=="league") { echo "selected"; } ?>>Elite</option>
							<option value="DR Congolese Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>DR Congolese Ligue 1</option>
							<option value="Congolese Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>Congolese Ligue 1</option>
							<option value="Ghanese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Ghanese Premier League</option>
							<option value="NPFL" <?php if($search_league=="league") { echo "selected"; } ?>>NPFL</option>
							<option value="Ivoiry Coastian Ligue 1" <?php if($search_league=="league") { echo "selected"; } ?>>Ivoiry Coastian Ligue 1</option>
							<option value="Championnat National" <?php if($search_league=="league") { echo "selected"; } ?>>Championnat National</option>
							<option value="Senegalese Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Senegalese Premier League</option>
							<option value="Tanzanian Premier League" <?php if($search_league=="league") { echo "selected"; } ?>>Tanzanian Premier League</option>
							<option value="Ugandanese Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Ugandanese Super League</option>
							<option value="Zambian Super League" <?php if($search_league=="league") { echo "selected"; } ?>>Zambian Super League</option>
							<option value="Premier Soccer League" <?php if($search_league=="league") { echo "selected"; } ?>>Premier Soccer League</option>
							</datalist>
						</select>
						<div>
												<div class="search-label">BID AND BUY PRICE:</div>

						<input type="number" min="200" max="15000000" step="50" name="search[search_bid]" id="search_bid" class="search_min_bid" value="<?php echo $search_bid; ?>" placeholder="ANY"/>
						<input type="number" min="200" max="15000000" step="50" name="search[search_buy_now]" id="search_buy_now" class="search_buy_now" value="<?php echo $search_buy_now; ?>" placeholder="ANY" />
						</div>
							<div>
							<input type="reset" name="go" class="btnReset" value="Reset">
								<input type="submit" name="go" class="btnSearch" value="Search">
							</div>
						</div>
						</div>
			</form>
	<script type="text/javascript">
function increaseValue() {
  var value = parseInt(document.getElementById('search_bid').value, 0);
  value = isNaN(value) ? 200 : value+50;
  value++;
  document.getElementById('search_bid').value = value-1;
}

function decreaseValue() {
  var value = parseInt(document.getElementById('search_bid').value, 0);
  value = isNaN(value) ? 200 : value-50;
  value < 200 ? value = 200 : '';
  value--;
  document.getElementById('search_bid').value = value+1;
}
</script>
<script type="text/javascript">
function increaseValue2() {
  var value = parseInt(document.getElementById('search_buy_now').value, 0);
  value = isNaN(value) ? 200 : value+50;
  value++;
  document.getElementById('search_buy_now').value = value-1;
}

function decreaseValue2() {
  var value = parseInt(document.getElementById('search_buy_now').value, 0);
  value = isNaN(value) ? 200 : value-50;
  value < 200 ? value = 200 : '';
  value--;
  document.getElementById('search_buy_now').value = value+1;
}
</script>
  <script>
	var element = document.getElementById('search_players');
var list = document.getElementById('names');
var options = list.options;

element.addEventListener('change', function(){
    var matched = false;
    [].forEach.call(options, function(option){
        if( option.innerText === element.value )
        {
            matched = true;
        }
    });
    if( !matched ) element.value = '';
});
</script>

<script>
	var element = document.getElementById('search_friendsusernames');
var list = document.getElementById('friendsusernames');
var options = list.options;

element.addEventListener('change', function(){
    var matched = false;
    [].forEach.call(options, function(option){
        if( option.innerText === element.value )
        {
            matched = true;
        }
    });
    if( !matched ) element.value = '';
});
</script>

<script type="text/javascript">
$(function () {
  $("#search_bid").keydown(function () {
    // Save old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0))
    $(this).data("old", $(this).val() == '');
  });
  $("#search_bid").keyup(function () {
    // Check correct, else revert back to old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0));
    else
      $(this).val($(this).data("old"));
  });
});
</script>
<script type="text/javascript">
$(function () {
  $("#search_max_bid").keydown(function () {
    // Save old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0))
    $(this).data("old", $(this).val() == '');
  });
  $("#search_max_bid").keyup(function () {
    // Check correct, else revert back to old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0));
    else
      $(this).val($(this).data("old"));
  });
});
</script>

<script type="text/javascript">
$(function () {
  $("#search_buy_now").keydown(function () {
    // Save old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0))
    $(this).data("old", $(this).val() == '');
  });
  $("#search_buy_now").keyup(function () {
    // Check correct, else revert back to old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 15000000 && parseInt($(this).val()) >= 0));
    else
      $(this).val($(this).data("old"));
  });
});
</script>

<script type="text/javascript">//<![CDATA[
$(document).ready(function() {  
    $("#search_players").on('input',function(e) {
        if($(this).val() == '') {
            $("#search_nationality").removeAttr('disabled');
			$("#search_clubs").removeAttr('disabled');
			$("#search_league").removeAttr('disabled');
        } else {
            $("#search_nationality").attr('disabled','');
			$("#search_clubs").attr('disabled','');
			$("#search_league").attr('disabled','');
        }
    });
});


  //]]></script>
 
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script
<script src='../js/js.js'></script>
<div class="footer">
  <p>&copy; 2020 - FUTTIE 21. All rights reserved.</p>
</div>
	</body>
</html>