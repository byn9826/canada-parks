<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Park List</title>
    </head>
    <body>
        <main>
            <div class="container">
                <button type="button" id="compare" class="btn btn-primary hidden" data-toggle="modal" data-target=".bs-example-modal-lg">Compare</button>
                <div class="row">
                    <?php for ($i = 0; $i < 46; $i++) {?>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <img class="img-responsive" src="https://images-resrc.staticlp.com/C=SQ/S=H185,U/O=85/http://media.lonelyplanet.com/a/g/hi/t/3a3737538ce2c8337655dcbf409e8d1c-gwaii-haanas-national-park-reserve-national-marine-conservation-area-reserve-haida-heritage-site.jpg" alt="...">
                        <div class="caption">
                            <h3>Name<?=$i?></h3>
                            <p>...</p>
                            <p><a href="#" class="btn btn-primary" role="button">Detail</a> <a  data-id="<?=$i?>" href="#" class="btn btn-default select" role="button">Compare</a></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Compare
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="compare.js"></script>
    </body>
</html>