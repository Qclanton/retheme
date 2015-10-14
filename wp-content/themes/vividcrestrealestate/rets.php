<h1>Page for test RETS answers</h1>

<ul>
    <?php foreach ($rets_data as $time=>$properties) { ?>
        <li>Time: <?= $time ?>, quantity: <?= count($properties) ?></li>
    <?php } ?>
</ul>
