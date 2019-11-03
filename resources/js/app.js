// markdown editor
import EasyMDE from "./vendor/easymde/easymde";
const axios = require('axios').default;

const editors = document.getElementsByClassName("markdown-editor");
const token = document.head.querySelector("meta[name=\"csrf-token\"]");

if (editors.length) {
  const imageUploadEndpoint = editors[0].getAttribute("data-upload-url");
  /* eslint-disable no-new */
  new EasyMDE({
    spellChecker: false,
    autoDownloadFontAwesome: false,
    imageCSRFToken: token.content,
    element: editors[0],
    toolbar: [
      "bold",
      "italic",
      "heading",
      "strikethrough",
      "|",
      "quote",
      "unordered-list",
      "ordered-list",
      "code",
      "|",
      "link",
      imageUploadEndpoint !== "" ? "upload-image" : "image",
      "table",
      "horizontal-rule",
      "|",
      "preview",
      "side-by-side",
      "fullscreen",
      "|",
      "undo",
      "redo"
    ],
    autosave: {
      enabled: true,
      delay: 10000,
      uniqueId: window.location
    },
    uploadImage: imageUploadEndpoint !== "",
    imageUploadEndpoint: imageUploadEndpoint,
    imageMaxSize: parseInt(editors[0].getAttribute("data-max-size"), 10),
    // previewRender: function (plainText) {
    //   return MarkdownIt.render(plainText); // Returns HTML from a custom parser
    // }
      previewRender: function(plainText, preview) { // Async method
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
        axios.post(editors[0].getAttribute("data-preview-url"), {payload: plainText})
            .then(function(response) {
                preview.innerHTML = response.data.data.html;
            });
          return "";
      },
  });
}

// basic confirm dialog trigger:
// uses data-confirm attribute and it's content to confirm the click event
(function () {
  document.addEventListener(
    "click",
    function (e) {
      if (e.which !== 1) {
        return true;
      }
      const attrName = "data-confirm";

      const el = e.target || e.srcElement;
      if (!el.hasAttribute(attrName)) {
        return true;
      }

      if (!confirm(el.getAttribute(attrName))) {
        e.preventDefault();
        e.stopImmediatePropagation();
        return false;
      }
      return true;
    },
    false
  );
})();
