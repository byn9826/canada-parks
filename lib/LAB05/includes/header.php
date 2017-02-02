<header class="header">
    <?php
        // Array to keep navigation links
        $lstNavLinks = [
            ['navUrl' => '#', 'navText' => 'Home'],
            ['navUrl' => '#', 'navText' => 'Blog'],
            ['navUrl' => '#', 'navText' => 'Experiments'],
            ['navUrl' => '#', 'navText' => 'Contact'],
            ['navUrl' => '#', 'navText' => 'About']
        ];
    ?>

	<!-- Header logo -->
	<div class="logo"><img src="images/logo.png" alt="Logo" /></div>
	
    <div class="details">
        <h1>HTTP 5202 - Web Development Application 2</h1>
        <div>Tel: 1.416.675.3111</div>
        <div>Email: enquiry@humber.ca</div>
    </div>

    <nav class="header-nav">
    <?php
        echo display_navigation($lstNavLinks);
    ?>
    </nav>

</header>