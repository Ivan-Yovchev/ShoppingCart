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
    <button id="add-product-btn">
        <a href="http://localhost/cart/editor/products/add">
            Add Product
        </a>
    </button>
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