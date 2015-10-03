<div id="categories-table" class="col-xs-8 col-lg-6">
    <button>
        <a href="http://localhost/cart/admin/categories/add">
            Add Category
        </a>
    </button>
    <ul>
        <?php foreach($this->categories as $category): ?>
            <li>
                <a href="http://localhost/cart/admin/products/index/<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    <?= htmlentities($category['Name']) ?>
                </a>
                <a href="http://localhost/cart/admin/categories/remove/<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    Remove
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>