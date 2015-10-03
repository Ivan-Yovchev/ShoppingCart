<div id="move-product">
    <h2><?= $this->product['Name'] ?></h2>
    <div><i><?= $this->category['Name'] ?></i></div>
    <form method="post">
        <input name="productId" type="hidden" value="<?= $this->product['id'] ?>">
        <input name="from" type="hidden" value="<?= $this->category['id'] ?>">
        <label for="to">Move To: </label>
        <select id="to" name="to">
            <?php foreach($this->categories as $category): ?>
                <option value="<?= $category['id'] ?>">
                    <?= ucfirst($category['Name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Move">
    </form>
</div>