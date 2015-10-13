<form class="search_form-main search_form search_form--small" name="search-properties" action="/properties" method="POST">
    <h2>Search Form</h2>
    <div class="universal_line-wrapper">
        <input 
            type="text" 
            placeholder="City, Postal Code, Neighborhood or District" 
            name="search_property[address]" 
            value="<?= isset($search->address) ? $search->address : "" ?>"
        >
    </div>
    <div class="universal_line-wrapper">
        <div class="universal_cell-wrapper">
            <select name="search_property[bathrooms]">
                <option value="0" <?= empty($search->bathrooms) ? "selected='selected'" : "" ?>>Bathrooms</option>
                <option value="1" <?= isset($search->bathrooms) && $search->bathrooms == 1 ? "selected='selected'" : "" ?>>1+ baths</option>
                <option value="2" <?= isset($search->bathrooms) && $search->bathrooms == 2 ? "selected='selected'" : "" ?>>2+ baths</option>
                <option value="3" <?= isset($search->bathrooms) && $search->bathrooms == 3 ? "selected='selected'" : "" ?>>3+ baths</option>
                <option value="4" <?= isset($search->bathrooms) && $search->bathrooms == 4 ? "selected='selected'" : "" ?>>4+ baths</option>
                <option value="5" <?= isset($search->bathrooms) && $search->bathrooms == 5 ? "selected='selected'" : "" ?>>5+ baths</option>
                <option value="6" <?= isset($search->bathrooms) && $search->bathrooms == 6 ? "selected='selected'" : "" ?>>6+ baths</option>
            </select>
        </div>
        <div class="universal_cell-wrapper">
            <select name="search_property[bedrooms]">
                <option value="0" <?= empty($search->bedrooms) ? "selected='selected'" : "" ?>>Bedrooms</option>
                <option value="1" <?= isset($search->bedrooms) && $search->bedrooms == 1 ? "selected='selected'" : "" ?>>1+ beds</option>
                <option value="2" <?= isset($search->bedrooms) && $search->bedrooms == 2 ? "selected='selected'" : "" ?>>2+ beds</option>
                <option value="3" <?= isset($search->bedrooms) && $search->bedrooms == 3 ? "selected='selected'" : "" ?>>3+ beds</option>
                <option value="4" <?= isset($search->bedrooms) && $search->bedrooms == 4 ? "selected='selected'" : "" ?>>4+ beds</option>
                <option value="5" <?= isset($search->bedrooms) && $search->bedrooms == 5 ? "selected='selected'" : "" ?>>5+ beds</option>
                <option value="6" <?= isset($search->bedrooms) && $search->bedrooms == 6 ? "selected='selected'" : "" ?>>6+ beds</option>
            </select>
        </div>
    </div>
    <div class="universal_line-wrapper">
        <div class="universal_cell-wrapper">
            <input 
                type="number" 
                name="search_property[min_price]" 
                placeholder="Min Price"
                value="<?= isset($search->min_price) ? $search->min_price : "" ?>"
            >
        </div>
        <div class="universal_cell-wrapper">
            <input 
                type="number" 
                name="search_property[max_price]" 
                placeholder="Max Price"
                value="<?= isset($search->max_price) ? $search->max_price : "" ?>"
            >
        </div>
    </div>
    <div class="universal_line-wrapper">
        <select name="search_property[types][]" multiple>
            <option value="0" <?= empty($search->types) ? "selected='selected'" : "" ?>>Property Type</option>
            <option value="House" <?= isset($search->types) && in_array("House", $search->types) ? "selected='selected'" : "" ?>>House</option>
            <option value="Condo" <?= isset($search->types) && in_array("Condo", $search->types) ? "selected='selected'" : "" ?>>Condo</option>
        </select>
    </div>	
    <div class="universal_line-wrapper">
        <select name="search_property[deal_type]">
            <option value="0" <?= empty($search->deal_type) ? "selected='selected'" : "" ?>>Deal Type</option>
            <option value="buy" <?= isset($search->deal_type) && $search->deal_type == "buy" ? "selected='selected'" : "" ?>>Buy</option>
            <option value="rent" <?= isset($search->deal_type) && $search->deal_type == "rent" ? "selected='selected'" : "" ?>>Rent</option>
        </select>
    </div>	
    <div class="universal_line-wrapper">
        <input class="universal-button" type="submit" value="Search" name="submit">
    </div>
</form>
