/* eslint-disable no-use-before-define */

import merge from 'deepmerge';
import apiFetch from '@wordpress/api-fetch';
import { getQueryArg, hasQueryArg } from '@wordpress/url';

const HIDDEN_STEP_CLASSNAME = 'yext-wizard__step--hidden';
const ACTIVE_STEP_CLASSNAME = 'yext-wizard__step--active';

const COMPLETED_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--complete';
const ACTIVE_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--active';

const REST_API_ROUTE = '/wp-json/yext/v1/settings';

const buildPayload = (formData) => {
	const REGEX = /(?<=\[).+?(?=\])/g;

	return !(formData instanceof FormData)
		? {}
		: // @ts-ignore
		  [...formData].reduce((payload, current) => {
				const [name, value] = current;

				const parts = name.match(REGEX);
				const object = parts.reduceRight(
					(obj, next, index) => ({ [next]: index + 1 === parts.length ? value : obj }),
					{},
				);

				return merge(payload, object);
		  }, {});
};

/**
 * Setup Wizard
 *
 * @return {void}
 */
const initWizard = () => {
	/**
	 * @type {HTMLElement}
	 */
	const yextWizard = document.querySelector('#yext-wizard');

	if (!yextWizard) {
		return;
	}

	/**
	 * @type {HTMLFormElement}
	 */
	const FORM = yextWizard.querySelector('.yext-wizard__form');

	if (!FORM) {
		return;
	}

	const { step } = yextWizard.dataset;
	const INITIAL_STATE = {
		step: Number(step),
		payload: {},
	};

	const dispatch = (action) => {
		switch (action) {
			case 'step':
				updateWizard();
				updateStorage();
				updateSearchParams();
				break;
			case 'payload':
				updateSettings();
				break;
			default:
				break;
		}
	};

	const STATE = new Proxy(INITIAL_STATE, {
		set: (object, prop, value) => {
			object[prop] = value;

			dispatch(prop);

			return true;
		},
	});

	/**
	 * @type {HTMLElement[]}
	 */
	const STEPS = Array.from(document.querySelectorAll('.yext-wizard__step'));

	/**
	 * @type {HTMLElement[]}
	 */
	const PROGRESS_STEPS = Array.from(document.querySelectorAll('.yext-wizard__timeline-step'));

	/**
	 * @type {HTMLElement[]}
	 */
	const BACK_BUTTONS = Array.from(yextWizard.querySelectorAll('.yext-wizard__back'));

	/**
	 * @type {HTMLElement[]}
	 */
	const NEXT_BUTTONS = Array.from(yextWizard.querySelectorAll('.yext-wizard__next'));

	const SUBMIT_BUTTONS = Array.from(yextWizard.querySelectorAll('.yext-wizard__submit'));

	/**
	 * Hide all steps
	 */
	function hideSteps() {
		STEPS.forEach((step) => {
			step.classList.remove(ACTIVE_STEP_CLASSNAME);
			step.classList.add(HIDDEN_STEP_CLASSNAME);
		});
	}

	/**
	 * Show a step
	 *
	 * @param {number} index Step index
	 */
	function showStep(index) {
		hideSteps();

		STEPS[index].classList.remove(HIDDEN_STEP_CLASSNAME);
		STEPS[index].classList.add(ACTIVE_STEP_CLASSNAME);
	}

	function getCurrentStep() {
		if (hasQueryArg(window.location.href, 'step')) {
			return getQueryArg(window.location.href, 'step');
		}

		if (localStorage.getItem('yext_wizard_step') !== null) {
			return localStorage.getItem('yext_wizard_step');
		}

		return 0;
	}

	/**
	 * Gather a list of required fields that have missing values
	 *
	 * @param {HTMLElement} target Field group
	 * @return {HTMLInputElement[]} Array of input elements
	 */
	function checkRequiredFields(target) {
		const fields = Array.from(target.querySelectorAll('input'));

		return fields.filter((input) => input.required && !input.value.trim().length);
	}

	function init() {
		const currentStep = getCurrentStep();

		STATE.step = Number(currentStep);
	}

	/**
	 * Update progress bar
	 *
	 * @param {number} index Progress id
	 */
	function updateProgressBar(index) {
		const activeStepIndex = PROGRESS_STEPS.findIndex(
			(step) => Number(step.getAttribute('data-progress-id')) === index,
		);
		const completedSteps = PROGRESS_STEPS.slice(0, activeStepIndex);
		const activeStep = PROGRESS_STEPS[activeStepIndex];

		PROGRESS_STEPS.forEach((step) => {
			step.classList.remove(ACTIVE_PROGRESS_STEP_CLASSNAME);
			step.classList.remove(COMPLETED_PROGRESS_STEP_CLASSNAME);

			if (completedSteps.includes(step)) {
				step.classList.add(COMPLETED_PROGRESS_STEP_CLASSNAME);
			}
		});

		activeStep.classList.add(
			activeStepIndex + 1 === PROGRESS_STEPS.length
				? COMPLETED_PROGRESS_STEP_CLASSNAME
				: ACTIVE_PROGRESS_STEP_CLASSNAME,
		);

		yextWizard.setAttribute('data-progress-id', String(index));
	}

	function updateWizard() {
		const { step: currentStep } = STATE;

		showStep(currentStep);
		yextWizard.setAttribute('data-step', String(currentStep));

		const { progressId } = STEPS[currentStep].dataset;
		updateProgressBar(Number(progressId));
	}

	function updateSearchParams() {
		const {
			location: { hash, host, pathname, protocol },
		} = window;
		const params = new URLSearchParams(window.location.search);
		params.set('step', String(STATE.step));
		const url = `${protocol}//${host}${pathname}?${params.toString()}${hash}`;

		window.history.replaceState({ path: url }, '', url);
	}

	function updateStorage() {
		localStorage.setItem('yext_wizard_step', String(STATE.step));
	}

	function updateSettings() {
		apiFetch({
			path: REST_API_ROUTE,
			method: 'POST',
			data: STATE.payload,
		}).catch((error) => {
			/* eslint-disable-next-line no-console */
			console.error(error);
			/* eslint-disable-next-line no-alert */
			window.alert(
				"There was an error updating the settings. Please make sure you're logged in and have the right authorization",
			);
		});
	}

	/**
	 * Add an error state to a list of fields
	 *
	 * @param {HTMLInputElement[]} fields HTML input elements
	 */
	function updateRequiredFields(fields) {
		if (Array.isArray(fields)) {
			fields.forEach((input) => {
				if (
					input instanceof HTMLInputElement &&
					input.required &&
					!input.value.trim().length
				) {
					input.classList.add('error');
				} else {
					input.classList.remove('error');
				}
			});
		}
	}

	/**
	 * Go to next step
	 *
	 * @param {Event} event Submit|Click Event
	 * @return {void}
	 */
	const maybeNext = (event) => {
		event.preventDefault();

		const currentStep = Number(STATE.step);

		if (currentStep + 1 === STEPS.length) {
			return;
		}

		const missingFields = checkRequiredFields(STEPS[currentStep]);

		if (!missingFields.length) {
			updateRequiredFields(Array.from(STEPS[currentStep].querySelectorAll('input')));
			STATE.step = currentStep + 1;
		} else {
			updateRequiredFields(missingFields);
		}
	};

	/**
	 * Go to previous step
	 *
	 * @param {Event} event Click Event
	 *
	 * @return {void}
	 */
	const back = (event) => {
		event.preventDefault();

		const currentStep = Number(STATE.step);

		if (currentStep === 0) {
			return;
		}

		STATE.step = currentStep - 1;
	};

	// Add event listeners
	FORM.addEventListener('submit', maybeNext);
	BACK_BUTTONS.forEach((button) => {
		button.addEventListener('click', back);
	});
	NEXT_BUTTONS.forEach((button) => {
		button.addEventListener('click', maybeNext);
	});
	SUBMIT_BUTTONS.forEach((button) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();

			STATE.payload = {
				settings: buildPayload(new FormData(FORM)),
				isLive: button.getAttribute('data-last-step'),
			};
		});
	});

	// Initialize
	init();
};

export default initWizard;
