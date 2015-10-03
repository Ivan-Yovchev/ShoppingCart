<ul>
    <?php foreach($this->products as $product): ?>
        <li>
            <?php if(!empty($_SESSION['user']) && $_SESSION['user'][0]['role'] == "Admin"): ?>
                <a href="http://localhost/cart/admin/products/view/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                    <?= htmlentities($product['Name']) ?>
                </a>
                <?php if($product['promoted'] == true): ?>
                    <div>
                        <h1 style="color: red">Promoted</h1>
                    </div>
                <?php endif; ?>
                <div>
                    <a href="http://localhost/cart/admin/products/remove/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Remove
                    </a>
                    <a href="http://localhost/cart/admin/products/move/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Move
                    </a>
                    <a href="http://localhost/cart/admin/products/change/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Change Quantity
                    </a>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>