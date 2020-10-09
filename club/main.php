<?php
require_once("db.php");

$db = new DB();
$data = $db->viewData();

?>
<html>
<head>
<link rel="stylesheet" style="text/css" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compitable" content="ie=edge">
<title>Player Search</title>
</head>

<body>

<h1>Player Search</h1>

<div class="form">
	<form action="search_page.php" method="post">
	<input type="text" name="name" placeholder="Search Here..." id="searchBox" oninput=search(this.value)>
	<button>Search</button>
	
	</form>

<ul id="dataViewer">
<?php foreach($data as $i) { ?>
<li><?php echo $i["name"]; ?></li>
<?php }?>
</ul>

<script src="main.js"></script>

</div>
</body>
</html>