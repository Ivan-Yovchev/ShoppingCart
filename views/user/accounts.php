<div>
    <input type="text" id="search-term" placeholder="username..." />
    <div id="users">
    </div>
</div>
<script>
    function getUsersByUserName(){
        var searchTerm = $('#search-term').val();
        $.ajax({
            url: "http://localhost/cart/admin/users/viewAccounts/" + searchTerm,
            method: "GET"
        }).success(function(data){
            $('#users').html(data);
        });
    }

    $(function () {
        getUsersByUserName();
    });

    $('#search-term').on("keyup", function(){
        getUsersByUserName();
    });
</script>