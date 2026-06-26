<?php
declare(strict_types=1);

namespace FourViewture\Course\ViewHelpers;

use FourViewture\Course\Domain\Model\Course;
use FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class CourseSchemaViewHelper extends AbstractViewHelper
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
            if ($course instanceof Course) {
                $schemaData[] = $this->generateCourseSchema($course);
            }
        }

        if (empty($schemaData)) {
            return '';
        }

        $output = count($schemaData) === 1 ? $schemaData[0] : $schemaData;

        return '<script type="application/ld+json">' . json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    protected function generateCourseSchema(Course $course): array
    {
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
            $offering['location'] = $this->generateAddressSchema($address);
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
        return $courseSchema;
    }

    protected function generateAddressSchema(Address $address): array
    {
        $schema = [
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

        if ($address->getLatitude() && $address->getLongitude()) {
            $schema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $address->getLatitude(),
                'longitude' => $address->getLongitude(),
            ];
        }

        if ($address->getPhone()) {
            $schema['telephone'] = $address->getPhone();
        }

        return $schema;
    }
}
