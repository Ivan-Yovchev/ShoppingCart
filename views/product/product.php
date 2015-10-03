<div id="product">
    <h2><?= $this->product['Name'] ?></h2>
    <div><i><?= $this->category['Name'] ?></i></div>
    <?php if(empty($this->promotion)): ?>
        <div><b>Price:</b> <?= $this->product['Price'] ?></div>
    <?php endif; ?>
    <?php if(!empty($this->promotion)): ?>
        <div><b>Price: </b>
            <strike>
                <?= $this->product['Price'] ?>
            </strike>
            <span>
                <?= number_format(((100 - intval($this->promotion['discount'])) / 100) * floatval($this->product['Price']), 2, '.', '') ?>
            </span>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $this->product['id'] ?>">
        <label for="quantity">Quantity: </label>
        <input id="quantity" name="quantity" type="number" value="1" min="1" max="<?= intval($this->product['Quantity']) ?>"/>
        <br />
        <input type="submit" value="Add To Cart" />
    </form>
</div>