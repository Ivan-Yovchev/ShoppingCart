<div id="product-container">
    <div id="search-product">
        <input type="text" id="search" name="searchTerm" placeholder="Food..." />
        <input type="hidden" id="selected-category" value="<?= $this->selected ?>">
        <select id="category-select">
            <option value="all" selected>
                All
            </option>
            <?php foreach($this->categories as $category): ?>
                <option value="<?= htmlentities(urlencode(strtolower($category['Name']))) ?>">
                    <?= ucfirst($category['Name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <form id="add-product" method="post">
        <label for="product-name">Name: </label>
        <input id="product-name" type="text" name="productName" />
        <label for="product-price">Price: </label>
        <input id="product-price" type="number" step="any" name="price">
        <label for="product-promotion">Promotion: </label>
        <select id="product-promotion" name="promotionId">
            <option value="null">No Promotion</option>
        </select>
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
    <div id="products">
    </div>
</div>
<script>
    function getProductsByCategoryAndSearchTerm(){
        var searchTerm = $('#search').val();
        var category = $('#category-select').val();
        $.ajax({
            url: "http://localhost/cart/editor/products/show/" + category + "/" + searchTerm,
            method: "GET"
        }).success(function(data){
            $('#products').html(data);
        });
    }

    $(function () {
        var selected = $('#selected-category').val();
        $('#category-select option[value="' + selected + '"]').attr('selected', 'selected');
    });

    $(function () {
       getProductsByCategoryAndSearchTerm();
    });

    $('#category-select').on("change", function(){
        getProductsByCategoryAndSearchTerm();
    });

    $('#search').on("keyup", function(){
        getProductsByCategoryAndSearchTerm();
    });
</script>