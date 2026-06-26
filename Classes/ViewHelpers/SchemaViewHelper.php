<?php

namespace FourViewture\Course\ViewHelpers;

use FourViewture\Course\Domain\Model\Course;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SchemaViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('courses', 'mixed', 'A single course or an array/iterator of courses', true);
    }

    public function render(): string
    {
        $courses = $this->arguments['courses'];
        if ($courses instanceof Course) {
            $courses = [$courses];
        }

        if (!is_iterable($courses)) {
            return '';
        }

        $schemaData = [];
        foreach ($courses as $course) {
            if (!$course instanceof Course) {
                continue;
            }

            $courseSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Course',
                'name' => $course->getCourseType(),
                'description' => $course->getCourseDescription() ?: $course->getCourseType(),
                'identifier' => $course->getNumber(),
            ];

            $offering = [
                '@type' => 'CourseInstance',
                'courseMode' => 'onsite',
            ];

            if ($course->getCourseStartDate()) {
                $offering['startDate'] = $course->getCourseStartDate()->format('c');
            }
            if ($course->getCourseEndDate()) {
                $offering['endDate'] = $course->getCourseEndDate()->format('c');
            }

            $address = $course->getAddress();
            if ($address) {
                $offering['location'] = [
                    '@type' => 'Place',
                    'name' => $address->getName() ?: $address->getCompany(),
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $address->getAddress(),
                        'addressLocality' => $address->getCity(),
                        'postalCode' => $address->getZip(),
                        'addressCountry' => 'DE',
                    ]
                ];
            }

            $costs = $course->getCosts();
            if ($costs) {
                $offering['offers'] = [
                    '@type' => 'Offer',
                    'price' => $costs,
                    'priceCurrency' => $course->getCurrency() ?: 'EUR',
                    'availability' => $course->isAvailable() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ];
            }

            $courseSchema['hasCourseInstance'] = $offering;
            $schemaData[] = $courseSchema;
        }

        if (empty($schemaData)) {
            return '';
        }

        // If only one course, don't wrap in array if we want simple JSON-LD,
        // but schema.org often accepts arrays of objects too.
        $output = count($schemaData) === 1 ? $schemaData[0] : $schemaData;

        return '<script type="application/ld+json">' . json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
