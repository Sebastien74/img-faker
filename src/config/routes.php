<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use FakeImgBundle\Controller\PlaceholderController;

return static function (RoutingConfigurator $routes): void {
    $routes
        ->add('seb_fake_img_placeholder', '/placeholder/{tag}.webp')
        ->controller(PlaceholderController::class)
        ->requirements(['tag' => '.+'])
        ->methods(['GET'])
    ;
};
