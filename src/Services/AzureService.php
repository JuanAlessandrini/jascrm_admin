<?php 
namespace App\Services;
use App\Entity\PersonId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Psr\Log\LoggerInterface;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper;
use MicrosoftAzure\Storage\Common\ServiceException;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\EntityManagerInterface;


class AzureService extends AbstractController{
    private $azure_key_storage;
    private $azure_key_cognitive;
    private $azureConectionString;
    private $azure_account_name;
    private $em;
    public $uriBase = 'https://jas-docs-cognitive.cognitiveservices.azure.com/vision/v3.2/read/'; //'https://westcentralus.api.cognitive.microsoft.com/vision/v3.1/';
    public $uriBaseFace = 'https://jas-docs-cognitive.cognitiveservices.azure.com/face/v1.0/'; 
    public $uriBaseOcr = 'https://jas-docs-cognitive.cognitiveservices.azure.com/vision/v2.0/'; 
    private $blobClient;
    // private $logger;
    private $client;
    private $private_folder = "private";

    public function __construct(EntityManagerInterface $em){
        // $this->logger = $logger;
        $this->azure_key_storage = $_ENV['AZURE_KEY_STORAGE'];
        $this->azure_key_cognitive = $_ENV['AZURE_KEY_COGNITIVE'];
        $this->azure_account_name = $_ENV['AZURE_STORAGE_ACCOUNT'];;
        $this->azureConectionString = "DefaultEndpointsProtocol=https;AccountName=".$this->azure_account_name.";AccountKey=".$this->azure_key_storage.";EndpointSuffix=core.windows.net";
        $this->blobClient = BlobRestProxy::createBlobService($this->azureConectionString);
        $this->client = new NativeHttpClient();
        $this->em = $em;
    }
    public function allContainers()
    {
        try {
            $container_list = $this->blobClient->listContainers();
            return $container_list->getContainers();

        } catch (ServiceException $exception) {
            // $this->logger->error('failed to get all containers: ' . $exception->getCode() . ':' . $exception->getMessage());
            throw $exception;
        }
    }

    public function allBlobs()
    {
        try {
            $result = $this->blobClient->listBlobs($this->private_folder);
            return $result->getBlobs();

        } catch (ServiceException $exception) {
            // $this->logger->error('failed to get all blobs: ' . $exception->getCode() . ':' . $exception->getMessage());
            throw $exception;
        }
    }

    public function uploadToBlobStorage($file, $fileName)
    {
        try {

            $content = file_get_contents($file);
            $this->blobClient->createBlockBlob($this->private_folder, $fileName, $content);

        } catch (ServiceException $exception) {
            // $this->logger->error('failed to upload the file: ' . $exception->getCode() . ':' . $exception->getMessage());
            throw $exception;
        }
    }

    public function delete($blobName)
    {
        try {
            $this->blobClient->deleteBlob($this->private_folder, $blobName);
        } catch (ServiceException $exception) {
            // $this->logger->error('failed to delete the file: ' . $exception->getCode() . ':' . $exception->getMessage());
            throw $exception;
        }
    }

    public function getFile($fileToUpload){
        $blob = $this->blobClient->getBlob($this->private_folder, $fileToUpload);
        return $blob->getContentStream();
    }
    public function getFileUrl($fileToUpload){
        
        $sasHelper = new BlobSharedAccessSignatureHelper($this->azure_account_name, $this->azure_key_storage);
        
        $sasUrl = $sasHelper->generateBlobServiceSharedAccessSignatureToken(
            'b',//$signedResource
            $this->private_folder.'/'.$fileToUpload,//$resourceName
            'r',//$signedPermissions
            date_format(new \DateTime('tomorrow'),'Y-m-d'), //$signedExpiry
            "", //$signedStart
            "", //$signedIP
            "https", //$signedProtocol
            "", // $signedIdentifier
            "", //$cacheControl
             "rscd",//$contentDisposition =
             "rsce",//$contentEncoding =
             "",//$contentLanguage =
             "rsct"//$contentType =
        );
    
        
        return "https://".$this->azure_account_name.".blob.core.windows.net/".$this->private_folder."/".$fileToUpload."?".$sasUrl;
    }

   
    public function getComputerVisionReadLink($fileName){
        $headers = Array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
        );
        $parameters = Array(
            'language' => 'es',
            'detectOrientation' => 'true',
            'readingOrder'=>'natural'
        );
        $method="POST";
        $file = "https://".$this->azure_account_name.".blob.core.windows.net/private/".$fileName."?".$_ENV["AZURE_TOKEN_STORAGE"];

        $request = $this->client->request(
            $method, 
            $this->uriBase.'analyze',
            [
                 
                'body'=> json_encode(Array("url"=>$file))
                ,
                'headers'=>$headers, 
                'query'=>$parameters,
                'extra' => [
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                    ],
                ],
            ]);
        if($request->getStatusCode()==202){
            $result = $request->getHeaders();
            $rta['status']='201';
            $rta['response']=$result['operation-location'][0];
        }else{
            
            $rta['status']=$request->getStatusCode();
            $rta['response']='';
            throw new Exception('Status Azure: '.$rta['status'].' en imagen '.$fileName." using link: ".$file);
        }
        return $rta;
    }

    public function getComputerVisionReadResults($link){
        $headers = Array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
        );
        $parameters = Array(
            'language' => 'es',
            'detectOrientation' => 'true'
        );
        $method="GET";
        
        $request = $this->client->request(
            $method, 
            $link,
            [
                 
                'body'=> []
                ,
                'headers'=>$headers, 
                'query'=>$parameters,
                'extra' => [
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                    ],
                ],
            ]);
        if($request->getStatusCode()==200){
            $result = $request->getContent();
            $rta['status']='200';
            if($result){
                $rta['response']= $this->processReadResults($result);
                $rta['meta']= ($result);
            }else{
                $rta['response']="";
            }
        }else{
            
            $rta['status']=$request->getStatusCode();
            $rta['response']='';
            throw new Exception('Status Azure: '.$rta['status'].' en '.$link);
        }
        return $rta;
    }

    private function processReadResults($input){
        $texto = "";
        $entrada = json_decode($input, true);
        if(array_key_exists('analyzeResult',$entrada)){
            $resultados = $entrada['analyzeResult']['readResults'];
            foreach ($resultados as $pagina) {
                $lineas = $pagina['lines'];
                foreach ($lineas as $linea) {
                    $texto .= $linea['text'].' ';
                }
            }
        }
        return $texto;
    }

    public function getOcrDetection($fileName){
        $headers = Array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
        );
        $parameters = Array(
            'language' => 'es' ,
            'detectOrientation' => 'true',
        );
        $method="POST";
        $file = $fileName;

        $request = $this->client->request(
            $method, 
            $this->uriBaseOcr.'ocr',
            [
                 
                'body'=> json_encode(Array("url"=>$file))
                ,
                'headers'=>$headers, 
                'query'=>$parameters,
                'extra' => [
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                    ],
                ],
            ]);
        if($request->getStatusCode()==200){
            $result = $request->getContent();
            $rta['status']='200';
            $rta['result']=json_decode($result, true);
        }else{
            
            $rta['status']=$request->getStatusCode();
            
            throw new Exception('Status Azure: '.$request->getStatusCode());
        }
        return $rta;
    }

    public function getComputerVisionFaceDetection($fileName, Bool $faceAttributes){
        $headers = Array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
        );
        $parameters = Array(
            'detectionModel' => 'detection_01' ,
            'returnFaceId' => 'true',
            'recognitionModel'=>'recognition_04',
            'returnFaceLandmarks'=>'true',
            'returnFaceAttributes'=>$faceAttributes ? 'age, gender, headPose, smile, facialHair, glasses, emotion, hair, makeup, occlusion, accessories, blur, exposure, noise, mask' : ''

        );
        $method="POST";
        $file = $fileName;

        $request = $this->client->request(
            $method, 
            $this->uriBaseFace.'detect',
            [
                 
                'body'=> json_encode(Array("url"=>$file))
                ,
                'headers'=>$headers, 
                'query'=>$parameters,
                'extra' => [
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                    ],
                ],
            ]);
        if($request->getStatusCode()==200){
            $result = $request->getContent();
            $rta['status']='200';
            $rta['result']=json_decode($result, true);
        }else{
            throw new Exception('Status Azure: '.$request->getStatusCode());
        }
        return $rta;
    }


    function persistPersonFace($upload){
        $groupPerson = "personas";
            
        if($upload->getUploadsEntities()->getCode() == null){
            $personId = $this->createPersonGroupPerson($groupPerson, $upload->getUploadsEntities()->getEntityDescription());
            $personIdEntity = new PersonId();
            $personIdEntity->setCode($personId);
            $personIdEntity->setUploadEntity($upload->getUploadsEntities());
            $this->em->persist($personIdEntity);
            $this->em->flush();
        }else{
            $personId = $upload->getUploadsEntities()->getCode()->getCode();
        }
          
            if($personId!=="0"){
                $output2 = "";
                $sasUrl = $this->getFileUrl($upload->getImageUrl());
                $response = $this->addPersonGroupFace($groupPerson, $sasUrl, $personId, $output2);
                
                  $mensajes = array(
                    '200'=>'ok',
                    '400' => $output2,
                    '401'=> 'Access denied due to invalid subscription key. Make sure you are subscribed to an API you are trying to call and provide the right key.',
                    '403' => 'Persisted face number reached limit.',
                    '404'=> 'Person group is not found.',
                    '408' => 'Request Timeout.',
                    '409'=> 'Person group is under training.',
                    '415' => 'Invalid Media Type.',
                    '429' => 'Rate limit is exceeded. Try again in 26 seconds.'
                  );
                  
                  return Array(
                      'status'=>$response['status'],
                      'response'=>$mensajes[$response['status']],
                      'personId'=>$personId
                  );
                
            }else{
                return Array(
                    'status'=>"450",
                    'response'=>"No se pudo crear el la persona dentro del grupo de personas"
                );
            }
          
          
        }
        
        
        
        ///////////////    PERSON GROUP     ////////////////////////
        
        function getPersonGroup($personGroupId){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $personGroupId
              );
            
            $method="GET";
            $file = $this->getFileUrl($fileName);

            $request = $this->client->request(
                $method, 
                $this->uriBaseFace.'persongroups/'.$personGroupId,
                [
                     
                    'body'=> json_encode(Array())
                    ,
                    'headers'=>$headers, 
                    'query'=>$parameters,
                    'extra' => [
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                        ],
                    ],
                ]);
        
                
                try
                {
                    if($request->getStatusCode()==200){
                        return $request->getContent();
                    }else{
                        return [];
                    }
                }
                catch (HttpException $ex)
                {
                    return json_encode($ex);
                }
        }
        
        //Crear grupo de personas (carpeta privada)
        function createPersonGroup($personGroupId, $personGroupName){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $personGroupId
              );
            
            $method="PUT";

            $request = $this->client->request(
                $method, 
                $this->uriBaseFace.'persongroups/'.$personGroupId,
                [
                     
                    'body'=> json_encode(Array('name' => $personGroupName))
                    ,
                    'headers'=>$headers, 
                    'query'=>$parameters,
                    'extra' => [
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                        ],
                    ],
                ]);
          
        
                try
                {
                    return $request->getStatusCode();
                }
                catch (HttpException $ex)
                {
                    return $ex;
                }
        }
        
        
        
        ///////////////    PERSON GROUP PERSON   /////////////////////
        
        function getPersonGroupPerson($personGroupId, $personId){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $personGroupId,
                  'personId' => $personId
              );
            
            $method="GET";

            $request = $this->client->request(
                $method, 
                $this->uriBaseFace.'persongroups/'.$personGroupId.'/persons/'.$personId,
                [
                     
                    'body'=> json_encode(Array())
                    ,
                    'headers'=>$headers, 
                    'query'=>$parameters,
                    'extra' => [
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                        ],
                    ],
                ]);

        
                try
                {
                    if($request->getStatusCode()==200){
                      return true;
                    }else{
                      return false;
                    }
                }
                catch (HttpException $ex)
                {
                    return json_encode($ex);
                }
        }
        
        //crear Persona en un grupo de personas
        function createPersonGroupPerson($groupPersonId, $name){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $groupPersonId,
              );
            
            $method="POST";

            $request = $this->client->request(
                $method, 
                $this->uriBaseFace.'persongroups/'.$groupPersonId.'/persons',
                [
                     
                    'body'=> json_encode(Array(
                        "name" => $name,
                        "userData" => 'datos de Persona'
                    ))
                    ,
                    'headers'=>$headers, 
                    'query'=>$parameters,
                    'extra' => [
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                        ],
                    ],
                ]);

        
                
        
                try
                {
                    
                    if($request->getStatusCode()==200){
                      $resultado = json_decode($request->getContent());
                      return $resultado->personId;
                    }else{
                      return "0";
                    }
                }
                catch (HttpException $ex)
                {
                    return json_encode($ex);
                }
        }
        
        function deletePersonGroupPerson($groupPersonId, $personId){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $groupPersonId,
                'personId' => $personId
              );
            
            $method="DELETE";

            $request = $this->client->request(
                $method, 
                $this->uriBaseFace.'persongroups/'.$groupPersonId.'/persons/'.$personId,
                [
                     
                    'body'=> json_encode(Array())
                    ,
                    'headers'=>$headers, 
                    'query'=>$parameters,
                    'extra' => [
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                        ],
                    ],
                ]);
          
        
                try
                {
                    
                    if($request->getStatusCode()==200){
                      return true;
                    }else{
                      return false;
                    }
                }
                catch (HttpException $ex)
                {
                    return json_encode($ex);
                }
        }
        
        //////////////////  PERSON GROUP PERSON : FACE  ////////////
        
        //Agregar Cara a Persona dentro de un grupo de personas
        function addPersonGroupFace($personGroupId, $fileName, $personId, &$output){
            $headers = Array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
            );
            $parameters = array(
                'personGroupId' => $personGroupId,
                  'personId'=> $personId,
                  'detectionModel'=>'detection_01'
                //   'targetFace'=> $targetFace,
              );
            
            $method="POST";
            //   echo $fileName;
            //   exit;
              try
                {
                    $request = $this->client->request(
                        $method, 
                        $this->uriBaseFace.'persongroups/'.$personGroupId.'/persons/'.$personId.'/persistedFaces',
                        [
                            
                            'body'=> json_encode(Array(
                                'url' => $fileName
                            ))
                            ,
                            'headers'=>$headers, 
                            'query'=>$parameters,
                            'extra' => [
                                'curl' => [
                                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                                ],
                            ],
                        ]);

        
                    if($request->getStatusCode()!==200){
                      $resultado = json_decode($request->getContent());
                      $output = $resultado->error->message;
                    }else{
                      $output = "";
                    }
                    return Array(
                        'status'=>$request->getStatusCode(),
                        'message'=>$output
                    );
                      //
                }
                catch (HttpException $ex){
                  return false;
                }
        }
        
//////////////////  FACE DETECTION ////////////////////////

function getIdentifyInfoFromFace($nameFile){
    $headers = Array(
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
    );
    $parameters = array(
      );
    
    $method="POST";

    $request = $this->client->request(
        $method, 
        $this->uriBaseFace.'identify',
        [
             
            'body'=> json_encode(Array(
                'url' => $nameFile
            ))
            ,
            'headers'=>$headers, 
            'query'=>$parameters,
            'extra' => [
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                ],
            ],
        ]);
    
    
    
          try
          {
              
              return json_encode(json_decode($request->getContent()), JSON_PRETTY_PRINT);
                //
          }
          catch (HttpException $ex)
          {
              return "<pre>" . $ex . "</pre>";
          }
    
    }
    function getIndentifyFace($faceIdToIdentify, $personGroupId){
        $headers = Array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
        );
        $parameters = array(
            'detectionModel' => 'detection_01' ,
            'recognitionModel'=>'recognition_04',
            );
        
        $method="POST";
    
        $request = $this->client->request(
            $method, 
            $this->uriBaseFace.'identify',
            [
                    
                'body'=> json_encode(Array(
                    'faceIds' => array($faceIdToIdentify),
                    'personGroupId' => $personGroupId,
                    'maxNumOfCandidatesReturned' => 1,
                    'confidenceThreshold' => 0.5
                ))
                ,
                'headers'=>$headers, 
                'query'=>$parameters,
                'extra' => [
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                    ],
                ],
            ]);

      
      
      try
      {
          
          if($request->getStatusCode()==200){
            $resultado = json_decode($request->getContent());
            $candidatos = $resultado[0]->candidates;
            if(sizeof($candidatos)>0){
              return $candidatos[0]->personId;
            }else{
              return "";
            }
          }else{
            return "";
          }
            //
      }
      catch (HttpException $ex)
      {
          return "";
      }

}
//////////////    TRINING MODEL  /////////////////

function getReadyTrainingStatus($personGroupId, $takeActions){
    $headers = Array(
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
    );
    $parameters = array(
        'personGroupId' => $personGroupId
        );
    
    $method="GET";

    $request = $this->client->request(
        $method, 
        $this->uriBaseFace.'persongroups/'.$personGroupId.'/training',
        [
                
            'body'=> json_encode(Array(
                
            ))
            ,
            'headers'=>$headers, 
            'query'=>$parameters,
            'extra' => [
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                ],
            ],
        ]);

       
        try
        {
           
            $rta= $request->getStatusCode();
            if($request->getStatusCode()==200){
              $resultado = json_decode($request->getContent());
              if($resultado->status=="running"){
                return false;
              }else{
                switch($resultado->status){
                  case "succeeded":

                    $timeWindow= "15"; //minutes
                    $fechaActual = date('Y-m-d H:i:s');
                    $fechaActual=strtotime('+3 hour', strtotime($fechaActual));
                    $fechaActual=strtotime('-'.$timeWindow.' minute', $fechaActual);
                    $formato = 'Y-m-d H:i:s';
                    $fechaUltimo = strtotime(str_replace("T", " ", substr($resultado->lastActionDateTime,1,19)));


                    if($fechaActual > $fechaUltimo){
                      if($takeActions==true){
                      $this->trainPersonGroup($personGroupId);}
                      return false;
                    }else{
                      
                        return true;
                    }

                    return false;
                    break;
                  case "notstarted":
                    
                    if($takeActions==true){
                    $this->trainPersonGroup($personGroupId);}
                    return false;
                    break;
                  default:
                    return false;
                    break;
                }

              }
            }else{
              if($rta==404){
                
                if($takeActions){
                $this->trainPersonGroup($personGroupId);}
                return false;
              }else{
                $output="Error";
                return false;
              }

            }
        }
        catch (HttpException $ex)
        {
            return json_encode($ex);
        }
}

function trainPersonGroup($personGroupId){
    $headers = Array(
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => $this->azure_key_cognitive
    );
    $parameters = array(
        'personGroupId' => $personGroupId
    );
    
    $method="POST";

    $request = $this->client->request(
        $method, 
        $this->uriBaseFace.'persongroups/'.$personGroupId.'/train',
        [
                
            'body'=> json_encode(Array(
            ))
            ,
            'headers'=>$headers, 
            'query'=>$parameters,
            'extra' => [
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                ],
            ],
        ]);

       
        try
        {
           
            if($request->getStatusCode()==202){
                return true;
            }else{
              return false;
            }
        }catch (HttpException $ex){
            return json_encode($ex);
        }
    }

}
?>