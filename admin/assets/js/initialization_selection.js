/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/* JS Document */

const memoryinitialization = [];

function setSessionMemory(key, values, merge = true) {
	if (merge) {
		values = mergeSessionMemory(key, values);
	} else {
		values = JSON.stringify(values);
	}

	if (typeof Storage !== "undefined") {
		sessionStorage.setItem(key, values);
	} else {
		memoryinitialization[key] = values;
	}
}

function mergeSessionMemory(key, values) {
	const oldValues = getSessionMemory(key);

	if (oldValues) {
		values = { ...oldValues, ...values };
	}

	return JSON.stringify(values);
}

function getSessionMemory(key, defaultValue = null) {
	if (typeof Storage !== "undefined") {
		const localValue = sessionStorage.getItem(key);

		if (isJsonString(localValue)) {
			defaultValue = JSON.parse(localValue);
		}
	} else if (typeof memoryinitialization[key] !== "undefined") {
		const localValue = memoryinitialization[key];

		if (isJsonString(localValue)) {
			defaultValue = JSON.parse(localValue);
		}
	}

	return defaultValue;
}

function isJsonString(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}

	return true;
}

function getArrayFormat(items) {
	// Check if items is an object and not an array
	if (typeof items === 'object' && !Array.isArray(items)) {
		return Object.values(items);
	}
	return items;
}
class InitializationManager {
	#repoArea = document.getElementById('select-repo-area');
	#powersArea = document.getElementById('select-powers-area');
	#initButton = document.getElementById('init-selected-powers');
	#backButton = document.getElementById('back-to-select-repo');
	#loadingDiv = window.loadingDiv || null;
	#buildTable = typeof buildPowerSelectionTable === 'function' ? buildPowerSelectionTable : null;
	#drawTable = typeof drawPowerSelectionTable === 'function' ? drawPowerSelectionTable : null;

	currentRepo = null;
	currentArea = null;

	constructor() {
		this._bindRepoButtons();
		this._bindInitSelectedPowers();
		this._updateInitButtonState();
	}

	/** Getter for selected items using global window reference. */
	get selectedItems() {
		if (!Array.isArray(window.selectedPowerItems)) {
			window.selectedPowerItems = [];
		}
		return window.selectedPowerItems;
	}

	/** Setter for selected items with sync to window and button state update. */
	set selectedItems(items) {
		window.selectedPowerItems = items;
		this._updateInitButtonState();
	}

	/** Add items to selection if not already selected. */
	addSelectedItems(data) {
		if (!data || typeof data.length !== 'number') return;

		const updated = [...this.selectedItems];

		for (let i = 0; i < data.length; i++) {
			const item = data[i];
			if (!updated.some(existing => this.#isSameItem(existing, item))) {
				updated.push(item);
			}
		}

		this.selectedItems = updated;
	}

	/** Remove items from selection based on identity comparison. */
	removeSelectedItems(data) {
		if (!data || typeof data.length !== 'number') return;

		const updated = this.selectedItems.filter(existing => {
			for (let i = 0; i < data.length; i++) {
				if (this.#isSameItem(existing, data[i])) {
					return false;
				}
			}
			return true;
		});

		this.selectedItems = updated;
	}

	/** Check if two items are the same using GUID. */
	#isSameItem(a, b) {
		return a?.guid && b?.guid && a.guid === b.guid;
	}

	/** Enable/disable the init button based on selection state. */
	_updateInitButtonState() {
		if (this.#initButton) {
			this.#initButton.disabled = this.selectedItems.length === 0;
		}
	}

	_bindRepoButtons() {
		document.querySelectorAll('.select-repo-to-load').forEach(button => {
			button.addEventListener('click', (e) => this._handleRepoClick(e));
		});
	}

	_bindInitSelectedPowers() {
		if (this.#initButton) {
			this.#initButton.addEventListener('click', () => this._handleInitSelectedPowers());
		}
		if (this.#backButton) {
			this.#backButton.addEventListener('click', () => this._handleBackToRepos());
		}
	}

	async _handleRepoClick(event) {
		const button = event.currentTarget;
		const repo = button?.dataset?.repo;
		const area = button?.dataset?.area;

		if (!repo || !area) {
			this._notify(Joomla.Text._("COM_COMPONENTBUILDER_MISSING_REPOSITORY_OR_AREA_DATA"), "danger");
			return;
		}

		this._showLoading();
		clearPowerSelectionTable();

		const url = `${UrlAjax}getRepoIndex&repo=${encodeURIComponent(repo)}&area=${encodeURIComponent(area)}`;

		try {
			const response = await fetch(url);

			if (!response.ok) throw new Error(`HTTP ${response.status}`);

			const data = await response.json();

			if (data.success && data.index && this.#buildTable) {
				const repoData = data.index[0];
				const {
					path = 'joomla/super-powers',
					read_branch = 'master',
					target,
					base = 'https://git.vdm.dev'
				} = repoData;

				const repo_base = (target === 'github') ? 'https://github.com' : base;
				const repo_path = (target === 'github') ? 'tree' : 'src/branch';

				window.targetPowerRepoUrl = `${repo_base}/${path}/${repo_path}/${read_branch}/`;

				this.#buildTable(repoData.index);

				setTimeout(() => {
					this._transitionTo(this.#repoArea, this.#powersArea);
					this._hideLoading();
				}, 500);

				this.currentRepo = repoData.guid;
				this.currentArea = area;
			} else {
				this._notify(data.message || Joomla.Text._("COM_COMPONENTBUILDER_FAILED_TO_RETRIEVE_REPOSITORY_INDEX"), "danger");
				this._hideLoading();
			}
		} catch (error) {
			console.error("Fetch error:", error);
			this._hideLoading();
			this._notify(Joomla.Text._("COM_COMPONENTBUILDER_NETWORK_OR_SERVER_ERROR_OCCURRED_WHILE_FETCHING_INDEX"), "danger");
		}
	}

	_handleBackToRepos() {
		this._transitionTo(this.#powersArea, this.#repoArea);
	}

	async _handleInitSelectedPowers() {
		if (!Array.isArray(this.selectedItems) || this.selectedItems.length === 0) {
			this._notify(Joomla.Text._("COM_COMPONENTBUILDER_NO_ITEMS_SELECTED"), "warning");
			return;
		}

		this._showLoading();

		const area = this.currentArea || 'error';
		const repo = this.currentRepo || 'error';

		const func = 'initSelectedPackages';

		try {
			// Convert selected items to form data
			const formData = new FormData();

			// Assuming Joomla expects `selected[]` for multiple values
			for (const item of this.selectedItems) {
				formData.append('selected[]', item.guid); // Only sending GUIDs
			}
			formData.append('area', area);
			formData.append('repo', repo);

			const response = await fetch(`${UrlAjax}${func}`, {
				method: 'POST',
				body: formData
			});

			if (!response.ok) throw new Error(`HTTP ${response.status}`);

			const data = await response.json();

			if (!data.success) {
				this._notify(data.message || Joomla.Text._("COM_COMPONENTBUILDER_FAILED_TO_INITIALIZE_SELECTED_POWERS"), "danger");
			} else {
				this._handleResultLog(data.result_log || {});
			}

			this._hideLoading();
			this._transitionTo(this.#powersArea, this.#repoArea);
		} catch (error) {
			console.error("Submission error:", error);
			this._notify(Joomla.Text._("COM_COMPONENTBUILDER_ERROR_OCCURRED_WHILE_INITIALIZING_POWERS"), "danger");

			this._hideLoading();
			this._transitionTo(this.#powersArea, this.#repoArea);
		}
	}

	_handleResultLog(resultLog) {
		const localGuids = this._normalizeGuids(resultLog.local);
		const notFoundGuids = this._normalizeGuids(resultLog.not_found);
		const addedGuids = this._normalizeGuids(resultLog.added);

		if (localGuids.length > 0) {
			this._notify(
				this._generateResultMessage(localGuids, 'local'),
				'info'
			);
		}

		if (notFoundGuids.length > 0) {
			this._notify(
				this._generateResultMessage(notFoundGuids, 'not_found'),
				'info'
			);
		}

		if (addedGuids.length > 0) {
			this._notify(
				this._generateResultMessage(addedGuids, 'added'),
				'success'
			);
		}
	}

	_normalizeGuids(value) {
		if (!value) return [];

		if (Array.isArray(value)) {
			return value;
		}

		if (typeof value === 'object') {
			return Object.keys(value);
		}

		return [];
	}

	_generateResultMessage(guids, type) {
		const messages = {
			local: Joomla.Text._('COM_COMPONENTBUILDER_THESE_ITEMS_WERE_ALREADY_PRESENT_LOCALLY_AND_WERE_NOT_INITIALIZED'),
			not_found: Joomla.Text._('COM_COMPONENTBUILDER_THESE_ITEMS_COULD_NOT_BE_FOUND_IN_THE_REMOTE_REPOSITORY_AND_WERE_NOT_INITIALIZED'),
			added: Joomla.Text._('COM_COMPONENTBUILDER_THESE_ITEMS_WERE_SUCCESSFULLY_INITIALIZED')
		};

		const names = [];

		for (const guid of guids) {
			const item = this.selectedItems.find(i => i.guid === guid);
			if (item?.name) {
				names.push(item.name);
			}
		}

		if (names.length === 0) {
			return null;
		}

		return `${messages[type]}\n<br>- ${names.join('\n<br>- ')}`;
	}

	_transitionTo(hideEl, showEl) {
		if (hideEl && showEl) {
			UIkit.util.ready(() => {
				UIkit.util.removeClass(hideEl, 'uk-animation-slide-top-small');
				UIkit.util.removeClass(showEl, 'uk-animation-slide-bottom-small');
				UIkit.util.addClass(hideEl, 'uk-animation-slide-top-small');

				setTimeout(() => {
					hideEl.style.display = 'none';
					showEl.style.display = '';
					UIkit.util.addClass(showEl, 'uk-animation-slide-bottom-small');
					if (this.#drawTable) this.#drawTable();
				}, 300);
			});
		}
	}

	_showLoading() {
		if (this.#loadingDiv) this.#loadingDiv.style.display = 'block';
	}

	_hideLoading() {
		if (this.#loadingDiv) this.#loadingDiv.style.display = 'none';
	}

	_notify(message, type = 'info') {
		const alertTypes = {
			primary: 'alert-primary',
			info: 'alert-info',
			success: 'alert-success',
			warning: 'alert-warning',
			danger: 'alert-danger',
		};

		const alertClass = alertTypes[type] || alertTypes.primary;

		let container = document.getElementById('alert-container');
		if (!container) {
			container = document.createElement('div');
			container.id = 'alert-container';
			container.className = 'position-fixed top-0 start-50 translate-middle-x p-3';
			container.style.zIndex = '1060';
			document.body.appendChild(container);
		}

		const alert = document.createElement('div');
		alert.className = `alert ${alertClass} alert-dismissible fade show`;
		alert.setAttribute('role', 'alert');
		alert.innerHTML = `
			${message}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		`;

		container.appendChild(alert);

		setTimeout(() => {
			alert.classList.remove('show');
			alert.classList.add('hide');
			alert.addEventListener('transitionend', () => {
				alert.remove();
			});
		}, 5000);
	}
}