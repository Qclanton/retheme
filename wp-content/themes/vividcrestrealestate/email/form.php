<p>Hello!</p>
<p>Customer used form on the site <?= $site ?><p>
<p>Client fills next fields:</p>

<table style="border: solid 1px">
    <thead>
            <tr>
                <th style="border: solid 1px">Field</th>
                <th style="border: solid 1px">Value</th>
            </tr>
    </thead>
    
    <tbody>
        <?php foreach ($data as $field=>$value) { ?>
            <tr>
                <td style="border: solid 1px"><?=$field ?></td>
                <td style="border: solid 1px">
                    <?php if ($field == "link") { ?>
                        <a href="<?=$value ?>"><?=$value ?></a>
                    <?php } else { ?>
                        <?=$value ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
    
