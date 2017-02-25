<?php
#author: Bao
##The rating star design and function is come from https://github.com/irfan/jquery-star-rating
?>
<link rel="stylesheet" type="text/css" href="../static/vendor/rating/rating.css" />

<script>
$(function(){                   // Start when document ready
    $('#star-rating').rating(); // Call the rating plugin
});
</script>

<section id="attitude" class="col-md-12">
    <section class="attitude-rating">
        <h5>Rating:</h5>
        <div id="star-rating">
            <input type="radio" name="example" class="rating" value="1" />
            <input type="radio" name="example" class="rating" value="2" />
            <input type="radio" name="example" class="rating" value="3" />
            <input type="radio" name="example" class="rating" value="4" />
            <input type="radio" name="example" class="rating" value="5" />
        </div>
    </section>

</section>
<script type="text/javascript" src="../static/vendor/rating/rating.js"></script>
<script type="text/javascript" src="../static/vendor/rating/rating.js"></script>
