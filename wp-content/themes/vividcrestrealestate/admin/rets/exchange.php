<div class="wrap">
    <h1>Exchange</h1>
    
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
    

    
    <!-- Form for fetching data -->  
    <h3>Fetch Data</h3>  
    <form id="fetch_data" name="fetch_data" method="POST" action="">
        <input type="hidden" name="action" value="fetchRawData">    
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="start">Start</label>
                </th>
                <td>
                    <input 
                        name="start"
                        type="text" 
                        value="<?= date("Y-m-d\T00:00:00", strtotime("-2 day")) ?>" 
                        class="regular-text"
                    />
                </td>                  
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="start">End</label>
                </th>
                <td>
                    <input 
                        name="end"
                        type="text" 
                        value="<?= date("Y-m-d\T00:00:00", strtotime("-1 day")) ?>" 
                        class="regular-text"
                    />
                </td>                  
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="class">Class</label>
                </th>
                <td>
                    <select name="class">
                        <option value="ResidentialProperty">Residential Property</option>
                        <option value="CommercialProperty">Commercial Property</option>
                        <option value="CondoProperty">Condo Property</option>
                    </select>
                </td>                 
            </tr>
        </table>
        
        <input type="submit" class="button-primary" value="Fetch Properties">    
    </form>
    
    
    <!-- Form for processing data -->
    <h3>Process Data</h3>  
    <form id="processing_data" name="processing_data"  method="POST" action="">
        <input type="hidden" name="action" value="processData">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="batch_size">Batch size</label>
                </th>
                <td>
                    <select name="batch_size">
                        <option value="2">2</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100" selected>100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </td>                 
            </tr>
        </table>
        
        <input type="submit" class="button-primary" value="Process Properties">    
    </form>
</div>
