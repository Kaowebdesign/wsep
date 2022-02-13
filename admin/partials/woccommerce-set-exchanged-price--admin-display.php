<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/admin/partials
 */
        $currencies = new Currencies();
		$currencies -> calculate();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="xml">
    <h1>Текущие курсы валют</h1>
    <div class="info wpml-admin-notice" style="background: #fff;padding: 16px;">
            <p style="color:#c00;margin-bottom:16px;">Внимание, это действие обновит цены всех товаров в соответствии с текущем курсом валют.</p>
            <h2>Курсы валют (НБУ / ПриватБанк)</h2>
            <p>
                <span>USD:</span>
                <span><?= $currencies->extUsd; ?></span>
            </p>
            <p>
                <span>EUR:</span>
                <span><?= $currencies->extEur; ?></span>
            </p>
        </div>
    <form method="post" action="" novalidate="novalidate" id="currencies-form">
        <p>
            <label for="usd">Курс доллара (USD):</label>
            <input type="number" name="usd" value="<?=$currencies->usd; ?>" id="usd" />
        </p>
        <p>
            <label for="eur"><label for="usd">Курс евро (EUR):</label>
            <input type="number" name="eur" value="<?= $currencies->eur; ?>" id="eur" />
        </p>

        <div class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Обновить цены">
        </div>
    </form>
</div>
