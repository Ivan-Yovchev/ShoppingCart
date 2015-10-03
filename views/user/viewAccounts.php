<ul>
    <?php foreach($this->users as $user): ?>
        <li>
            <a href="/cart/admin/users/account/<?= htmlentities(urlencode(strtolower($user['username']))) ?>">
                <?= htmlentities($user['username']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>