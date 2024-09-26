<?php
use Ramsey\Uuid\Uuid;
use Illuminate\Http\UploadedFile;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

function upload_to_cloudinary($uploadedFile, $image_name, $folder, $resource_type){
    $cloudinary_cloud_name = env('CLOUDINARY_CLOUD_NAME');
    $cloudinary_api_key = env('CLOUDINARY_API_KEY');
    $cloudinary_api_secret = env('CLOUDINARY_API_SECRET');
    $folder = str_replace("%2F","/", $folder);


    $cloudinary = new Cloudinary(
        [
            'cloud' => [
                'cloud_name' => $cloudinary_cloud_name,
                'api_key'    => $cloudinary_api_key,
                'api_secret' => $cloudinary_api_secret,
                'resource_type'=> $resource_type,
            ],
        ]
    );


    $uuid =  generateUUID();
    $result = $cloudinary->uploadApi()->upload(
                  $uploadedFile->getRealPath(),
                  ['public_id' => $uuid, 'folder'=>$folder]
              );


         return $result['secure_url'];

 }


function generateUUID(){
    return Uuid::uuid4();
 }

 function validateUUID($data, $field, $required=true){
    $validations = 'required|string|min:36|max:36';
    $validation_check = [
        $field.'.required' => 'Please provide '.$field,
         $field.'.string' => $field.' should be uuid',
        $field.'.min' => $field.' should be a valid uuid',
        $field.'.max' => $field.' should be a valid uuid',
    ];
    if(!$required){
        $validations = 'string|min:36|max:36';
        $validation_check = [
             $field.'.string' => $field.' should be uuid',
            $field.'.min' => $field.' should be a valid uuid',
            $field.'.max' => $field.' should be a valid uuid',
        ];
    }


    $validator = Validator::make($data, [
        $field => $validations,
    ], $validation_check);

    if ($validator->fails()) {
        return $validator->errors();
    }else{
        return true;
    }
 }

 function validateArrayType($data, $field, $required=true){

    $validations = 'required|array';
    $validation_check = [
        $field.'.required' => 'Please provide '.$field,
         $field.'.array' => $field.' should be an array',
    ];
    if(!$required){
        $validations = 'array';
        $validation_check = [
            $field.'.array' => $field.' should be an array',
        ];
    }

    $validator = Validator::make($data, [$field => $validations,], $validation_check);


    if ($validator->fails()) {
        return $validator->errors();
    }else{
        return true;
    }
 }


 function validateDoubleType($data, $field, $required=true){
    $validations = 'required|regex:/^\d+(\.\d{1,2})?$/';
    $validation_check = [
        $field.'.required' => 'Please provide '.$field,
        $field.'.regex' => $field.' should be a decimal data type',
       // $field.'.decimal:2' => $field.' should be a decimal data type',
    ];
    if(!$required){
        $validations = 'regex:/^\d+(\.\d{1,2})?$/';
        $validation_check = [
             $field.'.regex' => $field.' should be a decimal data type',
            // $field.'.decimal:2' => $field.' should be a decimal data type',
        ];
    }
    if(!is_numeric(floatval($field))){
        return response()->json([ 'message' => $field." should be a numeric value" ], 400);
    }

    $validator = Validator::make($data, [
        $field => $validations,
    ], $validation_check);

    if ($validator->fails()) {
        return $validator->errors();
    }else {
        return true;
    }
 }


 function validateStringType($data, $field, $required=true){
    $validations = 'required|string';
    $validation_check = [
        $field.'.required' => 'Please provide '.$field,
         $field.'.string' => $field.' should be a string data type',
    ];
    if(!$required){
        $validations = 'string';
        $validation_check = [
             $field.'.string' => $field.' should be a string data type',
        ];
    }


    $validator = Validator::make($data, [
        $field => $validations,
    ], $validation_check);

    if ($validator->fails()) {
        return $validator->errors();
    }else{
        return true;
    }
 }

 function initiate_payment($customer_email, $amount){

    $url = env('PAYSTACK_URL')."transaction/initialize";
    $amount = (int)$amount * 100;
    $fields = [
      'email' => $customer_email,
      'amount' => $amount,
      'callback_url' => env('PAYSTACK_CALLBACK_URL'),
      'metadata' => ["cancel_action" => env('PAYSTACK_CANCEL_URL')]
    ];

    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".env("PAYSTACK_SECRET_KEY"),
      "Cache-Control: no-cache",
    ));

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);
    return $result;
 }

 ?>
