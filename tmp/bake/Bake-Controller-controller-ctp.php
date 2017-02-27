<?php
use Cake\Utility\Inflector;

$defaultModel = $name;
?>
<CakePHPBakeOpenTagphp
namespace <?= $namespace ?>\Controller<?= $prefix ?>;

use <?= $namespace ?>\Controller\AppController;

/**
 * <?= $name ?> Controller
 *
 * @property \<?= $namespace ?>\Model\Table\<?= $defaultModel ?>Table $<?= $defaultModel ?>

<?php
foreach ($components as $component):
    $classInfo = $this->Bake->classInfo($component, 'Controller/Component', 'Component');
?>
 * @property <?= $classInfo['fqn'] ?> $<?= $classInfo['name'] ?>

<?php endforeach; ?>
 */
class <?= $name ?>Controller extends AppController
{
<?php
echo $this->Bake->arrayProperty('components', $components, ['indent' => false]);
?>
}
