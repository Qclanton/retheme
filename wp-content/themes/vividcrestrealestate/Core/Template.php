<?php
namespace Vividcrestrealestate\Core;

class Template 
{   
    public static function renderPart($view, $vars=[])
    {
        // Define template file and check existance
        $file = get_template_directory() . "/{$view}.php";
        
        if (!file_exists($file)) {
            return false;
        }
        
        
        
        // Extract vars
        extract((array)$vars);
        
        

        // Load template part
        ob_start();        
        require $file;
        $content = ob_get_contents();
        ob_end_clean();
        
        
        
        // Return rendered content
        return $content;
    }
    
    
    // Breadcrumbs
    public static function getBreadcrumbs() {
        global $wp_query;
        $crumbs = [];

        if (!is_front_page()) {
            $crumbs[] = (object)['title'=>"Home", 'link'=>home_url()];
            
            // For category
            if (is_category()) {
                $category = get_category_by_slug($wp_query->query['category_name']);
                $parent_categories = get_parent_categories($category);
                
                if (!empty($parent_categories)) {
                    $parent_category = $parent_categories[0];
                    $crumbs[] = (object)['title'=>$parent_category->name, 'link'=>home_url("/") . $parent_category->slug];
                }
                
                $crumbs[] = (object)['title'=>$category->name];
             
            
            // For detailed properties
            } elseif (isset($wp_query->query_vars['property_id'])) {
                $crumbs[] = [
                    (object)['title'=>"Properties", 'link'=>"/properties"],
                    (object)['title'=>"Map", 'link'=>"/map"]
                ];
                
                $propety = (new Structures\Properties())->getDetailed($wp_query->query_vars['property_id']);
                $crumbs[] = (object)['title'=>$propety->address];
                
                
            // For post and pages
            } elseif (!empty($wp_query->queried_object)) {
                $post = $wp_query->queried_object;
                $post_categories = wp_get_post_categories($wp_query->queried_object_id);
                $parent_post_id = $wp_query->queried_object->post_parent;
                
                if (!empty($post_categories)) {
                    $post_main_category = get_category($post_categories[0]);
                    $parent_categories = get_parent_categories($post_main_category);

                    if (!empty($parent_categories)) {
                        $parent_category = $parent_categories[0];
                        $crumbs[] = (object)['title'=>$parent_category->name, 'link'=>home_url("/") . $parent_category->slug];
                    }

                    $crumbs[] = (object)['title'=>$post_main_category->name, 'link'=>home_url("/") . $post_main_category->slug];
                }
                
                if (!empty($parent_post_id)) {
                    $parent_post = get_post($parent_post_id);
                    $crumbs[] = (object)['title'=>$parent_post->post_title, 'link'=>get_permalink($parent_post->ID)];
                }

                $crumbs[] = (object)['title'=>$post->post_title];
                
            
            // For search
            } elseif (isset($wp_query->query_vars['s'])) {
                $crumbs[] = (object)['title'=>"Search Results"];
            }
        }

        return $crumbs;
    }

    public static function renderBreadcrumbs() {
        $breadcrumbs = self::getBreadcrumbs();
        
        if (empty($breadcrumbs)) {
            return false;
        }

        
        
        $html = "<ul>";

        foreach ($breadcrumbs as $i=>$breadcrumb) {
            $parts = (is_array($breadcrumb) ? $breadcrumb : [$breadcrumb]);
            $first = array_shift($parts);      
            $parts_html = "";
            
            if (!empty($parts)) {      
                foreach ($parts as $i=>$part) {                    
                    $parts_html .= (empty($part->link)
                        ? "/{$part->title}"
                        : "/<a href='{$part->link}'>{$part->title}</a>"
                    );
                }
            } 
            
            $html .= (empty($first->link)
                ? "<li>{$first->title}{$parts_html}</li>"
                : "<li><a href='{$first->link}'>{$first->title}</a>{$parts_html}</li>"
            ); 
        }
        
        $html .= "</ul>";



        return $html;
    }
}
