
var server = 'https://phpgrad.com/janus';
var janus = null;
var mixertest = null;
var opaqueId = "audiobridgetest-"+Janus.randomString(12);
var audioStart = null;

var myroom = 1234;	// Demo room
var myusername = null;
var myid = null;
var webrtcUp = false;

$(document).ready(function() {
  // Initialize the library (all console debuggers enabled)
  Janus.init({debug: "all", callback: function() {
      // Use a button to start the demo
      startAudio = function() {
        //$(this).attr('disabled', true).unbind('click');
        // Make sure the browser supports WebRTC
        if(!Janus.isWebrtcSupported()) {
          window.audioBridgeApp.$alert("No WebRTC support... ");
          return;
        }
        // Create session
        janus = new Janus(
          {
            server: server,
            success: function() {
              // Attach to AudioBridge plugin
              janus.attach(
                {
                  plugin: "janus.plugin.audiobridge",
                  opaqueId: opaqueId,
                  success: function(pluginHandle) {
                    mixertest = pluginHandle;
                    Janus.log("Plugin attached! (" + mixertest.getPlugin() + ", id=" + mixertest.getId() + ")");
                    myusername =   'a-' + Math.floor(Math.random() * 1000);
                    var register = { "request": "join", "room": myroom, "ptype": "publisher", "display": myusername };
                    mixertest.send({ message: register});

                    document.getElementById('room').classList.remove('hidden');
                    document.getElementById('phone-icon').classList.add('hidden');
                    document.getElementById('phone-slash-icon').removeAttribute('class');
                  },
                  error: function(error) {
                    Janus.error("  -- Error attaching plugin...", error);
                    window.audioBridgeApp.$alert("Error attaching plugin... " + error);
                  },
                  consentDialog: function(on) {
                    Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                  },
                  iceState: function(state) {
                    Janus.log("ICE state changed to " + state);
                  },
                  mediaState: function(medium, on) {
                    Janus.log("Janus " + (on ? "started" : "stopped") + " receiving our " + medium);
                  },
                  webrtcState: function(on) {
                    Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                  },
                  onmessage: function(msg, jsep) {
                    Janus.debug(" ::: Got a message :::", msg);
                    var event = msg["audiobridge"];
                    Janus.debug("Event: " + event);
                    if(event) {
                      if(event === "joined") {
                        // Successfully joined, negotiate WebRTC now
                        if(msg["id"]) {
                          myid = msg["id"];
                          Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                          if(!webrtcUp) {
                            webrtcUp = true;
                            // Publish our stream
                            mixertest.createOffer(
                              {
                                media: { video: false},	// This is an audio only room
                                success: function(jsep) {
                                  Janus.debug("Got SDP!", jsep);
                                  var publish = { request: "configure", muted: false };
                                  mixertest.send({ message: publish, jsep: jsep });
                                    window.audioBridgeApp.afterAudioStart();
                                },
                                error: function(error) {
                                  Janus.error("WebRTC error:", error);
                                  bootbox.alert("WebRTC error... " + error.message);
                                }
                              });
                          }
                        }
                        // Any room participant?
                        if(msg["participants"]) {
                          var list = msg["participants"];
                          Janus.debug("Got a list of participants:", list);
                          for(var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if(muted === true || muted === "true")
                              $('#rp'+id + ' > i.abmuted').removeClass('hide').show();
                            else
                              $('#rp'+id + ' > i.abmuted').hide();
                            if(setup === true || setup === "true")
                              $('#rp'+id + ' > i.absetup').hide();
                            else
                              $('#rp'+id + ' > i.absetup').removeClass('hide').show();
                          }
                        }
                      } else if(event === "roomchanged") {
                        // The user switched to a different room
                        myid = msg["id"];
                        Janus.log("Moved to room " + msg["room"] + ", new ID: " + myid);
                        // Any room participant?
                        $('#list').empty();
                        if(msg["participants"]) {
                          var list = msg["participants"];
                          Janus.debug("Got a list of participants:", list);
                          for(var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if($('#rp'+id).length === 0) {
                              // Add to the participants list
                              $('#list').append('<li id="rp'+id+'" class="list-group-item">'+display+
                                ' <i class="absetup fa fa-chain-broken"></i>' +
                                ' <i class="abmuted fa fa-microphone-slash"></i></li>');
                              $('#rp'+id + ' > i').hide();
                            }
                            if(muted === true || muted === "true")
                              $('#rp'+id + ' > i.abmuted').removeClass('hide').show();
                            else
                              $('#rp'+id + ' > i.abmuted').hide();
                            if(setup === true || setup === "true")
                              $('#rp'+id + ' > i.absetup').hide();
                            else
                              $('#rp'+id + ' > i.absetup').removeClass('hide').show();
                          }
                        }
                      } else if(event === "destroyed") {
                        // The room has been destroyed
                        Janus.warn("The room has been destroyed!");
                        window.audioBridgeApp.$alert("The room has been destroyed", function() {
                          window.location.reload();
                        });
                      } else if(event === "event") {
                        if(msg["participants"]) {
                          var list = msg["participants"];
                          Janus.debug("Got a list of participants:", list);
                          for(var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            var setup = list[f]["setup"];
                            var muted = list[f]["muted"];
                            Janus.debug("  >> [" + id + "] " + display + " (setup=" + setup + ", muted=" + muted + ")");
                            if($('#rp'+id).length === 0) {
                              // Add to the participants list
                              $('#list').append('<li id="rp'+id+'" class="list-group-item">'+display+
                                ' <i class="absetup fa fa-chain-broken"></i>' +
                                ' <i class="abmuted fa fa-microphone-slash"></i></li>');
                              $('#rp'+id + ' > i').hide();
                            }
                            if(muted === true || muted === "true")
                              $('#rp'+id + ' > i.abmuted').removeClass('hide').show();
                            else
                              $('#rp'+id + ' > i.abmuted').hide();
                            if(setup === true || setup === "true")
                              $('#rp'+id + ' > i.absetup').hide();
                            else
                              $('#rp'+id + ' > i.absetup').removeClass('hide').show();
                          }
                        } else if(msg["error"]) {
                          if(msg["error_code"] === 485) {
                            // This is a "no such room" error: give a more meaningful description
                            window.audioBridgeApp.$alert(
                              "<p>Apparently room <code>" + myroom + "</code> " +
                              "does not exist. Do you have an updated <code>janus.plugin.audiobridge.jcfg</code> " +
                              "configuration file? copy the details of room <code>" + myroom + "</code> " +
                              "from that sample in your current configuration file, then restart Janus and try again."
                            );
                          } else {
                            window.audioBridgeApp.$alert(msg["error"]);
                          }
                          return;
                        }
                        // Any new feed to attach to?
                        if(msg["leaving"]) {
                          // One of the participants has gone away?
                          var leaving = msg["leaving"];
                          Janus.log("Participant left: " + leaving +
                            " (we have " + $('#rp'+leaving).length + " elements with ID #rp" +leaving + ")");
                          $('#rp'+leaving).remove();
                        }
                      }
                    }
                    if(jsep) {
                      Janus.debug("Handling SDP as well...", jsep);
                      mixertest.handleRemoteJsep({ jsep: jsep });
                    }
                  },
                  onlocalstream: function(stream) {
                    Janus.debug(" ::: Got a local stream :::", stream);
                    // We're not going to attach the local audio stream
                    $('#audiojoin').hide();
                    $('#room').removeClass('hide').show();
                  },
                  onremotestream: function(stream) {
                    $('#room').removeClass('hide').show();
                    var addButtons = false;
                    if($('#roomaudio').length === 0) {
                      addButtons = true;
                      $('#mixedaudio').append('<audio class="rounded" id="roomaudio" width="100%" height="100%" autoplay/>');
                    }
                    Janus.attachMediaStream($('#roomaudio').get(0), stream);
                    if(!addButtons)
                      return;
                    // Mute button
                    window.audioBridgeApp.audioenabled = true;
                    $('#toggleaudio').click(
                      function() {
                        window.audioBridgeApp.audioenabled = !window.audioBridgeApp.audioenabled;
                        mixertest.send({ message: { request: "configure", muted: !window.audioBridgeApp.audioenabled }});
                      }).removeClass('hide').show();

                  },
                  oncleanup: function() {
                    webrtcUp = false;
                    Janus.log(" ::: Got a cleanup notification :::");
                    $('#list').empty();
                    $('#mixedaudio').empty();
                    $('#room').hide();
                  }
                });
            },
            error: function(error) {
              Janus.error(error);
              window.audioBridgeApp.$alert(error, function() {
                window.location.reload();
              });
            },
            destroyed: function() {
              window.location.reload();
            }
          });
      };
    }});
});
