<form id="add-promotion" class="center" method="post">
    <label for="discount">Discount: </label>
    <br/>
    <input id="discount" name="discount" type="number" min="1" max="90" value="1"/>
    <br>
    <label for="from">From: </label>
    <input type="date" name="from" id="from" value="<?= date('Y-m-d') ?>"/>
    <label for="to">To: </label>
    <input type="date" name="to" id="to" value="<?= date('Y-m-d') ?>"/>
    <br />
    <input id="add-promotion-btn" type="submit" value="Create"  />
</form>