<?php

use Phalcon\Mvc\Model;

class Tarefa extends Model
{
    public ?int $id = null;
    public ?string $titulo = null;
    public ?string $descricao = null;
    public ?string $status = null;
    public ?string $criado_em = null;

    public function initialize(): void
    {
        $this->setSource('tarefas');
    }

    public function validation(): bool
    {
        if (empty($this->titulo)) {
            $this->appendMessage(
                new \Phalcon\Messages\Message('O título é obrigatório')
            );
            return false;
        }

        if (!in_array($this->status, ['pendente', 'concluida'])) {
            $this->appendMessage(
                new \Phalcon\Messages\Message('Status inválido')
            );
            return false;
        }

        return true;
    }
}