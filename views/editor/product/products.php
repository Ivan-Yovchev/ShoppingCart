<ul id="products-nav-editor">
    <?php foreach($this->products as $product): ?>
        <li class="label label-primary">
            <?php if(!empty($_SESSION['user']) && $_SESSION['user'][0]['role'] == "Editor"): ?>
                <a href="http://localhost/cart/editor/products/view/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                    <?= htmlentities($product['Name']) ?>
                </a>
                <?php if($product['promoted'] == true): ?>
                    <div class="promotion">
                        <img src="/cart/styles/promo.png">
                    </div>
                <?php endif; ?>
                <div id="actions">
                    <a class="remove" href="http://localhost/cart/editor/products/remove/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Remove
                    </a>
                    <a class="move" href="http://localhost/cart/editor/products/move/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Move
                    </a>
                    <a class="quantity" href="http://localhost/cart/editor/products/change/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                        Quantity
                    </a>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>