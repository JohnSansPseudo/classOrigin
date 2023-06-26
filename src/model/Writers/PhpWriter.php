<?php


namespace Writer;


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

    /**
     * @param string $sName
     * @return string
     */
    static public function getVarName(string $sName)
    {
        return '$' . $sName;
    }
}