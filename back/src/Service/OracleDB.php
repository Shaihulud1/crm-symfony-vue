<?php
namespace App\Service;


class OracleDB
{
    const ORNAME = "ouip_dev";
    const ORPASS = "T8y5ferY";
    const ORCONN = "91.194.16.45:21522/ORC2";
    const ORCHST = "AL32UTF8";

    private $oracle;
    private $userID;
    private $userName;
    
    public function __construct($userID, $userName)
    {
        $this->oracle = \oci_connect(self::ORNAME, self::ORPASS, self::ORCONN, self::ORCHST);
        $this->userID = $userID;
        $this->userName = $userName;
        $this->authUser();
    }

    public function authUser()
    {
        $sql = "BEGIN set_cont_man_user(:p_id_user, :p_user_name, null); END;";
        $sti = oci_parse($this->oracle, $sql);
        oci_bind_by_name($sti,':p_id_user', $this->userID, -1);
        oci_bind_by_name($sti,':p_user_name', $this->userName, -1);
        oci_execute($sti);
    }

    public function getGammas()
    {
        $sql = "SELECT ID_GAMMA, GAMMA_NAME, ID_BR  FROM v_gamma ORDER BY GAMMA_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[$result['ID_GAMMA']] = [
                'id' => $result['ID_GAMMA'],
                'name' => $result['GAMMA_NAME'],
                'idBrand' => $result['ID_BR'],
            ];
        }
        return $res;
    }

    public function getBrands()
    {
        $sql = "SELECT ID_BR, BRAND_NAME FROM v_brand ORDER BY BRAND_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[$result['ID_BR']] = [
                'id' => $result['ID_BR'],
                'name' => $result['BRAND_NAME'],
            ];
        }
        return $res;
    }

    public function getSubSections()
    {
        $sql = "SELECT ID_SUBSEC, ID_SECTION, SUBSEC_NAME FROM v_subsection ORDER BY SUBSEC_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[$result['ID_SUBSEC']] = [
                'id' => $result['ID_SUBSEC'],
                'name' => $result['SUBSEC_NAME'],
                'idSect' => $result['ID_SECTION'],
            ]; 
        }
        return $res;
    }

    public function getSections()
    {
        $sql = "SELECT ID_SECTION, SECTION_NAME FROM v_sections ORDER BY SECTION_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[$result['ID_SECTION']] = [
                'id' => $result['ID_SECTION'],
                'name' => $result['SECTION_NAME']
            ]; 
        }
        return $res;
    }


    public function test()
    {   
        $sql = "SELECT * FROM SUBSECTION";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        if ($result = oci_fetch_assoc($sti)) {
            // if(!$result['ID_GAMMA']){

                echo '<pre>';print_r($result);echo '</pre>';
            // }
        }
        die();
        //таблица: SECTIONS: ID_SECTION,  SECTION_NAME 
        //Таблица: SUBSECTION: ID_SUBSEC ID_SECTION SUBSEC_NAME
        //ID_BR, BRAND_NAME, 
        //ID_GAMMA, GAMMA_NAME, ID_BR
        
        die();
        return $res;
    }


}