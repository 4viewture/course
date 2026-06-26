<?php

namespace FourViewture\Course\Controller;

use FourViewture\Course\Domain\Repository\CourseRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;

class CourseController extends ActionController
{
    protected $courseRepository;

    public function injectCourseRepository(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function listAction(int $currentPage = 1): ResponseInterface
    {
        $categories = [];
        if (!empty($this->settings['categories'])) {
            $categories = GeneralUtility::intExplode(',', $this->settings['categories'], true);
        }

        $onlyAvailable = (bool)($this->settings['onlyAvailable'] ?? false);
        $address = (string)($this->settings['address'] ?? '');
        $limit = (int)($this->settings['limit'] ?? 0);
        $recordsPerPage = (int)($this->settings['recordsPerPage'] ?? 10);
        $offset = ($currentPage - 1) * $recordsPerPage;

        $effectiveLimit = $recordsPerPage;
        if ($limit > 0 && ($offset + $recordsPerPage) > $limit) {
            $effectiveLimit = max(0, $limit - $offset);
        }

        $courses = $this->courseRepository->findByFilters($categories, $onlyAvailable, $address, $effectiveLimit, $offset);
        $totalCourses = $this->courseRepository->countByFilters($categories, $onlyAvailable, $address);
        if ($limit > 0 && $totalCourses > $limit) {
            $totalCourses = $limit;
        }
        $numberOfPages = ceil($totalCourses / $recordsPerPage);

        $this->view->assign('courses', $courses);
        $this->view->assign('settings', $this->settings);
        $this->view->assign('currentPage', $currentPage);
        $this->view->assign('numberOfPages', $numberOfPages);

        return $this->htmlResponse();
    }

    public function monthAction(int $year = 0, int $month = 0): ResponseInterface
    {
        $now = new \DateTime('first day of this month 00:00:00');
        if ($year === 0) {
            $year = (int)$now->format('Y');
        }
        if ($month === 0) {
            $month = (int)$now->format('m');
        }

        $requestedDate = new \DateTime($year . '-' . $month . '-01 00:00:00');
        if ($requestedDate < $now) {
            $requestedDate = clone $now;
            $year = (int)$requestedDate->format('Y');
            $month = (int)$requestedDate->format('m');
        }

        $endDate = clone $requestedDate;
        $endDate->modify('last day of this month 23:59:59');

        $categories = [];
        if (!empty($this->settings['categories'])) {
            $categories = GeneralUtility::intExplode(',', $this->settings['categories'], true);
        }
        $onlyAvailable = (bool)($this->settings['onlyAvailable'] ?? false);
        $address = (string)($this->settings['address'] ?? '');

        $courses = $this->courseRepository->findByFilters($categories, $onlyAvailable, $address, 0, 0, $requestedDate, $endDate);

        $prevDate = clone $requestedDate;
        $prevDate->modify('-1 month');
        if ($prevDate < $now) {
            $prevDate = null;
        }

        $nextDate = clone $requestedDate;
        $nextDate->modify('+1 month');

        $this->view->assign('courses', $courses);
        $this->view->assign('currentDate', $requestedDate);
        $this->view->assign('prevDate', $prevDate);
        $this->view->assign('nextDate', $nextDate);
        $this->view->assign('settings', $this->settings);

        return $this->htmlResponse();
    }
}
