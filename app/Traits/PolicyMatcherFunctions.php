<?php
declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\NotValidPolicyCustomMethodException;
use App\Helpers\CustomPolicyMethods;
use Lauthz\Facades\Enforcer as NewEnforcer;

trait PolicyMatcherFunctions {

    protected function registerMatcherFunctions(){

        NewEnforcer::addFunction('aclFunction', function (...$args) {
            return $this->aclFunction(...$args);
        });
    }

    protected function aclFunction(...$args): bool
    {
        $evaluatedParams = [
            'request' => [
                'subject' => $args[0],
                'object' => $args[1],
                'action' => $args[2],
            ],
            'policy' => [
                'subject' => $args[3],
                'object' => $args[4],
                'action' => $args[5],
            ]
        ];

        try {
            [$method, $args] = $this->extractMethod($evaluatedParams['policy']['object']);

            $helper = app()->makeWith(CustomPolicyMethods::class, ['evaluatedParams' => $evaluatedParams]);

            if (method_exists($helper, $method)) {
                return $helper->$method(...$args);
            }
        } catch (\Exception $e){

        }
        return false;
    }

    /**
     * @param $string
     * @return array
     * @throws NotValidPolicyCustomMethodException
     */
    protected function extractMethod($string): array
    {
        $re = '/\s*(?<method>[^ (]+)(?:\((?<args>[^\)]+)\))?/mixX';
        preg_match_all($re, $string, $matches, PREG_SET_ORDER, 0);

        if(!isset($matches[0]['method']) || !isset($matches[0]['args'])){
            throw new NotValidPolicyCustomMethodException('Not custom policy!');
        }

        $method = $matches[0]['method'];
        $argumentString = $matches[0]['args'];


        preg_match_all('/(?<arg>[^,\s]+)/', $argumentString, $matches);

        return [
            $method,
            $matches['arg'] ?? []
        ];
    }
}
