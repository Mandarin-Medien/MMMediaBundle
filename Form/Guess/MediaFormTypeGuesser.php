<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 20.11.15
 * Time: 12:48
 */

namespace MandarinMedien\MMMediaBundle\Form\Guess;


use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Guess\Guess;

class MediaFormTypeGuesser implements FormTypeGuesserInterface
{

    protected $entities = array('MediaSortable');


    public function guessType($class, $property)
    {
        if(null !== ($annotations = $this->readPhpDocAnnotations($class, $property)))
        {
            if(in_array($annotations[2], $this->entities)) {

                if(isset($annotations[3])) {
                    return new TypeGuess('mmmedia_upload_collection', array(), Guess::VERY_HIGH_CONFIDENCE);
                } else {
                    return new TypeGuess('mmmedia_upload', array(), Guess::VERY_HIGH_CONFIDENCE);
                }
            }
        }
    }

    public function guessRequired($class, $property)
    {
    }

    public function guessMaxLength($class, $property)
    {
    }

    public function guessPattern($class, $property)
    {
    }

    protected function readPhpDocAnnotations($class, $property)
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);
        $phpdoc = $reflectionProperty->getDocComment();
        $matches = array();

        if(preg_match('/(?:@var)(?:\s)+(([a-zA-Z]+)(\[\])?)/', $phpdoc, $matches))
        {
            return $matches;
        } else {
            return null;
        }

    }
}