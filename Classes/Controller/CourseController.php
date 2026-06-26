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

    public function listAction(array $categories = [], bool $onlyAvailable = false, string $address = ''): ResponseInterface
    {
        // Fallback to settings if not provided by arguments
        if (empty($categories) && !empty($this->settings['categories'])) {
            $categories = GeneralUtility::intExplode(',', $this->settings['categories'], true);
        }

        if (!$onlyAvailable && isset($this->settings['onlyAvailable'])) {
            $onlyAvailable = (bool)$this->settings['onlyAvailable'];
        }

        if ($address === '' && isset($this->settings['address'])) {
            $address = $this->settings['address'];
        }

        $courses = $this->courseRepository->findByFilters($categories, $onlyAvailable, $address);

        $this->view->assign('courses', $courses);
        $this->view->assign('settings', $this->settings);

        return $this->htmlResponse();
    }
}
