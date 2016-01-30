<div class="wrap">
    <h1>MailGun Settings</h1>
    
    <form method="POST" action="">
        <input type="hidden" name="action" value="set">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="options[domain]">Domain</label>
                </th>
                <td>
                    <input 
                        name="options[domain]"
                        type="text" 
                        value="<?= $domain ?>" 
                        class="large-text"
                    />
                </td>                  
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="options[key]">Key</label>
                </th>
                <td>
                    <input 
                        name="options[key]" 
                        type="text" 
                        value="<?= $key ?>" 
                        class="large-text"
                    />
                </td>                  
            </tr>
        </table>
        
        <input type="submit" class="button-primary" value="Save Changes">
    </form>
</div>
