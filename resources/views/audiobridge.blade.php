<div id="room">
    <div class="col-md-6">
        <div class="panel text-center">

            <div class="my-2 text-center text-xl">
                Видеокомната
            </div>

            <button class="btn my-2" autocomplete="off" id="start_call"  @click="startCall">
                Начать видеозвонок
            </button>

            <div class="hidden">
                <button class="btn hide " autocomplete="off" id="phone-icon">
                    <font-awesome-icon icon="phone"></font-awesome-icon>
                </button>

                <button class="btn " autocomplete="off" id="phone-slash-icon">
                    <font-awesome-icon icon="microphone-slash"></font-awesome-icon>
                </button>
            </div>

            <div class="hidden" id="control-buttons">
            <button class="btn hide " autocomplete="off" id="toggleaudio">
                    <span id="volume-mute-icon" v-if="audioenabled">
                      <font-awesome-icon icon="volume-mute"></font-awesome-icon></span>
                <span id="volume-icon" v-else>
                      <font-awesome-icon icon="volume-up"></font-awesome-icon></span>
            </button>

            <button class="btn  m-2" autocomplete="off" id="start" @click="startVideo">
                    <span id="video-icon" v-if="!videoRoomStreaming" >
                      <font-awesome-icon icon="video"></font-awesome-icon></span>
                <span id="video-slash-icon" v-else>
                      <font-awesome-icon icon="video-slash"></font-awesome-icon></span>
            </button>
            </div>
        </div>
        <div class="panel-body">
            <ul id="list" class="list-group">
            </ul>
        </div>
    </div>
    <div class="col-md-6 hidden">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mixed Audio</h3>
            </div>
            <div class="panel-body" id="mixedaudio"></div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", function () {
        var audioBridgeApp = new Vue({
            el: '#room',
            data() {
                return {
                    videoRoomStreaming: false,
                    audioenabled: false,
                    devMode:false,
                }
            },
            methods: {
                afterAudioStart() {
                    startVideo()
                },
                startCall: function () {
                    $('#control-buttons').removeClass('hidden');
                    $('#start_call').remove();
                    startAudio();
                },
                startVideo: function () {
                    if (!window.videoRoomApp.is_started) {
                        if (!this.devMode) {
                            startVideo();
                        }
                        this.videoRoomStreaming = true;
                    } else if (mystream) {
                        var unpublish = {"request": "unpublish"};
                        sfutest.send({"message": unpublish});
                        this.videoRoomStreaming = false;
                    } else {
                        window.videoRoomApp.publishOwnFeed();
                        this.videoRoomStreaming = true;
                    }
                },
                startScreensharing: function () {
                    $('#screensharing_plugin').removeClass('hidden');
                    window.roomApp.screensharingStarted = true;
                    window.roomApp.chat_tasks_panel_opened = false;
                    this.screensharingStarted = true;
                    if (!this.devMode) {
                        startScreensharing();
                    }
                },
            },
            mounted: function () {
                if (!this.devMode) {
                window.audioBridgeApp = this;
                }
            }
        });
    });
</script>
