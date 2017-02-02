<footer class="footer">
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
    <nav class="footer-nav">
        <?php
            echo display_navigation($lstNavLinks);
        ?>
    </nav>
    <div>Copyright &copy; 2017 | Mohammad Irfaan Auhammad</div>
</footer>