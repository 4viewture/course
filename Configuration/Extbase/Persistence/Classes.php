<?php
declare(strict_types=1);

return [
    \FourViewture\Course\Domain\Model\Course::class => [
        'tableName' => 'tx_course_domain_model_course',
        'properties' => [
            'address' => [
                'fieldName' => 'address'
            ],
        ],
    ],
];
