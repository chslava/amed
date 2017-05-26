<?php
namespace DS\Hanza\Block;

class Hanza extends \Magento\Framework\View\Element\Template
{

    public function getAbsoluteMediaPath() {
        /*    /** @var \Magento\Framework\App\ObjectManager $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Filesystem $filesystem */
        $filesystem = $om->get('Magento\Framework\Filesystem');
        /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
        $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        return $reader->getAbsolutePath();
    }

    public function getTitle()
    {
        return 'Hanza import script';
    }



    private function mulipack_csv(){
        return 1;
    }


    public function get_product_file(){

        if($this->mulipack_csv()){
            return $this->getAbsoluteMediaPath() . "product_import/products_csv.csv";
        } else {
            return $this->getAbsoluteMediaPath()."INVc.txt";
        }

    }

    public function print_csv_product_list(){

        ?>

        <table>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Type</td>
                <td>Status</td>
            </tr>
            <?Php
            $dst_product_file = $this->get_product_file();
            //print($dst_product_file);
            $counter=0;
            if (file_exists($dst_product_file)) {
                if (($handle = fopen($dst_product_file, "r")) !== FALSE) {
                    $new_product = 0;
                    $ids_already_printed =[];
                    while (($data = fgetcsv($handle, 0)) !== FALSE) {
                        if ($this->mulipack_csv()){
                            if (strlen(trim($data[0]))==0 || trim($data[17]) != "I") {
                                continue;
                            }

                            if (in_array($data[0], $ids_already_printed)){
                                continue;
                            }
                            $ids_already_printed[] = $data[0];

                        }
                        $counter++;
                        ?>
                        <tr id="<?= str_replace(array("/","."),array("-","-"),$data[0]); ?>" class="csv-product" data-prod-id="<?= $data[0]; ?>">
                            <td class="sku">
                                <?= $data[0]; ?>
                            </td>
                            <td class="name">
                                <?= $data[1]; ?>
                            </td>

                            <td class="description">
                                <p><?= $data[16]; ?></p>
                                <a class="show-all-description" href="#show-all">View all</a>
                            </td>
                            <td class="price_by">
                                <?= $data[2]; ?>
                            </td>

                            <td class="status">
                                Waiting
                            </td>
                        </tr>
                        <?php

                    }
                }
            }
            ?>
            <script>
                TOTAL_ITEM_COUNT = <?= $counter; ?>;
            </script>
        </table>

        <?php
    }
}