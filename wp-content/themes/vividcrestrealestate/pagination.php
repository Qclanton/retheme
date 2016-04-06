<div class="universal-wrapper--inner clearfix two_cols">
    <div class="col--left">
        <div class="universal_line-wrapper">
            <?= $pagination->first_shown ?> - <?= $pagination->last_shown ?> of <?= $pagination->total ?>
        </div>
    </div>
    <div class="col--right">
        <ul class="pagintaion">
            <li class="previous" <?= $pagination->current > 1 ? "" : "style='display:none'" ?>>
                <a href="<?= createLink("/properties", ['current'=>$pagination->previous, 'per_page'=>$pagination->per_page, 'sort'=>$pagination->sort_encoded]) ?>">
                    «
                </a>
            </li>
            <li class="page-button page-button-first <?= $pagination->current == 1 ? "current" : "" ?>">
                <a href="<?= createLink("/properties", ['current'=>1, 'per_page'=>$pagination->per_page, 'sort'=>$pagination->sort_encoded]) ?>">
                    1
                </a>
            </li>
            <li class="separator" <?= $pagination->current > 4 ? "" : "style='display:none'" ?>>...</li>                    
            
            <?php for ($page = ($pagination->current-2); $page <= ($pagination->current+2); $page++) { ?>
                <?php if ($page > 1 && $page < $pagination->total_pages) { ?>
                    <li class="page-button <?= $page == $pagination->current ? "current" : ""?>">
                        <a href="<?= createLink("/properties", ['current'=>$page, 'per_page'=>$pagination->per_page, 'sort'=>$pagination->sort_encoded]) ?>">
                            <?= $page ?>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
            
            <li class="separator" <?= $pagination->current < $pagination->total_pages-2 ? "" : "style='display:none'" ?>>...</li>
            <li class="page-button page-button-last <?= $pagination->total_pages == $pagination->current ? "current" : ""?>" <?= $pagination->total_pages < 5 ? "style='display:none'" : "" ?>>
                <a href="<?= createLink("/properties", ['current'=>$pagination->total_pages, 'per_page'=>$pagination->per_page, 'sort'=>$pagination->sort_encoded]) ?>">
                    <?= $pagination->total_pages ?>
                </a>                
            </li>
            <li class="next" <?= $pagination->total_pages < 4 || $pagination->total_pages == $pagination->current ? "style='display:none'" : "" ?>>
                <a href="<?= createLink("/properties", ['current'=>$pagination->next, 'per_page'=>$pagination->per_page, 'sort'=>$pagination->sort_encoded]) ?>">
                    »
                </a>
           </li>
        </ul>
    </div>
</div>
