<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../templates/meta.php";
    ?>
    <meta name="author" content="Navpreet">
  <title>Parks</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include "../templates/header.php";
?>
<header id="header">
<div class="page-wrapper" id="div-header">
<div class="header-float"><img id="logo" alt="Logo Here" src=" "> </div> 
	  <div class="header-float"><h2 id="site-name">Parks</h2></div>
	  
 </div> 
</header>
<div class="page-wrapper">
<nav>
		<ul class="list-block">
		  <li><a href="#">Home</a></li>
		  <li><a href="#">Compare</a></li>
		  <li><a href="#">Parks</a></li>
		</ul>
	  </nav>
</div>
  <div class="page-wrapper">
	<main id="main">
	  <h1>About the Park</h1>
	  
	  By:Navpreet<br>
	  <img id="pic1" alt="Problem Loading Image" src="p1.jpg">
	  <p>hiiiii hw r u...........................................hello ........................this is parks page... i will add content to it............it is just fo testing
	  </p>
	 
	  
	  <p id="bruce-caves"><img id="img-bruce-caves" alt="Problem Loading Image" src="p2.jpg"/>Tgrfbgetbnhrnhtynjtyntfnmdtvgdbgrthbtr
	  brtntrmnjtmtumf yu myu mkyum yk i,kiul,jhmgmfj,fj,f,fyk,f,k,,fy.
	  jdytmkcgmjdukmd
	  
	  </p>
	  
	  
	  <form action="parks.html" method="post">
	  <h2>Comments</h2>
	  <div>
	  <label for="name" class="form-label">Name:</label>
	  <input type="text" id="name" name="visitor_name" placeholder="Type your name here."/>
	  </div>
	  <div>
	  <label for="comments" class="form-label">Comments:</label>
	  <input type="text" id="comments" name="visitor_comments" placeholder="Type your comments here."/>
	  </div>
	  <div>
	  <button type="submit" name="Submit">Post Comment</button>
	  </div>
	  </form>
	  
	</main>
	<aside id="sidebar">
	<article id="blog-posts">
	
	  <h2 class="links">Quick Links</h2>
	  <ul class="l1">
		<li><a href="#">Parks Canada</a></li>
	    <li><a href="#">Sauble Beach</a></li>
		<li><a href="#">The Expenditure</a></li>
	  </ul>
	 
	  </article>
	  <aside id="more-links">
	  <h2 class="links">More Links</h2>
	  <ul class="l1">
	    <li><a href="#">Parks Canada</a></li>
	    <li><a href="#">Sauble Beach</a></li>
		<li><a href="#">The Expenditure</a></li>
		<li><a href="#">Image Gallery</a></li>
	  </ul>
	 
	  </aside>
	</aside>
	
	<footer id="footer">
	  <p>&copy; Copyright Parks,2017.All rights are reserved.</p>
	  <p>
    </a>
</p>
    
	</footer>
  </div>
</body>
</html>
