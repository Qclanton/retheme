<div class="universal-wrapper--inner clearfix two_cols">
    <div class="col--left">
        <div class="universal_line-wrapper">
            <?= $pagination->first_shown ?> - <?= $pagination->last_shown ?> of <?= $pagination->total ?>
        </div>
    </div>
    <div class="col--right">
        <ul class="pagintaion">
                <li class="previous" <?= $pagination->current > 1 ? "" : "style='display:none'" ?>>
                    <a href="/properties?current=<?= $pagination->current-1 ?>&per_page=<?= $pagination->per_page ?>&sort=<?= $pagination->sort ?>">
                        «
                    </a>
                </li>
                <li class="page-button page-button-first <?= $pagination->current == 1 ? "current" : "" ?>">
                    <a href="/properties?current=1&per_page=<?= $pagination->per_page ?>&sort=<?= $pagination->sort ?>">
                        1
                    </a>
                </li>
                <li class="separator" <?= $pagination->current > 4 ? "" : "style='display:none'" ?>>...</li>                    
            
            <?php for ($page=2; $page < $pagination->total_pages; $page++) { ?>
                <li 
                    class="page-button <?= $page == $pagination->current ? "current" : ""?>" 
                    <?= ($pagination->current - 2) < $page && $page < ($pagination->current + 2)  ? "" : "style='display:none'" ?>
                    >
                    <a href="/properties?current=<?= $page ?>&per_page=<?= $pagination->per_page ?>&sort=<?= $pagination->sort ?>">
                        <?= $page ?>
                    </a>
                </li>
            <?php } ?>
            
                <li class="separator" <?= $pagination->current < $pagination->total_pages-2 ? "" : "style='display:none'" ?>>...</li>
                <li class="page-button page-button-last" <?= $pagination->total_pages < 5 ? "style='display:none'" : "" ?>>
                    <a href="/properties?current=<?= $pagination->total_pages ?>&per_page=<?= $pagination->per_page ?>&sort=<?= $pagination->sort ?>">
                        <?= $pagination->total_pages ?>
                    </a>                
                </li>
                <li class="next" <?= $pagination->total_pages < 4 ? "style='display:none'" : "" ?>>
                    <a href="/properties?current=<?= $pagination->current+1 ?>&per_page=<?= $pagination->per_page ?>&sort=<?= $pagination->sort ?>">
                        »
                    </a>
               </li>
        </ul>
    </div>
</div>
