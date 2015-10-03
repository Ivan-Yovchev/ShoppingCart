<form id="add-product" method="post">
    <label for="product-name">Name: </label>
    <input id="product-name" type="text" name="productName" />
    <label for="product-price">Price: </label>
    <input id="product-price" type="number" step="any" name="price">
    <label for="product-quantity">Quantity: </label>
    <input id="product-quantity" min="1" type="number" name="quantity">
    <label for="product-category">Category: </label>
    <select name="categoryId" id="product-category">
        <?php foreach($this->categories as $category): ?>
            <option value="<?= $category['id'] ?>">
                <?= ucfirst($category['Name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Add Product"/>
</form>