<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
     
      <title>Sajo's blog</title>

      <!-- Bootstrap -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/a.css" rel="stylesheet">
	  <link href="css/sidebar.css" rel="stylesheet">
  </head>
<body>

<?php
include_once("header.php");
include_once("nav.php");
include_once("../database.php");
include_once("../functions.php");
?>

<?php

if(!empty($_COOKIE['username'] && $_COOKIE['password'])){	
	if(isset($_GET['blog_id'])){
		
		$b_id=$_GET['blog_id'];
		
					$blogs = $db->query ("
						SELECT *
						FROM blog 
						WHERE blog_id='$b_id'
						")->fetchAll(PDO::FETCH_ASSOC);
	
					foreach($blogs as $b)
					{	
						$blog_id=$b['blog_id'];
						$blog_title = $b['title'];
						$blog_text =html_entity_decode ($b['text']);
						$blog_cat = $b['cat_id'];
						$blog_image = $b['blog_image'];
					}
	}
}	
?>
<div id="wrapper">
	
		<!--sidebar menu-->
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li><a href="dashboard.php">Home</a></li>
				<hr>
				<li role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					Edit blogs <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php
							$query="SELECT * FROM categories";
							$cats=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
							foreach($cats as $cat){
								$cat_id=$cat['cat_id'];
								$cat_name=$cat['cat_name'];
							
								echo "
									<li><a href='list_blogs.php?cat_id=$cat_id'>$cat_name</a></li>
									";
							}
						?>
					</ul>
				</li>
				<li><a href="add_blog.php">Add blog</a></li>
				<li role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					Delete blogs <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php
							$query="SELECT * FROM categories";
							$cats=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
							foreach($cats as $cat){
								$cat_id=$cat['cat_id'];
								$cat_name=$cat['cat_name'];
							
								echo "
									<li><a href='delete_blogs.php?cat_id=$cat_id'>$cat_name</a></li>
									";
							}
						?>
					</ul>
				</li>
				<li><a href="add_cat.php">Add blog category</a></li>
				<li><a href="delete_cat.php">Delete blog category</a></li>
				<hr>
				<li><a href="list_games.php">Historic games</a></li>
				<li><a href="add_historic_game.php">Add historic game</a></li>
				<li><a href="delete_games.php">Delete historic game</a></li>
			</ul>
		</div>
		<!--end of sidebar menu-->
	<div id="content-wrapper">
		<div class="container-fluid">
			<div class='row'>
				<div class="col-md-10 col-md-offset-1 add-blog">
				<center><h1><?php echo $blog_title; ?></h1></center>
				<div>
					<img src='<?php echo $blog_image;?>' width='100%' height='300px' />
					<p><?php echo $blog_text; ?></p>
				</div>
				<form method="post" action="">
					<hr>
					<button type="submit" name="delete" class="btn btn-danger">Delete blog</button>
					<a href="javascript:history.go(-1)"><button type="button" class="btn btn-primary pull-right">Go Back</button></a><br><br>
				</form>
				 
				</div>	
			</div>
		</div>
	</div>
</div>
<?php

if(isset($_POST['delete'])){
		$sql = "DELETE FROM blog WHERE blog_id='$b_id'";
		$db->exec($sql);		
		header("Location:dashboard.php");	
}
?>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$("#menu-toggle").click(function(e){
		e.preventDefault();
		$("#wrapper").toggleClass("menuDisplayed");
	});
</script>
<?php include_once 'footer.php'; ?>
  </body>
</html>