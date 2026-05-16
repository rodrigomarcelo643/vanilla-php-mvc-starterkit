# Prompt: Scaffold Feature

Use this prompt to ask an agent to scaffold a complete feature.

---

**Template:**

> Scaffold a new `{FeatureName}` feature for the Starter Kit project.
>
> - Panel: `{admin | app | client}`
> - Route: `GET {route-path}`
> - Controller: `{FeatureName}Controller` with a `index()` method
> - View: `app/views/{panel}/{feature}.php` using the `{panel}` layout
> - Add the route to `routes/web/{panel}.php`
>
> Follow the project conventions in `.agent/context/project.md`.
> Keep the controller thin — any DB logic goes in a model.

---

**Example:**

> Scaffold a new `Invoice` feature for the Starter Kit project.
>
> - Panel: `admin`
> - Route: `GET admin/invoices`
> - Controller: `InvoiceController` with an `index()` method
> - View: `app/views/admin/invoices.php` using the admin layout
> - Add the route to `routes/web/admin.php`
