To upgrade to font-awesome pro, create a new private repo, and run the following commands 

Please also reference https://fontawesome.com/how-to-use/on-the-web/setup/using-package-managers#installing-pro for npm authentication

    git remote add upstream https://github.com/packaged-ui/fontawesome.git
    git fetch upstream
    git push -u origin master
    git apply ./switch-to-pro.patch
    git add composer.json&& git add generate.php&& git add generate.sh&& git add package.json&& git commit -m "Upgraded To Pro"&& git push
    
If you do not have fontawesome set globally, you should create your .npmrc file at this point.
    
    yarn install
    ./generate.sh
