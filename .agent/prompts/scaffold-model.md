# Prompt: Scaffold Model

Use this prompt to ask an agent to create a new model.

---

**Template:**

> Create a new `{ModelName}` model in `app/models/{ModelName}.php`.
>
> Table name: `{table_name}`
>
> Include these methods:
> - `all()` — fetch all rows
> - `find(int $id)` — fetch single row by id
> - `create(array $data)` — insert a new row
> - `update(int $id, array $data)` — update a row
> - `delete(int $id)` — delete a row
>
> Use PDO prepared statements. Follow conventions in `.agent/context/project.md`.

---

**Example:**

> Create a new `Invoice` model in `app/models/Invoice.php`.
> Table name: `invoices`
> Include: `all()`, `find(int $id)`, `create(array $data)`, `update(int $id, array $data)`, `delete(int $id)`
