# Prompt: Debug & Review

Use this prompt to ask an agent to debug or review a file.

---

**Review a controller:**

> Review `app/controllers/{ControllerName}.php` in the Starter Kit project.
> Check for: thin controller pattern, proper use of `Router::json()` for AJAX,
> `Router::redirect()` for redirects, input sanitization, and no hardcoded credentials.
> Reference `.agent/context/project.md` for conventions.

---

**Debug a route not found:**

> The route `{METHOD} {uri}` is returning a 404 in the Starter Kit.
> Check `routes/web/{file}.php` to confirm the route is registered.
> Check `app/core/Router.php` `parseUri()` to confirm URI parsing.
> Check `BASE_URL` in `.env` matches the subfolder path.

---

**Debug a blank page / view error:**

> The view `app/views/{panel}/{view}.php` is rendering blank.
> Check the controller is calling `$this->{panel}('{panel}/{view}', $data)`.
> Check the layout files exist: `app/views/layouts/{panel}/header.php` and `footer.php`.
> Check `extract($data)` variables are correctly passed.
