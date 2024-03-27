/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

(function(){

	const T3_FAQ_ITEM_CLASS = 'wp-block-t3-faq-item';
	const T3_FAQ_BUTTON_CLASS = 'wp-block-t3-faq-button';
	const T3_FAQ_COLLAPSE_CLASS = 'wp-block-t3-faq-collapse';

	const T3_FAQ_BUTTON_ACTIVE_CLASS = T3_FAQ_BUTTON_CLASS + '--active';
	const T3_FAQ_COLLAPSE_ACTIVE_CLASS = T3_FAQ_COLLAPSE_CLASS + '--active';

	const T3_FAQ_ITEM_SELECTOR = '.' + T3_FAQ_ITEM_CLASS;
	const T3_FAQ_BUTTON_SELECTOR = '.' + T3_FAQ_BUTTON_CLASS;
	const T3_FAQ_BUTTON_ACTIVE_SELECTOR = '.' + T3_FAQ_BUTTON_ACTIVE_CLASS;
	const T3_FAQ_COLLAPSE_SELECTOR = '.' + T3_FAQ_COLLAPSE_CLASS;
	const T3_FAQ_COLLAPSE_ACTIVE_SELECTOR = '.' + T3_FAQ_COLLAPSE_ACTIVE_CLASS;
	const T3_FAQ_DATA_SELECTOR = '[data-t3-toggle="collapse"]';

	const px = function(px) {
		return px + 'px';
	}

	const setItemInactive = function(item) {
		const button = item.querySelector(T3_FAQ_BUTTON_SELECTOR);
		const collapse = item.querySelector(T3_FAQ_COLLAPSE_SELECTOR);

		button.classList.remove(T3_FAQ_BUTTON_ACTIVE_CLASS);
		button.setAttribute('aria-expanded',false);

		collapse.classList.remove(T3_FAQ_COLLAPSE_ACTIVE_CLASS);
		collapse.style.height = 0;
	}

	const setItemActive = function(item) {
		const button = item.querySelector(T3_FAQ_BUTTON_SELECTOR);
		const collapse = item.querySelector(T3_FAQ_COLLAPSE_SELECTOR);

		collapse.style.height = 'auto';
		let height = collapse.offsetHeight;
		collapse.style.height = '0';
		setTimeout(() => { collapse.style.height = px(height); },0);

		collapse.classList.add(T3_FAQ_COLLAPSE_ACTIVE_CLASS);
		button.classList.add(T3_FAQ_BUTTON_ACTIVE_CLASS);
		button.setAttribute('aria-expanded',true);
	}

	const onPageLoad = function() {
		let active = document.querySelector(T3_FAQ_COLLAPSE_ACTIVE_SELECTOR);
		if(active){ active.style.height = px(active.offsetHeight); }

		var buttons = document.querySelectorAll(T3_FAQ_DATA_SELECTOR);
		buttons.forEach(function(button){
			button.addEventListener('click',function(){
				let isActive = this.classList.contains(T3_FAQ_BUTTON_ACTIVE_CLASS);
				document.querySelectorAll(T3_FAQ_ITEM_SELECTOR).forEach( item => setItemInactive(item) );
				if(!isActive){ setItemActive(this.parentElement.parentElement); }
			});
		});
	}
	window.onload = onPageLoad;
})();
