<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Plagiarism Detection- Contact us</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			body {
			  margin: 0;
			  font-family: Arial, Helvetica, sans-serif;
			}

			.topnav {
			  overflow: hidden;
			  background-color: rgb(157, 3, 252);
			}

			.topnav a {
			  float: left;
			  color: #f2f2f2;
			  text-align: center;
			  padding: 14px 16px;
			  text-decoration: none;
			  font-size: 17px;
			}

			.topnav a:hover {
			  background-color: #ddd;
			  color: black;
			}

			.topnav a.active {
			  background-color: rgb(238, 235, 240);
			  color: white;
			}
			.container{
				overflow: hidden;
				background-color: rgb(157, 3, 252);
				position: fixed;
			  left: 0;
			  bottom: 0;
			  width: 100%;
			} 
			#all{
			  display: block;
			  margin-left: 150px;
			  margin-right: 100px;
			  width: 50%;
			}    
		</style>
	</head>
	
    <body>
		<?php
		$con = mysqli_connect("localhost", "root", "", "plagiarism") or die (mysqli_error($con));
		session_start();
		?>
        <div class="topnav">
		  <img src="images/logo2.jpg" style="float:right">
		  <a href="index.php">Home</a>
		  <a  href="about.php">About</a>
		  <a class="active" href="contact.php">Contact</a>
		  <?php
			if (isset($_SESSION['email'])) {
				$query="select name from userdetails where Email='".$_SESSION['email']."'";
				$result = mysqli_query($con, $query)or die($mysqli_error($con));
				$row= mysqli_fetch_array($result);
				?>
				<a href="dashboard.php">Dashboard</a>
				<a href="signup.php">Log-out</a>
			<?php } else { ?>
				<a href="signup.php">Sign-up</a>
			<?php } ?>
		</div>
				
			<div id="all" padding-left="100px" align="justify">
				
				<h1>CONTACT US</h1>
				<p>
				We hope to hear from you to serve you better! 
				<br>Kindly fill the feedback <a href="feed.php">form</a>
				<br>	<h3>	or </h3>
				<br>mail the admin at <a href="mailto:admin@noplagueiarism.edu">admin@noplagueiarism.edu</a>.
				
				<br><br>
				Best regards,
				<br>NOPlagueiarism team
				<br>(Roshni Kundu,
				<br>Suma Mounica,
				<br>Sumathi)
				</div>
			<div class="container" >
				<center>
					<p style="color: silver"> NOPlagueiarism &copy; All Rights Reserved  |  Contact Us: admin@noplagueiarism.edu</p>	
				</center>
			</div>
    </body>
</html>
