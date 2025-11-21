<?php

use FakeImgBundle\Service\PlaceholderGenerator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {

    $services = $configurator->services();

    // Autowire & autoconfigure bundle services
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->set(PlaceholderGenerator::class)
        ->arg('$backgroundColorHex', '%seb_fake_img.background_color%')
        ->arg('$textColorHex', '%seb_fake_img.text_color%')
        ->arg('$maxWidth', '%seb_fake_img.max_width%')
        ->arg('$maxHeight', '%seb_fake_img.max_height%')
    ;
};
