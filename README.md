# Derb

A PHP database connection class.

## To begin...

Set your database details up somewhere

```
	define("DB_HOST", "localhost");
	define("DB_NAME", "databasename");
	define("DB_USER", "username");
	define("DB_PASS", "password");
```

Create a new instance of the class
```
$db = new Derb;
```

## Useage

**Select (Multiple)**
```
$db->select('p.name as personname', 'p.gender', 'f.name as familyname');
$db->from('people as p');
$db->join('family as f', 'f.personid = p.id');
$db->orderby('personname ASC');
$db->execute();

$results = $db->getResults();
```

**Select (Single)**
```
$db->select('name');
$db->from('people');
$db->where('name = ? AND gender = ?');
$db->execute(array('Dave', 'male'));

$result = $db->getResult();
```

**Insert**
```
$db->insert('people');
$db->fields('name', 'gender');
$db->execute(array(':name'=>'Bob', ':gender'=>'male'));
```

**Delete**
```
$db->delete('people');
$db->where('name = ?');
$db->execute(array('Bob'));
```

**Update**
```
$db->update('people');
$db->set('name', 'gender');
$db->where('id = ?');
$db->execute(array('Ali', 'female', '1'));
```

**Custom**
```
$db->custom('SELECT name from people WHERE name = ?');
$db->execute(array('Ali'));
$result = $db->getResult();
```
