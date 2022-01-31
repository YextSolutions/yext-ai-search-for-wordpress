/* eslint-disable no-use-before-define */

import merge from 'deepmerge';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs, getQueryArg, hasQueryArg } from '@wordpress/url';

import {
	getRequiredFields,
	ignoreInputFields,
	ignoreRequiredFields,
	updateRequiredFields,
	watchInputFields,
	watchRequiredFields,
} from '../utils/input';

const {
	YEXT: {
		settings: PLUGIN_SETTINGS,
		settings_url: PLUGIN_SETTINGS_URL,
		rest_url: REST_API_ROUTE,
	},
} = window;

const HIDDEN_STEP_CLASSNAME = 'yext-wizard__step--hidden';
const ACTIVE_STEP_CLASSNAME = 'yext-wizard__step--active';

const COMPLETED_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--complete';
const ACTIVE_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--active';

const buildPayload = (formData) => {
	const REGEX = /\[.*?\]/g;

	return !(formData instanceof FormData)
		? PLUGIN_SETTINGS
		: merge(
				PLUGIN_SETTINGS,
				// @ts-ignore
				[...formData].reduce((payload, current) => {
					const [name, value] = current;
					const parts = name
						.match(REGEX)
						?.map((part) => part.replace('[', '').replace(']', ''));

					const object = parts
						? parts.reduceRight(
								(obj, next, index) => ({
									[next]: index + 1 === parts.length ? value.trim() : obj,
								}),
								{},
						  )
						: {};

					return merge(payload, object);
				}, {}),
		  );
};

/**
 * Setup Wizard
 *
 * @return {void}
 */
const initWizard = () => {
	/** @typedef {import('../types').YextWizard} YextWizard */

	/**
	 * @type {YextWizard}
	 */
	const yextWizard = document.querySelector('#yext-wizard');

	if (!yextWizard) {
		return;
	}

	/**
	 * @type {HTMLFormElement}
	 */
	const FORM = yextWizard.querySelector('.yext-settings__form');

	if (!FORM) {
		return;
	}

	const { step } = yextWizard.dataset;
	const INITIAL_STATE = {
		step: Number(step),
		payload: {
			settings: buildPayload(new FormData(FORM)),
		},
	};

	const dispatch = (action, values) => {
		switch (action) {
			case 'step':
				updateWizard(values);
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
			const prev = object[prop];
			object[prop] = value;

			dispatch(prop, [prev, value]);

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

		STEPS[index]?.classList?.remove(HIDDEN_STEP_CLASSNAME);
		STEPS[index]?.classList?.add(ACTIVE_STEP_CLASSNAME);
	}

	const setStep = (step) => Math.min(Math.max(Number(step), 0), 7);

	/**
	 * Get plugin `live` state
	 *
	 * @param {HTMLElement} target HTML Element
	 * @return {boolean} Returns true if `target` has `data-is-live` attribute.
	 * Fallback to current plugin settings.
	 */
	const isLive = (target) =>
		target?.getAttribute('data-is-live') === '1' || PLUGIN_SETTINGS?.wizard?.live === '1';

	/**
	 * Get the current step index from URL or HTML
	 *
	 * @return {number} Current step index
	 */
	function getCurrentStep() {
		if (hasQueryArg(window.location.href, 'step')) {
			const step = getQueryArg(window.location.href, 'step');

			if (!Number.isNaN(step) && Number(step) >= 0 && Number(step) + 1 < STEPS.length) {
				return Number(step);
			}
		}

		return Number(yextWizard.getAttribute('data-step'));
	}

	function init() {
		const currentStep = getCurrentStep();

		STATE.step = setStep(currentStep);

		yextWizard.state = STATE;
	}

	function updateInputFields(steps) {
		const [previousStep, currentStep] = steps;

		if (previousStep) {
			const previousRequiredFields = getRequiredFields(STEPS[previousStep]);
			const previousInputFields = Array.from(
				STEPS[previousStep]?.querySelectorAll('input') || [],
			);
			ignoreRequiredFields(previousRequiredFields);
			ignoreInputFields(previousInputFields);
		}

		if (currentStep) {
			const requiredFields = getRequiredFields(STEPS[currentStep]);
			const inputFields = Array.from(STEPS[currentStep]?.querySelectorAll('input') || []);
			watchRequiredFields(requiredFields);
			watchInputFields(inputFields);
		}
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

	function updateWizard(state) {
		const [, currentStep] = state;

		if (Number(currentStep) !== STEPS.length) {
			showStep(currentStep);

			updateInputFields(state);

			yextWizard.setAttribute('data-step', String(currentStep));
			yextWizard.setAttribute(
				'data-is-live',
				String(Number(STATE.step) + 1 === STEPS.length),
			);
			window.history.replaceState(
				{ step: currentStep },
				'',
				addQueryArgs(window.location.href, { step: currentStep }),
			);

			const { progressId } = STEPS[currentStep]?.dataset || {};
			if (progressId) {
				updateProgressBar(Number(progressId));
			}
		}
	}

	function updateSettings() {
		const {
			payload: {
				settings: {
					wizard: { active },
				},
			},
			payload,
		} = STATE;

		apiFetch({
			path: `${REST_API_ROUTE}/settings`,
			method: 'POST',
			data: payload,
		})
			.then(() => {
				if (!active) {
					import('dompurify').then(({ default: DOMPurify }) => {
						window.location.href = DOMPurify.sanitize(PLUGIN_SETTINGS_URL);
					});
				}
			})
			.catch((error) => {
				/* eslint-disable-next-line no-console */
				console.error(error);
				/* eslint-disable-next-line no-alert */
				window.alert(
					"There was an error updating the settings. Please make sure you're logged in and have proper authorization.",
				);
			});
	}

	/**
	 * Go to next step
	 *
	 * @param {Event} event Submit|Click Event
	 * @return {void}
	 */
	const maybeNext = (event) => {
		event.preventDefault();

		const { target } = event;
		const currentStep = Number(STATE.step);

		const missingFields = getRequiredFields(STEPS[currentStep]).filter(
			(input) => !input.value.trim().length,
		);

		if (missingFields.length) {
			updateRequiredFields(missingFields);
			return;
		}

		const inputFields = Array.from(STEPS[currentStep].querySelectorAll('input'));
		// @ts-ignore
		const live = isLive(target);

		if (inputFields.length) {
			updateRequiredFields(inputFields);
		}

		if (currentStep + 1 !== STEPS.length) {
			STATE.step = setStep(currentStep + 1);
		}

		STATE.payload = {
			settings: merge(buildPayload(new FormData(FORM)), {
				wizard: {
					current_step: live ? 0 : Number(STATE.step),
					live,
					active: STEPS[currentStep].getAttribute('data-last-step') !== '1',
				},
			}),
		};
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

		const { target } = event;
		const currentStep = Number(STATE.step);

		if (currentStep === 0) {
			return;
		}

		STATE.step = setStep(currentStep - 1);

		STATE.payload = {
			settings: merge(buildPayload(new FormData(FORM)), {
				wizard: {
					current_step: Number(STATE.step),
					// @ts-ignore
					live: isLive(target),
					active: true,
				},
			}),
		};
	};

	// Add event listeners
	FORM.addEventListener('submit', maybeNext);
	BACK_BUTTONS.forEach((button) => {
		button.addEventListener('click', back);
	});
	NEXT_BUTTONS.forEach((button) => {
		button.addEventListener('click', maybeNext);
	});

	// Initialize
	init();
};

export default initWizard;
