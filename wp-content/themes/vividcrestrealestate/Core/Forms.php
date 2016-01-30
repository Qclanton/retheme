<?php
namespace Vividcrestrealestate\Core;

use Mailgun\Mailgun;

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
        // Define properties
        $data = self::sanitize($data);
        $site = get_option("blogname");
        $from = "System Message <" . get_option("admin_email") . ">";
        $to = get_option("admin_email");
                
        
        // Create text
        $subject = "Customer used form on the site \"{$site}\"";
        $message = Template::renderPart("email/form", ['site'=>$site, 'data'=>$data]);

        
        // Send mail        
        $Mailgun = new Mailgun(get_option("mailgun_key"));
        $result = $Mailgun->sendMessage(
            get_option("mailgun_domain"),
            [
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'html' => $message
            ]
        );
        
        
        // Return sending result
        return $result;
    }
}
