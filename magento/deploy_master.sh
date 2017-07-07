#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PHP_PATH="/usr/bin/php -d memory_limit=512M"
MAGENTO_PATH=$DIR"/bin/magento"

MODE="production"

echo $DIR
echo $PHP_PATH
echo $MAGENTO_PATH

echo "Removes cache folders"
echo "======================================"
rm -R $DIR"/var/di" $DIR"/var/generation" $DIR"/pub/static/frontend" $DIR"/pub/static/adminhtml"
echo ""

echo "Cache clean"
echo "======================================"
$PHP_PATH $MAGENTO_PATH cache:clean
echo ""

echo "Cache flush"
echo "======================================"
$PHP_PATH $MAGENTO_PATH cache:flush
echo ""

echo "Upgrade"
echo "======================================"
$PHP_PATH $MAGENTO_PATH setup:upgrade
echo ""


echo "Reindex"
echo "======================================"
$PHP_PATH $MAGENTO_PATH indexer:reindex
echo ""

echo "Mode "$MODE
echo "======================================"
$PHP_PATH $MAGENTO_PATH deploy:mode:set $MODE -s
echo ""

echo "Compile"
echo "======================================"
$PHP_PATH $MAGENTO_PATH setup:di:compile
echo ""

echo "Deploy"
echo "======================================"
$PHP_PATH $MAGENTO_PATH setup:static-content:deploy --theme=amedical/base en_US
$PHP_PATH $MAGENTO_PATH setup:static-content:deploy --theme=amedical/base lv_LV
$PHP_PATH $MAGENTO_PATH setup:static-content:deploy --theme=amedical/base ru_RU
$PHP_PATH $MAGENTO_PATH setup:static-content:deploy --theme=Magento/backend en_US
echo ""