<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Ninja Name</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<style type="text/css">
			#container{
				margin: 0px auto;
				width: 700px;
				height: 500px;
				margin-top: 100px;
				background-color: cyan;
				border: 2px solid;
				padding: 10px;
			}
			h1{
				font-size: 46px;
			}
			input{
				font-size: 30px;
				margin-bottom: 40px;
			}
			div input{
				width: 580px;
				height: 50px;
				font-size: 24px;
				background-color: yellow;
			}
		</style>
		<script>
			$(document).ready(function()
			{
				$('html').on("submit","#inp_name",function(){
				var form = $('#inp_name');
				$.post(form.attr("action"), 
					form.serialize(), 
					function(data)
					{
						if(data.status)
						{	 
							$('h1.welc').hide();
							$('#inp_name').replaceWith(data.output);
						}
						else
						{
							alert('Please enter your name!');
						}
					}, "json");
					return false;					
				});

				$('html').on("submit","#out_name",function(){
				var form = $('#out_name');
					$.post(form.attr("action"), 
					form.serialize(), 
					function(data)
					{
						if(data.status)
						{	 
							$('h1.welc').show();
							$('#out_name').replaceWith(data.output);
						}
					}, "json");
					return false;					
				});
			});
		</script>
	</head>
	<body>
		<div id="container">
			<h1 class="welc">Welcome ninja!</h1><br>
			<div class="disp"> 
				<form id="inp_name" action="process.php" method="post">
					<input id="text1" type="text" name="your_name" placeholder="Enter your name...">
					<div id="button1">
						<input id="sub_info" type="submit" value="Click here to find your ninja name in japanese!">	
					</div>			
				</form>
			</div>
		</div>
	</body>
</html>