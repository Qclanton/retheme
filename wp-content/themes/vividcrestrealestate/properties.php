<h1>Properties</h1>
<form name="search-properties" action="/properties" method="POST">
    Address: <input type="text" name="search[address]">
    
    <input type="submit" value="search">   
</form>
<pre><?php var_dump($properties); ?></pre>
