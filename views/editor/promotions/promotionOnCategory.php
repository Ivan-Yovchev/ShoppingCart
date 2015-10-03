<div class="center">
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
            <select id="on" name="categoryId">
                <?php foreach($this->categories as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= $category['Name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <input type="submit" value="Promote" />
        </form>
    </div>
</div>