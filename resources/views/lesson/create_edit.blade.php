@extends('layouts.default')

@section('content')
    @if ($create)
        {{ Breadcrumbs::render('lesson.create', $course) }}
    @else
        {{ Breadcrumbs::render('lesson.edit', $model) }}
    @endif
    <div class=" sm:flex sm:justify-center h-screen p-2 pt-4" id="vue">
        <notifications group="foo" :classes="'mt-2 mr-2 notification'"></notifications>
        {{ Form::model($model, ['route' => $route, 'method' => 'post']) }}
        {{ Form::text('course_id', (isset($course) ? $course->id : $model->course->id), ['class' => 'hidden']) }}
        {{ Form::label('name', 'Название', ['class' => 'label'])}}
        {{ Form::text('name', null, ['class' => 'input']) }}
        {{ Form::label('description', 'Описание', ['class' => 'label'])}}
        {{ Form::text('description', null, ['class' => 'input']) }}
        {{ Form::label('content', 'содержание', ['class' => 'label'])}}
        <input :value="content" name="content" class="hidden">
        <tinymce v-bind:editor-data="content" v-on:update="content = $event"></tinymce>

        <div v-for="attachment in attachments" class="mt-1 flex">
                <div v-if="attachment.type === 'image'" class="w-16 h-16">
                    <img class="max-h-full"
                         v-bind:src="'{{ URL::to('/') }}' + attachment.path">
                </div>
                <div v-else :class="'btn text-center'">
                    <fa icon="download"></fa>
                    file
                </div>
            <button v-clipboard="'{{ URL::to('/') }}' + attachment.path" class="btn" type="button">
                <fa icon="copy"></fa>
            </button>
            <button @click="deleteAttachment(attachment.id)" class="btn" type="button">
                <fa icon="trash"></fa>
            </button>
        </div>

        <file-upload
            ref="upload"
            v-model="files"
            :multiple="true"
            class="btn m-2"
            @input-filter="inputFilter"
            :drop="true"
            :drop-directory="true"
        >
            <i class="fa fa-paperclip" aria-hidden="true"></i>
        </file-upload>
        <button class="btn m-2" type="button" v-on:click="send()" ref="send">
            <fa icon="arrow-up"></fa>
        </button>

        <ul>
            <li v-for="(file, index) in files" :key="file.id" :class="file.thumb ? '' : 'my-3'">
                <span></span>
                <span><img v-if="file.thumb" :src="file.thumb" width="40" height="auto" alt="no picture"
                           class="inline-block"/>@{{file.name}}</span>
                -
                <span>@{{bytesToSize(file.size)}}</span>

                <a class="btn" href="#" @click.prevent="$refs.upload.remove(file)">
                    <fa icon="trash"></fa>
                </a>
            </li>
        </ul>

        <br>
        {{ Form::label('is_public', 'Опубликован', ['class' => 'label inline-block']) }}
        {{ Form::checkbox('is_public', true, $create ? true : $model->is_public) }}
        <div class="flex justify-center m-2">
            {{ Form::submit(($create ? 'Создать' : 'Обновить'), ['class' => 'text-3xl lg:text-xl block px-4 btn']) }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ Form::close() }}
    </div>

    <script>
        window.addEventListener("load", function () {
            var app = new Vue({
                el: '#vue',
                data() {
                    return {
                        content: '<?= $model->content?>',
                        lesson_id: '<?= $model->id?>',
                        files: [],
                        attachments: []
                    };
                },
                methods: {
                    inputFilter(newFile, oldFile, prevent) {
                        console.log(this.files)
                        if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                            newFile.blob = ''
                            let URL = window.URL || window.webkitURL
                            if (URL && URL.createObjectURL) {
                                newFile.blob = URL.createObjectURL(newFile.file)
                            }
                            newFile.thumb = ''
                            if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                                newFile.thumb = newFile.blob
                            }
                        }
                    },
                    bytesToSize(bytes) {
                        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                        if (bytes == 0) return 'n/a';
                        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                        if (i == 0) return bytes + ' ' + sizes[i];
                        return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
                    },
                    send() {
                        var self = this;
                        if (this.files.length === 0) {
                            return;
                        }
                        const data = new FormData()
                        Array.from(this.files).forEach(file => {
                            data.append('files[]', file.file)
                        });
                        self.$notify({
                            group: 'foo',
                            type: 'warn',
                            title: 'started',
                            text: 'file uploading started'
                        })
                        axios.post('<?= route('attachments.store', '')?>' + this.lesson_id, data).then(() => {
                            this.getAttachments();
                            self.$notify({
                                group: 'foo',
                                type: 'success',
                                title: 'success',
                                text: 'file uploaded'
                            })
                            this.files = [];
                        }).catch(() => {
                            self.$notify({
                                group: 'foo',
                                type: 'error',
                                title: 'error',
                                text: 'file not uploaded'
                            })
                        })
                    },
                    async getAttachments() {
                        try {
                            const response = await axios.get('<?= route('attachments.show', '')?>' + this.lesson_id);
                            console.log(response);
                            this.attachments = response.data;
                        } catch (error) {
                            console.error(error);
                        }
                    },
                    deleteAttachment(id) {
                        var self = this;
                        axios.get('<?= route('attachments.delete', '')?>/'+id).then((response) => {
                            self.$notify({
                                group: 'foo',
                                type: 'success',
                                title: 'success',
                                text: response.data
                            })
                            this.getAttachments()
                        })
                    },
                },
                mounted() {
                    this.getAttachments()
                }
            });
        });
    </script>
@endsection
