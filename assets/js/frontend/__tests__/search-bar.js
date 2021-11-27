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

const globalConfig = {
	apiKey: process.env.YEXT_ANSWERS_API_KEY,
	experienceKey: process.env.YEXT_ANSWERS_EXPERIENCE_KEY,
	businessId: process.env.YEXT_ANSWERS_BUSINESS_ID,
    locale: 'en',
	templateBundle: global.TemplateBundle.default,
};

describe('Yext Search Bar UI SDK Component', () => {
    beforeEach(() => {
        const { container } = render(`
            <div class="yext-search-bar" data-testid="yext-search-bar-1"></div>
            <div class="yext-search-bar" data-testid="yext-search-bar-2"></div>
            <div
                class="custom-search-bar"
                data-placeholder-text="Custom Placeholder Text"
                data-label-text="Custom Label Text"
                data-submit-text="Custom Submit Text"
                data-testid="custom-search-bar"
            ></div>
        `);
    
        globalContainer = container;
    });
    
    afterEach(() => {
        document.body.removeChild(globalContainer);
    });

    test('search bar fails without valid credentials', () => {
        const AnswersSDK = Answers({
            config: {
                ...globalConfig,
                apiKey: '',
            },
            components: {
                searchBar: {},
            },
        });
    
        expect(AnswersSDK).toHaveProperty('error');
    });
    
    test('search bar renders', async () => {
        const AnswersSDK = Answers({
            config: globalConfig,
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
    
        await AnswersSDK.init();
    
        const search1 = screen.getByTestId('yext-search-bar-1');
        const search2 = screen.getByTestId('yext-search-bar-2');
        const customSearch = screen.getByTestId('custom-search-bar');

        expect(search1.querySelector('label')).toHaveTextContent('Label Text');
        expect(search1.querySelector('input')).toHaveAttribute('placeholder', 'Placeholder Text');
        expect(search1.querySelector('button[type="submit"]')).toHaveTextContent('Submit Text');

        expect(search2.querySelector('label')).toHaveTextContent('Label Text');
        expect(search2.querySelector('input')).toHaveAttribute('placeholder', 'Placeholder Text');
        expect(search2.querySelector('button[type="submit"]')).toHaveTextContent('Submit Text');

        expect(customSearch.querySelector('label')).toHaveTextContent('Custom Label Text');
        expect(customSearch.querySelector('input')).toHaveAttribute('placeholder', 'Custom Placeholder Text');
        expect(customSearch.querySelector('button[type="submit"]')).toHaveTextContent('Custom Submit Text');

        expect(globalContainer).toMatchSnapshot();
    });
});
