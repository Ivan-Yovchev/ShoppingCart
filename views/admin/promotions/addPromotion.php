<form method="post">
    <label for="discount">Discount: </label>
    <input id="discount" name="discount" type="number" min="1" max="90" value="1"/>
    <label for="from">From: </label>
    <input type="date" name="from" id="from" value="<?= date('Y-m-d') ?>"/>
    <label for="to">To: </label>
    <input type="date" name="to" id="to" value="<?= date('Y-m-d') ?>"/>
    <input type="submit" value="Create"  />
</form>