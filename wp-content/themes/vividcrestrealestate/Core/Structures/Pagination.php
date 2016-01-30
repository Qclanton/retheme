<?php
namespace Vividcrestrealestate\Core\Structures;

class Pagination 
{
    public $per_page;
    public $sort;
    public $orderby;
    public $order;
    public $current;
    public $previous;
    public $next;
    public $total;
    public $total_pages;
    public $first_shown;
    public $last_shown;
    
    
    
    public static function getAllowedSorts()
    {
        return [
            "publish_date|DESC",
            "publish_date|ASC",
            "price|DESC",
            "price|ASC"
        ];
    }
    
    
    
    public function __construct($total=0)
    {
        $per_page = (int)(isset($_GET['per_page']) ? $_GET['per_page'] : 8);
        $current = (int)(isset($_GET['current']) ? $_GET['current'] : 1);
        $sort = (isset($_GET['sort']) && in_array($_GET['sort'], $this->getAllowedSorts()) ? $_GET['sort'] : "publish_date|DESC");
        list($orderby, $order) = explode("|", $sort);
        
        
        $this->per_page = $per_page;
        $this->sort = $sort;
        $this->sort_encoded = urlencode($sort);
        $this->orderby = $orderby;
        $this->order = $order;
        $this->current = $current;
        $this->previous = $current-1;
        $this->next = $current+1;
        $this->total = $total;
        $this->total_pages = ceil($total/$per_page);
        $this->first_shown = (($current-1)*$per_page)+1;
        $this->last_shown = $current*$per_page;
    }
}
