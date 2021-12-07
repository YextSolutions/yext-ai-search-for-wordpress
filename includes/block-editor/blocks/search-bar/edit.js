/**
 * External dependencies
 */
import camelcaseKeys from 'camelcase-keys';

/**
 * Internal dependencies
 */
import Inspector from './inspector';

const { config } = window.YEXT.settings;
const { apiKey, experienceKey, businessId } = camelcaseKeys(config);

const { __ } = wp.i18n;
const { useBlockProps } = wp.blockEditor;

const isValid = apiKey && experienceKey && businessId;

/**
 * Search bar component for block editor.
 *
 * @param {Object} props Component props.
 * @return {Object} Block component.
 */
const Edit = (props) => {
	const {
		attributes: { placeholderText, submitText, labelText },
	} = props;
	const blockProps = useBlockProps();

	return isValid ? (
		<>
			<Inspector {...props} />
			<div {...blockProps}>
				<div className="yxt-Answers-component yxt-SearchBar-wrapper">
					<div className="yxt-SearchBar">
						<div className="yxt-SearchBar-container">
							<div className="yxt-SearchBar-form">
								<input
									className="js-yext-query yxt-SearchBar-input"
									type="text"
									name="query"
									value=""
									aria-label={labelText}
									autoComplete="off"
									autoCorrect="off"
									spellCheck="false"
									placeholder={placeholderText}
								/>
								<button
									type="submit"
									className="js-yext-submit yxt-SearchBar-button"
								>
									<div className="js-yxt-AnimatedForward component yxt-SearchBar-AnimatedIcon--inactive">
										<div
											className="Icon Icon--yext_animated_forward Icon--lg"
											aria-hidden="true"
										/>
									</div>
									<div
										className="js-yxt-AnimatedReverse component"
										data-component="IconComponent"
									>
										<div
											className="Icon Icon--yext_animated_reverse Icon--lg"
											aria-hidden="true"
										>
											{/* <img src ="/assets/svg/logo.svg"/> */}
										</div>
									</div>
									<span className="yxt-SearchBar-buttonText sr-only">
										{submitText}
									</span>
								</button>
							</div>
							<div className="yxt-SearchBar-autocomplete yxt-AutoComplete-wrapper js-yxt-AutoComplete-wrapper component">
								<div className="yxt-AutoComplete">
									<ul className="yxt-AutoComplete-results">
										<li className="js-yext-autocomplete-option yxt-AutoComplete-option yxt-AutoComplete-option--item">
											{__('Example autocomplete results', 'yext')}
										</li>

										<li className="js-yext-autocomplete-option yxt-AutoComplete-option yxt-AutoComplete-option--item">
											{__('Search results dropdown example', 'yext')}
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</>
	) : (
		<h1>Invalid</h1>
	);
};

export default Edit;
