# derb

A PHP database connection class.

## Useage

###### Select

```php
$db->select('p.name as personname', 'p.gender', 'f.name as familyname');
$db->from('people as p');
$db->join('family as f', 'f.personid = p.id');
$db->orderby('personname ASC');
$db->showQuery();
$db->execute();
```
