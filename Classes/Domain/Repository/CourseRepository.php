<?php

namespace FourViewture\Course\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class CourseRepository extends Repository
{
    public function findByFilters(array $categories = [], bool $onlyAvailable = false, string $address = ''): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = [];

        if (!empty($categories)) {
            $categoryConstraints = [];
            foreach ($categories as $category) {
                $categoryConstraints[] = $query->contains('categories', $category);
            }
            $constraints[] = $query->logicalOr(...$categoryConstraints);
        }

        if ($onlyAvailable) {
            // Assuming 'available_places' > 0 or not empty.
            // In TCA it's an input, so it might contain text like "Ausgebucht" or a number.
            // If it's a number, we can check > 0.
            $constraints[] = $query->logicalNot($query->equals('available_places', '0'));
            $constraints[] = $query->logicalNot($query->equals('available_places', 'Ausgebucht'));
            $constraints[] = $query->logicalNot($query->equals('available_places', ''));
        }

        if ($address !== '') {
            $constraints[] = $query->equals('address', $address);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        return $query->execute();
    }
}
