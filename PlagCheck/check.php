<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		body {
		  margin: 0;
		  font-family: Arial, Helvetica, sans-serif;
		}

		.topnav {
		  overflow: hidden;
		  background-color: rgb(157, 3, 252);
		  //position: fixed;
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
			
			  left: 0;
			  bottom: 0;
			  width: 100%;
		}    
		.area{
			border-style:ridge;
			font-size: large;
			//font-family: Trattatello, fantasy;
			color: rgb(26, 1, 31);
			text-align: center;
			height:400px;
			width: 25%;
			margin-left: 600px;
			margin-top: 100px;
		}    

		ul {
		  list-style-type: none;
		  margin: 0;
		  padding: 0;
		  width: 22%;
		  background-color: rgb(31, 7, 38);
		  color: white;
		  position: fixed;
		  height: 100%;
		  overflow: auto;
		  text-align: center;
		}

		li a {
		  display: block;
		  color: silver;
		  padding: 8px 16px;
		  text-decoration: none;
		}

		li a.active {
		  background-color: rgb(238, 235, 240);
		  color: white;
		}

		li a:hover:not(.active) {
		  background-color: #555;
		  color: white;
		}

			#dp{
				padding-top: 10px;
				border-radius: 50%;
			}
			.row {
		  display: flex;
		}

		/* Create five equal columns that sits next to each other */
		.column {
		  flex: 20%;
		  padding: 5px;
		}
		
		a {
			text-decoration: none;
			color: black;
		}
		</style>
	</head>
	
    <body>
        <div class="topnav">
			<img src="images/logo2.jpg" style="float:right">
			<a href="index.php">Home</a>
			<a href="about.php">About</a>
			<a href="contact.php">Contact</a>
			<a class="active" href="dashboard.php">Dashboard</a>
			<a href="logout.php">Log-out</a>
		</div>

	<ul>
		<li><img id="dp" src="images/dp.jpg"></li>
	  <li><a  href="aboutme.php">About Me</a></li>
	  <li><a class="active" href="dashboard.php">Upload and Check</a></li>
	  <li><a href="myreports.php">My Reports</a></li>
	</ul>

	<div style="margin-left:25%;padding:1px 16px;height:1000px;">
	  <div class="row"><div class="col"><a href="help.php"><figure><img src="images/help.jpg"><figcaption>Help</figcaption></figure></a></div>
	  <div class="col"><a href="uploading.php"><figure><img src="images/up.png"><figcaption>Upload</figcaption></figure></a></div>  
	
	</div>
	  <hr>
		<div>
			<?php
				$con = mysqli_connect("localhost", "root", "", "plagiarism")or die(mysqli_error($con));
				session_start();
				$uid = $_SESSION['userid'];
				$title = $_POST['title'];
				$title = mysqli_real_escape_string($con, $title);
				$content = $_POST['content'];
				$content = mysqli_real_escape_string($con, $content);
				$rep_name='report/u'.$uid.'_'.$title.'_report.txt';
				$file_loc='docs/u'.$uid.'_'.$title.'.txt';
				$file_loc=mysqli_real_escape_string($con, $file_loc);
								
				if(!isset($title) || trim($title) == '' || !isset($content) || trim($content)=='')
				{
					echo '<script>alert("Incomplete form")</script>';
					header('uploading.php');
				} else {
					$query = "INSERT INTO documents(userid, filename, file_loc, reportloc) values('$uid', '$title', '$file_loc', '$rep_name')";
					mysqli_query($con, $query) or die(mysqli_error($con));
				}
				//Generating a report
				$content = $_POST['content'];
				
				file_put_contents($file_loc, $title."<br>".$content);
				
				$cont_list = preg_replace('/[\n?!]+/', '.', $content); //replacing user string
				$cont_list = explode('.', $cont_list);
				$score=0;
				$plag_lines = array();
				$line=1;
				$rep_cont="<h3>Report</h3><br>";
				
				$common_words=['a', 'an', 'the', 'can', 'has', 'should', 'is', 'was', 'will', 'shall', 'be', 'in', 'on', 'to', 'into', 'but', 'and'];
				
				foreach($cont_list as $sent)
				{
					$sent=trim($sent);
					//echo $line.$sent."<br>";
					for($i=1; $i<=9; $i++)
					{
						$s='db/db'.$i.'.txt'; //location of databse files
						$cont=strval(file_get_contents($s));
						//$cont= preg_replace('/[\n.]+/', ' ', $cont); //replacing in source string
						$src_cont = preg_split('/\n/',$cont); //splitting the source document into lines
						$src=$src_cont[0];
						if(!empty($sent) and !empty($cont) and count(preg_split('/\s/',$sent))>=6)
						{
							for($j=1; $j<count($src_cont); $j++)
							{
								$cont_words = explode(' ', $sent); //split user doc sentences into words
								$matched_words=0;
								foreach($cont_words as $word)
								{
									if(stripos($src_cont[$j], $word) !== false and !in_array($word, $common_words))
										$matched_words+=1;
								}
								if ($matched_words>=6)
									$plag_lines[$line]=array($sent, $src);
							}
						}	
					}	
					if(!empty($sent) and preg_match('/\s+/',$sent))
						$line+=1;
				}
				$score=count($plag_lines);
				if($score==0){
					$rep_cont=$rep_cont."100% unique!<br>All lines are unique";
				}
				else{
					$line-=1;
					$rep_cont=$rep_cont.$score." lines out of ".$line." are copied.<br>";
					$score = round($score/$line*100,2);
					$rep_cont=$rep_cont."Content is ".$score."% plagiarized.<br><br>Copied content and their sources:<br>
						<table border='3'>
							<tr> <th>Line No.</th> <th>Sentence</th> <th>Source</th> </tr>";
					foreach($plag_lines as $key => $value)
						$rep_cont=$rep_cont." <tr><td> ".$key."</td> <td>".$value[0]."</td> <td>".$value[1]."</td></tr>";
					$rep_cont.='</table	>';
				}
				echo $rep_cont;
				strval(file_put_contents($rep_name , $rep_cont)); //retrieve file contents and save in string variable
				
			?>
		</div>
	</div>
	
	<div class="container" >
        <center>
            <p style="color: silver"> NOPlagueiarism &copy; All Rights Reserved  |  Contact Us: admin@noplagueiarism.edu</p>	
        </center>
    </div>
    </body>
</html>