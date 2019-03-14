<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Models\Article;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Table(name="s_articles_downloads")
 * @ORM\Entity()
 */
class Download extends ModelEntity
{
    /**
     * OWNING SIDE
     *
     * @var \Shopware\Models\Article\Article
     *
     * @ORM\ManyToOne(targetEntity="Shopware\Models\Article\Article", inversedBy="downloads")
     * @ORM\JoinColumn(name="articleID", referencedColumnName="id")
     */
    protected $article;

    /**
     * INVERSE SIDE
     *
     * @var \Shopware\Models\Attribute\ArticleDownload
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Attribute\ArticleDownload", mappedBy="articleDownload", cascade={"persist"})
     */
    protected $attribute;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="articleID", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $file;

    /**
     * @var float
     *
     * @ORM\Column(name="size", type="float", nullable=false)
     */
    private $size;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Article $article
     *
     * @return Download
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param string $name
     *
     * @return Download
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $file
     *
     * @return Download
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param float $size
     *
     * @return Download
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return \Shopware\Models\Attribute\ArticleDownload
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param \Shopware\Models\Attribute\ArticleDownload|array|null $attribute
     *
     * @return \Shopware\Models\Attribute\ArticleDownload
     */
    public function setAttribute($attribute)
    {
        return $this->setOneToOne($attribute, \Shopware\Models\Attribute\ArticleDownload::class, 'attribute', 'articleDownload');
    }
}
