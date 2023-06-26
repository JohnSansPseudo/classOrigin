<?php

namespace Describers;

class ProjectTableBdd
{
    /**
     * @var string
     */
    private string $nameProject;

    /**
     * @var TableBdd[]
     */
    private array $tableBdd;

    /**
     * @var string
     */
    private string $pathFolderCreate;

    /**
     * ProjectTableBdd constructor.
     * @param string $nameProject
     * @param string $pathFolderCreate
     */
    public function __construct(string $nameProject, string $pathFolderCreate)
    {
        $this->nameProject = $nameProject;
        $this->pathFolderCreate = $pathFolderCreate;
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
     * @return ProjectTableBdd
     */
    public function setNameProject(string $nameProject): ProjectTableBdd
    {
        $this->nameProject = $nameProject;
        return $this;
    }

    /**
     * @return TableBdd[]
     */
    public function getTableBdd(): array
    {
        return $this->tableBdd;
    }

    /**
     * @return string
     */
    public function getPathFolderCreate(): string
    {
        return $this->pathFolderCreate;
    }

    /**
     * @param string $pathFolderCreate
     * @return ProjectTableBdd
     */
    public function setPathFolderCreate(string $pathFolderCreate): ProjectTableBdd
    {
        $this->pathFolderCreate = $pathFolderCreate;
        return $this;
    }

    /**
     * @param TableBdd[] $aTables
     */
    public function setTablesBdd($aTables)
    {
        foreach($aTables as $oTable) { $this->setTableBdd($oTable); }
    }

    /**
     * @param TableBdd $oTable
     */
    public function setTableBdd($oTable)
    {
        $this->tableBdd[$oTable->getNameBdd()] = $oTable;
    }



    //Create folders ?
    //Create index
    //Create script
    //Faire des styles CSS déjà fournis
    //$sPath

}