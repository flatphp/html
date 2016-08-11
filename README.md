# Html
Html helpers and components.

# Installation
```php
composer require "flatphp/html"
```

# Helper Usage
```
<?php
use Flatphp\Html;
?>
<link rel="stylesheet" href="<?= Html\asset('css/bootstrap.min.css') ?>">
<script src="<?= Html\asset('js/bootstrap.min.js') ?>"></script>
```

# Form Usage
```
<?php
$category = array(
    1 => 'cat1',
    2 => 'cat2',
    3 => 'cat3'
);
$data = array(
    'title' => 'hello test',
    'category' => 1,
    'content' => 'content bala bala'
);
$form = new \Flatphp\Html\Form($data);
?>

<form name="test_form" method="post" action="/test.php">
    <div>title: <?= $form->text('title', ['class' => 'title_input', 'default_value' => 'please input title']) ?></div>
    <div>category: <?= $form->select('category', $category, ['class' => 'category_select']) ?></div>
    <div>content: <?= $form->textarea('content', ['class' => 'content_text'])?></div>
</form>
```
