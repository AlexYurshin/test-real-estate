<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class LocationNearestFilterDto
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
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
    public $lat;

    /**
     * @Assert\Type(type="numeric")
     * @Assert\NotBlank
     *
     * @var float
     */
    public $lon;
}
