<form id="search" class="form-inline" method="GET" action="../parks">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?=$name?>" placeholder="Park Name">
    </div>
    <div class="form-group">
        <label for="province">Province</label>
        <select class="form-control" id="province" name="province">
            <option value="">Select a Province</option>
            <?php foreach($provinces as $p) {?>
            <option <?=($province == $p["province_code"]) ? "selected" : ""?> value="<?=$p["province_code"]?>"><?=$p["province"]?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Search"/>
    </div>
    <div class="form-group">
        <a href="/parks" class="btn btn-primary">Reset</a>
    </div>
</form>