## README 

````md
# INF781 – Práctica 4

## CAPTCHA alternativo con Cloudflare Turnstile

Proyecto desarrollado en Laravel 13 utilizando Cloudflare Turnstile como mecanismo CAPTCHA alternativo.

---

# Requisitos

- PHP 8.3+
- Composer
- Node.js
- PostgreSQL
- Cuenta Cloudflare

---

# Instalación

```bash
git clone https://github.com/usuario/INF781-Tarea4-Apellido.git

cd INF781-Tarea4-Apellido

composer install

npm install
npm run build

cp .env.example .env

php artisan key:generate
````

Configurar PostgreSQL y variables Turnstile.

```bash
php artisan migrate
```

---

# Ejecutar

```bash
php artisan serve
```

Formulario protegido:

```text
http://127.0.0.1:8000/login
```

---

# Ejecutar pruebas

```bash
php artisan test
```

---

# Decisiones de diseño

Elegí Cloudflare Turnstile porque es gratuito y tiene mejor enfoque de privacidad comparado con Google reCAPTCHA. Además, la integración con Laravel es sencilla y permite implementar validación server-side limpia mediante una Rule personalizada.

La validación del lado servidor se implementó usando Laravel HTTP Client, enviando el token generado por el widget al endpoint oficial de Cloudflare.

Se utilizó una Rule separada para mantener el controlador limpio y cumplir principios de responsabilidad única.

Las claves se almacenaron únicamente en .env para evitar exposición de secretos.

Las pruebas automatizadas usan Http::fake() para simular respuestas reales del proveedor sin depender de internet.

---

# Capturas

Agregar capturas en:

```text
/docs/screenshots/
```

* Login correcto
* CAPTCHA inválido
* Error de validación

---

# Autor

Mayra Alejandra

---

# Licencia

MIT

````

---

# 16. Comandos finales

```bash
git init

git add .

git commit -m "Practica 4 Turnstile"

git branch -M main

git remote add origin TU_REPOSITORIO

git push -u origin main
````

---

# 17. Explicación para la sustentación

Preguntas probables:

## ¿Dónde está la validación server-side?

En:

```text
app/Rules/TurnstileRule.php
```

## ¿Qué hace?

Envía el token del frontend al servidor de Cloudflare.

## ¿Qué pasa si el token es falso?

Cloudflare responde:

```json
{
  "success": false
}
```

Entonces Laravel rechaza el login.

## ¿Por qué no basta validar en frontend?

Porque un atacante puede saltarse JavaScript y enviar peticiones manuales.

## ¿Por qué usar .env?

Para evitar exponer secretos en GitHub.

---

# 18. Puntos importantes para sacar buena nota

✔ Laravel 13
✔ PostgreSQL
✔ Breeze
✔ CAPTCHA alternativo
✔ Validación server-side
✔ Rule separada
✔ Tests PHPUnit
✔ README completo
✔ Secretos en .env
✔ Código limpio
