<div id="user">
    <h2><?= htmlentities($this->user['username']) ?></h2>
    <div>Money: <i><?= $this->user['money'] ?></i></div>
    <div>
        <?php if($this->user['role'] != "Admin" && $this->user['role'] != "Editor" && $this->user['banned'] == 0): ?>
        <button>
                <a href="/cart/admin/users/makeeditor/<?= urlencode($this->user['username']) ?>">
                    Make Editor
                </a>
        </button>
        <?php endif; ?>
        <?php if($this->user['role'] != "Admin"  && $this->user['banned'] == 0): ?>
            <button>
                <a href="/cart/admin/users/makeadmin/<?= urlencode($this->user['username']) ?>">
                    Make Admin
                </a>
            </button>
        <?php endif; ?>
        <?php if($this->user['banned'] == 0): ?>
            <button>
                <a href="/cart/admin/users/ban/<?= urlencode($this->user['username']) ?>">
                    Ban User
                </a>
            </button>
        <?php endif; ?>
    </div>
    <ul>
        <?php foreach($this->products as $product): ?>
            <li>
                <div><b><?= htmlentities($product['product']['Name']) ?></b></div>
                <div><i><?= htmlentities($product['category']['Name']) ?></i></div>
                <?php if(empty($product['promotion'])): ?>
                    <div>Price: <?= htmlentities($product['product']['Price']) ?></div>
                <?php endif; ?>
                <?php if(!empty($product['promotion'])): ?>
                    <div>Price: <?= number_format(((100 - intval($product['promotion']['discount'])) / 100) * floatval($product['product']['Price']), '2', '.', '') ?></div>
                <?php endif; ?>
                <div>Quantity: <?= htmlentities($product['Quantity']) ?></div>
                <form method="post">
                    <input type="hidden" name="productId" value="<?= $product['product']['id'] ?>">
                    <input type="hidden" name="userId" value="<?= $this->user['id'] ?>">
                    <?php if(empty($product['promotion'])): ?>
                        <input type="hidden" name="price" value="<?= $product['product']['Price'] ?>">
                    <?php endif; ?>
                    <?php if(!empty($product['promotion'])): ?>
                        <input type="hidden" name="price" value="<?= ((100 - intval($product['promotion']['discount'])) / 100) * floatval($product['product']['Price']) ?>">
                    <?php endif; ?>
                    <input type="submit" value="Remove">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>