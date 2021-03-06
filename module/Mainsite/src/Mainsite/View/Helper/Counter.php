<?php
namespace Mainsite\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays breadcrumbs.
 */
class Counter extends AbstractHelper 
{
    /**
     * Array of items.
     * @var array 
     */
    private $items = [];
    
    /**
     * Constructor.
     * @param array $items Array of items (optional).
     */
    public function __construct($items=[]) 
    {                
        $this->items = $items;
    }
    
    /**
     * Sets the items.
     * @param array $items Items.
     */
    public function setItems($items) 
    {
        $this->items = $items;
    }
    
    /**
     * Renders the breadcrumbs.
     * @return string HTML code of the breadcrumbs.
     */
    public function render() 
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.
        
        // Resulting HTML code will be stored in this var
        $result = '<b>';
        
        // Get item count
        $itemCount = count($this->items); 
        
        $itemNum = 1; // item counter
        
        // Walk through items
        foreach ($this->items as $label=>$link) {
            
            // Make the last item inactive
            $isActive = ($itemNum==$itemCount?true:false);
                        
            // Render current item
            $result .= $this->renderItem($label, $link, $isActive);
                        
            // Increment item counter
            $itemNum++;
        }
        
        $result .= '</b>';
        
        return $result;
        
    }
    
}    
