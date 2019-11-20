/*!
 * Adds a class to the body when the handler is clicked and toggles the
 * handle element aria-expanded value
 *
 * Example handle:
 * --------------------------------------------------------------
 *
 * <button
 *    aria-controls="main__aside"
 *    aria-expanded="true"
 *    data-toggle-handler="expandSidebar"
 *    data-toggle-callback="setMainAsideStatus">...</button>
 *
 *
 * Handle optional attributes:
 * --------------------------------------------------------------
 *
 * data-toggle-callback - callback after the element was toggled
 *
 *
 * Target:
 * --------------------------------------------------------------
 *
 * <div id="main__aside">...</div>
 *
 * When the handle is clicked we call the callback.
 */
import camelCase from "lodash/camelCase";

// handlers
const handlers = {};
// load the handlers from the toggleHandlers directory using webpack:
// see: https://github.com/chrisvfritz/vue-enterprise-boilerplate/blob/master/src/components/_globals.js
const requireHandlers = require.context(
    "./toggleHandlers",
    false,
    /[\w-]+\.js$/
);
requireHandlers.keys().forEach(fileName => {
    // Get the handler config
    const handlerConfig = requireHandlers(fileName);
    const handlerName = camelCase(
        fileName
            // Remove the "./_" from the beginning
            .replace(/^\.\/_/, "")
            // Remove the file extension from the end
            .replace(/\.\w+$/, "")
    );
    handlers[handlerName] = handlerConfig.default || handlerConfig;
});

// on click we toggle the target
document.addEventListener("click", function(e) {
    if (e.which !== 1) {
        return true;
    }

    let callbackAttrName = "data-toggle-handler",
        el = e.target || e.srcElement;

    if (!el.hasAttribute(callbackAttrName)) {
        return true;
    }
    if (el) {
        let callback = el.getAttribute(callbackAttrName),
            target = document.querySelector(`#${el.getAttribute("aria-controls")}`);
        if (callback) {
            e.preventDefault();
            new handlers[callback](el, target).toggle();
        }
    }
});
