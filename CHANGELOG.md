# Changelog

Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/lang/es/).

## [1.0.0] - 2025-11-04

### Añadido
- Lanzamiento inicial del plugin n8n Chat Widget
- Integración con la librería @n8n/chat vía CDN usando módulos ES6
- Página de configuración en el panel de administración de WordPress
- Soporte para modo flotante (window) y pantalla completa (fullscreen)
- Shortcode `[n8n_chat]` para insertar el chat en páginas
- Configuración de webhook de n8n Chat Trigger
- Soporte multiidioma: Español, Inglés, Alemán, Francés y Portugués
- Opción para mostrar/ocultar pantalla de bienvenida
- Mensajes de bienvenida personalizables
- **Título y subtítulo personalizables** (según documentación de n8n)
- **Placeholder del input personalizable** (según documentación de n8n)
- **Cargar sesión previa** - Mantener historial de conversaciones (según documentación de n8n)
- Estilos CSS responsivos con soporte para móviles
- Soporte para modo oscuro y alto contraste
- Soporte para navegación RTL (right-to-left)
- Funciones de sanitización y escape de datos siguiendo WPCS
- Documentación completa en readme.txt
- Enlace directo a configuración desde la página de plugins
- Cumplimiento con estándares PHPCS y WPCS
- Licencia GPL v2 para distribución en WordPress.org

### Seguridad
- Validación y sanitización de todas las entradas del usuario
- Uso de funciones de escape de WordPress para prevenir XSS
- Verificación de permisos de usuario en páginas de administración
- Prevención de acceso directo a archivos PHP

### Técnico
- Uso correcto de módulos ES6 con `type="module"`
- Importación dinámica de `createChat` desde @n8n/chat
- Configuración inyectada como `window.n8nChatConfig`
- Soporte completo para todas las opciones de la documentación oficial de n8n

## [1.1.0] - 2025-11-04

### Añadido
- **Sistema de build moderno con Vite**
  - Hot Module Replacement (HMR) para desarrollo
  - Build optimizado para producción
  - Minificación automática de JavaScript y CSS
  - Generación de archivos comprimidos (gzip y brotli)
  - Soporte para navegadores legacy con polyfills

- **Sass (SCSS) para estilos**
  - Estructura modular de archivos SCSS
  - Variables para fácil personalización
  - Mixins reutilizables
  - Organización en componentes

- **PostCSS para procesamiento de CSS**
  - Autoprefixer para compatibilidad de navegadores
  - PostCSS Preset Env para características modernas
  - CSSNano para minificación

- **Herramientas de desarrollo**
  - ESLint para linting de JavaScript
  - Prettier para formateo de código
  - EditorConfig para consistencia
  - .nvmrc para versión de Node.js

- **Documentación de desarrollo**
  - DEVELOPMENT.md con guía completa
  - Scripts npm documentados
  - Estructura de archivos explicada

### Cambiado
- JavaScript mejorado con mejor modularización
- Código refactorizado en funciones reutilizables
- API pública expuesta (`window.n8nChatWidget`)
- Eventos personalizados para integración

### Técnico
- Archivos fuente en `src/`
- Archivos compilados en `dist/`
- Soporte para modo desarrollo y producción
- Fallback a archivos legacy si no existe build

## [Unreleased]

### Planeado para futuras versiones
- Soporte para múltiples idiomas con archivos .po/.mo
- Personalización avanzada de colores y estilos mediante UI
- Múltiples widgets con diferentes configuraciones
- Estadísticas de uso del chat
- Integración con Google Analytics
- Opciones de posicionamiento personalizadas
- Soporte para páginas específicas (incluir/excluir páginas)
- Tests automatizados (Jest, Cypress)

---

Para ver el historial completo de cambios, visita el [repositorio en GitHub](https://github.com/alexcuadra/chat-for-n8n).

