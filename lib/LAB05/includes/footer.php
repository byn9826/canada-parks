<footer class="footer">
    <?php
    // Array to keep navigation links
    $lstNavLinks = [
                    ['#', 'Home'],
                    ['#', 'Blog'],
                    ['#', 'Experiments'],
                    ['#', 'Contact'],
                    ['#', 'About']
                   ];
    ?>
    <nav class="footer-nav">
        <?php
            //echo display_navigation($lstNavLinks);
            echo validation_functions::generateNavigationList($lstNavLinks)
        ?>
    </nav>
    <div>Copyright &copy; 2017 | Mohammad Irfaan Auhammad</div>
</footer>