<div id="remove-product">
    <h2><?= $this->product['Name'] ?></h2>
    <div><i><?= $this->category['Name'] ?></i></div>
    <div><b>Price:</b> <?= $this->product['Price'] ?></div>
    <div><b>Quantity:</b> <?= $this->product['Quantity'] ?></div>
    <form method="post">
        <input type="hidden" name="productId" value="<?= intval($this->product['id']) ?>">
        <input type="submit" value="Delete" />
    </form>
</div>