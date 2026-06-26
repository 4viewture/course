<?php
declare(strict_types=1);

namespace FourViewture\Course\ViewHelpers;

use FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AddressSchemaViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('address', Address::class, 'The address object', true);
    }

    public function render(): string
    {
        /** @var Address $address */
        $address = $this->arguments['address'];

        $schema = [
            '@context' => 'https://schema.org',
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

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
