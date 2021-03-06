<?php

/*
 * This file is part of BardisCMS.
 *
 * (c) George Bardis <george@bardis.info>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BardisCMS\ContentBlockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BardisCMS\ContentBlockBundle\Entity\ContentGlobalBlock.
 *
 * @ORM\Table(name="content_globalblock")
 * @ORM\Entity
 */
class ContentGlobalBlock
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BardisCMS\ContentBlockBundle\Entity\ContentBlock", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contentblock", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $contentblock;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contentblock.
     *
     * @param BardisCMS\ContentBlockBundle\Entity\ContentBlock contentblock
     *
     * @return ContentBlock
     */
    public function setContentblock(\BardisCMS\ContentBlockBundle\Entity\ContentBlock $contentblock = null)
    {
        $this->contentblock = $contentblock;

        return $this;
    }

    /**
     * Get contentblock.
     *
     * @return BardisCMS\ContentBlockBundle\Entity\ContentBlock
     */
    public function getContentblock()
    {
        return $this->contentblock;
    }
}
