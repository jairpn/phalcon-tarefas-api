<?php

use Phalcon\Mvc\Controller;

class TarefaController extends Controller
{
    // Listar todas as tarefas
    public function indexAction(): void
    {
        $tarefas = Tarefa::find();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($tarefas->toArray()));
        $this->response->send();
    }

    // Buscar tarefa por ID
    public function showAction(int $id): void
    {
        $tarefa = Tarefa::findFirstById($id);

        if (!$tarefa) {
            $this->response->setStatusCode(404, 'Not Found');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode(['erro' => 'Tarefa não encontrada']));
            $this->response->send();
            return;
        }

        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($tarefa->toArray()));
        $this->response->send();
    }

    // Criar nova tarefa
    public function createAction(): void
    {
        $dados = json_decode($this->request->getRawBody(), true);

        $tarefa = new Tarefa();
        $tarefa->titulo   = $dados['titulo']   ?? '';
        $tarefa->descricao = $dados['descricao'] ?? null;
        $tarefa->status   = $dados['status']   ?? 'pendente';

        if ($tarefa->save()) {
            $this->response->setStatusCode(201, 'Created');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode($tarefa->toArray()));
        } else {
            $erros = [];
            foreach ($tarefa->getMessages() as $msg) {
                $erros[] = $msg->getMessage();
            }
            $this->response->setStatusCode(422, 'Unprocessable Entity');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode(['erros' => $erros]));
        }

        $this->response->send();
    }

    // Atualizar tarefa
    public function updateAction(int $id): void
    {
        $tarefa = Tarefa::findFirstById($id);

        if (!$tarefa) {
            $this->response->setStatusCode(404, 'Not Found');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode(['erro' => 'Tarefa não encontrada']));
            $this->response->send();
            return;
        }

        $dados = json_decode($this->request->getRawBody(), true);

        $tarefa->titulo    = $dados['titulo']    ?? $tarefa->titulo;
        $tarefa->descricao = $dados['descricao'] ?? $tarefa->descricao;
        $tarefa->status    = $dados['status']    ?? $tarefa->status;

        if ($tarefa->save()) {
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode($tarefa->toArray()));
        } else {
            $erros = [];
            foreach ($tarefa->getMessages() as $msg) {
                $erros[] = $msg->getMessage();
            }
            $this->response->setStatusCode(422, 'Unprocessable Entity');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode(['erros' => $erros]));
        }

        $this->response->send();
    }

    // Remover tarefa
    public function deleteAction(int $id): void
    {
        $tarefa = Tarefa::findFirstById($id);

        if (!$tarefa) {
            $this->response->setStatusCode(404, 'Not Found');
            $this->response->setContentType('application/json', 'UTF-8');
            $this->response->setContent(json_encode(['erro' => 'Tarefa não encontrada']));
            $this->response->send();
            return;
        }

        $tarefa->delete();
        $this->response->setStatusCode(204, 'No Content');
        $this->response->send();
    }
}