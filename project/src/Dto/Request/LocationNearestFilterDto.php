<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class LocationNearestFilterDto
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Choice(callback={"App\Dictionary\LocationTypeDictionary", "getAllowedValues"})
     *
     * @var string
     */
    public $type;

    /**
     * @Assert\Type(type="numeric")
     * @Assert\NotBlank
     * @Assert\Positive
     *
     * @var int
     */
    public $distance;

    /**
     * @Assert\Type(type="numeric")
     * @Assert\NotBlank
     *
     * @var float
     */
    public $lon;

    /**
     * @Assert\Type(type="numeric")
     * @Assert\NotBlank
     *
     * @var float
     */
    public $lat;
}
