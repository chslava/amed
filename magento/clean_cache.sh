#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PHP_PATH="/usr/bin/php -d memory_limit=512M"
MAGENTO_PATH=$DIR"/bin/magento"

MODE="developer"

echo $DIR
echo $PHP_PATH
echo $MAGENTO_PATH



echo "Cache clean"
echo "======================================"
$PHP_PATH $MAGENTO_PATH cache:clean
echo ""

echo "Cache flush"
echo "======================================"
$PHP_PATH $MAGENTO_PATH cache:flush
echo ""

echo "Reindex"
echo "======================================"
$PHP_PATH $MAGENTO_PATH indexer:reset
$PHP_PATH $MAGENTO_PATH indexer:reindex
echo ""