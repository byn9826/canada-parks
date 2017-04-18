<?php

include "../../lib/DatabaseAccess.php";
include "../../lib/ParkRepository.php";
$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$parks = $parkRepository->getParks($page);
$total = $parkRepository->getTotalParks();

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
			$team_route_custom = "../../";
			include "../../templates/meta.php";
		?>
		<link rel="stylesheet" href="../../static/css/admin.css" type="text/css" />
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
                <div class="col-md-10" id="admin-parks">
                    <div class="form-group" id="search-park-form">
                        <label for="search-park">Search Park</label>
                        <input class="form-control" type="text" id="search-park" />
                        <div id="search-park-result">
                            
                        </div>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <td>Name</td>
                            <td>Province</td>
                            <td>Actions</td>
                        </tr>
                        <?php foreach($parks as $park) { ?>
                        <tr id="park-<?=$park["id"]?>">
                            <td><a href="form.php?action=edit&id=<?=$park["id"]?>"><?=$park["name"]?></a></td>
                            <td><?=$park["province"]?></td>
                            <td>
                                <a class="btn btn-success" href="form.php?action=edit&id=<?=$park["id"]?>">Edit</a>
                                <a class="btn btn-danger delete-park" data-park="<?=$park["id"]?>" data-toggle="modal" data-target=".delete">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <nav aria-label="...">
                        <?php
                        $pages = $total / 10;
                        ?>
                        <ul class="pagination">
                            <?php for($i = 1; $i <= $pages; $i++) {?>
                            <li class="<?=($page == $i) ? 'active' : ''?>"><a href="?page=<?=$i?>"><?=$i?> <span class="sr-only">(current)</span></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal fade delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                        </div>
                        <div class="modal-body">
                            Are you sure to delete the park?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<script type="text/javascript" src="../../static/source/adminParks.bundle.js"></script>-->
        <script type="text/javascript" src="../../static/js/admin/park-list.js"></script>
    </body>
</html>