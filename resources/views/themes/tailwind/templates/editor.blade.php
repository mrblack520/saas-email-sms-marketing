@extends('theme::layouts.dashboard')




@section('content')


<ul class="nav">
    <li class="nav-item">
      <button id="save_html_btn" class="btn btn-primary">Save HTML</button>
    </li>
    <li class="nav-item">
      <button id="save_json_btn" class="btn btn-success">Save JSON</button>
    </li>
    <li class="nav-item">
      <button id="load_design_btn" class="btn btn-info">Load Design</button>
    </li>
  </ul>
<div style="height: 90vh" class="container mt-4">
    <h2>Template Editor</h2>

    <div>
        <!-- Render Unlayer Editor here -->
        <!-- Example: You might use a div with an id for Unlayer to target -->
        <div style="height: 90vh" id="editor-container"></div>

        <!-- Include Unlayer scripts -->
        <script src="https://editor.unlayer.com/embed.js?2"></script>
        <script>
            class EmailEditor {
              constructor(id) {
                unlayer.init({
                  id: id,
                  displayMode: "email",
                  appearance: {
                    panels: {
                      tools: {
                        dock: "left"
                      }
                    }
                  }
                });
              }

              loadDesign(design) {
                unlayer.loadDesign(design);
              }

              saveDesign(callback) {
                unlayer.saveDesign(callback);
              }

              exportHtml(callback) {
                unlayer.exportHtml(callback, {
                  minify: true,
                  cleanup: true
                });
              }

              downloadHtml(htmlContent, fileName) {
                const blob = new Blob([htmlContent], { type: 'text/html' });
                const a = document.createElement('a');
                a.href = window.URL.createObjectURL(blob);
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
              }

              downloadjson(JSONContent, fileName) {
                const jsonString = JSON.stringify(JSONContent);
                const blob = new Blob([jsonString], { type: 'application/json' });
                const a = document.createElement('a');
                a.href = window.URL.createObjectURL(blob);
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
              }
            }

            const templateJson = localStorage.getItem('selectedTemplate');
            const storedTemplate = JSON.parse(templateJson);
// Initialize the Unlayer editor and load the template
const editor = new EmailEditor('editor-container');
editor.loadDesign(storedTemplate);
const saveHTMLBtn = document.getElementById('save_html_btn');
    const loadDesignBtn = document.getElementById('load_design_btn');
    const save_json_btn = document.getElementById('save_json_btn');

    let exportedHtmlData;
    saveHTMLBtn.addEventListener('click', e => {
      editor.exportHtml(data => {
        // const {  design } = data;
        //  console.log('exportHtml', design);
        editor.downloadHtml(data.html, 'exported_email.html');
      });
    });

    save_json_btn.addEventListener('click', e => {
      editor.exportHtml(data => {
        
    const {design}  = data;
    
        editor.downloadjson(design, 'exported_email.json');
      });
    });


loadDesignBtn.addEventListener('click', e => {
  editor.exportHtml(data => {

    // const {design}  = data;
//     const jsonString1 = JSON.stringify(design);
    
//          console.log(JSON.stringify( jsonString1 ));
    
//    fetch('{{ route('save_design') }}', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': '{{ csrf_token() }}',
//       },
//       body: jsonString1,
//     })
//       .then(response => {
//         if (!response.ok) {
//           throw new Error('Failed to save design to the database');
//         }
//         return response.json();
//       })
//       .then(responseData => {
//         // Handle the response data if needed
//         console.log(responseData);
//       })
//       .catch(error => {
//         console.error('Error:', error);
//       });
      const designHtml = data.html;

      var a=  localStorage.setItem('designHtml', designHtml);
    const routeUrl = "{{ route('edit_index') }}";
    window.location.href = routeUrl;


    
  });
});
        </script>
    </div>

</div>

@endsection