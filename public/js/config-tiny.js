var editor_config = {
    path_absolute: "/",
    selector: "#editor",
    plugins: [
        "textcolor", "table", "table", "lists", "code", "wordcount", "searchreplace",
        "visualblocks", "autolink",
    ],
    toolbar: [
        'undo redo | formatselect | bold italic strikethrough forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
    ],
    relative_urls: false,
    height: 200,
};

tinymce.init(editor_config);
