<?php


namespace Iggyvolz\SimpleAttributeReflection;


use ReflectionAttribute;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionFunctionAbstract;
use ReflectionProperty;
use ReflectionParameter;

class AttributeReflection
{
    private function __construct() {}

    /**
     * @template T of object
     * @param ReflectionFunctionAbstract|ReflectionClass|ReflectionProperty|ReflectionClassConstant|ReflectionParameter $target
     * @param class-string<T> $type
     * @return list<T>
     */
    public static function getAttributes(ReflectionFunctionAbstract|ReflectionClass|ReflectionProperty|ReflectionClassConstant|ReflectionParameter $target, string $type): array
    {
        return array_values(array_map(
            /**
             * @param ReflectionAttribute<T> $attribute
             * @return T
             */
            function(ReflectionAttribute $attribute): object {
                return $attribute->newInstance();
            },
            $target->getAttributes($type, ReflectionAttribute::IS_INSTANCEOF)
        ));
    }
    /**
     * @template T of object
     * @param ReflectionFunctionAbstract|ReflectionClass|ReflectionProperty|ReflectionClassConstant|ReflectionParameter $target
     * @param class-string<T> $type
     * @return T|null
     */
    public static function getAttribute(ReflectionFunctionAbstract|ReflectionClass|ReflectionProperty|ReflectionClassConstant|ReflectionParameter $target, string $type): ?object
    {
        return self::getAttributes($target, $type)[0] ?? null;
    }
}
