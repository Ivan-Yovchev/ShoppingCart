<ul  id="promotions-nav">
    <?php foreach($this->promotions as $promotion): ?>
        <li>
            <div>Discount: <b><?= $promotion['discount'] ?>%</b></div>
            <div>
                <span>
                    From: <b>
                        <?php
                            $date = date_create($promotion['promotion_start']);
                            echo $date->format("Y-m-d");
                        ?>
                    </b>
                </span>
                <span>
                    To: <b>
                        <?php
                            $date = date_create($promotion['promotion_end']);
                            echo $date->format("Y-m-d");
                        ?>
                    </b>
                </span>
            </div>
            <div id="promotion-actions">
                <a href="/cart/admin/promotions/onproduct/<?= $promotion['id'] ?>">
                    On Product
                </a>
                <a href="/cart/admin/promotions/oncategory/<?= $promotion['id'] ?>">
                    On Category
                </a>
                <a href="/cart/admin/promotions/onall/<?= $promotion['id'] ?>">
                    On All
                </a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>