<div>
    <h2>User: <?= $this->user['username'] ?></h2>
    <p>Cash: <i><?= $this->user['money'] ?></i></p>
    <div>
        <h4>User Bought Products</h4>
        <ul>
            <?php foreach($this->products as $product): ?>
                <li>
                    <div><b><?= htmlentities($product['product']['Name']) ?></b></div>
                    <div><i><?= htmlentities($product['category']['Name']) ?></i></div>
                    <div>Price: <?= htmlentities($product['product']['Price']) ?></div>
                    <div>Quantity: <?= htmlentities($product['Quantity']) ?></div>
                    <form method="post">
                        <input type="number" value="1" name="quantity" min="1" max="<?= intval($product['Quantity']) ?>">
                        <input type="hidden" name="productId" value="<?= $product['product']['id'] ?>">
                        <input type="hidden" name="userId" value="<?= $this->getLoggedUser()['id'] ?>">
                        <input type="hidden" name="price" value="<?= $product['product']['Price'] ?>">
                        <input type="submit" value="Sell">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>