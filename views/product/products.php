<ul id="products-nav">
    <?php foreach($this->products as $product): ?>
        <li class="label label-primary">
            <a href="http://localhost/cart/products/view/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                <?= htmlentities($product['Name']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>