<?php

include "../../lib/DatabaseAccess.php";
include "../../lib/ParkRepository.php";
$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
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

    <?php
    include "../navigation.php";
    ?>
        <div class="container">
            <h1 class="text-center">Park Admin Page</h1>
            <div class="row">
                <?php include "sidebar.php" ?>
                <div class="col-md-10">
                    <table class="table table-hover">
                        <tr>
                            <td>Name</td>
                            <td>Province</td>
                            <td>Actions</td>
                        </tr>
                        <?php foreach($parks as $park) { ?>
                        <tr>
                            <td><a href="form.php?action=edit&id=<?=$park["id"]?>"><?=$park["name"]?></a></td>
                            <td><?=$park["province"]?></td>
                            <td>
                                <a class="btn btn-success" href="form.php?action=edit&id=<?=$park["id"]?>">Edit</a>
                                <a class="btn btn-danger" href="#">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>