<?php

namespace DS\Importer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Directsql extends AbstractHelper
{

    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        $this->class = explode('\\',__CLASS__);
        $this->class = end($this->class);

        $this->_objectManager=\Magento\Framework\App\ObjectManager::getInstance();
        $this->store = $this->_objectManager->create('DS\Importer\Helper\Store');

    }


    public function remove_media_entries($missing_file){


        $full_path = $this->store->get_absolute_media_path()."catalog/product".$missing_file;

        if (!file_exists($full_path)){

            $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $sql = "delete from catalog_product_entity_media_gallery_value where catalog_product_entity_media_gallery_value.value_id in ( select mg.value_id from  catalog_product_entity_media_gallery mg where mg.value like '%$missing_file%');";
            $sql2 = "delete from catalog_product_entity_media_gallery_value_to_entity where catalog_product_entity_media_gallery_value_to_entity.value_id in (select mg.value_id from  catalog_product_entity_media_gallery mg where mg.value like '%$missing_file%');";
            $sql3 = "delete from  catalog_product_entity_media_gallery where value like '%$missing_file%';";


            try {
                $connection->query($sql);
                $connection->query($sql2);
                $connection->query($sql3);
                return ["status"=>true,"message"=>"Media entries removed!"];
            } catch (\Exception $e) {
                return ["status"=>false,"message"=>"Could not remove media entries. ".$e->getMessage()." "];
            }


        }

    }

}
