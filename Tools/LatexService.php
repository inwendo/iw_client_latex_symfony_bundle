<?php
namespace Inwendo\LatexClientBundle\Tools;

use Inwendo\Latex\Common\Api\DocumentApi;
use Inwendo\Latex\Common\Api\EnvironmentDataApi;
use Inwendo\Latex\Common\Configuration;
use Inwendo\Latex\Common\Model\DocumentRequest;
use Inwendo\Latex\Common\Model\EnvironmentDataRequest;
use Inwendo\LatexClientBundle\Entity\LatexDocumentMapping;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LatexService
{
    /**
     * @var ContainerInterface $containerInterface
     */
    private $containerInterface;
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $db;
    /**
     * LoginService constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
        $this->db = $this->containerInterface->get('doctrine');
    }

    /**
     * @param int $local_user_id
     * @param EnvironmentDataRequest $environmentDataRequest
     * @return bool|\Inwendo\Latex\Common\Model\EnvironmentDataResponse
     */
    public function saveEnvironmentData($local_user_id, EnvironmentDataRequest $environmentDataRequest){
        Configuration::getDefaultConfiguration()->addDefaultHeader('X-AUTH-TOKEN', $this->containerInterface->getParameter("inwendo_latex_client.jwt_license_token"));
        Configuration::getDefaultConfiguration()->addDefaultHeader('X-SERVICE-USER-ID', $local_user_id);
        Configuration::getDefaultConfiguration()->setHost($this->containerInterface->getParameter("inwendo_latex_client.endpoint"));
        $api = new EnvironmentDataApi();
        try{
            $response = $api->putEnvironmentDataItem($environmentDataRequest);
        } catch (\Exception $e) {
            $this->containerInterface->get("logger")->addWarning("LatexService:saveEnvironmentData EnvironmentData could not be saved! ". $e->getMessage());
            return false;
        }
        return $response;
    }
    /**
     * @param int $local_user_id
     * @param int $local_document_id
     * @param DocumentRequest $documentRequest
     * @return bool|\Inwendo\Latex\Common\Model\DocumentResponse
     */
    public function saveDocument($local_user_id, $local_document_id, DocumentRequest $documentRequest){
        Configuration::getDefaultConfiguration()->addDefaultHeader('X-AUTH-TOKEN', $this->containerInterface->getParameter("inwendo_latex_client.jwt_license_token"));
        Configuration::getDefaultConfiguration()->addDefaultHeader('X-SERVICE-USER-ID', $local_user_id);
        Configuration::getDefaultConfiguration()->setHost($this->containerInterface->getParameter("inwendo_latex_client.endpoint"));
        $api = new DocumentApi();
        /** @var LatexDocumentMapping $mapping */
        $mapping = $this->db->getRepository("InwendoLatexClientBundle:LatexDocumentMapping")->findOneBy(array("localId" => $local_document_id, "localUserId" => $local_user_id));
        if($mapping != null){
            try{
                $result = $api->putDocumentItem($mapping->getDistantId(), $documentRequest);
            } catch (\Exception $e) {
                $this->containerInterface->get("logger")->addWarning("LatexService:saveDocument Document could not be updated! ". $e->getMessage());
                return false;
            }
        }else{
            $mapping = new LatexDocumentMapping();
            $mapping->setLocalId($local_document_id);
            $mapping->setLocalUserId($local_user_id);
            try{
                $result = $api->postDocumentCollection($documentRequest);
                $mapping->setDistantId($result->getId());
                $this->db->getManager()->persist($mapping);
                $this->db->getManager()->flush();
            } catch (\Exception $e) {
                $this->containerInterface->get("logger")->addWarning("LatexService:saveDocument New Document could not be safed! ". $e->getMessage());
                return false;
            }
        }
        return $result;
    }
}
