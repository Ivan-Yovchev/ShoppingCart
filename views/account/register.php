<form id="register-form" method="post" class="col-md-3 col-sm-4 col-xs-6">
    <label class="col-xs-5" for="username">Username</label>
    <input class="col-xs-7" type="text" name="username" id="username"/>
    <br />
    <label class="col-xs-5" for="pass">Password</label>
    <input class="col-xs-7" type="password" name="password" id="pass"/>
    <br />
    <label class="col-xs-5" for="pass_confirm">Confirm</label>
    <input class="col-xs-7" type="password" name="confirm" id="pass_confirm"/>
    <br />
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
    <input class="btn btn-primary" type="submit" value="Register" /> or <a href="/cart/account/login">Login</a>
</form>