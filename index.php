<?php

function dbr($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}

//autoloading !!?? => composer !!

//DESCRIBERS
require_once ('src/model/Tools/PDOSingleton.php');
require_once ('src/model/Describers/Field/FieldBdd.php');
require_once ('src/model/Describers/Field/FieldBddFac.php');
require_once ('src/model/Describers/Field/IntField.php');
require_once ('src/model/Describers/Field/StringField.php');
require_once ('src/model/Describers/Field/BoolField.php');
require_once ('src/model/Describers/ProjectTableBdd.php');
require_once ('src/model/Describers/TableBdd.php');
require_once ('src/model/Describers/VarType.php');

//WRITERS
require_once ('src/model/Writers/GetStringInterface.php');
require_once ('src/model/Writers/PhpWriter.php');
require_once('src/model/Writers/AbstractAble.php');
require_once('src/model/Writers/Visibility.php');
require_once ('src/model/Writers/StaticAble.php');
require_once ('src/model/Writers/PhpDocBlocWriter.php');
require_once ('src/model/Writers/Class/ClassWriter.php');
require_once ('src/model/Writers/Class/ClassManagerWriter.php');
require_once('src/model/Writers/Class/ClassTableWriter.php');
require_once ('src/model/Writers/FunctionWriter.php');
require_once ('src/model/Writers/FunctionParamWriter.php');
require_once ('src/model/Writers/ConstantWriter.php');
require_once ('src/model/Writers/html/HtmlSelectOption.php');



//FORM
require_once ('src/model/Writers/html/StdAttributes.php');
require_once ('src/model/Writers/FormWriter.php');
require_once ('src/model/Writers/html/Form.php');
require_once ('src/model/Writers/html/FormElement.php');
require_once ('src/model/Writers/html/FormSubmit.php');
require_once ('src/model/Writers/html/Input.php');
require_once ('src/model/Writers/html/Select.php');
require_once ('src/model/Writers/html/Textarea.php');
require_once ('src/model/Writers/html/MultiSelector.php');

//PARAMCHECK
require_once ('../php/ManagerClassBdd/ManagerObjTable.php');
require_once ('../php/paramCheck/ParamCheck.php');
require_once ('../php/paramCheck/ParamArray.php');
require_once ('../php/paramCheck/ParamBool.php');
require_once ('../php/paramCheck/ParamFloat.php');
require_once ('../php/paramCheck/ParamInt.php');
require_once ('../php/paramCheck/ParamNumeric.php');
require_once ('../php/paramCheck/ParamString.php');
require_once ('../php/paramCheck/ParamObject.php');

require_once ('src/model/Describers/SqlSchemaInterpreter.php');
require_once ('src/model/Describers/SqlTypeInterpreter.php');


$oImgTable = new Describers\TableBdd('imageGallery');
$aField[] = Describers\FieldBddFac::getInstanceFieldBdd(Describers\VarType::INT, 'id')
    ->setMin(0)
    ->setPrimaryKey(true)
    ->setDefaultValue(0);
$aField[] = Describers\FieldBddFac::getInstanceFieldBdd(Describers\VarType::STRING, 'name')
    ->setMinLength(3)
    ->setMaxLength(20)
    ->setLabel('Name');
$oImgTable->setFields($aField);

$aTables[] = $oImgTable;

$oProject = new Describers\ProjectTableBdd('test', '');
$oProject->setTablesBdd($aTables);

/*dbr($oProject);
die();*/


$oSql = new \Describers\SqlSchemaInterpreter('droit_licence', 'test', '');
/*dbr($oSql->getDataBdd());
die();*/

/**
 * @var $oTable Describers\TableBdd
 */
foreach($oSql->getProject()->getTableBdd() as $oTable)
{
    foreach ($oTable->getFields() as $oField)
    {
        $oField->setLabel($oField->getNameFieldBdd());
    }
    $oWriterClassTable = new Writer\ClassTableWriter($oTable);
    $oWriterManager = new Writer\ClassManagerWriter($oWriterClassTable);
    $oFormWriter = new Writer\FormWriter($oWriterClassTable);
    //dbr($oWriterClassTable->getString());
    //dbr($oWriterManager->getString());
    $s = $oFormWriter->getFormAdd();
    dbr($s);
    die();

}
$aPays = array('FRANCE', 'BELGIQUE', 'SUISSE');
$oMultiSelector = new MultiSelector($aPays, 'Liste des pays', 'Liste des pays');

$sContent = $oMultiSelector->getString();


//dbr($oProject);
//die();

//TODO GERER LA CREATION DES FICHIERS DANS LES CLASS (init project)
//TODO GERE LA CREATION DES FORMULAIRES FRONT ET BACK
//TODO GERER LES NAMESPACE ??
//TODO GERER LES RETOURS AVEC PLUSIEURS type possible ??

//TODO FAIRE UN SELECT MULTIPLE
//TODO FAIRE UNE MODALE AVEC OVERLAY
//TODO FAIRE UN DROP FICHIER
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="style/MultiSelector.css">
      <link rel="stylesheet" href="style/global.css">

      <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script src="js/Overlay.js"></script>
      <script src="js/MultiSelector.js"></script>
      <title>Class origin</title>
  </head>
  <body>
    <h1>Hello, world!</h1>
    <?= $sContent ?>
  </body>
</html>