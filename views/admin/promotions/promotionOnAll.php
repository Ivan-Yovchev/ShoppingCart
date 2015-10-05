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
        <div>
            <i>
                Items:
            </i> <?= $this->count ?>
        </div>
        <form method="post">
            <input type="hidden" value="<?= $this->promotion['id'] ?>" name="promotionId">
            <input type="submit" value="Promote" />
        </form>
    </div>
</div>