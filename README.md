Introduction
------------
It is bundle of useful eRepublik's utilities.
###Erpk\Common\DateTime
That class extends original PHP [DateTime](http://php.net/manual/en/class.datetime.php).
Examples:
####Create DateTime from eRepublik day
```php
<?php
use Erpk\Common\DateTime;
$dateTime = DateTime::createFromDay(1849);
echo 'Day 1849 is '.$dateTime->format('Y-m-d');
```
Output
```
Day 1849 is 2012-12-12
```
###3Show current eRepublik day
```php
<?php
use Erpk\Common\DateTime;
$dateTime = new DateTime;
echo 'Today is '.$dateTime->getDay().' eRepublik\'s day';
```
Output (may differ)
```
Today is 1849 eRepublik's day
```
