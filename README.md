# Phalcon Tarefas API

API RESTful de gerenciamento de tarefas desenvolvida com PHP Phalcon 5 e PostgreSQL.

## Tecnologias

- PHP 8.3
- Phalcon 5.11
- PostgreSQL
- Arquitetura MVC

## Endpoints

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /tarefas | Lista todas as tarefas |
| GET | /tarefas/{id} | Busca tarefa por ID |
| POST | /tarefas | Cria nova tarefa |
| PUT | /tarefas/{id} | Atualiza tarefa |
| DELETE | /tarefas/{id} | Remove tarefa |

## Exemplo de uso

**Criar tarefa:**
```json
POST /tarefas
{
    "titulo": "Phalcon",
    "descricao": "Framework Phalcon",
    "status": "pendente"
}
```

**Atualizar status:**
```json
PUT /tarefas/1
{
    "status": "concluida"
}
```

## Como rodar

```bash
php -S localhost:8080 -t public
```