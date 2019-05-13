<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function buscarProjeto () {
    $tabela      = 'proj_cadastro';
    $requestData = $_REQUEST;

    $usuario = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    $dataRows = array();

    try{
      $dataFiltered = $this->db->get_where($tabela)->num_rows(); 
      $totalFiltered = $dataFiltered; 

      $columns = 
        array(
          0 => 'vId',
          1 => 'vTitulo',
          2 => 'vStatus',
          3 => 'vPrivado',
          4 => 'vData',
          5 => ''
        );

      $ordem = '';
      foreach ($requestData['order'] as $key => $value) {
        if ($ordem != '') {
          $ordem .= ', ';
        }

        $ordem .= $columns[$value['column']].' '.$value['dir'];
      }

      if ($ordem != '') {
        $ordem = ' ORDER BY '.$ordem;
      }

      $sql = "SELECT P.PROJ_ID vId,
                   P.PROJ_TITULO vTitulo,
                   P.PROJ_DESCRICAO vDescricao,
                   CASE
                    WHEN P.PROJ_STATUS = 'A' THEN 'Ativo'
                    ELSE 'Inativo'
                   END vStatus,
                   CASE
                    WHEN P.PROJ_PRIVADO = 0 THEN 'Público'
                    ELSE 'Privado'
                   END vPrivado,
                   DATE_FORMAT(P.PROJ_DATACAD, '%d/%m/%Y %h:%i') vData,
                   (SELECT COUNT(C.PROJ_ID) FROM proj_participantes C WHERE C.PROJ_ID = P.PROJ_ID) vColab

            FROM proj_cadastro P

            WHERE P.USU_ID = $usuario 
              OR P.PROJ_ID IN 
                (SELECT C.PROJ_ID 
                FROM proj_participantes C 
                WHERE C.USU_ID = $usuario
                AND C.PAR_RESPONSAVEL = 'S') ;";

      if(!empty($requestData['search']['value']) ) {
        $sql = 
          $sql.
          " AND P.PROJ_TITULO LIKE '%".$requestData['search']['value']."%' 
            $ordem   
            LIMIT ".$requestData['start']." ,".$requestData['length'];

            $query = $this->db->query($sql);
            $totalFiltered = $query->num_rows();
      } else {
        $sql = 
          $sql.
          $ordem.
          " LIMIT ".$requestData['start']." ,".$requestData['length'];
                   
        $query = $this->db->query($sql);
      }

      foreach ($query->result() as $row) {
        $nestedData = array(); 

        $nestedData[] = $row->vId;
        $nestedData[] = '<strong>'.$row->vTitulo.'</strong>';
        $nestedData[] = $row->vStatus;
        $nestedData[] = $row->vPrivado;
        $nestedData[] = $row->vColab;
        $nestedData[] = "<a data-toggle='tooltip' 
                        title='Editar' 
                        class='fa fa-pencil-square-o text-default' 
                        aria-hidden='true' 
                        style='cursor: pointer; font-size: 20px;' 
                        onclick='projetos.carregaEdit(".$row->vId.");'>
                      </a>";

        $dataRows[] = $nestedData;
      }

      return array(
              "draw"                 => intval( $requestData['draw'] ),
              "iTotalDisplayRecords" => intval( $totalFiltered ), 
              "recordsTotal"         => intval( $dataFiltered ), 
              "recordsFiltered"      => intval( $totalFiltered ), 
              "data"                 => $dataRows
            );

      } catch(PDOException $e) { 
              echo 'Erro: ' . $e->getMessage();
      }           
  }

  public function salvarProjeto ($form, $participantes) {
    $id  = 0;
    $values = array();

    if (isset($form)) { 
      parse_str($form, $values); 

      try{
        $tabela = 'proj_cadastro';

        $edTitulo     = ($values['edTitulo'] != '')     ? $values['edTitulo'] : null;
        $edDescricao  = ($values['edDescricao'] != '')  ? $values['edDescricao'] : null;
        $cbPublico    = ($values['cbPublico'] != '')    ? $values['cbPublico'] : null;
        $cbStatus     = ($values['cbStatus'] != '')     ? $values['cbStatus'] : null;

        $dados = 
          array(
            'PROJ_TITULO'    => $edTitulo,
            'PROJ_DESCRICAO' => $edDescricao,
            'PROJ_PRIVADO'   => $cbPublico,
            'PROJ_STATUS'    => $cbStatus,
            'USU_ID'         => $this->session->userdata('logged_in_colabad')['sesColabad_vId']
          );

        if ($values['edEditar'] == 'S') {  
          $this->db->update($tabela, $dados, array("PROJ_ID" => $values['edCodigo']));
          $id = $this->db->affected_rows();

          $this->salvaParticipantes($values['edCodigo'], $participantes, 'S');
        } else {
          $this->db->insert($tabela, $dados);
          $id = $this->db->insert_id();
          $this->salvaParticipantes($id, $participantes, 'N');
        }

        return
          array(
            'result' => 'OK',
            'mensagem' => $id.' - '.$edTitulo
          );

      } catch(PDOException $e) { 
        return
          array(
            'result' => 'ERRO',
            'mensagem' => $e->getMessage()
          );
      }
    }
  }

  function salvaParticipantes($id, $participantes, $editar) {
    $tabela = 'proj_participantes';

    if ($editar == 'S') {
      $this->db->delete($tabela, array('PROJ_ID' => $id));
    }

    if ($participantes != null) {
      foreach ($participantes as $value) {
        $this->db->insert(
          $tabela, 
          array(
            'PROJ_ID'         => $id,
            'USU_ID'          => $value['cod'],
            'PAR_RESPONSAVEL' => $value['resp']
          )
        ); 
      }
    }
  }  

}
