<div class="wrap">
    <h1>Expiration Settings</h1>
    
    <form method="POST" action="">
        <input type="hidden" name="action" value="set">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="options[period_for_buy]">Buy</label>
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
                    <label for="options[period_for_rent]">Rent</label>
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
        </table>
        
        <input type="submit" class="button-primary" value="Save Changes">
    </form>
</div>
