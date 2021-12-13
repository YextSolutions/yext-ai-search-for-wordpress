/**
 * External dependencies
 */
import { screen } from '@testing-library/dom';
import '@testing-library/jest-dom';

/**
 * Internal dependencies
 */
import { render } from './utils/dom';
import Answers from '../components/answers';

let globalContainer;
let globalAnswers;

const globalConfig = {
	config: {
		apiKey: 'test',
		experienceKey: 'test',
		businessId: '123',
		locale: 'en',
		templateBundle: global.TemplateBundle.default,
	},
	components: {
		searchBar: {
			props: {},
		},
	},
};

describe('Yext Search Bar UI SDK Component', () => {
	beforeEach(async () => {
		const { container } = render(`
			<div class="yext-search-bar" data-testid="yext-search-bar-1"></div>
		`);

		globalContainer = container;
	});

	afterEach(() => {
		document.body.removeChild(globalContainer);
		global.ANSWERS.components._activeComponents = [];
		global.ANSWERS.components._componentIdCounter = 0;
		globalAnswers = null;
	});

	test('search bar fails without valid credentials', async () => {
		globalAnswers = Answers({
			...globalConfig,
			config: {
				...globalConfig.config,
				apiKey: '',
			},
		});

		expect(globalAnswers).toHaveProperty('error');
	});

	test('search bar renders', async () => {
		globalAnswers = Answers(globalConfig);
		await globalAnswers.init();

		const search1 = screen.getByTestId('yext-search-bar-1');

		expect(search1.querySelector('label')).toBeInTheDocument();
		expect(search1.querySelector('input')).toBeInTheDocument();
		expect(search1.querySelector('button[type="submit"]')).toBeInTheDocument();

		expect(
			global.ANSWERS.components._activeComponents.filter(
				(component) => component._templateName === 'search/search',
			),
		).toHaveLength(1);
		expect(globalContainer).toMatchSnapshot();
	});

	test('search bar renders multiple instances', async () => {
		globalContainer.innerHTML +=
			'<div class="yext-search-bar" data-testid="yext-search-bar-2"></div>';
		globalAnswers = Answers(globalConfig);
		await globalAnswers.init();

		const search1 = screen.getByTestId('yext-search-bar-1');
		const search2 = screen.getByTestId('yext-search-bar-2');

		expect(search1.querySelector('label')).toBeInTheDocument();
		expect(search1.querySelector('input')).toBeInTheDocument();
		expect(search1.querySelector('button[type="submit"]')).toBeInTheDocument();

		expect(search2.querySelector('label')).toBeInTheDocument();
		expect(search2.querySelector('input')).toBeInTheDocument();
		expect(search2.querySelector('button[type="submit"]')).toBeInTheDocument();

		expect(
			global.ANSWERS.components._activeComponents.filter(
				(component) => component._templateName === 'search/search',
			),
		).toHaveLength(2);
		expect(globalContainer).toMatchSnapshot();
	});

	test('search bar renders custom element', async () => {
		globalContainer.innerHTML += `
			<div class="custom-search-bar" data-testid="custom-search-bar"></div>
		`;
		globalAnswers = Answers({
			...globalConfig,
			components: {
				searchBar: {
					props: {
						cssClass: 'custom-search-bar',
					},
				},
			},
		});
		await globalAnswers.init();

		const customSearch = screen.getByTestId('custom-search-bar');

		expect(customSearch.querySelector('label')).toBeInTheDocument();
		expect(customSearch.querySelector('input')).toBeInTheDocument();
		expect(customSearch.querySelector('button[type="submit"]')).toBeInTheDocument();

		expect(
			global.ANSWERS.components._activeComponents.filter(
				(component) => component._templateName === 'search/search',
			),
		).toHaveLength(2);
		expect(globalContainer).toMatchSnapshot();
	});

	test('search bar uses default props', async () => {
		globalAnswers = Answers({
			...globalConfig,
			components: {
				searchBar: {
					props: {
						labelText: 'Label Text',
						placeholderText: 'Placeholder Text',
						submitText: 'Submit Text',
					},
				},
			},
		});
		await globalAnswers.init();

		const search1 = screen.getByTestId('yext-search-bar-1');

		expect(search1.querySelector('label')).toHaveTextContent('Label Text');
		expect(search1.querySelector('input')).toHaveAttribute('placeholder', 'Placeholder Text');
		expect(search1.querySelector('button[type="submit"]')).toHaveTextContent('Submit Text');

		expect(
			global.ANSWERS.components._activeComponents.filter(
				(component) => component._templateName === 'search/search',
			),
		).toHaveLength(1);
		expect(globalContainer).toMatchSnapshot();
	});

	test('search bar prefers data attributes as props', async () => {
		globalContainer.innerHTML += `
			<div
				class="custom-search-bar"
				data-placeholder-text="Custom Placeholder Text"
				data-label-text="Custom Label Text"
				data-submit-text="Custom Submit Text"
				data-testid="custom-search-bar"
			></div>
		`;
		globalAnswers = Answers({
			...globalConfig,
			components: {
				searchBar: {
					props: {
						cssClass: 'custom-search-bar',
						labelText: 'Label Text',
						placeholderText: 'Placeholder Text',
						submitText: 'Submit Text',
					},
				},
			},
		});
		await globalAnswers.init();

		const search1 = screen.getByTestId('yext-search-bar-1');
		const customSearch = screen.getByTestId('custom-search-bar');

		expect(search1.querySelector('label')).toHaveTextContent('Label Text');
		expect(search1.querySelector('input')).toHaveAttribute('placeholder', 'Placeholder Text');
		expect(search1.querySelector('button[type="submit"]')).toHaveTextContent('Submit Text');

		expect(customSearch.querySelector('label')).toHaveTextContent('Custom Label Text');
		expect(customSearch.querySelector('input')).toHaveAttribute(
			'placeholder',
			'Custom Placeholder Text',
		);
		expect(customSearch.querySelector('button[type="submit"]')).toHaveTextContent(
			'Custom Submit Text',
		);

		expect(
			global.ANSWERS.components._activeComponents.filter(
				(component) => component._templateName === 'search/search',
			),
		).toHaveLength(2);
		expect(globalContainer).toMatchSnapshot();
	});
});
