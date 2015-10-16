<div class="wrap">
    <h1>Connection Settings</h1>
    
    <form method="POST" action="">
        <input type="hidden" name="action" value="set">
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="options[url]">Url</label>
                </th>
                <td>
                    <input 
                        name="options[url]"
                        type="text" 
                        value="<?= $url ?>" 
                        class="large-text"
                    />
                </td>                  
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="options[login]">Login</label>
                </th>
                <td>
                    <input 
                        name="options[login]" 
                        type="text" 
                        value="<?= $login ?>" 
                        class="regular-text"
                    />
                </td>                  
            </tr>
            
                            <tr>
                <th scope="row">
                    <label for="options[password]">Password</label>
                </th>
                <td>
                    <input 
                        name="options[password]" 
                        type="text" 
                        value="<?= $password ?>" 
                        class="regular-text"
                    />
                </td>                  
            </tr>
        </table>
        
        <input type="submit" class="button-primary" value="Save Changes">
    </form>
</div>
