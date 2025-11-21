<?php

namespace FakeImgBundle\Controller;

use Seb\FakeImgBundle\Service\PlaceholderGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that exposes the placeholder route
 */
class PlaceholderController
{
    private PlaceholderGenerator $placeholderGenerator;

    /**
     * Constructor
     *
     * @param PlaceholderGenerator $placeholderGenerator
     */
    public function __construct(PlaceholderGenerator $placeholderGenerator)
    {
        $this->placeholderGenerator = $placeholderGenerator;
    }

    /**
     * Generate a placeholder image from tag
     *
     * Example URL: /placeholder/fakeimg-360x500.webp
     *
     * @param string $tag
     *
     * @return Response
     */
    #[Route(
        path: '/placeholder/{tag}.webp',
        name: 'seb_fake_img_placeholder',
        requirements: ['tag' => '.+'],
        methods: ['GET']
    )]
    public function __invoke(string $tag): Response
    {
        return $this->placeholderGenerator->generateFromTag($tag);
    }
}
