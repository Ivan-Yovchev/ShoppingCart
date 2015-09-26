<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
</head>
<body>
    <div>
        <p>
            <?php if(!empty ($this->has_logged_user())): ?>
                    Hello, <?= $this->get_logged_user()['username'] ?>
            <?php endif; ?>
        </p>
        <p>testing header</p>
        <div>
            <?php if(!empty ($this->has_logged_user())): ?>
                <a href="/cart/account/logout">[Logout]</a>
            <?php endif; ?>
        </div>
    </div>
