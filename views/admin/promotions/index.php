<div>
    <button>
        <a href="/cart/admin/promotions/add">
            Add Promotion
        </a>
    </button>
    <div>
        <input type="text" id="search-promotion" name="searchTerm" />
    </div>
    <div id="promotions">
    </div>
</div>
<script>
    function getPromotions(){
        var searchTerm = $('#search-promotion').val();
        $.ajax({
            url: "http://localhost/cart/admin/promotions/show/" + searchTerm,
            method: "GET"
        }).success(function(data){
            $('#promotions').html(data);
        });
    }

    $(function () {
        getPromotions();
    });

    $('#search-promotion').on("keyup", function(){
        getPromotions();
    });
</script>