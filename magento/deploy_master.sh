#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PHP_PATH="/usr/bin/php -d memory_limit=256M"
MAGENTO_PATH=$DIR"/bin/magento"

MODE="production"

echo $DIR
echo $PHP_PATH
echo $MAGENTO_PATH

echo "Removes cache folders"
echo "======================================"
rm -R $DIR"/var/di" $DIR"/var/generation" $DIR"/pub/static/frontend/DS/multipack"
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

echo "Compile"
echo "======================================"
$PHP_PATH $MAGENTO_PATH setup:di:compile
echo ""

echo "Reindex"
echo "======================================"
$PHP_PATH $MAGENTO_PATH indexer:reindex
echo ""

echo "Deploy"
echo "======================================"
$PHP_PATH $MAGENTO_PATH setup:static-content:deploy
echo ""

echo "Mode "$MODE
echo "======================================"
$PHP_PATH $MAGENTO_PATH deploy:mode:set $MODE
echo ""
