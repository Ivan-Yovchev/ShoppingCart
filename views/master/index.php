<div id="main" class="col-lg-6 col-md-8 col-xs-10">
    <h2>Welcome to our online shopping cart</h2>
    <?php if(!$this->hasLoggedUser()): ?>
        <p>Please
            <a href="http://localhost/cart/account/login">
                Login
            </a>
            or
            <a href="http://localhost/cart/account/register">
                Register
            </a>
        </p>
    <?php endif; ?>
    <?php if($this->hasLoggedUser()): ?>
        <p>Feel free to explore a wide variety of products.</p>
        <p>Spend your money wisely!</p>
    <?php endif; ?>
</div>