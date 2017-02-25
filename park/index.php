<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../templates/meta.php";
    ?>
    <meta name="author" content="Navpreet">
  <title>Parks</title>
</head>
<body>
<?php
include "../templates/header.php";
?>

  <main class="container">
      <div class="row">
    <aside id="sidebar" class="col-md-4">
          <article id="blog-posts">
              <h2 class="links">Quick Links</h2>
              <ul class="l1">
                  <li><a href="#">Weather</a></li>
                  <li><a href="#">Search Nearby parks</a></li>
                  <li><a href="#">Image Gallery</a></li>
              </ul>

          </article>
      </aside>
	    <div class="col-md-8">
	  <h1>About the Park</h1>

	  By:Navpreet<br>
	  <img class="img-responsive" id="pic1" alt="Problem Loading Image" src="p1.jpg">
	  <p> This is a beautiful park for enjoyment. It is an ideal location to be used for special occasions and celebrations. It is a great park to spend time with family as well as friends.
	  </p>


	  <p id="bruce-caves">Tgrfbgetbnhrnhtynjtyntfnmdtvgdbgrthbtr
	  brtntrmnjtmtumf yu myu mkyum yk i,kiul,jhmgmfj,fj,f,fyk,f,k,,fy.
	  jdytmkcgmjdukmd

	  </p>
	  <?php
        include "../templates/attitude.php";
      ?>
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

	</div>
      </div>
  </main>
<?php include "../templates/footer.php";?>
</body>
</html>
