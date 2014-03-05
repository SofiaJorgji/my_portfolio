<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
	<title>Ninja gold game</title>
</head>
<body>
<div id="wrapper">
    <h2>Your Gold: <?=(isset($gold_total) ? $gold_total : 0) ?></h2>
	<div class="forms">
        <h3>Casino</h3>
        <p class="earn">(Earns/loses 0-50 golds)</p>
        <form action="" method="post">
            <input type="hidden" name="low" value="0">
            <input type="hidden" name="high" value="50">
            <input type="hidden" name="action" value="casino">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="forms">
        <h3>House</h3>
        <p class="earn">(Earns 2-5 golds)</p>
        <form action="" method="post">
            <input type="hidden" name="low" value="2">
            <input type="hidden" name="high" value="5">
            <input type="hidden" name="action" value="house">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="forms">
        <h3>Cave</h3>
        <p class="earn">(Earns 5-10 golds)</p>
        <form action="" method="post">
            <input type="hidden" name="low" value="5">
            <input type="hidden" name="high" value="10">
            <input type="hidden" name="action" value="cave">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="forms">
        <h3>Farm</h3>
        <p class="earn">(Earns 10-20 golds)</p>
        <form action="" method="post">
            <input type="hidden" name="low" value="10">
            <input type="hidden" name="high" value="20">
            <input type="hidden" name="action" value="farm">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="cleaning"></div>
    <h4>Activities:</h4>
    <div>
        <?php
            if(isset($activities))
            {
                foreach($activities as $activity)
                {
                    echo '<p style="color:'.$activity['status'].'">'.$activity['message'].'</p>';
                }
            }
        ?>
    </div>
</div>
</body>
</html>