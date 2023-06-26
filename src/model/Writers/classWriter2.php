<?php



try{
    $oPdo = new PDO('mysql:host=localhost;dbname=droit_licence', 'root', '');
}
catch(PDOException $e){

    echo $e->getMessage();
}


/*
 *
//select * from INFORMATION_SCHEMA.COLUMNS
$aData = $oPdo->query('select * from droit_typo_vte_contrat');

$aData = $oPdo->query('SELECT * FROM droit_typo_vte_contrat LIMIT 1', PDO::FETCH_CLASS, 'ContratBdd');

foreach($aData as $d)
{
    dbr($d);die('die');
}
*/

$aData = $oPdo->query('SELECT *
        FROM information_schema.columns
        WHERE table_schema="droit_licence"
        AND table_name="droit_typo_vte_contrat"');//, PDO::FETCH_OBJ

$aDataRem = array();
foreach($aData as $o) { $aDataRem[] = $o; }

//dbr($aDataRem);die();


$oClassWriterBdd = new ClassWriterBdd($aDataRem);

//dbr($oClassWriterBdd->getClassStrChild());die();


//TODO pour les éléments html est ce que j'écris une class qui écrit du code qui renvoie vers une class qui génère du html ou directement renvoie du html ??
// TODO Faire les param phpstorm dans les functions et les props ??
// TODO BRANCHER LA CLASS PARAM
// TODO FAIRE LA CLASSE HTML
// TODO FAIRE UNE CLASSE CONTROLLER et d'ailleur l'autre c'est modele !!
// TODO REVOIR LE MODELE MVC !! POUR CLASSE MODELE ET MODELES
// TODO VOIR LES EXPORTS ET DONC LES TYPE DE RETOUR
// TODO VOIR LES SOURCES (table bdd ?? ou objet)
// TODO POUR LES CLASSES VOIR POUR METTRE EN ABSTRAIT ET IMPLEMENTER ET OU MERE FILLE
// TODO VOIR POUR LA CORRESPONDANCE DES NOMs DE COLONNES SQL ET LES GETTER SETTER ET PROPS !!
// TODO LA FONCTION NE PEUT ETRE ABSTRACT SI ELLE N'EST PAS LA CLASS NE L'EST PAS !!
// TODO REVOIR LA CLASS FONCTION


class PhpWriter
{
    /**
     * @var string
     */
    const TAB = '    ';
    /**
     * @var string
     */
    const TAB2 = '        ';
    /**
     * @var string
     */
    const TAB3 = '            ';

    /**
     * @var string
     */

    const RETOUR = '</br>';
    /**
     * @var string
     */
    const RETOUR2 = '</br></br>';
}

class ElfWriter extends PhpWriter
{
    /**
     * @var
     */
    private function getInputHtml()
    {
        return '<input type="" class="" id="">';
    }

    public function getStrElf()
    {

    }
}

abstract class ClassWriter extends PhpWriter
{
    /**
     * @var string
     */
    private $sSuffixeClass;

    /**
     * @var boolean
     */
    private $bAbstract = false;

    /**
     * @var string
     */
    private $sExtends = '';

    /**
     * @var array
     */
    private $aImplements = array();

    /**
     * @return bool
     */
    public function getIsAbstract(): bool
    {
        return $this->bAbstract;
    }

    /**
     * @param bool $bAbstract
     * @return ClassWriter
     */
    public function setBoolAbstract(bool $bAbstract): ClassWriter
    {
        $this->bAbstract = $bAbstract;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrExtends(): string
    {
        return $this->sExtends;
    }

    /**
     * @param string $sExtends
     * @return ClassWriter
     */
    public function setStrExtends(string $sExtends): ClassWriter
    {
        $this->sExtends = $sExtends;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrImplements(): array
    {
        return $this->aImplements;
    }

    /**
     * @param string $aImplements
     * @return ClassWriter
     */
    public function setArrImplements(array $aImplements): ClassWriter
    {
        $this->aImplements = $aImplements;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuffixeClass()
    {
        return $this->sSuffixeClass;
    }

    /**
     * @param string $suffixeClass
     * @return ClassWriter
     */
    public function setSuffixeClass($sSuffixeClass)
    {
        $this->sSuffixeClass = $sSuffixeClass;
        return $this;
    }


    /** @var array * */
    private $_aDataTable = array();

    /** @return array */
    public function getDataTable(){ return $this->_aDataTable; }

    /**
     * @param array $aData
     * @return static
     */
    public function setDataTable($aData) { $this->_aDataTable = $aData; return $this; }

    /**
     * @param array $aDataTable
     * @param boolean $bAbstract
     * @param string $sExtends
     * @param array $aImplements
     */
    public function __construct($aDataTable, $bAbstract=false, $sExtends='', $aImplements=array())
    {
        $this->setDataTable($aDataTable)->setBoolAbstract($bAbstract)->setStrExtends($sExtends)->setArrImplements($aImplements);
    }

    /**
     * @return string
     */
    private function getStrAbstract()
    {
        return $this->getIsAbstract() ? 'abstract ' : '';
    }

    private function getStrImplements()
    {
        if(count($this->getArrImplements()) < 1) return '';
        else return ' implements ' . implode(' ', $this->getArrImplements());
    }


    /**
     * @param $sClassName
     * @param $sContent
     * @return string
     */
    protected function getClassStr($sClassName, $sContent)
    {
        $s =  $this->getStrAbstract() . 'Class ' . $sClassName . ' ' . $this->getStrExtends() . ' ' . $this->getStrImplements() . self::RETOUR;
        $s .= '{' . self::RETOUR;
        $s .=       $sContent;
        $s .= '}' . self::RETOUR;
        return $s;
    }
    abstract public function getClassStrChild();

    public function getTypePhpByTypeSql($sTypeSql)
    {
        $aTypeSqlToPhp = array(
            'varchar' => 'string',
            'enum' => 'string',
            'text' => 'string',
            'date' => 'string',
            'datetime' => 'string',
            'timestamp' => 'int',
            'tinyint' => 'int',
            'smallint' => 'int',
            'mediumint' => 'int',
            'int' => 'int',
            'bigint' => 'int',
            'float' => 'float',
            'double' => 'float',
        );

        if(isset($aTypeSqlToPhp[$sTypeSql])) return $aTypeSqlToPhp[$sTypeSql];
        throw New Exception('Error $sTypeSql from not recognize');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getStrRowClassInstance()
    {
        return self::TAB . 'static public function getInstance() { return new ' . $this->getClassName() . '(); }' . self::RETOUR2;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getTableName()
    {
        $aData = $this->getDataTable();
        if(isset($aData[0]['TABLE_NAME'])) return $aData[0]['TABLE_NAME'];
        else throw new Exception('Error getting table name, empty array ??');
    }

    /**
     * @param string
     * @return string
     * @throws Exception
     */
    public function getClassName()
    {
        $sTable = $this->getTableName();

        $aNameTable = explode('_', $sTable);
        return join('', array_map('ucfirst', $aNameTable)) . static::getSuffixeClass();
    }
}

class ClassWriterHtml extends ClassWriter
{
    /**
     * @param array $aData
     */
    public function __construct($aDataTable)
    {
        $this->setDataTable($aDataTable);
        $this->setSuffixeClass('Html');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getClassStrChild()
    {
        $s = $this->getProps();
        $s .= $this->getGetters();
        $s .= $this->getSetters();
        $s .= $this->getStrRowConstTable();
        $s .= $this->getStrRowClassInstance();
        $s .= $this->getFunctionAdd();
        $s .= $this->getFunctionUpdate();
        $s .= $this->getFunctionGetAll();
        $s .= $this->getFunctionHydrate();
        $s .= $this->getFunctionToArray();
        $s .= $this->getFunctionDelete();
        return $this->getClassStr($this->getClassName(), $s);
    }

}

class ClassWriterBdd extends ClassWriter
{
    /**
     * @param array $aData
     */
    public function __construct($aDataTable)
    {
        $this->setDataTable($aDataTable);
        $this->setSuffixeClass('Bdd');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getClassStrChild()
    {
        $s = $this->getProps();
        $s .= $this->getGetters();
        $s .= $this->getSetters();
        $s .= $this->getStrRowConstTable();
        $s .= $this->getStrRowClassInstance();
        $s .= $this->getFunctionAdd();
        $s .= $this->getFunctionUpdate();
        $s .= $this->getFunctionGetAll();
        $s .= $this->getFunctionHydrate();
        $s .= $this->getFunctionToArray();
        $s .= $this->getFunctionDelete();
        return $this->getClassStr($this->getClassName(), $s);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getStrRowConstTable()
    {
        return self::TAB . "const sTable='" . $this->getTableName() . "';" . self::RETOUR2;
    }

    //PROPS GETTERS SETTERS TYPE HYDRATE TOARRAY
    /**
     * @return string
     * @throws Exception
     */
    public function getProps()
    {
        $sProps = '';
        foreach($this->getDataTable() as $aData){
            $sProps .= self::TAB . "/**" . self::RETOUR;
            $sProps .= self::TAB . '* @var ' . $this->getTypePhpByTypeSql($aData['DATA_TYPE']) . self::RETOUR;
            $sProps .= self::TAB . '*/' . self::RETOUR;
            $sProps .= self::TAB . 'private $' . $aData['COLUMN_NAME'] . ';'. self::RETOUR;
        }
        $sProps .= self::RETOUR;
        return $sProps;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getGetters()
    {
        $sGetters = '';
        foreach($this->getDataTable() as $aData){
            $sColName = $aData['COLUMN_NAME'];
            $sGetters .= self::TAB . 'public function ' . $this->getSetterFuncName($sColName) . '(){ return $this->' . $sColName . '(); }' . self::RETOUR;
        }
        $sGetters .= self::RETOUR;
        return $sGetters;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSetters()
    {
        //TODO RENVOYER AU CHECK PARAM DES CLASS POUR CHAQUE TYPE
        $sSetters = '';
        foreach($this->getDataTable() as $aData){
            $sColName = $aData['COLUMN_NAME'];
            $sVarName = '$' . $sColName;
            $sSetters .= self::TAB . 'public function ' . $this->getGetterFuncName($sColName) . '(' . $sVarName . ') { $this->' . $this->getPropName($sColName) . ' = ' . $sVarName . '; return $this; }' . self::RETOUR;
        }
        $sSetters .= self::RETOUR;
        return $sSetters;

    }

    /**
     * @return string
     */
    public function getPropName($sCOLUMN_NAME)
    {
        return $sCOLUMN_NAME;
    }

    /**
     * @return string
     */
    public function getSetterFuncName($sCOLUMN_NAME)
    {
        return 'set' . ucfirst($sCOLUMN_NAME);
    }

    /**
     * @return string
     */
    public function getGetterFuncName($sCOLUMN_NAME)
    {
        return 'get' . ucfirst($sCOLUMN_NAME);
    }

    /**
     * @return string
     */
    public function getFunctionHydrate()
    {
        $sContent = '';
        foreach($this->getDataTable() as $aData){
            $sColName = $aData['COLUMN_NAME'];
            $sVarName = '$' . $sColName;
            $sContent .= self::TAB2 . '$this->' . $this->getSetterFuncName($sColName) . '($oData->' . $sColName . ');' . self::RETOUR;
        }
        $sContent .= self::TAB2 . 'return $this;';

        $oWriter = new FunctionWriter('hydrate', '$oData', $sContent);
        return $oWriter->getFunctionStr();
    }

    /**
     * @return string
     */
    public function getFunctionToArray()
    {
        $sContent = self::TAB2 . '$aData = array();' . self::RETOUR;
        foreach($this->getDataTable() as $aData){
            $sColName = $aData['COLUMN_NAME'];
            $sContent .= self::TAB2 . "\$aData['" . $sColName . "'] = \$this->" . $this->getGetterFuncName($sColName) . "();" . self::RETOUR;
        }
        $sContent .= self::TAB2 . 'return $this;';
        $oWriter = new FunctionWriter('toArray', '$aData', $sContent);
        return $oWriter->getFunctionStr();
    }

    //FIN PROPS GETTERS SETTERS TYPE HYDRATE TOARRAY

    //DEBUT FUNCTION
    /**
     * @return string
     */
    public function getFunctionGetAll()
    {
        $sContent = self::TAB2 . "\$aData = \RS::\$BDD->select('*', self::sTable, \$sWhere, ' ORDER BY categorie, libelle');" . self::RETOUR;
        $sContent .= self::TAB2 . "\$aDataRem = array();" . self::RETOUR;
        $sContent .= self::TAB2 . "foreach(\$aData as \$oData)" . self::RETOUR;
        $sContent .= self::TAB2 . '{' . self::RETOUR;
        $sContent .= self::TAB3 . "\$aDataRem[\$oData->id] = self::getInstance()->hydrate(\$oData);" . self::RETOUR;
        $sContent .= self::TAB2 . '}' . self::RETOUR;
        $sContent .= self::TAB2 . "return \$aDataRem;";
        $oWriter = new FunctionWriter('getAll', '$sWhere=null', $sContent);
        return $oWriter->getFunctionStr();
    }

    /**
     * @return string
     */
    public function getFunctionAdd()
    {
        //Rajouter un log auto ??
        //Rajouter un mail auto ??
        $sContent = self::TAB2 . "\$id = \RS::\$BDD->insert(self::sTable, \$this->toArray());" . self::RETOUR;
        $sContent .= self::TAB2 . "if(!\$id) throw New Exception('Error insert "  . $this->getClassName('bdd') . "');" . self::RETOUR;
        $sContent .= self::TAB2 . "return \$this->setId(\$id);";

        $oWriter = new FunctionWriter('insert', '', $sContent);
        return $oWriter->getFunctionStr();
    }

    /**
     * @return string
     */
    public function getFunctionUpdate()
    {
        //Rajouter un log auto ??
        //Rajouter un mail auto ??
        $sContent = self::TAB2 . "\$bUp = \RS::\$BDD->update(self::sTable, \$aData, ' id=' . echap_sql(\$id));" . self::RETOUR;
        $sContent .= self::TAB2 . "if(!\$bUp) throw New Exception('Error update "  . $this->getClassName('bdd') . "');" . self::RETOUR;
        $sContent .= self::TAB2 . "return \$this;";
        $oWriter = new FunctionWriter('update', '$aData, $id', $sContent);
        return $oWriter->getFunctionStr();
    }

    /**
     * @return string
     */
    public function getFunctionDelete()
    {
        //Rajouter un log auto ??
        //Rajouter un mail auto ??
        $sContent = self::TAB2 . "return \RS::\$BDD->delete(self::sTable, ' id=' . echap_sql(\$id) );";

        $oWriter = new FunctionWriter('delete', '$id', $sContent);
        return $oWriter->getFunctionStr();
    }

    //FIN FUNCTION
}

class FunctionWriter extends PhpWriter
{
    /**
     * @var string
     */
    private $_sVisibility;

    /**
     * @var string
     */
    private $_sAbstract;

    /**
     * @var string
     */
    private $_sStatic;

    /**
     * @var string
     */
    private $_sContent;
    /**
     * @var string
     */
    private $_sName;

    /**
     * @var string
     */
    private $_sParam;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->_sContent;
    }

    /**
     * @param string $sContent
     * @return FunctionWriter
     */
    public function setContent(string $sContent): FunctionWriter
    {
        $this->_sContent = $sContent;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_sName;
    }

    /**
     * @param string $sName
     * @return FunctionWriter
     */
    public function setName(string $sName): FunctionWriter
    {
        $this->_sName = $sName;
        return $this;
    }

    /**
     * @return string
     */
    public function getParam(): string { return $this->_sParam; }

    /**
     * @param string $sParam
     * @return FunctionWriter
     */
    public function setParam(string $sParam): FunctionWriter
    {
        $this->_sParam = $sParam;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->_sVisibility;
    }

    /**
     * @param string $sVisibility
     * @return FunctionWriter
     */
    public function setVisibility(string $sVisibility): FunctionWriter
    {
        $this->_sVisibility = $sVisibility;
        return $this;
    }

    /**
     * @return string
     */
    public function getAbstract(): string
    {
        return $this->_sAbstract;
    }

    /**
     * @param string $sAbstract
     * @return FunctionWriter
     */
    public function setAbstract(string $sAbstract): FunctionWriter
    {
        $this->_sAbstract = $sAbstract;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatic(): string
    {
        return $this->_sStatic;
    }

    /**
     * @param string $sStatic
     * @return FunctionWriter
     */
    public function setStatic(string $sStatic): FunctionWriter
    {
        $this->_sStatic = $sStatic;
        return $this;
    }

    /**
     * @param string $sFuncName
     * @param string $sParam
     * @param string $sContent
     * @param string $sAbstract
     * @param string $sStatic
     * @param string $sVisibility
     */
    public function __construct($sFuncName, $sParam, $sContent, $sAbstract= '', $sStatic='', $sVisibility='public')
    {
        return $this->setName($sFuncName)
            ->setParam($sParam)
            ->setContent($sContent)
            ->setAbstract($sAbstract)
            ->setStatic($sStatic)
            ->setVisibility($sVisibility);
    }

    /**
     * @return string
     */
    public function getFunctionStr()
    {
        $s = self::TAB . $this->getStatic() . $this->getAbstract() . $this->getVisibility() . ' function ' . $this->getName() . '(' . $this->getParam() . ')' . self::RETOUR;
        $s .= self::TAB . '{' . self::RETOUR;
        $s .= $this->getContent() . self::RETOUR;
        $s .= self::TAB . '}' . self::RETOUR2;
        return $s;
    }
}

class ParamWriter
{
    /**
     * @var null | array
     */
    private $_mDefautValue;

    /**
     * @var string
     */
    private $_sName;

    /**
     * @return array|null
     */
    public function getDefautValue(): ?array
    {
        return $this->_mDefautValue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_sName;
    }

    /**
     * @param string $sName
     * @return ParamWriter
     */
    public function setName(string $sName): ParamWriter
    {
        $this->_sName = $sName;
        return $this;
    }



    /**
     * @param array|null $mDefautValue
     * @return ParamWriter
     */
    public function setDefautValue(?array $mDefautValue): ParamWriter
    {
        $this->_mDefautValue = $mDefautValue;
        return $this;
    }



    public function __constructor($sName, $mDefautValue=null)
    {
        $this->setDefautValue($mDefautValue)->setName($sName);
    }

    public function getStrParam()
    {
        $sParam = '$' . $this->getName();
    }

}