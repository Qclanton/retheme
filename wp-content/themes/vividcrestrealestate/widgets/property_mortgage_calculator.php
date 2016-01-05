<script src="<?= content_url() ?>/plugins/mortgages_rates/views/js/calc.js"></script>
<div class="mortgage__calc property__blocks">
    <h2 class="title--colored">Mortgage Calculator</h2>
    <div class="mortgage__calc-line clearfix">
        <div class="mortgage__calc-cell">
            <span>Mortgage Amount</span>
            <input type="number" placeholder="Mortgage Amount" value="<?= $amount ?>" name="mortage_sum" >
        </div>
        <div class="mortgage__calc-cell">
            <span>Interest Rate</span>
            <select name="rate">
                <?php foreach ($rates as $i=>$rate) { ?>
                    <option 
                            <?= $rate->rate == $default_rate ? "selected='selected'" : "" ?> 
                            value="<?= $rate->rate ?>"
                        >
                        <?= number_format($rate->rate, 2) ?>% in <?= $rate->term ?> year<?= $i!=1 ? "s" : "" ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mortgage__calc-cell">
            <span>Amortization Period</span>
            <select name="amortization_period">
                <?php for ($i=1; $i<=25; $i++) { ?>
                    <option 
                            <?= $i == $default_period ? "selected='selected'" : "" ?> 
                            value="<?= $i ?>"
                        >
                        <?= $i ?> year<?= $i != 1 ? "s" : "" ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mortgage__calc-cell">
            <span>Payment Frequency </span>
            <select name="payment_frequency">
                <option value="weekly" selected="selected">Weekly</option>
                <option value="rapid_weekly">Rapid Weekly</option>
                <option value="biweekly">Bi-Weekly</option>
                <option value="rapid_biweekly">Rapid Bi-Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>	
        <h2 class="title--underlined"><strong></strong></h2>
    </div>
</div>		
