<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="/cart/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/cart/styles/main-styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    <header id="header">
        <div id="logout">
            <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"): ?>
                <a href="/cart/users/cart">Cart</a>
            <?php endif ?>
            <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"): ?>
                <a href="/cart/editor/users/cart">Cart</a>
            <?php endif ?>
            <?php if($this->hasLoggedUser()): ?>
                <a href="/cart/account/logout" id="logout-button" class="btn btn-info">Logout</a>
            <?php endif; ?>
        </div>
        <div id="inner-header" class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
            <div id="image">
                <div id="inner-image">
                        <div id="cart-logo">
                            <img src="/cart/styles/logo.png" />
                        </div>
                        <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"): ?>
                            <div id="editor-logo">
                                <img src="/cart/styles/editor.png" />
                            </div>
                        <?php endif; ?>
                </div>
            </div>
            <div id="nav" class="col-xs-12">
                <div id="inner-nav" class="col-xs-12">
                    <?php if($this->hasLoggedUser()): ?>
                        <ul id="menu" class="col-xs-12">
                            <?php if($this->getLoggedUser()['role'] == 'User'): ?>
                                <li><a href="/cart/users/view/<?= $this->getLoggedUser()['username']?>">Home</a></li>
                            <?php endif; ?>
                            <?php if($this->getLoggedUser()['role'] == 'Editor'): ?>
                                <li><a href="/cart/editor/users/view/<?= $this->getLoggedUser()['username']?>">Home</a></li>
                            <?php endif; ?>
                            <li><a href="/cart/categories/index">Categories</a></li>
                            <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"): ?>
                                <li><a href="/cart/products/index/all">Products</a></li>
                            <?php endif; ?>
                            <?php if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"): ?>
                                <li><a href="/cart/editor/products/index/all">Products</a></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <?php  include_once(DX_ROOT_DIR . "views\\layouts\\messages.php")?>
