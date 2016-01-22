<div class="wrap">
    <h1>Featured Properties</h1>
    
    
    <!-- Messages -->
    <?php if (!empty($positive_messages)) { ?>
        <div id="message" class="updated">
            <?php foreach ($positive_messages as $positive_message) { ?>
                <p><?= $positive_message ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    
    <?php if (!empty($negative_messages)) { ?>
        <div id="message" class="error">
            <?php foreach ($negative_messages as $negative_message) { ?>
                <p><?= $negative_message ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    

    
    <!-- Form for set -->
    <form method="POST" action="">
        <input type="hidden" name="action" value="set">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="searched_mls_id">MLS #</label>
                </th>
                <td>
                    <input 
                        name="searched_mls_id"
                        type="text" 
                        value="<?= $searched_mls_id ?>" 
                        class="regular-text"
                        placeholder="Type MLS #"                        
                    />
                    <input type="submit" class="button-primary" value="Set As Featured">
                </td>                  
            </tr>
        </table>
    </form>
    
    
    
    <!-- List of featured properties -->
    <?php if (!empty($featured_properties)) { ?>
        <table class="widefat">
            <thead>
                    <tr>
                        <th>MLS #</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Creation date</th>
                        <th>Action</th>
                    </tr>
            </thead>
            
            <tbody>
                <?php foreach ($featured_properties as $property) { ?>
                    <tr>  
                        <td>
                            <a href="<?= site_url("/properties/{$property->id}/") ?>"><?= $property->mls_id ?>
                        </td>              
                        <td><?= $property->address ?></td>
                        <td>
                            <img width="100px" height="100px" src="<?= $property->main_image ?>"/>
                        </td>
                        <td><?= $property->creation_date ?></td>
                        <td>
                            <a href="<?= admin_url("admin.php?page=featured_properties&action=remove&mls_id={$property->mls_id}") ?>" class="button">Remove</a>
                        </td>          
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>
