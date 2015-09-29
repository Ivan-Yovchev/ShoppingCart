<div id="product">
    <h2><?= $this->product['Name'] ?></h2>
    <div><i><?= $this->category['Name'] ?></i></div>
    <div><b>Price:</b> <?= $this->product['Price'] ?></div>
    <form method="post">
        <input type="hidden" name="id" value="<?= $this->product['id'] ?>">
        <label for="quantity">Quantity: </label>
        <input id="quantity" name="quantity" type="number" value="1" min="1" max="<?= intval($this->product['Quantity']) ?>"/>
        <input type="submit" value="Add To Cart" />
    </form>
</div>