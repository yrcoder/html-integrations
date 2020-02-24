// Load styles
import './static/style.css';

// Generate scripts
const jsDemoImagesTransform = document.createElement('script');
jsDemoImagesTransform.type = 'text/javascript';
jsDemoImagesTransform.src = 'https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image';

// Load generated sripts
document.head.appendChild(jsDemoImagesTransform);

// Set up the editor
tinymce.init({
  selector: '#editor',
  external_plugins: {
    tiny_mce_wiris: 'http://localhost:8006/node_modules/@wiris/mathtype-tinymce5/plugin.min.js',
  },
  toolbar: 'undo redo | styleselect | bold italic | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',

  // Handle on loaded content event
  setup(editor) {
    editor.on('LoadContent', () => {
      const editorContent = tinyMCE.activeEditor.getContent();
      document.getElementById('editorContentTransform').innerHTML = editorContent;
    });
  },
});

// Takes the data of the editor
// Replaces the content of a div with the data transformed
function updateFunction() {
  const editorContent = tinyMCE.activeEditor.getContent();
  document.getElementById('editorContentTransform').innerHTML = editorContent;
  com.wiris.js.JsPluginViewer.parseElement(document.getElementById('editorContentTransform'));
}

// Add listener on click button to launch updateFunction
document.getElementById('btn-update').addEventListener('click', () => {
  updateFunction();
});
