# Magento 2 Module OlhaChe Offers

    ``olhache/module-offers``


## Main Functionalities
-

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/OlhaChe`
 - Enable the module by running `php bin/magento module:enable OlhaChe_Offers`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require olhache/module-offers`
 - enable the module by running `php bin/magento module:enable OlhaChe_Offers`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

## Description
You will need to add a new “Offers” menu in the back office that will allow you to manage
offer banners assigned to one or more categories. 
The new menu will need to be taken into account in the ACLs.

Your entity will need to include the following fields:
- A label to name the offer
- An image
- A redirection link
- A multiple choice list to select one or more categories
- A display start date
- A display end date

A grid will need to allow you to view all the offers in the back office.
On the front, you will need to display the offers (image + redirection link) on the categories chosen in the back office according to the display start and end dates.
Example of displaying an offer on a category page: 
![example.png](..%2F..%2F..%2F..%2F..%2F..%2F..%2FDesktop%2Fexample.png)




