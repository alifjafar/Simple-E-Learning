var editor_config = {
    path_absolute: "/",
    selector: "#content",
    plugins: [
        "link image", "textcolor", "table", "table", "lists", "media", "code", "wordcount", "searchreplace",
        "visualblocks", "autolink",
    ],
    toolbar: [
        'undo redo | formatselect | bold italic strikethrough forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
    ],
    relative_urls: false,
    height: 350,
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'File Manager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }
};

tinymce.init(editor_config);
