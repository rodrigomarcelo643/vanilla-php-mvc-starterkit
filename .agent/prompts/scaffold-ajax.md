# Prompt: Scaffold AJAX Endpoint

Use this prompt to ask an agent to add a new AJAX POST endpoint.

---

**Template:**

> Add a new AJAX endpoint to the Starter Kit.
>
> - Route: `POST ajax/{endpoint-name}`
> - Controller: `{ControllerName}` — method `ajax{ActionName}()`
> - Expected request: JSON or form POST with fields: `{field1}`, `{field2}`
> - Success response: `Router::json(['success' => true, 'message' => '...'])`
> - Error response: `Router::json(['success' => false, 'message' => '...'], 422)`
>
> Add the route to `routes/web/ajax.php`.
> Validate all inputs before processing. Follow `.agent/context/project.md`.

---

**Example:**

> Add a new AJAX endpoint to the Starter Kit.
> Route: `POST ajax/update-profile`
> Controller: `ProfileController` — method `ajaxUpdateProfile()`
> Fields: `name`, `email`
> Return success/error JSON responses.
