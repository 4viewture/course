<?php

namespace FourViewture\Course\Controller;

use FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class AddressController extends ActionController
{
    /**
     * @param \FriendsOfTYPO3\TtAddress\Domain\Model\Address $address
     * @return ResponseInterface
     */
    public function showAction(Address $address): ResponseInterface
    {
        $this->view->assign('address', $address);
        return $this->htmlResponse();
    }
}
