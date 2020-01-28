<?php

namespace App\RestController;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\MyService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class TestController extends AbstractFOSRestController
{
    /**
     * @var MyService
     */
    private MyService $myService;

    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
    }

    /**
     * @Rest\Route
     * @Rest\View
     *
     * @IsGranted("ROLE_TEST", statusCode=403, message="Test Access Denied.")
     *
     * @param Request $request
     *
     * @return array
     */
    public function getTestAction(Request $request): array
    {
        return $this->myService->result();
    }
}
