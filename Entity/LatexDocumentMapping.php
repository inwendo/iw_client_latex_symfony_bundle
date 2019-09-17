<?php

namespace Inwendo\LatexClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LatexDocumentMapping
 *
 * @ORM\Table(name="iw_client_latex_document_mapping", uniqueConstraints={@ORM\UniqueConstraint(name="document_mapping_unique", columns={"local_id", "latex_service_account"})})
 * @ORM\Entity
 */
class LatexDocumentMapping
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="local_user_id", type="integer")
     */
    private $localUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="local_id", type="integer")
     */
    private $localId;
    /**
     * @var integer
     *
     * @ORM\Column(name="distant_id", type="integer")
     */
    private $distantId;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLocalUserId()
    {
        return $this->localUserId;
    }

    /**
     * @param int $localUserId
     */
    public function setLocalUserId($localUserId)
    {
        $this->localUserId = $localUserId;
    }

    /**
     * @return int
     */
    public function getLocalId()
    {
        return $this->localId;
    }

    /**
     * @param int $localId
     */
    public function setLocalId($localId)
    {
        $this->localId = $localId;
    }

    /**
     * @return int
     */
    public function getDistantId()
    {
        return $this->distantId;
    }

    /**
     * @param int $distantId
     */
    public function setDistantId($distantId)
    {
        $this->distantId = $distantId;
    }
}
