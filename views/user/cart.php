<div id="cart" class="center">
    <?php if(empty($this->productsInCart)): ?>
        <h2>Cart is Empty</h2>
    <?php endif ?>
    <?php if(!empty($this->productsInCart)): ?>
        <ul>
            <?php $totalPrice = 0; $products = $this->productsInCart; for($i = 0; $i < count($products); $i++): ?>
                <li>
                    <div>
                        <h4><?= $products[$i]['product']['Name'] ?></h4>
                    </div>
                    <div>
                        <?php if(empty($products[$i]['promotion'])): ?>
                            <span>
                                <i><?= $products[$i]['quantity'] ?></i> x
                                <i><?= $products[$i]['product']['Price'] ?></i> =
                                <b>
                                    <?php
                                    $totalPrice += $products[$i]['quantity']*floatval($products[$i]['product']['Price']);
                                    echo number_format($products[$i]['quantity']*floatval($products[$i]['product']['Price']), 2, '.', '');
                                    ?>
                                </b>
                            </span>
                        <?php endif; ?>
                        <?php if(!empty($products[$i]['promotion'])): ?>
                            <span>
                                <strike>
                                    <i><?= $products[$i]['quantity'] ?></i> x
                                    <i><?= $products[$i]['product']['Price'] ?></i> =
                                    <b>
                                        <?php
                                        echo number_format($products[$i]['quantity']*floatval($products[$i]['product']['Price']), 2, '.', '');
                                        ?>
                                    </b>
                                </strike>
                            </span>
                            <div>
                                <i><?= $products[$i]['quantity'] ?></i> x
                                <i><?= number_format((((100 - intval($products[$i]['promotion']['discount'])) / 100)  * floatval($products[$i]['product']['Price'])), '2', '.', '') ?></i> =
                                <b>
                                    <?php
                                        $number = (((100 - intval($products[$i]['promotion']['discount'])) / 100)  * floatval($products[$i]['product']['Price']));
                                        $totalPrice += $number * $products[$i]['quantity'];
                                        echo number_format($number * $products[$i]['quantity'], 2, '.', '');
                                    ?>
                                </b>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="/cart/products/removeFromCart/<?= $i ?>">Remove</a>
                </li>
            <?php endfor; ?>
        </ul>
        <span>Total: </span><b><i><?= number_format($totalPrice, 2, '.', '') ?></i></b>
        <div>
            <a href="/cart/users/checkout">Checkout</a>
        </div>
    <?php endif ?>
</div>