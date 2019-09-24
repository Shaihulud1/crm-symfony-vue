<?php
namespace App\Service;


class OracleDB
{


    private $oracle;
    private $userID;
    private $userName;
    
    public function __construct(?Int $userID, ?String $userName)
    {

        $this->oracle = \oci_connect(self::ORNAME, self::ORPASS, self::ORCONN, self::ORCHST);
        $this->userID = $userID;
        $this->userName = $userName;
        $this->authUser();
    }

    public function authUser(): void
    {
        $sql = "BEGIN set_cont_man_user(:p_id_user, :p_user_name, null); END;";
        $sti = oci_parse($this->oracle, $sql);
        oci_bind_by_name($sti,':p_id_user', $this->userID, -1);
        oci_bind_by_name($sti,':p_user_name', $this->userName, -1);
        oci_execute($sti);
    }

    public function getDescriptByID(int $id): array
    {
        $sql = "SELECT ID_PPD, DESCR_NAME, DESCR, CONTRAIND, COMPOS, METHOD_USE, HOW_USE 
                    FROM v_pp_description WHERE ID_PPD = $id ORDER BY DESCR_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        if ($result = oci_fetch_assoc($sti)) {
            $res = [
                'id' => $result['ID_PPD'],
                'name' => $result['DESCR_NAME'],
                'detail' => $result['DESCR']->load(),
                'contra' => $result['CONTRAIND']->load(),
                'struct' => $result['COMPOS']->load(),
                'methoduse' => $result['METHOD_USE']->load(),
                'how_use' => $result['HOW_USE']->load(),
            ];
        }
        return $res;        
    }
    
    public function getDescripts(): array
    {   
        $sql = "SELECT ID_PPD, DESCR_NAME FROM v_pp_description ORDER BY DESCR_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        if ($result = oci_fetch_assoc($sti)) {
            $res[] = [
                'id' => $result['ID_PPD'],
                'name' => $result['DESCR_NAME'],
                // 'detail' => $result['DESCR']->load(),
                // 'contra' => $result['CONTRAIND']->load(),
                // 'struct' => $result['COMPOS']->load(),
                // 'methoduse' => $result['METHOD_USE']->load(),
                // 'how_use' => $result['HOW_USE']->load(),
            ];
        }
        return $res;
    }

    public function getGammas(): array
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

    public function getBrands(): array
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

    public function getSubSections(): array
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

    public function getSections(): array
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

    public function getForms(): array
    {
        $sql = "SELECT FORM_NAME, ID_FORM, FORM_SH_NAME FROM v_form ORDER BY FORM_NAME ASC";
        $sti = oci_parse($this->oracle, $sql);
        oci_execute($sti);
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[] = [
                'id' => $result['ID_FORM'],
                'name' => $result['FORM_NAME'],
                'shortName' => $result['FORM_SH_NAME'],
            ];   
        }
        return $res;
    }

    public function getPropsWithGroups(?Int $subsectID): Array
    {
        $sql = "SELECT ID_PROP, PROP_NAME, GRPR_NAME, ID_GRPR, ID_SUBSEC FROM v_subsec_group where id_subsec = $subsectID";
        $sti = oci_parse($this->oracle, $sql); 
        oci_execute($sti);       
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[] = [
                'id' => $result['ID_PROP'],
                'name' => $result['PROP_NAME'],
                'group' => $result['GRPR_NAME'],
                'groupID' => $result['ID_GRPR'],
                'subsection' => $result['ID_SUBSEC'],
                'isActive' => 'Да',
            ];
        } 
        return $res;  
    }

    public function getMnns()
    {
        $sql = "SELECT * FROM v_mnn_single";
        $sti = oci_parse($this->oracle, $sql); 
        oci_execute($sti); 
        $res = [];
        while ($result = oci_fetch_assoc($sti)) {
            $res[] = [
                'id' => $result['ID_MNNS'],
                'name' => $result['MNN_NAME'],
            ];
        }
        return $res;
    }


    public function test()
    {   
        $sql = "SELECT * FROM v_subsec_group";
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