<?php

namespace App\Controllers;
use App\Models\TarefasModel;
use App\Models\StatusModel;

class PagesController extends BaseController
{
    private ?array $data;

    private function getStatusList()
    {
        $statusModel = \model(StatusModel::class);
        $this->data['status'] = $statusModel->index();
    }

    public function index()
    {
        if (! is_file(APPPATH . 'Views/tarefas.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tarefas');
        };
        
        $statusID = filter_input(\INPUT_GET, 'status', \FILTER_SANITIZE_NUMBER_INT);

        $model = \model(TarefasModel::class);
        $this->data['tarefas'] = $model->getTarefas($statusID);
        $this->data['statusID'] = $statusID;
        $this->getStatusList();
        return view('Views/templates/header') . view('Views/tarefas', $this->data) . view('Views/templates/footer');
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post' && $this->validate(
            ['descricao' => 'required'])) {

            $model = model(TarefasModel::class);
            $model->save(['descricao' => $this->request->getPost('descricao'), 'status_id' => 1]);
            return redirect()->to('/');
        }
    }

    public function delete()
    {
        $id = filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $model = \model(TarefasModel::class);
        $model->deleteTarefa($id);
        return redirect()->to('/');
    }

    public function update()
    {
        $id = filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $model = \model(TarefasModel::class);
        $model->updateTarefa($id);
        return redirect()->to('/');
    }

    public function editar()
    {
        if ($this->request->getMethod() === 'post' && $this->validate(['editText' => 'required'])) {
            $id = filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);
            $txt = $this->request->getPost('editText');
            $model = \model(TarefasModel::class);
            $model->editTarefa($id, $txt);
            return redirect()->to('/');
        }
    }

    public function refazer()
    {
        $id = filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $model = \model(TarefasModel::class);
        $model->refazer($id);
        return redirect()->to('/?status=2');
    }

    public function restaurar()
    {
        $id = filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $model = \model(TarefasModel::class);
        $model->refazer($id);
        return redirect()->to('/?status=3');
    }

    public function concluirTodas()
    {
        $model = \model(TarefasModel::class);
        $model->concluirTodos();
        return redirect()->to('/');
    }

    public function deletarTodas()
    {
        $model = \model(TarefasModel::class);
        $model->deleteTodos();
        return redirect()->to('/');
    }
}
