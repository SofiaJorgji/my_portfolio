<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="wrapper">
		<h1>
		<?php 
			echo '<table>'; 
			for($i = 0; $i < 8; $i++)
			{ 
				echo '<tr>'; 

				for($j = 0; $j < 8; $j++)
				{ 
					$switching = ($i+$j)%2 ? 'black': 'red'; 
					echo '<td bgcolor="'.$switching.'"/>';
				} 
				echo '</tr>'; 
			}
			echo '</table>';
		?> 
		</h1>
		<h2>
		<?php 
			echo '<table>'; 
			for($k = 0; $k < 8; $k++)
			{ 
				echo '<tr>'; 
				for($n = 0; $n < 8; $n++)
				{ 
					$switching2 = ($k+$n)%2 ? '#669933': '#FFFFCC'; 
					echo '<td bgcolor="'.$switching2.'"/>';  
				} 
				echo '</tr>'; 
			}
			echo '</table>';
		?> 
		</h2>
	</div>
</body>
</html>