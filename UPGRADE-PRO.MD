To upgrade to font-awesome pro, create a new private repo, and run the following commands 


    git remote add upstream https://github.com/packaged-ui/fontawesome.git
    git fetch upstream
    git push -u origin master
    git apply ./switch-to-pro.patch
    git add composer.json&& git add generate.php&& git add generate.sh&& git add package.json&& git commit -m "Upgraded To Pro"&& git push
    yarn install
    ./generate.sh
