<div class="wrap">
    <h1>Expiration Settings</h1>
    
    <div class="card">
        You can specify expiration periods according to deal type. Also, you can specify batch size for autoremove.
    </div>
    
    <form method="POST" action="">
        <input type="hidden" name="action" value="set">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="options[period_for_buy]">Buy Expiration Period</label>
                </th>
                <td>
                    <input 
                        name="options[period_for_buy]"
                        type="text" 
                        value="<?= $period_for_buy ?>" 
                        class="regular-text"
                    />
                </td>
            </tr>   
            <tr>
                <th scope="row">
                    <label for="options[batch_size_for_buy]">Buy Batch Size</label>
                </th>
                <td>
                    <input 
                        name="options[batch_size_for_buy]"
                        type="text" 
                        value="<?= $batch_size_for_buy ?>" 
                        class="regular-text"
                    />
                </td>                  
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="options[period_for_rent]">Rent Expiration Period</label>
                </th>
                <td>
                    <input 
                        name="options[period_for_rent]" 
                        type="text" 
                        value="<?= $period_for_rent ?>" 
                        class="regular-text"
                    />
                </td>
            </tr>   
            <tr>                
                <th scope="row">
                    <label for="options[batch_size_for_rent]">Rent Batch Size</label>
                </th>
                <td>
                    <input 
                        name="options[batch_size_for_rent]"
                        type="text" 
                        value="<?= $batch_size_for_rent ?>" 
                        class="regular-text"
                    />
                </td>                   
            </tr>
        </table>
        
        <input type="submit" class="button-primary" value="Save Changes">
    </form>
</div>
