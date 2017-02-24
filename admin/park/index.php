<?php

include "../../lib/ParkRepository.php";

$parkRepository = new ParkRepository();
$parks = $parkRepository->getParks();

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
			$team_route_custom = "../../";
			include "../../templates/meta.php";
		?>
		<title>Park List Admin</title>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Park Admin Page</h1>
            <a class="btn btn-default" href="/admin/park/form.php?action=add" role="button">Add Park</a>
            <table class="table table-hover">
                <tr>
                    <td>Name</td>
                    <td>Province</td>
                    <td>Actions</td>
                </tr>
                <?php foreach($parks as $park) { ?>
                <tr>
                    <td><a href="/admin/park/form.php?action=edit&id=<?=$park["id"]?>"><?=$park["name"]?></a></td>
                    <td><?=$park["province"]?></td>
                    <td>
                        <a class="btn btn-success" href="/admin/park/form.php?action=edit&id=<?=$park["id"]?>">Edit</a>
                        <a class="btn btn-danger" href="#">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>