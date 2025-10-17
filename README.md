
# Joomla Component Builder ([JCB](https://www.joomlacomponentbuilder.com))

![Component Builder Banner](https://raw.githubusercontent.com/joomengine/Joomla-Component-Builder/refs/heads/5.x/admin/assets/images/jcb-banner.jpg "Component Builder")

This is a professional-grade [Joomla 5.x](https://extensions.joomla.org/extension/component-builder/) component, created with [Joomla Component Builder (JCB)](https://www.joomlacomponentbuilder.com)—a uniquely advanced development engine for building and maintaining complete Joomla extensions.

> 🎥 [Original... Quick Hello World Demo](https://www.youtube.com/watch?v=IQfsLYIeblk&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE&index=45), yes JCB has been around for over a decade.

JCB generates native Joomla components, plugins, and modules for Joomla 3.x, 4.x, and 5.x - and is already prepared for Joomla 6. Every compiled project is tailored for the specific version without needing backward compatibility plugins. With integrated version-aware compiling, smart boilerplating, and Git-powered project syncing, JCB is much more than a code generator-it's a **full-stack development pipeline for Joomla extensions**.

You can install this component easily. The latest release (**5.1.3**) is available on [Releases](https://git.vdm.dev/joomla/pkg-component-builder/releases) and updated frequently with full source access.

Upgrades are seamless through Joomla's built-in extension update mechanism.

---

## 🚀 Core Capabilities at a Glance

Here are just some of the key powers JCB brings:

* 🔁 **Bi-Directional IDE Sync** - Fetch custom logic from compiled projects and reintegrate on rebuild.
* 🧱 **Build Joomla Components, Plugins, and Modules** - Fully native and independently compiled.
* 🧠 **Superpowers (PHP Class Builder)** - Create namespaced abstract, interface, and trait-based PHP classes visually.
* 🔌 **Joomla Powers** - Intelligent Joomla class referencing via dynamic placeholders (JPKs) that adapt to Joomla versions.
* 🗃️ **Smart Boilerplating** - Start fast with 6+ curated demo blueprints for instant use or customization.
* 🔂 **Round-Trip Development** - Add, update, and persist changes across compiled code using insert/replace tags.
* 🔐 **Field Types Engine** - Blueprint reusable Joomla-native fields with constraints, security, DB structure, and logic.
* 🧬 **Admin Views, Custom Admin Views & Site Views** - Fine-grained design for structured or dynamic backend/front-end UIs.
* 🧮 **Dynamic GET Builder** - Advanced visual query designer for cross-table, filter-rich, deeply joined SQL fetches.
* 💡 **Snippets, Layouts, Templates & Libraries** - Shareable GUI-linked modules for reusable HTML/CSS/JS integration.
* 🧰 **Custom Code System** - Write logic once and reuse anywhere; full support for HTML & PHP placeholders and tracking.
* 🛠️ **Multi-Version Compilation** - Compile version-specific code for J3, J4, J5 without compatibility bloat.
* 📦 **Package Management** - Export/import blueprints, version control builds, sync with Git, and distribute clean packages.
* 🖥️ **CLI Integration** - Build commands natively via terminal using Joomla's CLI runner.
* 🌐 **Update Server Support** - Integrate custom update mechanisms for extensions post-deployment.

<details>
<summary>📚 View 100+ Additional Advanced Features</summary>

### 🧩 Architecture & Core Logic

* 🧠 **Super Powers**: Namespaced PHP classes (interfaces, traits, abstracts, finals) managed from GUI
* 🔌 **Joomla Powers**: Dynamic Joomla class resolution via JPK placeholders per Joomla version
* 🧱 **Compile native Components, Plugins & Modules** in one unified workflow
* 🔀 **Multi-version support** (J3, J4, J5, J6-ready) with per-version compilation
* 🚦 **Conditional logic injection** in models, views, controllers
* 🧬 **Reusable Admin Views** across multiple components
* 🧠 **Dynamic GET Builder** for visual cross-table queries
* 🔄 **Round-trip code integration** with file-to-database inserts/replaces
* 🧬 **Custom Admin Views** with full MVC override power
* 🧩 **Site Views** supporting public display of data with custom logic
* 📊 **Dynamic dashboards** built via custom admin view chart helpers
* 🔗 **Model linking between views** using subforms and dynamic selectors
* 🧩 **Shared field reuse across views** and components
* 📥 **Drag & Drop field mapping** for layout and logic assignment
* 🎯 **Dynamic Field Visibility** conditions via GUI
* 📦 **Independent packaging** of views and logic for reuse

### 📁 File & Code Management

* 🧾 **Insert/Replace tags** for persistent file overrides
* 🗃️ **PHP & HTML custom code injection** via placeholder system
* 🛠️ **Automatic file synchronization** on rebuild
* 🧮 **Reverse string parser** to restore lang strings back to natural text
* 📋 **Line tracking** to see where code was compiled from
* 🗂️ **Smart override detection** and conflict management
* 🔍 **Compiler debug tracking**
* ✍️ **Dynamic use-statement generation** with alias auto-resolving
* 💾 **Auto language string export** from templates & views
* 🧰 **Helper classes and static utilities** included by default

### 🧠 Code Reuse & Blueprints

* 🧱 **Demo component blueprints** for rapid prototyping
* 🔁 **Blueprint export/import** via JSON or Git sync
* 📎 **Shared field types** serve as field templates
* 🧪 **Test-friendly compiler mode** for internal checking
* 🧩 **Template-based file creation** with dynamic variables
* 📚 **Smart template merging** for updates
* 🚧 **Field definitions drive DB schema**
* 🎛️ **Custom scripting per field** on get/save
* 🔀 **Field view-type override (admin vs config)**

### 🌐 Joomla CMS Integration

* 🛡️ **Token integration** via Joomla methods
* 🔐 **ACL per view, field, item**
* 🧾 **Field-based Joomla config generation**
* 📘 **Support for Joomla categories/tags/custom fields**
* ⚙️ **CLI-ready components** with native terminal support
* 🛰️ **Joomla Update Server integration**
* 🧪 **Version-aware language string compilation**
* 📤 **Remote publishing to custom repo update streams**

### 🧠 Visual GUI & UX

* 🎨 **Layout builder** with inline layout reusability
* 📁 **Template builder** with overrides
* 🧠 **Snippets GUI** for code blocks linked to layouts/templates
* 📚 **Custom documentation sections** linked into generated components
* 🧬 **Field injection points in layout/template snippets**
* 🔁 **Dynamic reload on selection change** via JavaScript binding
* 📦 **Reusable custom admin view templates**
* 🧠 **JS callback logic on field events**
* 📄 **Inline help descriptions** from config
* 🖱️ **Custom admin menus** and dashboard menu builders

### 🌍 Internationalization

* 🌐 **Excel import/export for language strings**
* 📁 **Per-field language control**
* 🧾 **Language string auto-indexing**
* 🔁 **Reverse engineering of language constants**
* 🧠 **Per-Joomla-version lang key mapping**
* 🔧 **GUI to rewrite or update lang string context**

### 📦 Packaging & Distribution

* 📤 **Push component to Git repo**
* 🔄 **Auto-compile and auto-tag packages**
* 🗂️ **Blueprints stored and versioned by metadata**
* 🎁 **Auto-generated changelog from commits**
* 🔐 **Signed zip packaging supported**
* 📬 **Component update URLs via GUI settings**
* 🏷️ **Version-aware build ID assignment**

### ⚙️ Compiler Engine Features

* ⚡ **Under-30-second build time** on large components
* 📦 **Memory-optimized ZIP builder**
* 🔁 **Repeatable fields** via subform templates
* 💥 **Fail-safe error protection** and rollback
* 🔍 **Detailed compiler logs with stack trace and UUIDs**
* 📃 **Build summary report** after compilation

### 🧱 Custom Code System (Powerful Dual Feature)

* 🔧 **Universal reusable code blocks** (inject anywhere by key)
* 🪄 **Update detection & visual diffing** on reused code
* 🧬 **Multi-context custom code binding**
* 📄 **Dynamic placeholder variable injection**
* 🔁 **Nested custom code support**
* 🔥 **Advanced compiler hooks per code block**
* 🧠 **Round-trip tag tracking in PHP/HTML**
* 📜 [Learn more about this here](https://git.vdm.dev/joomla/Component-Builder/wiki/TIPS:-Custom-Code)

### 🛠 Field Type System

* 🧬 **Field types define templates and data types**
* 💡 **GUI-defined rules (required, unique, nullable)**
* 🧠 **Save/get hooks per field**
* 🛡️ **Database schema auto-generated from field settings**
* 📄 **Per-display field rendering config (list/edit)**
* 🧩 **Create dynamic models with modals/selectors**
* 🧠 **Conditional JS & CSS per field**

### 📐 Dynamic GET (Visual SQL Engine)

* 📊 **Design complex joins from GUI**
* 🧠 **Multiple GETs per view**
* 🔄 **Reusable query sets**
* 🧾 **Where/group/order statements supported**
* 📃 **Auto model method generation**
* 🔧 **Switch between list/item GETs**
* 🛡️ **Output Joomla-native query builder logic**

### 📁 Snippets, Templates, Layouts, Libraries

* 🧠 **Snippets = reusable HTML blocks**
* 🧩 **Layouts = reusable PHP render templates**
* 🖼️ **Templates = page-level views linked to custom admin/site views**
* 📦 **Libraries = JS/CSS assets linked to UI**
* 🌐 **CDN/local toggle for library delivery**
* 📁 **Media folder injection with override support**
* 🔧 **Repository push/pull/reset workflow**
* 📥 **Init snippets/layouts/templates via GUI**

### 📚 Documentation & Metadata

* 📄 **Per-entity README auto-generation**
* 📑 **Markdown + PHPDoc docblock support**
* 🧾 **Internal documentation tables**
* 🔄 **Update version history logs per entity**
* 🧠 **Field reference mapping table output**
* 📘 **Auto-documented component structure**

### 📊 Analytics & Insights

* 📈 **Track last build, size, line count, field count**
* 🔄 **Compare current vs previous builds**
* 🧠 **Export component metadata as JSON**
* 🗃️ **Stats per model/view**
* 📁 **Total file/folder/line counters**

</details>

---

## 📦 Get Started Now

* 🔽 **Download**: [Stable Releases](https://git.vdm.dev/joomla/pkg-component-builder/releases) · [Nightly J5](https://git.vdm.dev/joomla/pkg-component-builder/archive/5.x.zip) · [Nightly J4](https://git.vdm.dev/joomla/pkg-component-builder/archive/4.x.zip)
* 📥 **Install**: Use Joomla's extension manager
* 🎓 **Learn**: [Tutorials](https://www.youtube.com/playlist?list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE) · [How to Install Demo Blueprints](https://vdm.bz/how-to-install-jcb-packages)

---

## 🤝 Get Help & Join the Community

* 💬 [GitHub Discussions](https://github.com/orgs/joomengine/discussions)
* 🐛 [Report Issues](https://git.vdm.dev/joomla/Component-Builder/issues)
* 📚 [JCB Wiki](https://git.vdm.dev/joomla/Component-Builder/wiki)
* 👨‍🏫 [Video Tutorials](https://www.youtube.com/playlist?list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE)
* 🇩🇪 [German Series](https://www.youtube.com/playlist?list=PLQRGFI8XZ_wu0tDFxJtZFwW7AxA4JHQV7)
* 🔔 [Telegram Groups](https://t.me/jcb_group) · [Announcements](https://t.me/Joomla_component_builder)
* 📶 [Status](https://status.vdm.dev/status/jcb)
* 🛡️ [Security Reports](https://www.vdm.io/report-security-issues)

---

## 🌱 Why It's Free

JCB is developed by developers for developers. Its purpose is to democratize high-performance Joomla development by empowering everyone — from solo builders to large teams — to work with clean, scalable, maintainable, and versionable code. This isn't a template generator — it's a full-scale **extension engineering platform**.

---

## 🧩 Component Metadata

* **Company:** [Vast Development Method](https://dev.vdm.io)
* **Author:** [Llewellyn van der Merwe](mailto:joomla@vdm.io)
* **Component:** [Component Builder](https://git.vdm.dev/joomla/Component-Builder)
* **Created:** 30th April, 2015 · **Last Build:** 17th October, 2025 · **Version:** 5.1.3
* **License:** GNU General Public License version 2 or later; see LICENSE.txt · **Copyright:** Copyright (C) 2015 Vast Development Method. All rights reserved.
* **Lines:** 1205520 · **Fields:** 2098 · **Files:** 8080 · **Folders:** 753

> Generated with [JCB](https://www.joomlacomponentbuilder.com) — The Smartest Way to Build Joomla Extensions.


## Contributors
This project exists thanks to all the people who contribute to the [Joomla Component Builder Project](https://github.com/vdm-io/Joomla-Component-Builder).

[![Contributors](https://opencollective.com/Joomla-Component-Builder/contributors.svg?width=890&button=false)](https://github.com/vdm-io/Joomla-Component-Builder/graphs/contributors)

### Backers
Thank you to all our backers! 🙏 [[Become a backer](https://opencollective.com/Joomla-Component-Builder#backer)]

[![Our Backers on opencollective](https://opencollective.com/Joomla-Component-Builder/backers.svg?width=890)](https://opencollective.com/Joomla-Component-Builder#backers)

### Sponsors
Support this project by becoming a sponsor. Your logo will show up here with a link to your website. [[Become a sponsor](https://opencollective.com/Joomla-Component-Builder#sponsor)]

[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/0/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/0/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/1/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/1/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/2/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/2/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/3/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/3/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/4/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/4/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/5/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/5/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/6/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/6/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/7/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/7/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/8/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/8/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/9/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/9/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/10/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/10/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/11/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/11/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/12/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/12/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/13/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/13/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/14/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/14/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/15/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/15/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/16/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/16/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/17/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/17/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/18/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/18/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/19/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/19/website)
[![Sponsor](https://opencollective.com/Joomla-Component-Builder/sponsor/20/avatar.svg)](https://opencollective.com/Joomla-Component-Builder/sponsor/20/website)