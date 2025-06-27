<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Package\CustomCode\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Custom Code Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Custom Codes repository in Markdown format.
	 *
	 * Provides accurate descriptions of both custom code injection methods:
	 *   1) Placeholder reuse with [CUSTOMCODE=...]
	 *   2) File-level insert/replace tags for persistent customization
	 *
	 * @param  array  $items  All custom code entries stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Custom Codes';
		$readme[] = '';

		// Overview
		$readme[] = '### What Are Custom Codes in JCB?';
		$readme[] = <<<MD
Custom Codes in JCB allow you to create and manage custom logic that can be reused, shared, and even injected  
into your component code at compile time. This feature supports **two advanced use cases**:

1. **Reusable Code Blocks with Argument Injection**
	called: **JCB (manual)**
2. **Persistent File Modification via Insert/Replace Tags**
	called: **Hash (automation)**

---
MD;

		// Section 1: Placeholder Injection
		$readme[] = '### 1. Reusable Code Injection with `[CUSTO' . 'MCODE=...]` (JCB manual)';
		$example = '[CUSTOM' . 'CODE=mainReadmePackageFooter]';
		$example_ = '[CUSTOM' . 'CODE=mainReadmePackageFooter+foo,bar,baz]';
		$readme[] = <<<MD
This method allows you to define a custom code block once and inject it into any JCB-supported code area  
using a placeholder like:

```text
{$example}
````

You can also pass **dynamic arguments** into these placeholders:

```text
{$example_}
```

Your custom code may then reference these values using zero-based placeholders:

* `[[[arg0]]]` → `foo`
* `[[[arg1]]]` → `bar`
* `[[[arg2]]]` → `baz`

If your code uses `n` placeholders, **you must pass `n` arguments** during use.

> 🧠 **Encoding Special Characters:**
> To include reserved characters in arguments, use these HTML-safe equivalents:
> `[` ⇒ `&#91;`   `]` ⇒ `&#93;`   `,` ⇒ `&#44;`   `+` ⇒ `&#43;`   `=` ⇒ `&#61;`

#### Scope of Use:

* Works in any JCB code area (PHP, JS, HTML, etc.)
* Can be used **within other custom codes**
* ❗ **Cannot be used inside its own definition or in IDE hash automation code**

#### Note on Editor Sync:

At present, argument-based custom codes **cannot be reversed back from the compiled project into the UI**
without losing the `[[[argX]]]` placeholders. All updates for such code **must be done via the JCB UI**
until this limitation is resolved.

---
MD;

		// Section 2: Insert/Replace in Files
		$readme[] = '### 2. Persistent File Overrides via Insert/Replace Tags (Hash automation)';
		$exsample = 'INSERT<>';
		$readme[] = <<<MD
When working with a compiled component installed on the same Joomla instance as JCB,
you can **insert or replace blocks of code** inside the actual generated files using special comment tags like:

```php
/***[{$exsample}$$$$]***/
// your code
/***[/{$exsample}$$$$]***/
```

JCB scans for these tags and:

* Extracts the content
* Stores it in the Custom Code UI
* Keeps track of the file and line number
* Re-injects the code on future compilations

This works for both **PHP** and **HTML** using appropriately formatted tag styles.

If the injection location becomes ambiguous, JCB will:

* Comment out the custom code block
* Warn you about the issue
* Preserve the code for manual review

📘 Full tag syntax reference available here:
👉 [TIPS: Custom Code](https://git.vdm.dev/joomla/Component-Builder/wiki/TIPS:-Custom-Code)

---
MD;

		// Section 3: Language String Extraction
		$readme[] = '### 3. Reverse Engineering of Language Strings';
		$exsample = 'xt::_';
		$readme[] = <<<MD
When custom code uses `Te{$exsample}('SOME_CONSTANT')` language strings, JCB automatically converts them
**back into their readable string form** when importing into the editor. This improves maintainability
by letting you work with the original values rather than language constants.

---
MD;

		// Section 4: Git Workflow & Customization
		$readme[] = '### 4. Customization, Forking, and Version Control';
		$readme[] = <<<MD
As with other JCB entities, Custom Codes support a Git-based workflow:

* **Init**: Import from a repository
* **Reset**: Overwrite with the repository version
* **Push**: Update a shared repository if you have write access
* **Fork**: Maintain and manage your own custom code set

This design encourages collaborative and modular development across multiple JCB projects.

---
MD;

		// Index of available entries
		$readme[] = '### Index of Custom Codes';
		$readme[] = '';

		$readme[] = $this->getIndex($items);
		$readme[] = '';

		$readme[] = <<<MD
### All used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);

	}
}

