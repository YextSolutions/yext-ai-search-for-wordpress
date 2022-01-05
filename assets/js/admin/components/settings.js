import { getRequiredFields, updateRequiredFields } from '../utils/input';

const initSettings = () => {
	const yextForm = document.querySelector('#yext-settings form');

	if (!yextForm) {
		return;
	}

	const handleFormSubmit = (event) => {
		event.preventDefault();

		const activeTab = yextForm.querySelector('.tab-content.is-active');

		const missingFields = getRequiredFields(activeTab).filter(
			(input) => !input.value.trim().length,
		);

		if (missingFields.length) {
			updateRequiredFields(missingFields);
			return;
		}

		event.target.submit();
	};

	yextForm.addEventListener('submit', handleFormSubmit);
};

export default initSettings;
