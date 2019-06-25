<?php

/**
 * Controlle principal OpencartML 
 * Versão 1.1
 * Situação: Production
 * Autor / Flavio Lima  bhlims2 gmail com
 * Alterado por Flavio Lima  bhlima/gmail/com
 * Alterado por Thiago Guelfi  thiagovalentoni@gmail.com
 */
class ModelExtensionModuleOpencartml extends Model {

    public $result;

    /**
     * GetToken
     * @return type array() = Ultimo registro do banco de dados
     */
    public function GetToken() {

        //$lastid = $this->db->getLastId('oc_ml_token');
        $result = $this->db->query("SELECT MAX(ID) FROM " . DB_PREFIX . "ml_token");
        $lastid = $result->row;
        $id_query = $lastid['MAX(ID)'];
        $sql = "SELECT * FROM `" . DB_PREFIX . "ml_token` WHERE id = '" . (int) $id_query . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    /**
     * PutToken
     * Grava o ultimo registro do token
     * @return type array()
     */
    public function PutToken($access_token, $refresh_token, $expires_in, $user_id, $scope, $token_type) {
        if (!empty($access_token) && !empty($expires_in)) {
            $query = "INSERT INTO `" . DB_PREFIX . "ml_token` (`access_token`, `refresh_token`, `expires_in`, `user_id`, `scope`, `token_type`) 
                VALUES ('" . $this->db->escape($access_token) . "','" . $this->db->escape($refresh_token) . "','" . $this->db->escape($expires_in) . "','" . $this->db->escape($user_id) . "','" . $this->db->escape($scope) . "','" . $this->db->escape($token_type) . "')";
            $this->db->query($query);
        }
        return;
    }

}
