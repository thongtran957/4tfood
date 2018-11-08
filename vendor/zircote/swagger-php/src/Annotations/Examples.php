<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApi\Annotations;

/**
 * @Annotation
 */
class Examples extends AbstractAnnotation
{
    /**
     * Short description for the example.
     *
     * @var string
     */
    public $summary = UNDEFINED;

    /**
     * Embedded literal example. The value field and externalValue field are
     * mutually exclusive. To represent examples of media types that cannot
     * naturally represented in JSON or YAML, use a string value to contain
     * the example, escaping where necessary.
     *
     * @var string
     */
    public $description = UNDEFINED;

    /**
     * Embedded literal example.
     * The value field and externalValue field are mutually exclusive.
     * To represent examples of media types that cannot naturally represented
     * in JSON or YAML, use a string value to contain the example, escaping
     * where necessary.
     *
     * @var string
     */
    public $value = UNDEFINED;

    /**
     * A URL that points to the literal example. This provides the
     * capability to reference examples that cannot easily be included
     * in JSON or YAML documents.
     * The value field and externalValue field are mutually exclusive.
     *
     * @var string
     */
    public $externalValue = UNDEFINED;

    public static $_types = [
        'summary' => 'string',
        'value' => 'string',
        'description' => 'string',
        'externalValue' => 'string',
    ];

    public static $_required = ['summary'];

    public static $_parents = [
        'OpenApi\Annotations\Components',
        'OpenApi\Annotations\Parameter',
        'OpenApi\Annotations\MediaType',
    ];
}
