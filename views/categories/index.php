<div id="categories-table" class="col-xs-8 col-lg-6">
    <ul id="categories-nav">
        <?php foreach($this->categories as $category): ?>
            <li class="label label-primary">
                <a href="http://localhost/cart/products/index/<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    <?= htmlentities($category['Name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>