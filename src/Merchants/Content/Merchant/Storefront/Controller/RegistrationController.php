<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\Merchant\Storefront\Controller;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Customer\Exception\CustomerAlreadyConfirmedException;
use Shopware\Core\Checkout\Customer\Exception\CustomerNotFoundByHashException;
use Shopware\Core\Checkout\Customer\SalesChannel\AccountRegistrationService;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Validation\DataBag\QueryDataBag;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\Framework\Validation\Exception\ConstraintViolationException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Production\Merchants\Content\Merchant\Services\RegistrationService;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class RegistrationController extends StorefrontController
{
    /**
     * @var AccountRegistrationService
     */
    private $accountRegistrationService;

    public function __construct(
        AccountRegistrationService $accountRegistrationService
    ) {
        $this->accountRegistrationService = $accountRegistrationService;
    }

    /**
     * @Route("/merchant/registration/confirm", name="storefront.merchant.register.mail", methods={"GET"})
     */
    public function confirmRegistration(SalesChannelContext $context, QueryDataBag $queryDataBag): Response
    {
        try {
            $this->accountRegistrationService->finishDoubleOptInRegistration($queryDataBag, $context);
        } catch (CustomerNotFoundByHashException | CustomerAlreadyConfirmedException | ConstraintViolationException $exception) {
            $this->addFlash('danger', $this->trans('account.confirmationIsAlreadyDone'));

            return $this->redirectToRoute('frontend.home.page');
        }

        $this->addFlash('success', $this->trans('account.doubleOptInRegistrationSuccessfully'));

        return $this->redirectToRoute('frontend.home.page');
    }

    protected function addFlash(string $type, string $message)
    {
        if (!$this->container->has('session')) {
            throw new \LogicException('You can not use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".');
        }

        $this->container->get('session')->getFlashBag()->add($type, $message);
    }
}
