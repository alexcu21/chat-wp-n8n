# n8n Chat Widget para WordPress

Plugin de WordPress que integra el widget de chat de n8n en tu sitio web, permitiendo conectar flujos de trabajo de automatización e IA directamente con tus visitantes.

## 🚀 Instalación

### Desde WordPress

1. Descarga el plugin o clónalo desde GitHub
2. Sube la carpeta `chat-for-n8n` a `/wp-content/plugins/`
3. Activa el plugin desde el menú "Plugins" en WordPress
4. Ve a **Ajustes → n8n Chat Widget** para configurarlo

### Configuración Rápida

1. **Crea un workflow en n8n:**
   - Añade un nodo "Chat Trigger" a tu workflow
   - Activa el workflow
   - Copia la URL del webhook (debe terminar en `/chat`)

2. **Configura el plugin:**
   - Ve a **Ajustes → n8n Chat Widget**
   - Pega la URL del webhook
   - Configura las opciones de apariencia
   - Guarda los cambios

3. **¡Listo!** El widget aparecerá automáticamente en tu sitio

## ⚙️ Opciones de Configuración

### Configuración Principal

- **URL del Webhook**: La URL del nodo "Chat Trigger" de tu workflow en n8n
  - Formato: `https://tu-n8n.app/webhook/tu-id/chat`

### Configuración de Apariencia

- **Modo del Widget:**
  - **Ventana Flotante**: Widget en la esquina inferior derecha (predeterminado)
  - **Pantalla Completa**: Usa el shortcode `[n8n_chat]` en una página

- **Idioma:** Español, Inglés, Alemán, Francés, Portugués

- **Pantalla de Bienvenida:** Mostrar/ocultar mensaje de bienvenida

- **Mensajes Iniciales:** Personaliza el mensaje de bienvenida

## 📝 Uso del Shortcode

Para insertar el chat en una página específica:

```
[n8n_chat]
```

**Nota:** Cambia el modo a "Pantalla Completa" en los ajustes para usar el shortcode.

## 🛠️ Requisitos Técnicos

- **WordPress:** 5.8 o superior
- **PHP:** 7.4 o superior
- **n8n:** Instancia con nodo "Chat Trigger" configurado

## 🔧 Solución de Problemas

### El widget no aparece

1. **Verifica la URL del webhook:**
   - Asegúrate de que esté correctamente configurada en **Ajustes → n8n Chat Widget**
   - Debe ser accesible públicamente
   - Debe terminar con `/chat`

2. **Limpia el caché:**
   - Limpia el caché de WordPress (si tienes plugin de caché)
   - Limpia el caché del navegador (Ctrl+Shift+R o Cmd+Shift+R)

3. **Revisa la consola del navegador:**
   - Presiona F12 para abrir herramientas de desarrollo
   - Ve a la pestaña "Console"
   - Busca errores relacionados con "n8n Chat Widget"

4. **Verifica que los scripts se carguen:**
   - En herramientas de desarrollo, ve a "Network"
   - Recarga la página
   - Busca `chat.bundle.es.js` y `chat-for-n8n.js`
   - Ambos deben cargar con status 200

### Errores comunes

**Error: "URL del Webhook no configurada"**
- Configura la URL en **Ajustes → n8n Chat Widget**

**Error: "createChat no está disponible"**
- Verifica que el CDN de n8n esté accesible
- Revisa si hay conflictos con otros plugins

**El widget no se conecta con n8n**
- Verifica que tu workflow en n8n esté activo
- Asegúrate de que la URL del webhook sea correcta
- Revisa los logs de n8n para ver si las peticiones llegan

## 🎨 Personalización

### CSS Personalizado

Puedes añadir CSS personalizado en tu tema para modificar la apariencia:

```css
/* Cambiar posición del widget */
.n8n-chat-window {
    bottom: 30px !important;
    right: 30px !important;
}

/* Cambiar colores */
#n8n-chat-container {
    border-color: #your-color !important;
}
```

### Configuración Avanzada

El plugin sigue las mejores prácticas de WordPress y es compatible con:
- ✅ Multisitio
- ✅ Temas personalizados
- ✅ Page builders (Elementor, Divi, etc.)
- ✅ Plugins de caché
- ✅ WPML y Polylang

## 📚 Estructura de Archivos

```
chat-for-n8n/
├── chat-for-n8n.php     # Archivo principal del plugin
├── chat-for-n8n.js      # Script de inicialización (módulo ES6)
├── chat-for-n8n.css     # Estilos personalizados
├── readme.txt           # Documentación para WordPress.org
├── README.md            # Este archivo
├── CHANGELOG.md         # Historial de cambios
├── LICENSE              # Licencia GPL v2
└── index.php            # Seguridad contra browsing
```

## 🔐 Seguridad

- ✅ Todas las entradas se sanitizan y validan
- ✅ Todas las salidas usan funciones de escape
- ✅ Verificación de permisos en páginas de admin
- ✅ Prevención de acceso directo a archivos
- ✅ Compatible con WPCS y PHPCS

## 📄 Licencia

Este plugin está licenciado bajo GPL v2 o posterior.

## 🤝 Contribuir

Las contribuciones son bienvenidas! Si encuentras un bug o tienes una sugerencia:

1. Abre un issue en GitHub
2. Envía un pull request
3. Reporta problemas en el foro de WordPress

## 📞 Soporte

- **Documentación de n8n:** https://docs.n8n.io/
- **Chat Trigger Docs:** https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/

## 🙏 Créditos

Desarrollado por Alex Cuadra
- Website: https://alexcuadra.dev
- Basado en la librería @n8n/chat

## 📋 Changelog

### 1.0.0 - 2025-11-04
- 🎉 Lanzamiento inicial
- ✅ Integración completa con @n8n/chat
- ✅ Soporte para módulos ES6
- ✅ Página de configuración en admin
- ✅ Modo flotante y pantalla completa
- ✅ Soporte multiidioma
- ✅ Totalmente responsive

---

**¿Te gusta el plugin? ¡Déjanos una reseña! ⭐⭐⭐⭐⭐**

