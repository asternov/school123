<!DOCTYPE html>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/video-js.css') }}" />
</head>
<body>
<video
    id="vid1"
    class="video-js vjs-default-skin"
    controls
    autoplay
    width="640" height="264"
    data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v=xjS6SftYQaQ?modestbranding=1"}],
    "youtube": {"ytControls": 0, "modestbranding": 1, "customVars": { "wmode": "transparent" } } }'
>
</video>

<script src="{{ asset('js/video.js') }}"></script>
<script src="{{ asset('js/youtube.js') }}"></script>
</body>
</html>
