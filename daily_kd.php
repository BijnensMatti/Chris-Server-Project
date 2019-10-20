<?php
error_reporting(E_ALL);
$mode = $_GET['mode'];
if($mode=="ranked"||$mode=="casual"||!isset($mode)){
} else {
    die("Invalid mode set.");
}
date_default_timezone_set('Europe/Berlin');
$userid = htmlspecialchars($_GET["userid"]);
$json = file_get_contents("localhost/data_daily.php?userid=" . $userid);
$obj = json_decode($json, true);

$killst = $obj[0]["casual_kills"] + $obj[0]["ranked_kills"];
$deathst = $obj[0]["casual_deaths"] + $obj[0]["ranked_deaths"];
$killsy = $obj[1]["casual_kills_y"] + $obj[1]["ranked_kills_y"];
$deathsy = $obj[1]["casual_deaths_y"] + $obj[1]["ranked_deaths_y"];
$todayheadshots = $obj[0]["g_headshots"] - $obj[1]["g_headshots_y"];
$winst = $obj[0]["casual_wins"] + $obj[0]["ranked_wins"];
$winsy = $obj[1]["casual_wins"] + $obj[1]["ranked_wins"];
$losst = $obj[0]["casual_losses"] + $obj[0]["ranked_losses"];
$lossy = $obj[1]["casual_losses"] + $obj[1]["ranked_losses"];
if ($mode=="ranked"){
$killst = $obj[0]["ranked_kills"];
$deathst = $obj[0]["ranked_deaths"];
$killsy = $obj[1]["ranked_kills_y"];
$deathsy = $obj[1]["ranked_deaths_y"];
$winst = $obj[0]["ranked_wins"];
$winsy = $obj[1]["ranked_wins"];
$losst = $obj[0]["ranked_losses"];
$lossy = $obj[1]["ranked_losses"];
} else if ($mode=="casual"){
$error = true;
}
$todaywins = $winst-$winsy;
$todaylosses = $losst-$lossy;
if ($todaylosses>0){
    $wltoday = $todaywins/$todaylosses;
    $wltoday *= 100;
} else if ($todaywins>0) {
    $wltoday = 100;
}
$statusdate = $obj[0]["date"];
$statustime = strtotime($statusdate);
$todaykills = $killst - $killsy;
$todaydeaths = $deathst - $deathsy;
$dailykd = $todaykills/$todaydeaths;
echo "Today's kills: " . $todaykills . "<br>";
echo "Today's deaths: " . $todaydeaths . "<br>";
echo "<h1>".strtoupper($mode)." KD Today: " . $dailykd . "</h1><br>";
if(!isset($mode)){
$headshotrate = $todayheadshots/$todaykills;
$hs = $headshotrate*100;
echo "Headshotrate Today: " . $hs . "%<br><br>";
}
echo "Wins:Losses: " . $todaywins . ":" . $todaylosses . " (" .$wltoday . "%)<br><br>";
date_default_timezone_set('Europe/Berlin');
$status = date("H:00:00");
echo "(Stand: " . date('H:i:s', $statustime) . ")<br>";
echo "<a target='_blank' href='http://christian-krug.website/script.php?id=" . $userid . "'>UPDATE DATA NOW.</a><br>";
echo "<a href='daily_kd.php?userid=" . $userid . "&mode=ranked'>ONLY RANKED</a><br>";
echo "<a href='daily_kd.php?userid=" . $userid . "&mode=casual'>ONLY CASUAL</a><br>";
echo "<a href='daily_kd.php?userid=" . $userid . "'>BOTH</a>";
?>
