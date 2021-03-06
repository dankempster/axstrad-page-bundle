# Installation

## Update composer.json
```
"require": {
    ...
    "axstrad/axstrad": "dev-develop@dev"
}
```

## Update AppKernel.php
```
// ./app/AppKernel.php

$bundles = array(
    // ... your other bundles

    // requires
    new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    new \Axstrad\Bundle\DoctrineExtensionsBundle\AxstradDoctrineExtensionsBundle(),
    new \Axstrad\Bundle\ExtraFrameworkBundle\AxstradExtraFrameworkBundle(),
    new \Sonata\SeoBundle\SonataSeoBundle(),
    new \Symfony\Cmf\Bundle\SeoBundle\CmfSeoBundle(),
    new \Axstrad\Bundle\SeoBundle\AxstradSeoBundle(),

    // AxstradPageBundle
    new \Axstrad\Bundle\PageBundle\AxstradPageBundle(),
);
```

## Update config.yml
```
# ./app/config/config.yml

# Doctrine Configuration
doctrine:
    # ...other doctrine config...
    orm:
        # ...other orm config...
        mappings:
            axstrad_content: # Required by AxstradPageBundle
                type: yml
                prefix: Axstrad\Component\Content\Entity
                dir: "%kernel.root_dir%/../vendor/axstrad/content/config/Orm"
                alias: AxstradContent
                is_bundle: false
            CmfSeoBundle: # Required by AxstradSeoBundle
                type: xml
                prefix: Symfony\Cmf\Bundle\SeoBundle\Model
                dir: Resources/config/doctrine-model
        filters:
            activatable: # Required by AxstradPageBundle
                class: Axstrad\DoctrineExtensions\Activatable\Filter\OrmFilter
                enabled: true


## AxstradDoctrineExtensionsBundle
axstrad_doctrine_extensions:
    orm:
        default:
            activatable: true # Required by AxstradPageBundle

## StofDoctrineExtensionsBundle
stof_doctrine_extensions:
    default_locale: %locale%
    orm:
        default:
            sluggable: true # Required by AxstradPageBundle

## Symfony SEO Bundle : extends Sonata SEO Bundle
# required by AxstradSeoBundle
cmf_seo:
    content_key: document
    persistence:
        orm: true
    # Standard page title
    title: "%%content_title%% | Acme App"

## Sonata SEO Bundle
# required by SymfonySEOBundle
sonata_seo:
    page:
        title: Acme App
        metas:
            name:
                robots: "index, follow"
            http-equiv:
                'Content-Type': "text/html; charset=utf-8"
                'X-Ua-Compatible': "IE=Edge"
        head:
            'xmlns': "http://www.w3.org/1999/xhtml"
```

## Update routing.yml
```
# ./app/config/routing.yml

axstrad_page:
    resource: '@AxstradPageBundle/Resources/config/routing.yml'
```

## Admin
The bundle has support for SonataAdmin baked in. During compilation PageBundle
looks for SonataAdmin, if found it will configure everything for you. It does
this by including Resources/config/admin.xml, so feel free to override part or
all of it to fit your needs.

## Next
The bundle comes with a basic template, so you'll probably want to override them.

 * AxstradPageBundle:Default:index.html.twig : Renderes the page itself
 * AxstradPageBundle::layout.html.twig : Simple HTML structure
