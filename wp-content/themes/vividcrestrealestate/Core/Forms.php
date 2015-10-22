<?php
namespace Vividcrestrealestate\Core;

class Forms 
{   
    private static function sanitizeOne($element)
    {
        return wp_filter_nohtml_kses($element);
    }
    
    public static function sanitize($data)
    {           
        if (is_array($data)) {
            $sanitized = [];
            
            foreach ($data as $key=>$element) {
                $sanitized[$key] = (is_object($element) || is_array($element) 
                    ? self::sanitize($element) 
                    : self::sanitizeOne($element)
                );
            }
        } elseif (is_object($data)) {
            foreach ($data as &$element) {
                $element = (is_object($element) || is_array($element) 
                    ? self::sanitize($element) 
                    : self::sanitizeOne($element)
                );
            }
            
            $sanitized = $data;
        } else {
            $sanitized = self::sanitizeOne($data);
        }
        
        
        return $sanitized;
    }
    
    public static function sendToAdmin(array $data)
    {
        // Activate possibility to use HTML in letter
        add_filter("wp_mail_content_type", function() { 
            return "text/html";
        });
                
        
        // Define properties
        $data = self::sanitize($data);
        $site = get_option("blogname");
        $name = "System Message";
        $from = get_option("admin_email");
        $to = get_option("admin_email");
                
        
        // Create text
        $subject = "Customer used form on the site \"{$site}\"";
        $message = Template::renderPart("email/form", ['site'=>$site, 'data'=>$data]);


        // Create headers
        $headers[] = "From: {$name} <{$from}>";


        // Send mail
        $result = wp_mail($to, $subject, $message, $headers);


        // Set default settings to other functions
        remove_filter("wp_mail_content_type", function() { 
            return "text/html";
        });
        
        
        // Return sending result
        return $result;
    }
}
