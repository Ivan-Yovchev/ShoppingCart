<ul>
    <?php foreach($this->products as $product): ?>
        <li>
            <?php if(!empty($_SESSION['user']) && $_SESSION['user'][0]['role'] == "Editor"): ?>
                <a href="http://localhost/cart/editor/products/view/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">
                    <?= htmlentities($product['Name']) ?>
                </a>
                <a href="http://localhost/cart/editor/products/remove/<?= htmlentities(urlencode(strtolower($product['Name']))) ?>">Remove</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>