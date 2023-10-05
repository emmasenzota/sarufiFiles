<?php
namespace App\Controllers;

//Use this class to train your chatbot 
use Config\Sarufi as confSarufi;
use Alphaolomi\Sarufi\Sarufi as Sarufi;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

const PUBLICPATH ='../public/';

class Training extends Controller{
    use ResponseTrait;

    // define some constant variables here 
    protected $Sarufi;
    public    $request;
    public    $Client;


    // Replace Training array to JSON file 

    // initialise class during call 
    public function __construct()
    {
        $this->Sarufi = new Sarufi(confSarufi::$apiKey);
        $this->request = \Config\Services::request();
        
    }

    public function trainWithArray(array $array) {
        // check for empty array and send error/ exception 
        if(empty($array)){
            return $this->respond(['error' => 'Training araay is empty']);
        }
        else{
            $updates = $this->Sarufi->updateBot(confSarufi::$botId,'YaKwetu','Culture',$array['desc'],$array['intents'],$array['flow'],true);

            // after training with our array we terminate this method by notifying our front end 
            return $this->respond($updates);
        }
    }
    /**
     * @method trainWithFile()
     * 
     * @return Array | String
     */
    public function trainWithFile(string $intentFile, string $flowFile, string $metadataFile) {
        try {
            $result = $this->Sarufi->updateFromFile(confSarufi::$botId ,$intentFile ,$flowFile ,$metadataFile,);

            // on succes 
            return $result;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index() {
        // load in the files 
        $metadata = PUBLICPATH . 'metadata.json';
        $flow = PUBLICPATH . 'flow.json';
        $intent = PUBLICPATH . 'intent.json';

        $from_training = $this->trainWithFile($intent,$flow,$metadata);
        return $this->respond($from_training);
    }

}