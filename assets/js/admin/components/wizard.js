const HIDDEN_STEP_CLASSNAME = 'yext-wizard__step--hidden';
const ACTIVE_STEP_CLASSNAME = 'yext-wizard__step--active';

const COMPLETED_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--complete';
const ACTIVE_PROGRESS_STEP_CLASSNAME = 'yext-wizard__timeline-step--active';

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
	const STATE = new Proxy(
		{ step: Number(step) },
		{
			set: (object, prop, value) => {
				if (prop === 'step') {
					object[prop] = value;

					/* eslint-disable-next-line no-use-before-define */
					updateWizard();
				}

				object[prop] = value;

				return true;
			},
		},
	);

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
	const BACK_BUTTONS = Array.from(yextWizard.querySelectorAll('.yext-wizard__footer-back'));

	/**
	 * @type {HTMLElement[]}
	 */
	const NEXT_BUTTONS = Array.from(yextWizard.querySelectorAll('.yext-wizard__footer-next'));

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

	/**
	 * Go to next step
	 *
	 * @param {Event} event Submit|Click Event
	 *
	 * @return {void}
	 */
	const next = (event) => {
		event.preventDefault();

		const currentStep = Number(STATE.step);

		if (currentStep + 1 === STEPS.length) {
			return;
		}

		STATE.step = currentStep + 1;
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
	FORM.addEventListener('submit', next);
	BACK_BUTTONS.forEach((button) => {
		button.addEventListener('click', back);
	});
	NEXT_BUTTONS.forEach((button) => {
		button.addEventListener('click', next);
	});
};

export default initWizard;
