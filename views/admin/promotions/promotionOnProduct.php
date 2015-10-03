<div>
    <div>Discount: <b><?= $this->promotion['discount'] ?>%</b></div>
    <div>
        <span>
            From: <b>
                <?php
                $date = date_create($this->promotion['promotion_start']);
                echo $date->format("Y-m-d");
                ?>
            </b>
        </span>
        <span>
            To: <b>
                <?php
                $date = date_create($this->promotion['promotion_end']);
                echo $date->format("Y-m-d");
                ?>
            </b>
        </span>
        <form method="post">
            <input type="hidden" value="<?= $this->promotion['id'] ?>" name="promotionId">
            <label for="on">On: </label>
            <select id="on" name="productId">
                <?php foreach($this->products as $product): ?>
                    <option value="<?= $product['id'] ?>">
                        <?= $product['Name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Promote" />
        </form>
    </div>
</div>