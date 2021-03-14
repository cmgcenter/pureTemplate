# pureTemplate
Simple and Powerfull Template Render for Pure PHP Projects

#install
## composer require cmgdevs/pure-template:dev-main
## preload ready in LWFramework (https://github.com/cmgcenter/pureTemplate)

#Init in Pure PHP 
## in index.php You must Add a function call view with 2 vars

```php
<?php
function view($file, $data)
{
	$viewPath = 'path/To/ViewFiles/'; 
	$layoutPath ='path/to/layout/';
	$cachePath = 'path/to/cacche/';
	$template = new \CMGDevs_PureTemplate\Pure($viewPath, $layoutPath, $cachePath);
	return $template->view($file, $data);
}
?>
```


# Create a Layout Skeleton
View Wiki(https://github.com/cmgcenter/pureTemplate/wiki)


# How To Use
## loop foreach
```php
<?php
$names = ['ana'=>45, 'cris'=>100,'robert'=>34];
?>
```
```php
<?php
{ foreach ($names as key => $value): }
<ul>
	<li>{{$key}} - {{$value}}</li>
</ul>
{ endforeach }
?>
```

## output
ana - 45
cris - 100
robert - 34

# loop for
```php
<?php
{ for($i=0; $i<10; $i++ )}
echo {{array[$i]}}
{endfor}
?>
```
