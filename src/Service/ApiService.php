<?php
namespace App\Service;

class ApiService{

    private $validator;
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateAndCreate($data, $entityClassName){

        $objectNormalizer = new ObjectNormalizer();
        $normalizers = [$objectNormalizer];
        $encoders = [new JsonEncoder()];
        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->deserialize($data, $entityClassName, 'json');
        $errors = $this->validator->validate($result);

        if(count($errors) > 0){
            throw new CustomApiException(Response::HTTP_BAD_REQUEST, (string) $errors);
        }

        return $result;

    }}

    ?>
