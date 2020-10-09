<html>
<head>
<meta http-equiv="Refresh" content="0; url='5kpack.php'" />
</head>
<body>
<link rel="stylesheet" type="text/css" href="..css/pack.css">
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$con = mysqli_connect('localhost','root','');
	
	if(!$con)
	{
		echo 'Not Connected To Server';
	}
	
	if(!mysqli_select_db($con, 'futtie'))
	{
		echo 'Database Not Selected';
	}
	
	$sql = "INSERT INTO user_items (name, card_img, quality, rarity, rating, price, position, role, club, league, club_img, nationality, country_img, card_type, walkout_img, chance, user_id, owns, duplicate, trade-able)
SELECT name, card_img, quality, rarity, rating, price, position, role, club, league, club_img, nationality, country_img, card_type, walkout_img, chance, id, in_packs, duplicate, trade-able
FROM players, users WHERE in_packs='Y' AND rating>'74'
ORDER BY -LOG(1+RAND())*chance, name
LIMIT 6 ON DUPLICATE KEY UPDATE duplicate = '1'";
	
	if(!mysqli_query($con,$sql))
	{
		echo 'Not Inserted';
	}
	
	else 
	{
		echo 'Inserted';
	}
?>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$con = mysqli_connect('localhost','root','');
	
	if(!$con)
	{
		echo 'Not Connected To Server';
	}
	
	if(!mysqli_select_db($con, 'futtie'))
	{
		echo 'Database Not Selected';
	}
	
	$sql2 = "update user_items
set duplicate = 1
where id not in
(
   select * from
   (
      select min(id)
      from user_items
      group by name
   ) tmp
) ";
	
	if(!mysqli_query($con,$sql2))
	{
	}
?>
</body>
</html>