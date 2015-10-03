<div id="user">
    <h2>User: <?= $this->user['username'] ?></h2>
    <p>Cash: <i><?= $this->user['money'] ?></i></p>
    <div>
        <h4>User Bought Products</h4>
        <ul>
            <?php foreach($this->products as $product): ?>
                <li>
                    <div><b><?= htmlentities($product['product']['Name']) ?></b></div>
                    <div><i><?= htmlentities($product['category']['Name']) ?></i></div>
                    <?php if(empty($product['promotion'])): ?>
                        <div>Price: <?= htmlentities($product['product']['Price']) ?></div>
                    <?php endif; ?>
                    <?php if(!empty($product['promotion'])): ?>
                        <div>Price: <?= number_format(((100 - intval($product['promotion']['discount'])) / 100) * floatval($product['product']['Price']), '2', '.', '') ?></div>
                    <?php endif; ?>
                    <div>Quantity: <?= htmlentities($product['Quantity']) ?></div>
                    <form method="post">
                        <input type="number" value="1" name="quantity" min="1" max="<?= intval($product['Quantity']) ?>">
                        <input type="hidden" name="productId" value="<?= $product['product']['id'] ?>">
                        <input type="hidden" name="userId" value="<?= $this->getLoggedUser()['id'] ?>">
                        <?php if(empty($product['promotion'])): ?>
                            <input type="hidden" name="price" value="<?= $product['product']['Price'] ?>">
                        <?php endif; ?>
                        <?php if(!empty($product['promotion'])): ?>
                            <input type="hidden" name="price" value="<?= ((100 - intval($product['promotion']['discount'])) / 100) * floatval($product['product']['Price']) ?>">
                        <?php endif; ?>
                        <input type="submit" value="Sell">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>