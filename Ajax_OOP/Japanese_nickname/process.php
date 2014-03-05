<?php

function to_ninja($name)
{
	$map =[
	"A" => "ka","B"=>"tu","C"=>"mi","D"=>"te","E"=>"ku","F"=>"lu","G"=>"ji","H"=>"ri",
	"I"=>"ki","J"=>"zu","K"=>"me","L"=>"ta","M"=>"rin","N"=>"to","O"=>"mo","P"=>"no",
	"Q"=>"ke","R"=>"shi","S"=>"ari","T"=>"chi","U"=>"do","V"=>"ru","W"=>"mei","X"=>"na",
	"Y"=>"fu","Z"=>"zi"," "=>" "];

	$ninja="";
	$arr = str_split(strtoupper($name));
	foreach($arr as $letter)
	{
		$ninja .= $map[$letter];
	} 
	return($ninja);
}

if(isset($_POST['your_name']))
{

	if(empty($_POST['your_name']))
	{
	 	$data['status']=false;
	 	$data['error'] = "Please enter a name";
	}
	else
	{
 		$data['status']=true;
 		$ninja = to_ninja($_POST['your_name']);
 		$data['output']="<form id='out_name' action='process.php' method='post'>
			<div>
				<h1>Your ninja name is: ". $ninja . "</h1>
			</div>
			<input type='hidden' name='try_next'>
			<input class='try_next' type='submit' value='Try another name!'>				
		</form>";
	}
echo json_encode($data);
}

if(isset($_POST['try_next']))
{
	$data['status'] = true;
	$data['output'] = "<form id='inp_name' action='process.php' method='post'>
							<div>
							<input type='text' name='your_name' placeholder='Enter your name...'>
							</div><br>
							<input class='sub_info' type='submit' value='Click here to find your ninja name in japanese!'>				
					   </form>";
echo json_encode($data);			
}

?>