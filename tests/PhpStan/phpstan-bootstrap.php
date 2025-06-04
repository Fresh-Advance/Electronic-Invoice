<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

class_alias(
    \OxidEsales\Eshop\Application\Model\User::class,
    \FreshAdvance\ElectronicInvoice\Extension\Model\User_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Controller\StartController::class,
    \FreshAdvance\ElectronicInvoice\Extension\Controller\StartController_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Model\Basket::class,
    \FreshAdvance\ElectronicInvoice\Extension\Model\Basket_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Controller\ArticleDetailsController::class,
    \FreshAdvance\ElectronicInvoice\ProductVote\Controller\ArticleDetailsController_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Component\Widget\ArticleDetails::class,
    \FreshAdvance\ElectronicInvoice\ProductVote\Widget\ArticleDetails_parent::class
);
