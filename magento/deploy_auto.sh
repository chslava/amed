#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PHP_PATH="/usr/bin/php -d memory_limit=256M"
MAGENTO_PATH=$DIR"/bin/magento"
BRANCH_LOG_FILE=$DIR"/.current.branch.log";
COMMIT_LOG_FILE=$DIR"/.current.commit.log";

#check the version of the branch
#git_branch=$(/usr/bin/git branch | grep \*);
/usr/bin/git branch 2>&1 | grep \* > "$BRANCH_LOG_FILE";
current_branch=$(< "$BRANCH_LOG_FILE");
if [ -f "$COMMIT_LOG_FILE" ]; then
   current_commit=$(< "$COMMIT_LOG_FILE");
else
   touch ""$COMMIT_LOG_FILE"";
   current_commit="";
fi

#echo "Current branch $current_branch";
#echo "Current commit $current_commit";
echo "";
echo "";

if [ "$current_branch" != "* master" ]; then
  echo "Its not a master branch...";
  echo "Checking if the commit have been changed ... ";
  /usr/bin/git log -1 2>&1 > ""$COMMIT_LOG_FILE"";
  #echo "$COMMIT_LOG_FILE";
  latest_commit = $(< "$COMMIT_LOG_FILE");
  if ["$current_commit" != "$latest_commit"]; then
      echo "";
      echo "Have to deploy...";
      echo "";
      
      #./deploy_develop.sh;
      
      echo "";
      echo "Done!";
      echo "";
    else
        echo "no changes from last commit!"
        echo "Exit without doing anything!";
  fi;
else
    echo "we are on master branch!";
    echo "Exit without doing anything!";
fi