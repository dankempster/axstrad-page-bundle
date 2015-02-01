<?php
/**
 * This file is part of the Axstrad library.
 *
 * (c) Dan Kempster <dev@dankempster.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2014-2015 Dan Kempster <dev@dankempster.co.uk>
 */

namespace Axstrad\Bundle\PageBundle\Entity;

use Axstrad\Bundle\PageBundle\Exception\InvalidArgumentException;
use Axstrad\Common\Entity\IdTrait;
use Axstrad\DoctrineExtensions\Activatable\ActivatableTrait;
use Axstrad\Component\Content\Entity\Article;
use Axstrad\DoctrineExtensions\Sluggable\SluggableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Cmf\Bundle\SeoBundle\Model\SeoMetadata;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;

/**
 * Axstrad\Bundle\PageBundle\Entity\BasePage
 *
 * @author Dan Kempster <dev@dankempster.co.uk>
 * @license MIT
 * @package Axstrad/PageBundle
 * @subpackage ORM
 * @ORM\MappedSuperclass
 */
class BasePage extends Article implements
    SeoAwareInterface
{
    use IdTrait;
    use ActivatableTrait;
    use SluggableTrait;

    /**
     * @var string The entity's slug
     * @ORM\Column(type="string", length=100)
     * @Gedmo\Slug(fields={"heading"})
     */
    protected $slug;

    /**
     * @var SeoMetadata
     * @ORM\OneToOne(targetEntity="Symfony\Cmf\Bundle\SeoBundle\Model\SeoMetadata")
     * @ORM\JoinColumn(name="seoMetaDataId")
     */
    protected $seoMetadata;

    /**
     */
    public function getSeoMetadata()
    {
        return $this->seoMetadata;
    }

    /**
     */
    public function setSeoMetadata($metadata)
    {
        if ( ! $metadata instanceof SeoMetadata) {
            throw InvalidArgumentException::create(
                'Symfony\Cmf\Bundle\SeoBundle\Model\SeoMetadata',
                $metadata
            );
        }

        $this->seoMetadata = $metadata;
        return $this;
    }
}

