<?php

namespace FourViewture\Course\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class CourseRepository extends Repository
{
    public function findByFilters(array $categories = [], bool $onlyAvailable = false, string $address = '', int $limit = 0, int $offset = 0, ?\DateTime $startDate = null, ?\DateTime $endDate = null): QueryResultInterface
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

        if ($startDate !== null) {
            $constraints[] = $query->greaterThanOrEqual('course_start_date', $startDate);
        }

        if ($endDate !== null) {
            $constraints[] = $query->lessThanOrEqual('course_start_date', $endDate);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        $query->setOrderings(['course_start_date' => QueryInterface::ORDER_ASCENDING]);

        if ($limit > 0) {
            $query->setLimit($limit);
        }
        if ($offset > 0) {
            $query->setOffset($offset);
        }

        return $query->execute();
    }

    public function countByFilters(array $categories = [], bool $onlyAvailable = false, string $address = '', \DateTime $startDate = null, \DateTime $endDate = null): int
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
            $constraints[] = $query->logicalNot($query->equals('available_places', '0'));
            $constraints[] = $query->logicalNot($query->equals('available_places', 'Ausgebucht'));
            $constraints[] = $query->logicalNot($query->equals('available_places', ''));
        }

        if ($address !== '') {
            $constraints[] = $query->equals('address', $address);
        }

        if ($startDate !== null) {
            $constraints[] = $query->greaterThanOrEqual('course_start_date', $startDate);
        }

        if ($endDate !== null) {
            $constraints[] = $query->lessThanOrEqual('course_start_date', $endDate);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        return $query->execute()->count();
    }
}
