<template>
    <div id="app">
        <editor
            api-key="20nhax22w3loedproz3lxs017q5lv4hgkgwtwfjh979edysf"
            v-model="userInput"
            :init="{
         height: 500,
         plugins: [
           'advlist autolink lists link image charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime media table paste code help wordcount '
         ],
         images_upload_url: 'postAcceptor.php',
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent  | removeformat | help',
           mobile: {
                menubar: true,
                plugins: [ 'autosave image media autolink', 'lists', ],
                toolbar: [ 'undo styleselect' ]
            }
       }"
        />
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'

    export default {
        name: 'app',
        components: {
            'editor': Editor
        },
        props: ['editorData'],
        data() {
            return {
            };
        },
        computed: {
            userInput: {
                get: function () {
                    return this.editorData;
                },
                set: function (newValue) {
                    this.$emit('update', newValue)
                }
            },
        }
    }
</script>
