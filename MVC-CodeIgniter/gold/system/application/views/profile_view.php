<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
	<title>Ninja gold game</title>
    <style type="text/css">
        #wrapper{
            background-color: #99ff99;
            width: 960px;
            height: 700px;
            margin: 0px auto;
            padding: 10px;
        }
        .form1, .form2, .form3, .form4{
            float: left;
            margin-left: 20px;
            margin-right: 20px;
            display: inline-block;
            width: 100px;
            background-color:#9966ff;
            width:180px;
            border: 2px solid black;
        }
        form{
            width: 100px;
        }
        h3{
            width: 100px;
            color: black;
        }
        .cleaning{
            clear: both;
        }
        .gold{
            background-color: red;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <h2>Your Gold: <?=(isset($gold_total) ? $gold_total : 0) ?></h2>
	<div class="form1">
        <h3>Casino</h3>
        <form action="" method="post">
            <input type="hidden" name="low" value="0">
            <input type="hidden" name="high" value="50">
            <input type="hidden" name="action" value="casino">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="form2">
        <h3>House</h3>
        <form action="" method="post">
            <input type="hidden" name="low" value="2">
            <input type="hidden" name="high" value="5">
            <input type="hidden" name="action" value="house">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="form3">
        <h3>Cave</h3>
        <form action="" method="post">
            <input type="hidden" name="low" value="5">
            <input type="hidden" name="high" value="10">
            <input type="hidden" name="action" value="cave">
            <input class="gold" type="submit" value="Find Gold">
        </form>
    </div>
    <div class="form4">
        <h3>Farm</h3>
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