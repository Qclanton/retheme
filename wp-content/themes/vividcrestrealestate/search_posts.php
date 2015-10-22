<?php if (count($posts) == 0) { ?>
    <p>Sorry but search result is empty. Please, try again</p>
<?php } else { ?>
    
    <form role="search" method="get" id="searchform" class="searchform" action="<?= site_url() ?>">
        <input type="text" name="s" value="<?= $search_query ?>" />
        <input type="submit" value="Search" />
    </form>
    
    <?php foreach ($posts as $post) { ?>
        <h4><?= $post->post_title ?></h4>
        <p>
            <a href="<?= get_permalink($post->ID) ?>">
                <?= generate_excerpt($post->post_content, "...", 500) ?>
            </a>
        </p>
     <?php } ?>   
</div>
<?php } ?>
