=== Chat for n8n ===
Contributors: alexcuadra
Tags: chat, n8n, automation, ai, chatbot
Requires at least: 5.8
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add the n8n-powered chat widget to your website, connecting automation and AI workflows.

== Description ==

Chat for n8n te permite integrar fácilmente el widget de chat de n8n en tu sitio de WordPress, conectando tus flujos de trabajo de automatización e IA directamente con tus visitantes.

= Características Principales =

* **Integración Sencilla**: Conecta tu sitio WordPress con n8n en minutos
* **Modo Flotante**: Widget flotante en la esquina de tu sitio
* **Modo Pantalla Completa**: Inserta el chat en cualquier página usando shortcodes
* **Multiidioma**: Soporte para Español, Inglés, Alemán, Francés y Portugués
* **Personalizable**: Configura mensajes de bienvenida y apariencia
* **Totalmente Responsive**: Funciona perfectamente en todos los dispositivos
* **Accesible**: Cumple con estándares de accesibilidad web
* **Sin Dependencias Externas**: Todo se carga desde CDN confiables

= ¿Qué es n8n? =

n8n es una plataforma de automatización de flujos de trabajo extensible y de código abierto. Te permite conectar cualquier cosa con todo, incluyendo APIs, bases de datos, servicios de IA, y más.

= Cómo Funciona =

1. Crea un workflow en n8n con un nodo "Chat Trigger"
2. Copia la URL del webhook del nodo "Chat Trigger"
3. Pega la URL en la configuración del plugin
4. ¡El widget de chat aparecerá automáticamente en tu sitio!

= Casos de Uso =

* Asistentes virtuales de atención al cliente
* Chatbots de ventas y marketing
* Sistemas de soporte técnico automatizados
* Generación de leads cualificados
* Consultas y reservas automatizadas
* Integración con sistemas CRM
* Asistentes con IA (ChatGPT, Claude, etc.)

= Shortcode =

Usa el shortcode `[n8n_chat]` para insertar el chat en cualquier página o entrada cuando uses el modo "Pantalla Completa".

== Installation ==

= Instalación Automática =

1. Inicia sesión en tu panel de administración de WordPress
2. Ve a "Plugins" > "Añadir nuevo"
3. Busca "Chat for n8n"
4. Haz clic en "Instalar ahora" y luego en "Activar"

= Instalación Manual =

1. Descarga el plugin
2. Sube la carpeta `chat-for-n8n` al directorio `/wp-content/plugins/`
3. Activa el plugin desde el menú "Plugins" en WordPress

= Configuración =

1. Ve a "Ajustes" > "Chat for n8n"
2. Introduce la URL del webhook de tu nodo "Chat Trigger" de n8n
3. Configura las opciones de apariencia según tus preferencias
4. Guarda los cambios

Para más información sobre cómo crear un workflow de chat en n8n, consulta la [documentación oficial de n8n](https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/).

== Frequently Asked Questions ==

= ¿Necesito una cuenta de n8n? =

Sí, necesitas tener n8n instalado (puede ser auto-hospedado o usar n8n.cloud) y crear un workflow con un nodo "Chat Trigger".

= ¿Es gratis? =

El plugin es 100% gratuito. n8n ofrece tanto versiones auto-hospedadas gratuitas como planes de pago en n8n.cloud.

= ¿Puedo personalizar el diseño del chat? =

Sí, puedes personalizar el modo de visualización, idioma, mensajes de bienvenida y más desde la página de configuración.

= ¿Funciona en dispositivos móviles? =

Sí, el widget es totalmente responsive y funciona perfectamente en smartphones y tablets.

= ¿Puedo usar múltiples widgets en diferentes páginas? =

Actualmente, el plugin soporta un widget por sitio. Para múltiples widgets, puedes crear diferentes instancias con configuraciones específicas.

= ¿Dónde puedo obtener soporte? =

Puedes obtener soporte en los foros de WordPress.org o visitar la [documentación de n8n](https://docs.n8n.io/).

= ¿Es compatible con GDPR? =

El plugin en sí no recopila datos. La conformidad con GDPR dependerá de cómo configures tu workflow en n8n. Asegúrate de revisar las políticas de privacidad de n8n y configurar tu workflow adecuadamente.

= ¿Puedo integrar IA como ChatGPT? =

¡Sí! n8n soporta integración con múltiples servicios de IA incluyendo OpenAI (ChatGPT), Anthropic (Claude), y muchos más a través de sus nodos.

== Screenshots ==

1. Página de configuración del plugin en el panel de administración
2. Widget de chat en modo flotante en el sitio web
3. Chat en modo pantalla completa usando shortcode
4. Ejemplo de conversación con el chatbot
5. Opciones de personalización disponibles

== Changelog ==

= 1.0.0 =
* Lanzamiento inicial
* Soporte para modo flotante y pantalla completa
* Configuración de webhook de n8n
* Soporte multiidioma (ES, EN, DE, FR, PT)
* Mensajes de bienvenida personalizables
* Integración completa con la librería @n8n/chat
* Cumplimiento con estándares WPCS y PHPCS
* Totalmente responsive y accesible

== Upgrade Notice ==

= 1.0.0 =
Lanzamiento inicial del plugin. ¡Instala y comienza a automatizar tus conversaciones!

== Additional Information ==

= Requisitos Técnicos =

* WordPress 5.8 o superior
* PHP 7.4 o superior
* Un workflow de n8n con nodo "Chat Trigger" configurado

= Recursos Útiles =

* [Sitio web de n8n](https://n8n.io/)
* [Documentación de n8n](https://docs.n8n.io/)
* [Documentación del Chat Trigger](https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/)
* [Repositorio de GitHub](https://github.com/alexcuadra/chat-for-n8n)

= Contribuir =

Este plugin es de código abierto. Si quieres contribuir, reportar bugs o solicitar características, visita nuestro repositorio en GitHub.

= Privacidad =

Este plugin no recopila ni almacena ningún dato personal de los usuarios de tu sitio. Todas las conversaciones se procesan a través de tu instancia de n8n según la configuración de tu workflow.

= Licencia =

Este plugin es software libre distribuido bajo la licencia GPL v2 o posterior.

