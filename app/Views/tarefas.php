<aside>
  <div>
    <div>
      <?= session()->getFlashdata('error') ?>
      <?= service('validation')->listErrors() ?>
      <form action="list" method="get">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-control">
            <?php
              foreach ($status as $key => $value) { 
                if ($value['id'] == $statusID) { ?>
                  <option value="<?=esc($value['id'])?>" selected><?=esc($value['status'])?></option>
              <?php  } else { ?>
                <option value="<?=esc($value['id'])?>"><?=esc($value['status'])?></option>
              <?php }; 
              }; ?>
          </select>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-danger">Buscar Tarefas</button>
        </div>
      </form>
    </div>
    <div>
      <form action="create" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="descricao" class="form-label">Tarefa:</label>
          <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-danger">Criar Tarefa</button>
        </div>
      </form>
    </div>
  </div>
</aside>
<main>
  <section>
    <div>
      <?php
        if (count($tarefas) > 0 && ($statusID == 1 || $statusID == null)) { ?>
          <h3>Lista de Tarefas a Fazer</h3>
          <div id="all" class="float-end">
            <button type="button" class="btn btn-warning flost-end" data-bs-toggle="modal" data-bs-target="#concluirTodasModal"><i class="fa-solid fa-check"></i> Concluir Todas</button>
            <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deletarTodasModal"><i class="fa-solid fa-trash-can"></i> Deletar Todas</button>
          </div>
          <table class="table table-hover table-bordered table-striped table-dark align-middle">
            <thead class="table-light">
              <tr class="text-center">
                <th scope="col">Tarefa</th>
                <th colspan="3">Ações</th>
              </tr>
            </thead>
            <tbody>
          <?php
            foreach ($tarefas as $key => $tarefa) { ?>
              <tr>
                <td><?=$tarefa['descricao']?></td>
                <td class="text-center">
                  <button type="button" value="<?=$tarefa['id']?>" id="editar" class="btn btn-outline-success acao" data-bs-toggle="modal" data-bs-target="#editarModal"><i class="fa-solid fa-pen"></i> Editar</button>
                  <button type="button" value="<?=$tarefa['id']?>" id="concluir" class="btn btn-outline-warning acao" data-bs-toggle="modal" data-bs-target="#concluirModal"><i class="fa-solid fa-check"></i> Concluir</button>
                  <button type="button" value="<?=$tarefa['id']?>" id="deletar" class="btn btn-outline-danger acao" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash-can"></i> Deletar</button>
                </td>
              </tr>
        <?php  }; ?>
          </tbody>
        </table>
        <?php } else if(count($tarefas) > 0 && ($statusID == 2)) { ?>
          <h3>Lista de Tarefas Feitas</h3>
          <table class="table table-hover table-borderless table-striped table-dark align-middle">
            <thead class="table-light">
              <tr class="text-center">
                <th scope="col">Tarefa</th>
                <th colspan="1">Ações</th>
              </tr>
            </thead>
            <tbody>
          <?php
            foreach ($tarefas as $key => $tarefa) { ?>
              <tr>
                <td><?=$tarefa['descricao']?></td>
                <td class="text-center">
                  <a href="refazer?id=<?=$tarefa['id']?>"> <button type="button" value="<?=$tarefa['id']?>" id="refazer" class="btn btn-outline-success acao" ><i class="fa-solid fa-recycle"></i> Refazer</button></a>
                </td>
              </tr>
        <?php  }; ?>
          </tbody>
        </table>
        <?php } else if(count($tarefas) > 0 && ($statusID == 3)){ ?>
          <h3>Lista de Tarefas Deletadas</h3>
          <table class="table table-hover table-borderless table-striped table-dark align-middle">
            <thead class="table-light">
              <tr class="text-center">
                <th scope="col">Tarefa</th>
                <th colspan="1">Ações</th>
              </tr>
            </thead>
            <tbody>
          <?php
            foreach ($tarefas as $key => $tarefa) { ?>
              <tr>
                <td><?=$tarefa['descricao']?></td>
                <td class="text-center">
                  <a href="restaurar?id=<?=$tarefa['id']?>"> <button type="button" value="<?=$tarefa['id']?>" id="restaurar" class="btn btn-outline-success acao" ><i class="fa-solid fa-trash-can-arrow-up"></i> Restaurar</button></a>
                </td>
              </tr>
        <?php  }; ?>
          </tbody>
        </table>
        <?php }; ?>          
    </div>
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
      <form method="post" id="editForm">
        <?= csrf_field() ?>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editarModalLabel">Editar Tarefa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <textarea name="editText" id="editText" cols="30" rows="10" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen"></i> Editar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal fade" id="concluirModal" tabindex="-1" aria-labelledby="concluirModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="concluirModalLabel">Concluir Tarefa</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Deseja realmente concluir a tarefa?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="concluir/?"></a>
            <a id="concluirLink"><button type="button" class="btn btn-warning"><i class="fa-solid fa-check"></i> Concluir</button></a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Deletar Tarefa</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Deseja realmente deletar a tarefa?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a id="delLink"><button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can" id="modalDeleteBtn"></i> Deletar</button></a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="concluirTodasModal" tabindex="-1" aria-labelledby="concluirTodasModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="concluirTodasModalLabel">Concluir Todas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Deseja realmente concluir todas as tarefas?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="concluirTodas"><button type="button" class="btn btn-warning"><i class="fa-solid fa-check"></i> Concluir Todas</button></a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="deletarTodasModal" tabindex="-1" aria-labelledby="deletarTodasModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deletarTodasModalLabel">Deletar Todas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Deseja realmente deletar todas as tarefas?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="deletarTodas"><button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Deletar Todas</button></a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>