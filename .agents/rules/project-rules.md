# Project Rules

## 1. Language (English Only)
- Everything must be written in English.
- **Code**: Class names, method/function names, variables, constants, docblocks, and comments must all be in English.
- **User Interface (UI)**: All views, Blade templates, forms, labels, buttons, navigation items, messages, error messages, toast/flash alerts, and placeholder text must be in English.

## 2. Controllers
- Whenever creating a controller, always use the `--resource` flag:
  ```bash
  php artisan make:controller <Name>Controller --resource
  ```

## 3. Variable Naming
- All variables (PHP, JavaScript, Blade, etc.) must strictly use `camelCase`:
  - Examples: `$userData`, `$totalPrice`, `$orderItemCount`, `$isPublished`
  - Do not use `snake_case` or `PascalCase` for variables.
