<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Sarufi as Sarufi;

// use sarifi library 
use Alphaolomi\Sarufi\Sarufi as AlphaSarufi;
use CodeIgniter\API\ResponseTrait;
use GuzzleHttp\Client;

class Chat extends Controller
{  
    use ResponseTrait;

     // some variables 
    public $gClient;
    protected $request;
    protected $responce;

    function __construct()
    {
        $this->request = \Config\Services::request();
    }


    public function index()
    {
        
            return view('chat_view');
      
    }

    public function chatWithBot() {
        
        // calling Guzzlehttp 
        $this->gClient = new Client();
        
        $query = (String) json_decode(file_get_contents("php://input"));

         $userQuery = empty($query) ? "Hi " : $query ;

        $sarufi = new AlphaSarufi(Sarufi::$apiKey);
        $response = $sarufi->chat(Sarufi::$botId,'123',$userQuery,'text','general');

        return $this->respond($response);
    }
     
    public function chatWithBotCli($qn) {
        // initiallising GuzzlehttpClient
        $this->gClient = new Client();

        //check for parameter passed if is empty 
        $query = empty($qn) ? "mambo vipi" : $qn;

        // authentication 
        $sarufi = new AlphaSarufi(Sarufi::$apiKey);

        //conversation with the chatbot
        $responce = $sarufi->chat(Sarufi::$botId, '322', $query, 'text', 'general');

        // respond to the request 
        return $this->respond($responce);
    }
}
