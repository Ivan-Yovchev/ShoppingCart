<div id="categories-table" class="col-xs-8 col-lg-6">
    <button>
        <a href="http://localhost/cart/editor/categories/add">
            Add Category
        </a>
    </button>
    <ul id="categories-nav-editor">
        <?php foreach($this->categories as $category): ?>
            <li class="label label-primary">
                <a class="cat-normal" href="http://localhost/cart/editor/products/index/<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    <?= htmlentities($category['Name']) ?>
                </a>
                <a class="cat-remove" href="http://localhost/cart/editor/categories/remove/<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    Remove
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>