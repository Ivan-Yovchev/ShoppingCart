<ul id="products-nav">
    <?php foreach($this->products as $product): ?>
        <li class="label label-primary">
            <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"): ?>
                <a href="http://localhost/cart/products/view/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                    <?= htmlentities($product['Name']) ?>
                </a>
                <?php if($product['promoted'] == true): ?>
                    <div class="promotion">
                        <img src="/cart/styles/promo.png">
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>