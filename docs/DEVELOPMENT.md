# Guía de Desarrollo - n8n Chat Widget

Esta guía explica cómo configurar el entorno de desarrollo y trabajar con el sistema de build del plugin.

## 🚀 Inicio Rápido

### Requisitos Previos

- Node.js >= 18.0.0
- npm >= 9.0.0
- WordPress 5.8+
- PHP 7.4+

### Instalación

```bash
# 1. Clonar o navegar al directorio del plugin
cd wp-content/plugins/chat-for-n8n

# 2. Instalar dependencias
npm install

# 3. Construir archivos para producción
npm run build
```

## 📦 Scripts Disponibles

### Desarrollo

```bash
# Modo desarrollo con hot-reload (puerto 3000)
npm run dev
```

Este comando:
- Inicia el servidor de desarrollo de Vite
- Activa hot module replacement (HMR)
- No minifica el código
- Genera source maps

### Build de Producción

```bash
# Construir archivos optimizados para producción
npm run build
```

Este comando:
- Compila todos los archivos de `src/` a `dist/`
- Minifica JavaScript y CSS
- Genera archivos comprimidos (.gz y .br)
- Optimiza para navegadores compatibles

### Modo Watch

```bash
# Construir automáticamente cuando cambien los archivos
npm run watch
```

Útil cuando estás desarrollando y quieres ver los cambios en tiempo real sin el servidor de desarrollo.

### Preview

```bash
# Vista previa del build de producción (puerto 3001)
npm run preview
```

## 📁 Estructura de Archivos

```
chat-for-n8n/
├── src/                          # Código fuente
│   ├── js/
│   │   └── main.js              # JavaScript principal
│   └── scss/
│       ├── main.scss            # SCSS principal
│       ├── _variables.scss      # Variables SCSS
│       ├── _mixins.scss         # Mixins SCSS
│       ├── _base.scss           # Estilos base
│       ├── _container.scss      # Estilos del contenedor
│       ├── _window-mode.scss    # Estilos modo ventana
│       └── _accessibility.scss  # Estilos de accesibilidad
├── dist/                         # Archivos compilados (generados)
│   ├── main.js                  # JavaScript compilado
│   ├── chat-for-n8n.css         # CSS compilado
│   ├── *.gz                     # Archivos comprimidos gzip
│   └── *.br                     # Archivos comprimidos brotli
├── chat-for-n8n.php             # Archivo principal del plugin
├── chat-for-n8n.js              # JavaScript legacy (fallback)
├── chat-for-n8n.css             # CSS legacy (fallback)
├── vite.config.js               # Configuración de Vite
├── postcss.config.js            # Configuración de PostCSS
├── package.json                 # Dependencias y scripts
└── README.md                    # Documentación del usuario
```

## 🛠️ Tecnologías

### Vite

Build tool moderno y rápido que proporciona:
- Hot Module Replacement (HMR)
- Build optimizado
- Soporte para módulos ES6
- Plugins extensibles

### Sass (SCSS)

Preprocesador CSS con:
- Variables
- Mixins
- Nesting
- Imports modulares
- Funciones matemáticas

### PostCSS

Procesador de CSS con plugins:
- **Autoprefixer**: Añade prefijos de navegadores automáticamente
- **PostCSS Preset Env**: Permite usar características modernas de CSS
- **CSSNano**: Minifica el CSS en producción

## 🎨 Desarrollo con Sass

### Variables

Todas las variables están en `src/scss/_variables.scss`:

```scss
// Colores
$color-border: #e0e0e0;
$color-focus: #0073aa;

// Espaciado
$spacing-lg: 20px;

// Breakpoints
$breakpoint-mobile: 480px;
```

### Mixins

Los mixins útiles están en `src/scss/_mixins.scss`:

```scss
// Responsive
@include mobile {
    // Estilos para móvil
}

// Flexbox center
@include flex-center;

// Focus visible
@include focus-visible;

// Scrollbar personalizado
@include custom-scrollbar;
```

### Estructura Modular

Los estilos están organizados en módulos:

- `_base.scss` - Estilos base y resets
- `_container.scss` - Contenedor del chat
- `_window-mode.scss` - Modo flotante
- `_accessibility.scss` - Accesibilidad y media queries

## 💻 Desarrollo con JavaScript

### Estructura del Código

El JavaScript está modularizado en `src/js/main.js`:

```javascript
// Validación de configuración
function validateConfig(config) { }

// Construcción de configuración
function buildChatConfig(config) { }

// Inicialización
function initN8nChat() { }
```

### API Pública

El plugin expone una API pública:

```javascript
window.n8nChatWidget = {
    version: '1.0.0',
    init: initN8nChat,
};
```

### Eventos Personalizados

El plugin dispara eventos personalizados:

```javascript
// Widget cargado correctamente
window.addEventListener('n8nChatWidgetLoaded', (event) => {
    console.log('Widget loaded:', event.detail.config);
});

// Error al cargar el widget
window.addEventListener('n8nChatWidgetError', (event) => {
    console.error('Widget error:', event.detail.error);
});
```

## 🔧 Configuración de WordPress

### Modo Desarrollo

Para usar archivos sin compilar en WordPress, añade en `wp-config.php`:

```php
define('WP_DEBUG', true);
define('N8N_CHAT_WIDGET_DEV', true);
```

Esto hará que el plugin use los archivos de `src/` en lugar de `dist/`.

### Modo Producción

En producción, el plugin usa automáticamente los archivos compilados de `dist/`.

## 🧪 Testing

### Linting JavaScript

```bash
# Ejecutar ESLint (cuando esté configurado)
npm run lint:js
```

### Linting CSS

```bash
# Ejecutar Stylelint (cuando esté configurado)
npm run lint:css
```

### Formateo de Código

```bash
# Formatear código con Prettier (cuando esté configurado)
npm run format
```

## 📝 Buenas Prácticas

### JavaScript

1. Usa módulos ES6
2. Valida todas las entradas
3. Maneja errores apropiadamente
4. Documenta funciones complejas
5. Usa const/let en lugar de var

### SCSS

1. Usa variables para valores reutilizables
2. Organiza en archivos modulares
3. Usa mixins para código repetitivo
4. Sigue la metodología BEM para nombres de clases
5. Comenta secciones complejas

### Git

1. No commitear `node_modules/`
2. No commitear `dist/` (se genera automáticamente)
3. Usar mensajes de commit descriptivos
4. Crear branches para nuevas features

## 🐛 Solución de Problemas

### El build falla

```bash
# Limpiar node_modules y reinstalar
rm -rf node_modules
npm install
```

### Los cambios no se reflejan

```bash
# Limpiar directorio dist y reconstruir
rm -rf dist
npm run build
```

### Error de permisos

```bash
# Dar permisos correctos (Linux/Mac)
chmod -R 755 .
```

## 📚 Recursos Adicionales

- [Vite Documentation](https://vitejs.dev/)
- [Sass Documentation](https://sass-lang.com/)
- [PostCSS Documentation](https://postcss.org/)
- [WordPress Plugin Development](https://developer.wordpress.org/plugins/)

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una branch (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Añadir nueva funcionalidad'`)
4. Push a la branch (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

---

¿Preguntas? Abre un issue en GitHub o contacta a [Alex Cuadra](https://alexcuadra.dev)

