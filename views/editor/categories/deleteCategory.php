<div class="center">
    <h2><?= $this->category['Name'] ?></h2>
    <div><b>Products in category:</b> <?= $this->category['count'] ?></div>
    <form method="post">
        <input type="hidden" name="categoryId" value="<?= intval($this->category['id']) ?>">
        <input type="submit" value="Delete" />
    </form>
</div>