<!DOCTYPE html>
<html>
<head>
<title> DominoX </title>
<meta charset = "utf-8">
<link rel="stylesheet" type="text/css" href="css/index.css">
<meta name = "viewport" content = "width=device-witdh, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="container">
			<div class="col-xs-12">
				<a href="https://www.facebook.com" class="social-button facebook pull-right" title="Dominox Facebook" target="_blank"><div class="fa fa-facebook-official"></div></a>
				<a href="https://plus.google.com" class="social-button google-plus pull-right" title="Dominox Google+" target="_blank"><div class="fa fa-google-plus"></div></a>
				<a href="https://www.youtube.com" class="social-button youtube pull-right" s title="Dominox Youtube" target="_blank"><div class="fa fa-youtube-play"></div></a>
			</div>
		</div>
	</div>
   
	<div class="row">
		<div class="container">
			<div class="col-xs-12">
				<nav class = "navbar navbar-inverse">
					<div  class="navbar-header" >
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>                        
						</button>

						<a class="navbar-brand" href="index.php"><img src="images/logo.svg"  width="80" height="40" class = "img-responsive"></a>
					</div>
				<div class="collapse navbar-collapse" id="mainNavBar">
					<ul  class = "nav navbar-nav">
						<li><a href = "tutorial.php">TUTORIAL</a></li>
						<li><a href = "statistics.php">STATISTICS</a></li>
						<li><a href = "settings.php">SETTINGS</a></li>
						<?php if(isset($_SESSION['user_id'])){
						echo '<li><a href = "account.php">MY ACCOUNT</a></li>
						<li><a href = "logout.php"><span class="glyphicon glyphicon-log-in"></span> LOGOUT </a></li>';
						}elseif(!isset($_SESSION['user_id'])){
						echo '<li><a href = "register.php">REGISTER</a></li>
						<li class="active"><a href = "login.php"><span class="glyphicon glyphicon-log-in"></span> LOGIN </a></li>';
						}
						?>
					</ul>
				</div>
				</nav>
			</div>
		</div>
	</div>

	<div class="row">
		<div class = "container-fluid">
			<div class=" col col-xs-12">
				<div id="images-container" class="images">
					<canvas class="canvas" id="canvas" width="1230" height="400" >Your browser does not support canvases.</canvas>
					<img src="images/tiles/0_1.svg" id="0_1.svg" alt="" width="0" height="0">
					<img src="images/tiles/0_2.svg" id="0_2.svg" alt="" width="0" height="0">
					<img src="images/tiles/0_3.svg" id="0_3.svg" alt="" width="0" height="0">
					<img src="images/tiles/0_4.svg" id="0_4.svg" alt="" width="0" height="0">
					<img src="images/tiles/0_5.svg" id="0_5.svg" alt="" width="0" height="0">
					<button onclick="startAnimation()">Start</button>
					<button onclick="stopAnimation()">Stop</button>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class="col-xs-12">
				<div class="col1" width="1000">
					<h4 style="color:#cc3300" class="text-left "> LOG IN </h4>
					<hr>
						<div class="container">
							<div class="col-xs-6">
								<?php  
								session_start();
								$isLoggedIn = false;
								if(empty($_POST['username']))
								{
									$message = 'Please enter a valid username!';
								}
								elseif(empty($_POST['password']))
								{
									$message = 'Please enter a valid password!';
								}
								elseif(empty($_POST['login_token']))
								{
									$message = 'Please enter valid parameters!';
								}	
								elseif (strlen($_POST['username']) > 30 || strlen($_POST['username']) < 4)
								{
									$message = 'Incorrect username length!';
								}
								elseif (strlen($_POST['password']) > 30 || strlen($_POST['password']) < 4)
								{
									$message = 'Incorrect password length!';
								}
								elseif (ctype_alnum($_POST['username']) != true)
								{
									$message = 'Username must be alphanumeric!';
								}
								elseif (ctype_alnum($_POST['password']) != true)
								{
									$message = 'Password must be alpha numeric!';
								}
								else
								{
									$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
									$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
									$password = substr(sha1($password), 0, 30);
									try
									{
										$dbh = new PDO("mysql:host=localhost;dbname=domino", 'root', '');
										$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										$stmt = $dbh->prepare("SELECT `username` FROM `users` 
										WHERE `username` = :username AND `password` = :password");
										$stmt->bindParam(':username', $username, PDO::PARAM_STR);
										$stmt->bindParam(':password', $password, PDO::PARAM_STR);
										$stmt->execute();
										$user_id = $stmt->fetchColumn();
										if($user_id == false)
									{
										$message = 'Incorrect username or password!';
									}
									else
									{
										$_SESSION['user_id'] = $user_id;
										$isLoggedIn = true;
										$stmt = $dbh->prepare('SELECT username FROM users WHERE username = :username');
										$stmt->bindParam(':username', $username, PDO::PARAM_STR);
										$stmt->execute();
										$user = $stmt->fetchColumn();
										$message = 'Welcome to DominoX, ' . $user .'! Have fun.<br> <a href = "play.php"> PLAY NOW </a>'; 
									}
									}
									catch(Exception $e)
									{
											$message = 'We are unable to process your request. Please try again later!';
									}
								}
									echo $message;
								?>

							</div>
  
						</div> 
					<hr>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="js/drag-and-drop.js"></script>
<script type="text/javascript" src="js/animation.js"></script>
</html>

