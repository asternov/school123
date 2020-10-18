<div>
    <div id="videos">
        <div id="local" :class="'local-block panel '" style="display: none">
            <div class="text-center" id="videolocal"></div>
        </div>
        <div v-for="i in [1,2,3,4,5]" class="remote-block" :id="'remote-block-' + i"
             style="display: none">
            <div class="">
                <div class="m-3 bg-white relative" :id="'videoremote' + i"></div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", function () {
        var videoRoomApp = new Vue({
            el: '#videos',
            data() {
                return {
                    is_started: false,
                    abonents: [],
                    useVideo: true,
                    interval: null,
                    devMode: false,
                    possibleSizes: ['w-1/3', 'w-1/2', 'w-full'],
                    panelsSizes: {
                        'local': 'w-1/3', '1': 'w-1/3', '2': 'w-1/3',
                        '3': 'w-1/3', '4': 'w-1/3', '5': 'w-1/3',
                    },
                }
            },
            methods: {
                requestVideoCall(user_id) {
                    this.$axios.get('users/' + user_id + '/request_video_in/' + this.room_id)
                },
                renderFeeds() {
                    for (var i = 1; i <= 4; i++) {
                        document.getElementById('remote-block-' + i).style.display = i < feeds.length ? 'block' : "none";
                    }
                },
                startRender() {
                    this.interval = setInterval(this.renderFeeds, 1000);
                },
                publishOwnFeed() {
                    var useAudio = false;
                    sfutest.createOffer(
                        {
                            media: {audioRecv: false, videoRecv: false, audioSend: useAudio, videoSend: true},
                            simulcast: doSimulcast,
                            simulcast2: doSimulcast2,
                            success: function (jsep) {
                                Janus.debug("Got publisher SDP!");
                                Janus.debug(jsep);
                                var publish = {
                                    "request": "configure",
                                    "audio": useAudio,
                                    "video": true,
                                };
                                sfutest.send({"message": publish, "jsep": jsep});
                            },
                            error: function (error) {
                                Janus.error("WebRTC error:", error);
                                if (useAudio) {
                                    publishOwnFeed(false);
                                } else {
                                    window.videoRoomApp.$alert("WebRTC error... " + JSON.stringify(error));
                                    $('#publish').removeAttr('disabled').click(function () {
                                        publishOwnFeed(true);
                                    });
                                }
                            }
                        });
                },
            },
            mounted: function () {
                window.videoRoomApp = this;
            }
        });
    });
</script>
