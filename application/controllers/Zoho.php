<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zoho extends CI_Controller {

    public function callback()
    {
        // Get authorization code from Zoho
        $code = $this->input->get('code');

        if (!$code) {
            echo "Authorization code not received";
            return;
        }

        echo "Authorization Code:<br>";
        echo $code;

        // IMPORTANT: Copy this code and use it to generate tokens
    }

    public function generate()
    {
        // Paste the authorization code you got from the browser here
        $code = '1000.cab2b37c02ff9ed213ef6e11e46f5dcf.b73f2b09051a27f077314e11d737cd68';

        $ch = curl_init('https://accounts.zoho.com/oauth/v2/token');

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'authorization_code',
                'client_id' => '1000.PEC8F0LPABZK3HUPIGVJ90I4IRH9TM',
                'client_secret' => '022191dff0595fe4e311870b06b8ffcc1bbbe8314d',
                'redirect_uri' => 'https://crm.voltronix.ae/crm/pm/index.php/zoho/callback',
                'code' => $code
            ]),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        echo "<pre>";
        print_r($response);  // THIS WILL SHOW ACCESS + REFRESH TOKEN
        echo "</pre>";
    }

   
}
