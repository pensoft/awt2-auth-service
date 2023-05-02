<?php

namespace App\Helpers;

use App\Exceptions\CustomPolicyMethodArgumentsException;
use App\Services\MicroserviceConnectorService;
use Casbin\Util\BuiltinOperations;

class CustomPolicyMethods
{
    /**
     * @var array
     */
    private array $evaluatedParams = [];

    /**
     * @param array $evaluatedParams
     */
    public function __construct(array $evaluatedParams){
        $this->evaluatedParams = $evaluatedParams;
    }

    /** The method check if the given endpoint is owned by the requester
     * @return bool
     * @throws CustomPolicyMethodArgumentsException
     */
    public function isOwner(): bool
    {
        $arguments = func_get_args();

        $endpoint = $arguments[0];

        if(count($arguments) != 1){
            throw new CustomPolicyMethodArgumentsException('Arguments of the method isOwner not matched required 1!');
        }

        $res = BuiltinOperations::keyMatchFunc($this->evaluatedParams['request']['object'], $endpoint);

        if($res){
            try {
                $server = env('API_GATEWAY_SERVICE').'/api';
                $res = app(MicroserviceConnectorService::class)->execute($server .$this->evaluatedParams['request']['object']);
                $extObject = $res['data'];
                if(isset($extObject['user'])){
                    return $extObject['user']['id'] == $this->evaluatedParams['request']['subject'];
                }
            } catch (\Exception $e){

            }
        }

        return false;
    }
}
