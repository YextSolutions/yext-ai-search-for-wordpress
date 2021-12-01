/**
 * Render HTML in a test environment.
 *
 * @param {string} html HTML string.
 *
 * @return {{container: HTMLElement}} Object with `container` prop.
 */
export function render(html) {
	const container = document.createElement('div');
	container.innerHTML = html;
	document.body.appendChild(container);
	return { container };
}
