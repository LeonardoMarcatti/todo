<?php

namespace App\Models;

use CodeIgniter\Model;

class TarefasModel extends Model
{
    protected $table = 'tarefas';
    protected $allowedFields = ['descricao', 'status_id'];

    public function getTarefas(int|null $status)
    {
      if ($status && $status != 1) {
        return $this->select(['descricao', 'id'])->where('status_id', $status)->orderBy('id', 'desc')->limit(10)->get()->getResultArray();
      }

      return $this->select(['descricao', 'id'])->where('status_id', 1)->get()->getResultArray();
    }

    public function deleteTarefa(int $id)
    {
      return $this->set('status_id', 3)->where('id', $id)->update();
    }

    public function updateTarefa(int $id)
    {
      return $this->set('status_id', 2)->where('id', $id)->update();
    }

    public function editTarefa(int $id, string $txt)
    {
      return $this->set('descricao', $txt)->where('id', $id)->update();
    }

    public function refazer(int $id)
    {
      return $this->set('status_id', 1)->where('id', $id)->update();
    }

    public function deleteTodos()
    {
      return $this->set('status_id', 3)->where('status_id', 1)->update();
    }

    public function concluirTodos()
    {
      return $this->set('status_id', 2)->where('status_id', 1)->update();
    }
}