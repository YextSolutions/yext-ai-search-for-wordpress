const getRequiredFields = (target) => {
	if (!target) {
		return [];
	}

	const fields = Array.from(target.querySelectorAll('input'));

	return fields.filter((input) => input.getAttribute('data-required') === '1');
};

const isRequiredField = (input) =>
	input instanceof HTMLInputElement && input.getAttribute('data-required') === '1';

const setIsInvalid = (event) => {
	const {
		target,
		target: { value },
	} = event;

	if (!value.trim().length) {
		target.classList.add('is-invalid');
	} else {
		target.classList.remove('is-invalid');
	}
};

const watchRequiredFields = (fields) => {
	fields.forEach((input) => {
		if (isRequiredField(input)) {
			input.addEventListener('input', setIsInvalid);
		}
	});
};

const ignoreRequiredFields = (fields) => {
	fields.forEach((input) => {
		if (isRequiredField(input)) {
			input.removeEventListener('input', setIsInvalid);
		}
	});
};

const updateRequiredFields = (fields) => {
	fields.forEach((input) => {
		if (isRequiredField(input)) {
			if (!input.value.trim().length) {
				input.classList.add('is-invalid');
			} else {
				input.classList.remove('is-invalid');
			}
		}
	});
};

const setIsTouched = (event) => {
	event.target.classList.add('is-touched');
};

const watchInputFields = (fields) => {
	fields.forEach((input) => {
		input.addEventListener('focus', setIsTouched);
	});
};

const ignoreInputFields = (fields) => {
	fields.forEach((input) => {
		input.removeEventListener('focus', setIsTouched);
	});
};

export {
	getRequiredFields,
	ignoreInputFields,
	ignoreRequiredFields,
	updateRequiredFields,
	watchInputFields,
	watchRequiredFields,
};
