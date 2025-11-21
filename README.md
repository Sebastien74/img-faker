// config/routes/seb_fake_img.yaml
seb_fake_img:
resource: '@SebFakeImgBundle/config/routes.php'
type: php

return [
// ...
Seb\FakeImgBundle\SebFakeImgBundle::class => ['all' => true],
];

seb_fake_img:
    route_prefix: '/placeholder'   # non utilisé si tu laisses la route PHP comme au-dessus
    background_color: 'e0e0e0'
    text_color: '707070'
    max_width: 4000
    max_height: 4000

<img src="{{ path('seb_fake_img_placeholder', { tag: 'fakeimg-360x500' }) }}" alt="Placeholder">