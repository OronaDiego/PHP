# 🎬 Marvel Next Release – PHP App

Aplicación web desarrollada en **PHP** que consume una **API externa** para mostrar información sobre la próxima película del Universo Cinematográfico de Marvel (MCU).

El proyecto está optimizado para ejecutarse en **hosting compartido**, implementando **cache por archivo** para mejorar performance y reducir llamadas innecesarias a la API.

---

## 🚀 Funcionalidades

- Consulta a API externa (`whenisthenextmcufilm.com`)
- Muestra:
  - Título de la próxima película
  - Fecha de estreno
  - Días restantes para el estreno
  - Póster oficial
  - Siguiente producción anunciada
- Cache por archivo para optimizar consumo de recursos
- Manejo de errores en llamadas HTTP
- Compatible con hosting compartido (Hostinger)

---

## 🧰 Tecnologías utilizadas

- **PHP 8+**
- **cURL**
- **JSON**
- **HTML5**
- **CSS (Pico.css vía CDN)**

---

## 🧠 Decisiones técnicas destacadas

### 📦 Cache por archivo
Para evitar realizar una llamada a la API en cada request, se implementó un sistema de cache simple basado en archivos:

- Cache almacenado en `cache/marvel.json`
- Tiempo de expiración: **1 hora**
- Si la API falla, se utiliza el último cache válido
- Ideal para entornos de bajo consumo como hosting compartido

```php
$cacheTime = 3600; // 1 hora
