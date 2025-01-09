<?php

namespace App\Http\Requests;

use Spatie\LaravelData\Data;
//use ReflectionClass;
//use ReflectionProperty;
//use Carlin\LaravelDataSwagger\Attributes\Property;


class BaseRequest extends Data
{
    //public static function attributes(): array
    //{
    //    $attributes = [];
    //    $reflection = new ReflectionClass(static::class);
	//
    //    foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
    //        $propertyAttributes = $property->getAttributes(Property::class);
    //        if (!empty($propertyAttributes)) {
    //            $propertyAttribute = $propertyAttributes[0]->newInstance();
    //            $attributes[$property->getName()] = $propertyAttribute->title ?? $property->getName();
    //        }
    //    }
	//
    //    return $attributes;
    //}

}
