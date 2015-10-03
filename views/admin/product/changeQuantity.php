<div>
    <h2><?= $this->product['Name'] ?></h2>
    <div><b>Quantity: </b><?= $this->product['Quantity'] ?></div>
    <form method="post">
        <input type="hidden" value="<?= $this->product['id'] ?>" name="productId">
        <label for="quantity">Change to: </label>
        <input id="quantity" type="number" value="1" min="1" name="quantity"/>
        <input type="submit" value="Change" />
    </form>
</div>