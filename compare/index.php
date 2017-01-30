<?php
$provinces = array(
    'Alberta' => 'AB',
    'British Columbia' => 'BC',
    'Manitoba' => 'MB',
    'New Brunswick' => 'NB',
    'Newfoundland and Labrador' => 'NL',
    'Northwest Territories' => 'NT',
    'Nova Scotia' => 'NS',
    'Nunavut' => 'NU',
    'Ontario' => 'ON',
    'Prince Edward Island' => 'PE',
    'Quebec' => 'QC',
    'Saskatchewan' => 'SK',
    'Yukon' => 'YT'
);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Park List</title>
        <link rel="stylesheet" href="/static/css/parks.css">
    </head>
    <body>
        <main>
            <div class="container">
                <h1 class="text-center">Park List</h1>
                <form id="search" class="form-inline">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Park Name">
                    </div>
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select class="form-control" id="province" name="province">
                            <option value="">Select a Province</option>
                            <?php foreach($provinces as $name => $value) {?>
                            <option value="<?=$value?>"><?=$name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">

                    </div>
                </form>
                <button type="button" id="compare" class="btn btn-primary hidden" data-toggle="modal" data-target=".bs-example-modal-lg">Compare</button>
                <div class="row">
                    <?php
                    //$url = 'http://travel.nationalgeographic.com/travel/parks/canada-national-parks/';
                    $url = 'https://en.wikipedia.org/wiki/List_of_National_Parks_of_Canada';
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    $html = curl_exec($handle);
                    libxml_use_internal_errors(true); // Prevent HTML errors from displaying
                    
                    $dom = new DOMDocument();
                    $dom->loadHTML($html);
                    $xpath = new DOMXPath($dom);
                    // national geo
                    // $classname = 'canada-park-guides';
                    // $results = $xpath->query("//*[contains(@class, '$classname')]");

                    // foreach ($results as $result) {
                    //     $parks = $result->getElementsByTagName('li');
                    //     foreach($parks as $park) {
                    //         var_dump($park->getElementsByTagName('a')->item(0)->nodeValue);
                    //         echo '<img src="' . $park->getElementsByTagName('img')->item(0)->getAttribute('src') . '" />';
                    //     }
                    // }
                    
                    $classname = 'wikitable';
                    $results = $xpath->query("//*[contains(@class, '$classname')]");
                    foreach($results as $result) {
                        $trs = $result->getElementsByTagName('tr');
                        $skip = false;
                        foreach($trs as $tr) {
                            if ($skip == true) {
                                $td = $tr->getElementsByTagName('td');
                                $name = $td->item(0)->getElementsByTagName('a')->item(0)->nodeValue;
                                $photo = $td->item(1)->getElementsByTagName('img')->item(0);
                                if ($photo != null ) {
                                    $img = $photo->getAttribute('src');
                                } else {
                                    $img = '';
                                }
                                ?>
                        <div class="col-xs-6 col-sm-4 col-md-3 park">
                            <?php if ($img != '') {?>
                            <img class="img-responsive" src="<?=$img?>" alt="...">
                            <?php } ?>
                            <div class="caption">
                                <h4><?=$name?></h4>
                                <p>...</p>
                                <p><a href="#" class="btn btn-primary" role="button">Detail</a> <a  data-id="<?=$i?>" href="#" class="btn btn-default select" role="button">Compare</a></p>
                            </div>
                        </div>
                                <?php
                            }
                            $skip = true;
                        }
                        break;
                    }


                    ?>
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