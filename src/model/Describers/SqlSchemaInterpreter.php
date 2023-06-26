<?php


namespace Describers;

class SqlSchemaInterpreter
{

    /**
     * @var string
     */
    private string $nameBdd='';

    /**
     * @var string
     */
    private string $nameProject='';

    /**
     * @var array
     */
    private array $dataBdd=array();

    /**
     * @var ProjectTableBdd | null
     */
    private ?ProjectTableBdd $project=null;

    /**
     * @var string
     */
    private string $pathFolder='';

    /**
     * @return string
     */
    public function getPathFolder(): string
    {
        return $this->pathFolder;
    }

    /**
     * @param string $pathFolder
     * @return SqlSchemaInterpreter
     */
    public function setPathFolder(string $pathFolder): SqlSchemaInterpreter
    {
        $this->pathFolder = $pathFolder;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataBdd(): array
    {
        return $this->dataBdd;
    }

    /**
     * @param array $dataBdd
     * @return SqlSchemaInterpreter
     */
    public function setDataBdd(array $dataBdd): SqlSchemaInterpreter
    {
        $this->dataBdd = $dataBdd;
        return $this;
    }

    /**
     * @return ProjectTableBdd |null
     */
    public function getProject(): ?ProjectTableBdd
    {
        return $this->project;
    }

    /**
     * @param ProjectTableBdd $project
     * @return SqlSchemaInterpreter
     */
    public function setProject(ProjectTableBdd $project): SqlSchemaInterpreter
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameBdd(): string
    {
        return $this->nameBdd;
    }

    /**
     * @param string $nameBdd
     * @return SqlSchemaInterpreter
     */
    public function setNameBdd(string $nameBdd): SqlSchemaInterpreter
    {
        $this->nameBdd = $nameBdd;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameProject(): string
    {
        return $this->nameProject;
    }

    /**
     * @param string $nameProject
     * @return SqlSchemaInterpreter
     */
    public function setNameProject(string $nameProject): SqlSchemaInterpreter
    {
        $this->nameProject = $nameProject;
        return $this;
    }

    /**
     * SqlSchemaInterpreter constructor.
     * @param string $sNameBdd
     * @param string $sProject
     * @param string $sPathFolder
     */
    public function __construct(string $sNameBdd, string $sProject, string $sPathFolder)
    {
        $this->setNameBdd($sNameBdd)->setNameProject($sProject)->setPathFolder($sPathFolder);
        $this->getSqlSchema();
        if(count($this->getDataBdd()) > 0) $this->getProjectFromBdd();
    }

    private function getSqlSchema()
    {
        $oPdo = \PDOSingleton::getInstance();
        $sql = 'SELECT *
        FROM information_schema.columns
        WHERE table_schema="' . htmlspecialchars($this->getNameBdd()) . '"'; //AND table_name="droit_typo_vte_contrat"
        $oState = $oPdo->prepare($sql);
        $bExec = $oState->execute();
        if(!$bExec) return;
        $aTableBdd = array();
        $oState->setFetchMode(\PDO::FETCH_ASSOC);
        while ($a = $oState->fetch()) { $aTableBdd[$a['TABLE_NAME']][$a['COLUMN_NAME']] = $a; }
        $this->setDataBdd($aTableBdd);
    }

    private function getProjectFromBdd()
    {
        /*$aSqlType = array(
            'int' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'tinytext' => new SqlTypeInterpreter(VarType::STRING, \FormElement::TEXTAREA),
            'text' => new SqlTypeInterpreter(VarType::STRING, \FormElement::TEXTAREA),
            'mediumtext' => new SqlTypeInterpreter(VarType::STRING, \FormElement::TEXTAREA),
            'longtext' => new SqlTypeInterpreter(VarType::STRING, \FormElement::TEXTAREA),
            'enum' => new SqlTypeInterpreter(VarType::STRING, \FormElement::SELECT),
            'tinyint' => new SqlTypeInterpreter(VarType::BOOL, \FormElement::SELECT),
            'smallint' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'mediumint' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'bigint' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'decimal' => new SqlTypeInterpreter(VarType::FLOAT, \FormElement::INPUT),
            'float' => new SqlTypeInterpreter(VarType::FLOAT, \FormElement::INPUT),
            'double' => new SqlTypeInterpreter(VarType::FLOAT, \FormElement::INPUT),
            'date' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
            'datetime' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
            'timestamp' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'time' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
            'year' => new SqlTypeInterpreter(VarType::INT, \FormElement::INPUT),
            'char' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
            'varchar' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
            'json' => new SqlTypeInterpreter(VarType::STRING, \FormElement::INPUT),
        );*/

        $aTable = array();
        foreach($this->getDataBdd() as $sTable => $aField)
        {
            $aFieldDesc = array();
            foreach($aField as $aPropField)
            {
                /*[0] => Array
                    (
                    [TABLE_CATALOG] => def
                    [TABLE_SCHEMA] => droit_licence
                    [TABLE_NAME] => droit_typo_vte_contrat
                    [COLUMN_NAME] => id
                    [ORDINAL_POSITION] => 1
                    [COLUMN_DEFAULT] =>
                    [IS_NULLABLE] => NO
                    [DATA_TYPE] => int
                    [CHARACTER_MAXIMUM_LENGTH] =>
                    [CHARACTER_OCTET_LENGTH] =>
                    [NUMERIC_PRECISION] => 10
                    [NUMERIC_SCALE] => 0
                    [DATETIME_PRECISION] =>
                    [CHARACTER_SET_NAME] =>
                    [COLLATION_NAME] =>
                    [COLUMN_TYPE] => int(11)
                    [COLUMN_KEY] => PRI
                    [EXTRA] => auto_increment
                    [PRIVILEGES] => select,insert,update,references
                    [COLUMN_COMMENT] =>
                    [IS_GENERATED] => NEVER
                    [GENERATION_EXPRESSION] =>
                    )*/

                $sBddNameField =  $aPropField['COLUMN_NAME'];

                $sLabel = ucfirst($sBddNameField);
                if($aPropField['COLUMN_KEY'] === 'PRI') $sLabel = '';

                $oSqlTypeInter = new SqlTypeInterpreter($aPropField);
                $oFieldDesc = FieldBddFac::getInstanceFieldBdd($oSqlTypeInter->getVarType(), $sBddNameField, $sLabel)->setFieldBdd($aPropField);
                $oFieldDesc->setFormElement($oSqlTypeInter->getFormElement());

                //PRIMARY KEY && AUTOINCREMENT
                if($aPropField['COLUMN_KEY'] === 'PRI'){
                    $oFieldDesc->setPrimaryKey(true);
                    if($aPropField['DATA_TYPE'] === VarType::INT){
                        $oFieldDesc->setMin(0)->setDefaultValue(0);
                        if($aPropField['EXTRA'] === 'auto_increment') $oFieldDesc->setAutoIncrement(true);
                        else $oFieldDesc->setAutoIncrement(false);
                    }
                }
                //NULLABLE
                if($aPropField['IS_NULLABLE'] === 'YES') $oFieldDesc->setNullable(true);
                else $oFieldDesc->setNullable(false);

                //DEFAULT VALUE
                if($aPropField['COLUMN_DEFAULT']){
                    if($aPropField['COLUMN_DEFAULT'] === 'NULL') $oFieldDesc->setDefaultValue(null);
                    else if($aPropField['DATA_TYPE'] === VarType::INT){
                        $oFieldDesc->setDefaultValue(intval($aPropField['COLUMN_DEFAULT']));
                    }else $oFieldDesc->setDefaultValue(htmlspecialchars($aPropField['COLUMN_DEFAULT']));
                }
                //STRING LENGHT MAX
                if($aPropField['DATA_TYPE'] === VarType::STRING && $aPropField['CHARACTER_MAXIMUM_LENGTH']){
                    $oFieldDesc->setMaxLength(intval($aPropField['CHARACTER_MAXIMUM_LENGTH']));
                    $oFieldDesc->setMinLength(0);
                }
                $aFieldDesc[] = $oFieldDesc;
            }

            $oTable = new TableBdd($sTable);
            $oTable->setFields($aFieldDesc);
            $aTable[] = $oTable;
        }

        $oProject = new ProjectTableBdd($this->getNameProject(), $this->getPathFolder());
        $oProject->setTablesBdd($aTable);
        $this->setProject($oProject);
    }
}