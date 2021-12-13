/**
 * Base Answers UI Component
 */
export default class Component {
	/**
	 * Construct a component.
	 *
	 * @param {string} name Component name.
	 * @param {Object} props Component props.
	 */
	constructor(name = '', props = {}) {
		this.name = name;
		this.props = props;
	}

	/**
	 * Register component using `addComponent` from the Answers UI SDK.
	 */
	register() {
		if (!window.ANSWERS) {
			throw new Error('Yext: Answers UI SDK is not loaded.');
		}

		window.ANSWERS.addComponent(this.name, this.props);
	}
}
