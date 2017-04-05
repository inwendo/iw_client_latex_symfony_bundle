<?php
namespace Inwendo\LatexClientBundle\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Inwendo\Auth\LoginBundle\Entity\ServiceAccount;
/**
 * LatexServiceAccount
 *
 * @ORM\Table(name="iw_client_latex_service_account")
 * @ORM\Entity
 */
class LatexServiceAccount extends ServiceAccount
{
    /**
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(EntityManagerInterface $em)
    {
        return $em->getRepository(__CLASS__);
    }
}